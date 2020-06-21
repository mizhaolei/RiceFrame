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
use think\captcha\Captcha;

class Admin extends Controller
{
    /**
     * 后台登录
     */
    public function login(){
        if(request()->isPost()){
            $data=$_POST;
            $captcha = new Captcha();
            if( !$captcha->check($data['code']))
            {
                // 验证失败
                $this->error('验证码错误！');
            }
            $memberModel=db('admin_member');
            $data['password']=zz_ucenter_md5($data['password'], config('UC_AUTH_KEY'));
            $member=$memberModel->where('username',$data['username'])->where('password',$data['password'])->find();
            if(!$member){
                action_log("member_login_error","admin_member",0,0,"登录失败，尝试登录。用户名：".$data['username']);
                $this->error('用户名或密码错误！');
            }
			if((int)$member['id']!=1){
				if((int)$member['status']<1){
					$this->error('该用户已删除或禁用，请联系管理员！');
				}
				
				
				if((int)$member['group_id']==0){
					$this->error('该用户没有被分配到任何用户权限组，无法登录！');
				}
				//判断用户组
				$authGroup=db('admin_auth_group')->find($member['group_id']);
				if(!$authGroup){
					$this->error('用户权限组不存在或已被删除，无法登录！');
				}
				if((int)$authGroup['status']!=1){
					$this->error('当前用户所在用户权限组已被删除或禁用，无法登录！');
				}
			}
			
            //登录，保存登录信息
            session('uid',$member['id']);
            //更新用户信息
            $updateData['id']=$member['id'];
            $updateData['last_login_time']=time();
            $updateData['last_login_ip']=request()->ip();
            $memberModel->update($updateData);
            action_log("member_login_success","admin_member",$member['id'],$member['id']);
            //跳转到首页
            $this->success('登录成功，正在跳转...','index/index',null,10);
        }
        else{
            //判断是否存在登录信息，如果存在，直接跳转到后台首页。
            $uid=session('uid');
            if($uid){
                return redirect(url('index/index'));
            }
            return $this->fetch();
        }
    }
    /**
     * 后台退出
     */
    public function logout(){
        session('ADMIN_MEMBER_RULES',null);
        session('uid',null);
        session('ADMIN_MENU_LIST',null);
        $this->success('退出成功，正在跳转...','admin/login');
    }
    /**
     * 验证码
     */
    public function img_captcha(){
        $config =    [
            // 验证码字体大小
            'fontSize'    =>    20,
            // 验证码位数
            'length'      =>    4,
            'imageW'=>148,
            'imageH'=>38
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }
}
