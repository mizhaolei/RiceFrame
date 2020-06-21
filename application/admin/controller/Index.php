<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\admin\controller;


class Index extends Base
{
    /**
     * 后台首页
     */
    public function index()
    {
        //判断后台统计配置是否开启 1 开启
        if (config("WEB_TONGJI") == 1) {
            //删除七天前的数据 pv uv url
            //获取七天前日期
            $dateinfo = date('Y-m-d', strtotime('-7 days'));
            //转换为时间戳
            $shijianchuo = strtotime($dateinfo);
            //删除pv
            db('pv_log')->where('create_time','<',$shijianchuo)->delete();
            //删除url
            db('url_log')->where('create_time','<',$shijianchuo)->delete();
            //删除uv
            db('uv_log')->where('create_time','<',$shijianchuo)->delete();
        }
        $member = db('admin_member')->find(UID);
        $this->assign('member', $member);
        return $this->fetch();
    }

    /**
     * 控制中心
     */
    public function main()
    {
        $where[] = ['status','=',1];
        //已添加文章
        $articleCount = db('document')->count();
        $this->assign('articleCount', $articleCount);

        //已添加文章分类
        $categoryCount = db('document_category')->where($where)->count();
        $this->assign('categoryCount', $categoryCount);
        //后台管理员
        $memberCount = db('admin_member')->where($where)->count();
        $this->assign('memberCount', $memberCount);

        //行为日志
        $actionlogCount = db('admin_action_log')->where($where)->count();
        $this->assign('actionlogCount', $actionlogCount);

        if (config("WEB_TONGJI") == 1) {

            //获取今日pv
            $pvList = db('pv_log')->where('date', date('Y-m-d'))->field('time,view')->order('time asc')->select();
            $this->assign('pvList', $pvList);
            //获取今日uv
            $uvList = db('uv_log')->where('date', date('Y-m-d'))->field('count(id) as people,time')->group('time')->order('time asc')->select();
            $this->assign('uvList', $uvList);

            //安排最近一周的日期
            $dateArr = [];
            for ($i = 6; $i > -1; $i--) {
                array_push($dateArr, date("m-d", strtotime("-$i day")));
            }
            $this->assign('dateArr', $dateArr);

            //统计最近一周pv
            $pv7List = db('pv_log')->field('sum(view) as view,date')->group('date')->order('date asc')->select();
            $this->assign('pv7List', $pv7List);

            //统计最近一周pv
            $uv7List = db('uv_log')->field('count(id) as view,date')->group('date')->order('date asc')->select();
            $this->assign('uv7List', $uv7List);

            //获取TOP10被浏览页面
            $totalPv = db('url_log')->sum('pv');
            $top10 = db('url_log')->field('url,title,sum(pv) as pv')->order('pv desc')->limit(10)->group('url')->select();
            $this->assign('totalPv', $totalPv);
            $this->assign('top10', $top10);
        }

        return $this->fetch();
    }

    /**
     * 生成sitemap.xml
     */
    public function sitemap()
    {
        //获取协议
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ?
            "https://" : "http://";
        //获取域名
        $domain = $protocol . $_SERVER['HTTP_HOST'];
        //获取页码
        $page = input('page/d');
        if (!$page) {
            $page = 1;
        }
        $str = '';
        if ($page == 1) {
            if(file_exists('sitemap.xml'))
                unlink('sitemap.xml');
            $str .= '<?xml version="1.0"  encoding="utf-8"?>';
            $str .= '<urlset>';
            //首页
            $str .= '<url>';
            $str .= '<loc>' . $domain . '</loc>';
            $str .= '<lastmod>' . date('Y-m-d', time()) . '</lastmod>';
            $str .= '<changefreq>daily</changefreq>';
            $str .= '<priority>1.0</priority>';
            $str .= '</url>';
        }
        $pagesize = 100;

        //获取文章分类url
        $categoryInfo = db('document_category')->field('id,title,create_time')
            ->where('display', 1)->where('status', 1)
            ->page($page, $pagesize)
            ->order('id desc')->select();

        foreach ($categoryInfo as $v) {
            $str .= '<url>';
            $str .= '<loc>' . $domain . url('article/lists?id=' . $v['id']) . '</loc>';
            $str .= '<lastmod>' . date('Y-m-d', $v['create_time']) . '</lastmod>';
            $str .= '<changefreq>always</changefreq>';
            $str .= '<priority>0.8</priority>';
            $str .= '</url>';
        }
        //获取详细页分类url
        $documentInfo = db('document')->field('id,create_time')
            ->where('status', 1)
            ->page($page, $pagesize)
            ->order('id desc')->select();

        foreach ($documentInfo as $v) {
            $str .= '<url>';
            $str .= '<loc>' . $domain . url('article/detail?id=' . $v['id']) . $v['id'] . '</loc>';
            $str .= '<lastmod>' . date('Y-m-d', $v['create_time']) . '</lastmod>';
            $str .= '<changefreq>monthly</changefreq>';
            $str .= '<priority>0.6</priority>';
            $str .= '</url>';
        }
        if (count($categoryInfo) < $pagesize && count($documentInfo) < $pagesize) {
            $str .= '</urlset>';
            if (!(file_put_contents('sitemap.xml', $str, FILE_APPEND | LOCK_EX))) {
                $this->error('站点地图更新失败！');
            } else {
                $this->success('站点地图全部更新完成！', null,'stop');
            }
        }
        //写入
        if (!(file_put_contents('sitemap.xml', $str, FILE_APPEND | LOCK_EX))) {
            $this->error('站点地图更新失败！');
        } else {
            $this->success('站点地图正在生成，请稍后（' . $page . '）...', 'sitemap?page=' . ($page + 1));
        }
    }

}
