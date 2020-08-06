<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\admin\controller;
use think\Controller;

class Base extends Controller
{

    protected function initialize(){
        //验证用户凭证
        $uid=session('uid');
        if(!$uid){
            $this->error('请登录！','admin/login');
        }
        $member=db('admin_member')->field('id,status,group_id')->find($uid);
        if(!$member){
            $this->logout();
            $this->error('错误：当前用户不存在或已删除！','admin/login');
        }

        //判断权限，加载菜单
        //判断超级管理员
        if($member['id']!=1){
            if($member['status']==-1){
                $this->logout();
                $this->error('错误：当前用户不存在或已删除！','admin/login');
            }
            if($member['status']==0){
                $this->logout();
                $this->error('错误：当前登录用户已被禁用，请联系系统管理员！','admin/login');
            }
            if($member['group_id']==0){
                $this->logout();
                $this->error('错误：当前登录用户未被分配到任何权限组！','admin/login');
            }

            //判断权限
            $authGroup=$this->getRules($member['group_id']);

            if(!$authGroup){
                $this->logout();
                $this->error('错误：无法获取用户组权限！','admin/login');
            }
            if($authGroup['status']<1){
                $this->logout();
                $this->error('错误：用户权限组已被禁用，请联系管理员！','admin/login');
            }
            if(!$authGroup['rules']){
                $this->logout();
                $this->error('错误：用户权限组没有分配权限！',null,'stop');
            }
            if(!$this->checkAuth($authGroup['rules'])){
                $this->error('错误：没有权限！',null,'stop');
            }
            //加载菜单
            $adminMenuList=$this->getMenus($authGroup['rules']);
        }
        else{
            //加载菜单
            $adminMenuList=$this->getMenus();
        }

        $this->assign('__MENU__', $adminMenuList);

        /* 读取数据库中的配置 */
        $config =   cache('DB_CONFIG_DATA_ADMIN');
        if(!$config){
            $config =   get_db_config(2);
            //读取版本号
            $vinfo=get_hula_version();

            if($vinfo)
            $config['HULA_VERSION']=isset($vinfo->version)?$vinfo->version:'';

            cache('DB_CONFIG_DATA_ADMIN',$config);
        }
        //动态添加配置
        config($config,'app');

        //定义用户id常量
        define('UID',$uid);
    }

    /**
     * 获取后台菜单
     */
    public function getMenus($rules=''){

        $menus  =   session('ADMIN_MENU_LIST');
        if(empty($menus)){
            // 获取主菜单
            $map[] =['hide','=',0];
            $map[] =['status','=',1];
            $map[] =['pid','=',0];
            //判断是否处于开发者模式下
            if(!config('DEVELOP_MODE')){
                $map[] =['is_dev','=',0];
            }
			if($rules){
                $map[] =['id','in',$rules];
			}
            $menus=db('admin_menu')->where($map)->order('sort asc')->select();


            foreach ($menus as $key=>$item){
                $map2=array();
                $map2[] =['hide','=',0];
                $map2[] =['status','=',1];
                $map2[] =['pid','=',$item['id']];
                //判断是否处于开发者模式下
                if(!config('DEVELOP_MODE')){
                    $map2[] =['is_dev','=',0];
                }
				if($rules){
                    $map2[] =['id','in',$rules];
				}

                $child=db('admin_menu')->where($map2)->order('sort asc')->select();
                if($child){
                    $menus[$key]['child']=$child;
                }
            }
            session('ADMIN_MENU_LIST',$menus);
        }

        return $menus;
    }

    /**
     * 获取用户组权限
     */
    public function getRules($group_id){
        $authGroup=db('admin_auth_group')->find($group_id);
        return $authGroup;
    }

    /**
     * 判断权限
     */
    public function checkAuth($rules){
        $request = request();
        $check = strtolower($request->controller().'/'.$request->action());

        //首页
        if($check=='index/index'){
            return true;
        }
		
        //使用当前访问的url地址去数据库中检索
        $adminMenu=db('admin_menu')->where('url', 'like', "$check%")->field('id')->find();

        //如果后台菜单中无记录，无权限访问。
        if(!$adminMenu){
            return false;
        }
        $ruleArr=explode(',',$rules);
        if(!in_array($adminMenu['id'],$ruleArr)){
            return false;
        }
        return true;
    }

    /**
     * 退出登录
     */
    public function logout(){
        session('ADMIN_MENU_LIST',null);
        session('ADMIN_MEMBER_RULES',null);
        session('uid',null);
    }
	
	/**
     * 如果在非第一页没有数据时，跳转到最后一页
     */
    public function ifPageNoData($lists){
        $currentPage=$lists->currentPage();
		$page=input('page/d');
		$page=$page?$page:1;
		if($currentPage!=$page){
			//page是url传递的
			//$currentPage是程序生成的。超出数据分页数，$currentPage为最后一页页码
			$currentUrl=request()->url();
			$newUrl=preg_replace('/([\?\&])page=\d+$/','$1'."page=$currentPage",$currentUrl);
			header("Location: $newUrl");
    		exit();
		}
    }
	
	/**
     * 获得当前页面的referer
     */
    public function getPageReferer(){
        $referer=cookie('PAGE_REFERER');
		cookie('PAGE_REFERER',null);
		return $referer;
    }
	
	/**
     * 存储当前页面的referer
     */
    public function savePageRefererToCookie(){
        $referer=$this->request->header('referer');
		cookie('PAGE_REFERER',$referer);
    }
}
