<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\index\controller;
use think\Controller;

/**
 * 前台父类
 * Class Index
 */
class Base extends Controller
{
    protected function initialize()
    {

        /* 读取数据库中的配置 */
        $config = cache('DB_CONFIG_DATA_INDEX');
        if (!$config) {
            $config = get_db_config(1);
            cache('DB_CONFIG_DATA_INDEX', $config);
        }

        config($config,'app'); //添加配置
        //系统模板目录，兼容模板标签 include
        define('TPL', __ROOT__.'template/'.config('WEB_TEMPLATE_PATH').'/');

        //判断是否关闭站点。
        if (!config('WEB_SITE_CLOSE')) {
            $this->error('网站暂时关闭！','','stop');
        }
        //判断后台统计配置是否开启  1 开启
        if (config("WEB_TONGJI") == 1) {
            //pv表   zz_pv_log  栏目存在 点击进入页面后
            //判断 时间 0-1点 为time=0  H 24小时制
            $date_data = date("Y-m-d");
            $hour = date('H');
			$pvWhere[] =['date','=',$date_data]; 
			$pvWhere[] =['time','=',$hour]; 
            $pvInfo = db('pv_log')->where($pvWhere)->field('id')->find();
            if ($pvInfo) {
                db('pv_log')->where($pvWhere)->setInc('view');
            } else {
                $pvData['view'] = 1;
                $pvData['date'] = $date_data;
                $pvData['time'] = $hour;
                $pvData['create_time'] = time();
                db('pv_log')->insertGetId($pvData);
            }
            //uv表
            //获取ip
            $ipData = request()->ip();
            //查询该ip今天是否存在过
			$uvWhere[] =['date','=',$date_data]; 
			$uvWhere[] =['ip','=',$ipData]; 
			
            $uvInfo = db('uv_log')->where($uvWhere)->field('id')->find();
            //不存在 添加数据
            if (!$uvInfo) {
                $uvData['ip'] = $ipData;
                $uvData['time'] = $hour;
                $uvData['date'] = $date_data;
                $uvData['create_time'] = time();
                db('uv_log')->insertGetId($uvData);
            }
        }

        //判断是否开启了伪静态
        if (config('WEB_REWRITE')) {
            $this->request->setRoot('/');
        } else {
            $this->request->setRoot('/index.php');
        }
    }

    //统计url
    protected function urlrecord($title)
    {
        $date_data = date("Y-m-d");
        //获取url
        $urlInfo = request()->url(true);
        //根据url和date字段判断数据库中是否存在该页面的记录
		$urlWhere[] =['date','=',$date_data]; 
		$urlWhere[] =['url','=',$urlInfo]; 
        $url_data = db('url_log')->where($urlWhere)->field('id')->find();
        if ($url_data) {
            db('url_log')->where($urlWhere)->setInc('pv');
        } else {
            $dataUrl['url'] = $urlInfo;
            $dataUrl['pv'] = 1;
            $dataUrl['title'] = $title;
            $dataUrl['date'] = $date_data;
            $dataUrl['create_time'] = time();
            db('url_log')->insertGetId($dataUrl);
        }
    }
}