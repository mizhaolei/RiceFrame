<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\common\validate\Adminmember as UserValidate;


class Adminmember extends Base
{
    /**
     * 后台管理员信息首页
     * @return none
     */
    public function index(){
        $nickname=trim(input('get.nickname'));
        $map[] =['status','>',-1];
        if($nickname){
            $map[] =['username|nickname','like',"%".$nickname."%"];
        }
        $this->assign('nickname',$nickname);
        $lists   =   db('admin_member')->where($map)->order('id desc')->paginate(config('LIST_ROWS'),false,['query' => request()->param()]);
		$this->ifPageNoData($lists);
        $page = $lists->render();
        $this->assign('lists',$lists);
        $this->assign('page', $page);

        $this->meta_title = '管理员列表';
        return $this->fetch();
    }

    /**
     * 新增管理员
     */
    public function add(){
        if(request()->isPost()){
            $data=$_POST;
//            验证
            $userValidate=new UserValidate();
            if (!$userValidate->check($data)) {
                $this->error($userValidate->getError());
            }
//            验证  确认密码是否与密码相同
            if($data['repassword']!==$data['password']){
                $this->error('两次输入密码不一致！请重新输入！');
            }
//            判断管理员名是否重复
            $checkUwhere[] =['username','=',$data['username']];
            $checkUwhere[] =['status','>',-1];
            $checkUsername=db('admin_member')->where($checkUwhere)->find();
            if($checkUsername){
                $this->error('管理员名重复！');
            }
            $datas['username']=$data['username'];
            if(!$data['nickname']){
                $this->error('请输入昵称！');
            }
			$datas['nickname']=$data['nickname'];
            $datas['reg_time']=time();
            $datas['update_time']=time();
            $datas['status']=1;
            $datas['password']=zz_ucenter_md5($data['password'], config('UC_AUTH_KEY'));
            $re=db('admin_member')->insertGetId($datas);
            if($re){
//                添加行为记录
                action_log("adminmember_add","admin_member",$re,UID);
                $this->success('新增成功','');
            } else {
                $this->error('新增失败');
            }
        } else {
            $this->meta_title = '新增管理员';
            return $this->fetch();
        }
    }
    /**
     * 编辑管理员
     */
    public function edit(){
    	
        if(request()->isPost()){
            $data=$_POST;
//            验证
            $userValidate=new UserValidate();
            if (!$userValidate->scene('editpwd')->check($data)) {
                $this->error($userValidate->getError());
            }
			//            验证  确认密码是否与密码相同
            if($data['repassword']!==$data['password']){
                $this->error('两次输入密码不一致！请重新输入！');
            }
			
			$member=db('admin_member')->find(UID);
			if(!$member){
				$this->error('管理员不存在或已删除！');
			}
			if(zz_ucenter_md5($data['oldpassword'], config('UC_AUTH_KEY'))!=$member['password']){
				$this->error('原密码错误！');
			}

            $datas['id']=UID;
            $datas['update_time']=time();
            $datas['password']=zz_ucenter_md5($data['password'], config('UC_AUTH_KEY'));
            $re=db('admin_member')->update($datas);
            if($re){
//                添加行为记录
                action_log("adminmember_edit","admin_member",UID,UID);
                session('uid',null);
                session('ADMIN_MENU_LIST',null);
                $this->success('密码修改成功，请重新登录','admin/login');
            } else {
                $this->error('操作失败');
            }
        } else {
            
            $this->meta_title = '编辑管理员';
            return $this->fetch();
        }
    }

/**
     * 编辑管理员
     */
    public function resetpwd($id){
    	if($id==1){
			$this->error('该管理员为超级管理员，无法重置其密码！');
		}
        if(request()->isPost()){
        	if(UID!=1){
        		$this->error('您不是超级管理员无法重置其他管理员的密码！');
        	}
			
        	$member=db('admin_member')->find($id);
			if(!$member){
				$this->error('管理员不存在或已删除！');
			}
            $data=$_POST;
//            验证
            $userValidate=new UserValidate();
            if (!$userValidate->scene('editpwd')->check($data)) {
                $this->error($userValidate->getError());
            }
//            验证  确认密码是否与密码相同
            if($data['repassword']!==$data['password']){
                $this->error('两次输入密码不一致！请重新输入！');
            }

            $datas['id']=$id;
            $datas['update_time']=time();
            $datas['password']=zz_ucenter_md5($data['password'], config('UC_AUTH_KEY'));
            $re=db('admin_member')->update($datas);
            if($re){
            	action_log("adminmember_resetpwd","admin_member",$id,UID);
                $this->success('密码重置成功','');
            } else {
                $this->error('操作失败');
            }
        } else {
            $this->meta_title = '重置密码';
            return $this->fetch();
        }
    }

    /**
     * 编辑管理员昵称
     */
    public function nickname($id){

        if(request()->isPost()){
            $nickname=input('nickname');
//            验证
            if(!$nickname){
                $this->error('请输入管理员昵称');
            }

            $datas['id']=$id;
            $datas['nickname']=$nickname;
            $datas['update_time']=time();
            $re=db('admin_member')->update($datas);
            if($re){
//                添加行为记录
                action_log("adminmember_edit","admin_member",$id,UID);
                $this->success('操作成功','','top');
            } else {
                $this->error('操作失败');
            }
        } else {
            $member=db('admin_member')->find($id);
            $this->assign('member',$member);
            $this->meta_title = '编辑管理员';
            return $this->fetch();
        }
    }


    /**
     * 删除后台管理员
     */
    public function del(){
        $ids = input('ids/a');
        if ( empty($ids) ) {
            $this->error('请选择要操作的数据!');
        }
        //超级管理员，不能被删除。
        if(in_array(1,$ids)){
            $this->error('超级管理员无法被删除！');
        }
        $where[] =['id','in',$ids];
        $data['status']=-1;
        $res=db('admin_member')->where($where)->update($data);
        if($res){
            //                添加行为记录
            action_log("adminmember_del","admin_member",$ids,UID);
            $this->success('删除成功','index');
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * 对管理员进行授权，分配权限组
     */
    public function auth($id){
        if (request()->isPost()){
            $data['id']=input('id/d');
            if($data['id']==1){
                $this->error('该管理员为超级管理员，无法授权！');
            }
            $data['group_id']=input('group_id/d');
            $res=db('admin_member')->update($data);
            if($res){
                session('ADMIN_MEMBER_RULES',null);
//                添加行为记录
                action_log("adminmember_auth","admin_member",$data['id'],UID);
                $this->success('操作成功！','');
            }else{
                $this->error('操作失败！');
            }
        }else{
            $map[] =['status','>',-1];
            $lists = db('admin_auth_group')->where($map)->select();
            $member=db('admin_member')->find($id);
            $this->assign('member',$member);
            $this->assign('lists',$lists);
            $this->assign('id',$id);
            return $this->fetch();
        }
    }


    /**
     * 启用禁用管理员
     */
    public function set_status(){
        if (request()->isPost()){
            $data['id']=input('id');
            //超级管理员，不能被删除。
            if($data['id']==1){
                $this->error('该管理员为超级管理员，无法改变其状态！');
            }
            $data['status']=input('val');
            if($data['status']==1){
//               启用
                $adminmember_status="adminmember_status_qi";
            }
            if($data['status']==0){
//               禁用
                $adminmember_status="adminmember_status_jin";
            }
            $res=db('admin_member')->update($data);
            if($res){
//                添加行为记录
                action_log($adminmember_status,"admin_member",$data['id'],UID);
                $this->success('操作成功！');
            }else{
                $this->error('操作失败！');
            }
        }else{
            $this->error('非法请求！');
        }
    }
}
