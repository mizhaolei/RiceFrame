<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\common\validate\AdminMenu as AdminMenuValidate;
use think\db;


class Adminmenu extends Base
{
    /**
     * 后台菜单首页
     * @return none
     */
    public function index($pid=0){
        $title=trim(input('get.title'));
        $map[] =['pid','=',$pid];
        if($title){
            $map[] =['title','like',"%".$title."%"];
        }

        $this->assign('title',$title);


        $lists   =   db('admin_menu')->where($map)->order('sort asc')->paginate(config('LIST_ROWS'),false,['query' => request()->param()]);
		$this->ifPageNoData($lists);
        $page = $lists->render();
        $this->assign('lists',$lists);
        $this->assign('pid',$pid);
        $this->assign('page', $page);

        $topMenu=['pid'=>0,'title'=>'顶级分类'];
        if($pid!=0){
            $topMenu=db('admin_menu')->find($pid);
            $topMenu=$topMenu;
        }
        $this->assign('topMenu', $topMenu);
        $this->meta_title = '菜单列表';
        return $this->fetch();
    }

    /**
     * 新增后台菜单
     */
    public function add(){
        if(request()->isPost()){
            $data=$_POST;
            $adminMenuValidate=new AdminMenuValidate();
            if (!$adminMenuValidate->check($data)) {
                $this->error($adminMenuValidate->getError());
            }
            $re=db('admin_menu')->insertGetId($data);
            if($re){
                session('ADMIN_MENU_LIST',null);
                //                添加行为记录
                action_log("adminmenu_add","admin_menu",$re,UID);
                $this->success('新增成功','');
            } else {
                $this->error('新增失败');
            }
        } else {
            $this->assign('pid',input('pid'));
            $this->meta_title = '新增菜单';
            return $this->fetch();
        }
    }

    /**
     * 编辑后台菜单
     */
    public function edit($id = 0){
    	$info=db('admin_menu')->find($id);
		if(!$info){
			$this->error('后台菜单不存在或已删除！');
		}
        if(request()->isPost()){
            $data=$_POST;
            $adminMenuValidate=new AdminMenuValidate();
            if (!$adminMenuValidate->check($data)) {
                $this->error($adminMenuValidate->getError());
            }
			$data['hide']=isset($data['hide'])?1:0;
            $re=db('admin_menu')->update($data);
            if($re){
                session('ADMIN_MENU_LIST',null);
                //                添加行为记录
                action_log("adminmenu_edit","admin_menu",$data['id'],UID);
                $this->success('编辑成功','');
            } else {
                $this->error('编辑失败');
            }
        } else {
            $this->assign('id',$id);
            
            $this->assign('info',$info);
            $this->meta_title = '编辑菜单';
            return $this->fetch();
        }
    }

    /**
     * 删除后台菜单
     */
    public function del(){
        $ids = input('ids/a');

        //判断要删除的数据，是否有子菜单。
        foreach ($ids as $item){
            $child=db('admin_menu')->where('pid',$item)->find();
            if($child){
                $this->error('检测到要删除菜单下，存在子菜单。请删除子菜单后，再执行删除命令!');
                return;
            }
        }

        if ( empty($ids) ) {
            $this->error('请选择要操作的数据!');
        }

        if(db('admin_menu')->delete($ids)){
            session('ADMIN_MENU_LIST',null);
            //                添加行为记录
            action_log("adminmenu_del","admin_menu",$ids,UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
    /**
     * 菜单排序
     */
    public function sort(){
        if (request()->isPost()){
            $data['id']=input('id');
            $data['sort']=input('sort');

            $adminMenuValidate=new AdminMenuValidate();
            if (!$adminMenuValidate->scene('sort')->check($data)) {
                $this->error($adminMenuValidate->getError());
            }
            $res=db('admin_menu')->update($data);
            if($res){
                session('ADMIN_MENU_LIST',null);
                //                添加行为记录
                action_log("adminmenu_sort","admin_menu",$data['id'],UID);
                $this->success('排序修改成功！');
            }else{
                $this->error('排序修改失败！');
            }
        }else{
            $this->error('非法请求！');
        }
    }

    /**
     * 显示隐藏菜单
     */
    public function hide(){
        if (request()->isPost()){
            $data['id']=input('id');
            $data['hide']=input('val');

            if($data['hide']==1){
				//隐藏
                $adminmenu_status="adminmenu_status_yin";
            }
            if($data['hide']==0){
				//显示
                $adminmenu_status="adminmenu_status_xian";
            }

            $res=db('admin_menu')->update($data);

            if($res){
                session('ADMIN_MENU_LIST',null);
                //                添加行为记录
                action_log($adminmenu_status,"admin_menu",$data['id'],UID);
                $this->success('操作成功！');
            }else{
                $this->error('操作失败！');
            }
        }else{
            $this->error('非法请求！');
        }
    }
}
