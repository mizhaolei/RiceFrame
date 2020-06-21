<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\common\validate\Adminauthgroup as AuthManagerValidate;
use think\Url;

class Adminauthgroup extends Base
{
    /**
     * 后台用户权限首页
     * @return none
     */
    public function index(){
        $lists = db('admin_auth_group')->where('status','>',-1)->paginate(config('LIST_ROWS'),false,['query' => request()->param()]);
		$this->ifPageNoData($lists);
        $page = $lists->render();
        $this->assign('lists',$lists);
        $this->assign('page', $page);
        $this->meta_title = '用户权限';
        return $this->fetch();
    }

    /**
     * 编辑用户权限
     */
    public function add($id = 0){
        if(request()->isPost()){
            $data=$_POST;
//            验证
            $authManagerValidate=new AuthManagerValidate();
            if (!$authManagerValidate->check($data)) {
                $this->error($authManagerValidate->getError());
            }
//            判断用户组名称是否重复
            $checkwhere[] =['title','=',$data['title']];
            $checkwhere[] =['status','>',-1];
            $checkTitle=db('admin_auth_group')->where($checkwhere)->find();
            if($checkTitle){
                $this->error('用户组名称重复！');
            }
            $data['type']=1;
			$data['status']=1;
            $data['module']='admin';
            $re=db('admin_auth_group')->insertGetId($data);
            if($re){
                //                添加行为记录
                action_log("adminauthgroup_add","admin_auth_group",$re,UID);
                $this->success('新增成功','');
//                未刷新界面
            } else {
                $this->error('新增失败');
            }
        } else {
            $this->meta_title = '新增用户组';
            return $this->fetch();
        }
    }



    /**
     * 编辑用户权限
     */
    public function edit($id = 0){
    	$info=db('admin_auth_group')->find($id);
		if(!$info){
			$this->error("用户权限组不存在或删除！");
		}
        if(request()->isPost()){
            $data=$_POST;
//            验证
            $authManagerValidate=new AuthManagerValidate();
            if (!$authManagerValidate->check($data)) {
                $this->error($authManagerValidate->getError());
            }
//            判断用户组名称是否重复
            $checkwhere[] =['title','=',$data['title']];
            $checkwhere[] =['status','>',-1];
            $checkwhere[] =['id','<>',$data['id']];

            $checkTitle=db('admin_auth_group')->where($checkwhere)->find();
            if($checkTitle){
                $this->error('用户组名称重复！');
            }
            $re=db('admin_auth_group')->update($data);
            if($re){
                //                添加行为记录
                action_log("adminauthgroup_edit","admin_auth_group",$data['id'],UID);
                $this->success('编辑成功','');
//                未刷新界面
            } else {
                $this->error('编辑失败');
            }
        } else {
            $this->assign('id',$id);
            $this->assign('info',$info);
            $this->meta_title = '编辑权限用户组';
            return $this->fetch();
        }
    }

    /**
     * 启用禁用用户权限
     */
    public function set_status(){
        if (request()->isPost()){
            $data['id']=input('id');
            $data['status']=input('val');
            if($data['status']==1){
                $adminAuthgroup_status="adminauthgroup_status_qi";
            }
            if($data['status']==0){
                $adminAuthgroup_status="adminauthgroup_status_jin";
            }
            $res=db('admin_auth_group')->update($data);
            if($res){
//                添加行为记录
                action_log($adminAuthgroup_status,"admin_auth_group",$data['id'],UID);
                $this->success('操作成功！','index');
            }else{
                $this->error('操作失败！');
            }
        }else{
            $this->error('非法请求！');
        }
    }

    /**
     * 删除权限分组
     */
    public function del(){
        $id = input('ids/a');
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $where[] =['id','in',$id];
        $data['status']=-1;
        $res=db('admin_auth_group')->where($where)->update($data);
        if($res){
        	db('admin_member')->where('group_id','in',$id)->update(['group_id'=>0]);
            //添加行为记录
            action_log("adminauthgroup_del","admin_auth_group",$id,UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * 访问授权页面
     */
    public function access($id){
        if (request()->isPost()){
            $rule=input('rule/a');
            if(!$rule){
                $this->error('请选择要授权的访问！');
            }
            $data['rules']=implode(',',$rule);
            $res=db('admin_auth_group')->where('id', $id)->update($data);
            if($res){
                session('ADMIN_MEMBER_RULES',null);
                //添加行为记录
                action_log("adminauthgroup_access","admin_auth_group",$id,UID);
                $this->success('操作成功','index');
            } else {
                $this->error('操作失败！');
            }
        }
        else{
            //拉取所有后台所有菜单
            $lists=db('admin_menu')->where('status',1)->order('sort asc')->select();
            $lists=list_to_tree($lists,0);

            $authGroup=db('admin_auth_group')->find($id);

            $this->assign('id',$id);
            $this->assign('authGroup',$authGroup);
            $this->assign('lists',$lists);
            $this->meta_title = '访问授权';
            return $this->fetch();
        }
    }

    /**
     * 成员授权页面
     */
    public function user($id){
        if (request()->isPost()){
            $username=input('username');
            if(!$username){
                $this->error('请输入要授权的用户名！');
            }

            $res=db('admin_member')->where('username',$username)->find();
            if(!$res){
                $this->error('该用户不存在或已删除！');
            }
            if($res['id']==1){
                $this->error('该用户为超级管理员，无法授权！');
            }
            if($res['group_id']!=0){
                $this->error('该用户已被分配到其他权限组，无法授权！');
            }
            $data['id']=$res['id'];
            $data['group_id']=$id;
            $res=db('admin_member')->update($data);
            if($res){
                session('ADMIN_MEMBER_RULES',null);
                //                添加行为记录
                action_log("adminauthgroup_user","admin_member",$data['id'],UID);
                $this->success('操作成功');
            } else {
                $this->error('操作失败！');
            }
        }
        else{

            $authGroup=db('admin_auth_group')->find($id);
            $this->assign('authGroup',$authGroup);

            $where[] =['group_id','=',$id];
            $where[] =['status','>',-1];
            $lists=db('admin_member')->where($where)->select();
			
            $this->assign('lists', $lists);
            $this->assign('id',$id);
            $this->meta_title = '成员授权';
            return $this->fetch();
        }

    }

    /**
     * 成员取消授权页面
     */
    public function user_cancel($id){
        $data['id']=$id;
        $data['group_id']=0;
        $res=db('admin_member')->where('id',$id)->update($data);
        if($res){
            //                添加行为记录
            action_log("adminauthgroup_user_cancel","admin_member",$id,UID);
            $this->success('操作成功');
        } else {
            $this->error('操作失败！');
        }
    }


}
