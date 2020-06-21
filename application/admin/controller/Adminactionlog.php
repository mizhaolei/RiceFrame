<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Adminactionlog extends Base
{
    /**
     * 用户行为日志actionlog
     */
    public function actionlog(){
    	$title = trim(input('title'));
		$this -> assign('title', $title);

        $map['a.status']=array('gt','0');
        $lists   =   db('admin_action_log')->alias('a')
        ->join('admin_action b','a.action_id = b.id')
        ->join('admin_member c','a.user_id = c.id','LEFT')
        ->field('a.*,b.title,c.username')
        ->order('a.id desc');


        if ($title) {
            $lists=$lists->where('b.title','like', "%$title%");
        }
        $lists=$lists->paginate(config('LIST_ROWS'),false,['query' => request()->param()]);
		$this->ifPageNoData($lists);
        $page = $lists->render();
        $this->assign('lists',$lists);
        $this->assign('page', $page);
        $this->meta_title = '行为日志';
        return $this->fetch();
    }
    /**
     *用户行为记录详细
     */
    public function edit_action_log($id = 0){
        
        $info= db('admin_action_log')->alias('a')
        ->join('admin_action b','a.action_id = b.id')
        ->join('admin_member c','a.user_id = c.id','LEFT')
        ->field('a.*,b.title,c.username')
        ->find($id);
		if(!$info){
			$this->error('行为记录不存在或已删除！');
		}
		$this->assign('id',$id);
        $this->assign('info',$info);
        $this->meta_title = '行为日志详细';
        return $this->fetch();
    }

    /**
     * 删除用户行为记录
     */
    public function delactionlog(){
        $ids = input('ids/a');
        if ( empty($ids) ) {
            $this->error('请选择要操作的数据!');
        }
        $res=db('admin_action_log')->delete($ids);
        if($res){
            //添加行为记录
            action_log("adminactionlog_del","admin_action_log",$ids,UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * 清空日志
     */
    public function clear(){
        $res = db('admin_action_log')->where('1=1')->delete();
        if($res !== false){
            $this->success('日志清空成功！','');
        }else {
            $this->error('日志清空失败！');
        }
    }

}
