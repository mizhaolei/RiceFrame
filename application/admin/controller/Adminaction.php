<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\common\validate\Adminaction as ActionValidate;


class Adminaction extends Base
{
    /**
     * 用户行为
     */
    public function action(){
    	$title = trim(input('title'));
        $where[]=['status','>',-1];
		if ($title) {
            $where[] =['name|title','like',"%$title%"];
		}
		
		$this -> assign('title', $title);
        $lists   =   db('admin_action')->where($where)->order('id desc')->paginate(config('LIST_ROWS'),false,['query' => request()->param()]);
		$this->ifPageNoData($lists);
        $page = $lists->render();
        $this->assign('lists',$lists);
        $this->assign('page', $page);
        $this->meta_title = '用户行为';
        return $this->fetch();
    }

    /**
     * 启用禁用用户行为
     */
    public function set_action_status(){
        if (request()->isPost()){
            $data['id']=input('id');
            $data['status']=input('val');
            if($data['status']==1){
                $adminAction_status="adminaction_status_qi";
            }
            if($data['status']==0){
                $adminAction_status="adminaction_status_jin";
            }

            $res=db('admin_action')->update($data);
            if($res){
                //                添加行为记录
                action_log($adminAction_status,"admin_action",$data['id'],UID);
                $this->success('操作成功！');
            }else{
                $this->error('操作失败！');
            }
        }else{
            $this->error('非法请求！');
        }
    }

    /**
     * 新增用户行为
     */
    public function add_action(){
        if(request()->isPost()){
            $data=$_POST;
			//验证
            $actionValidate=new ActionValidate();
            if (!$actionValidate->check($data)) {
                $this->error($actionValidate->getError());
            }
			//判断行为标识是否重复
            $checkName=db('admin_action')->where('name',$data['name'])->where('status','>',-1)->find();
            if($checkName){
                $this->error('行为标识重复！');
            }
			//判断行为名称是否重复
            $checkTitle=db('admin_action')->where('title',$data['title'])->where('status','>',-1)->find();
            if($checkTitle){
                $this->error('行为名称重复！');
            }
            $data['update_time']=time();
            $data['status']=1;
            $re=db('admin_action')->insertGetId($data);
            if($re){
                //                添加行为记录
                action_log("adminaction_add","admin_action",$re,UID);
                $this->success('新增成功','action');
            } else {
                $this->error('新增失败');
            }
        } else {
            $this->meta_title = '新增用户行为';
            return $this->fetch();
        }
    }

    /**
     * 编辑用户行为
     */
    public function edit_action($id = 0){
    	$info=db('admin_action')->find($id);
		if(!$info){
			$this->error('用户行为不存在或已删除！');
		}
        if(request()->isPost()){
            $data=$_POST;
            //验证
            $actionValidate=new ActionValidate();
            if (!$actionValidate->check($data)) {
                $this->error($actionValidate->getError());
            }
            //判断行为标识是否重复

            $checkNwhere[] =['name','=',$data['name']];
            $checkNwhere[] =['status','>',-1];
            $checkNwhere[] =['id','<>',$data['id']];
            $checkName=db('admin_action')->where($checkNwhere)->find();
            if($checkName){
                $this->error('行为标识重复！');
            }
			//判断行为名称是否重复
            $checkTwhere[] =['title','=',$data['title']];
            $checkTwhere[] =['status','>',-1];
            $checkTwhere[] =['id','<>',$data['id']];
            $checkTitle=db('admin_action')->where($checkTwhere)->find();
            if($checkTitle){
                $this->error('行为名称重复！');
            }
            $data['update_time']=time();
            $re=db('admin_action')->update($data);
            if($re){
                //添加行为记录
                action_log("adminaction_edit","admin_action",$data['id'],UID);
                $this->success('编辑成功','');
            } else {
                $this->error('编辑失败');
            }
        } else {
            $this->assign('id',$id);
            $this->assign('info',$info);
            $this->meta_title = '编辑用户行为';
            return $this->fetch();
        }
    }

    /**
     * 删除用户行为
     */
    public function delaction(){
        $ids = input('ids/a');
        if ( empty($ids) ) {
            $this->error('请选择要操作的数据!');
        }
        $where[] =['id','in',$ids];
        $data['status']=-1;
        $res=db('admin_action')->where($where)->update($data);
        if($res){
            //添加行为记录
            action_log("adminaction_del","admin_action",$ids,UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * 用户行为日志actionlog
     */
    public function actionlog(){
        $map[] =['status','>',-1];
        $lists   =   db('admin_action_log')->where($map)->order('id desc')->paginate(config('LIST_ROWS'),false,['query' => request()->param()]);
        $page = $lists->render();
        $this->assign('lists',$lists);
        $this->assign('page', $page);
        $this->meta_title = '行为日志';
        return $this->fetch();
    }
}
