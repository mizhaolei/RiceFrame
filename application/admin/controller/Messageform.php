<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Messageform extends Base {
	/**
	 * 留言列表管理
	 */
	public function index() {
		$nickname = trim(input('get.nickname'));
		$map[] = ['status','>',-1];
		if ($nickname) {
			$map[] = ['content','like','%'.$nickname.'%'];
		}
		$this -> assign('nickname', $nickname);
		$lists = db('message_form') -> order('create_time desc') -> where($map) -> paginate(config('LIST_ROWS'),false,['query' => request()->param()]);
		$this->ifPageNoData($lists);
		$page = $lists -> render();
		$this -> assign('lists', $lists);
		$this -> assign('page', $page);
		$this -> meta_title = '留言管理';
		return $this -> fetch();
	}

	/**
	 * 留言详情
	 */
	public function message_details($id = 0) {
		$linkInfo = db('message_form') -> where('id', $id) -> find();
		$this -> assign('info', $linkInfo);
		$this -> assign('id', $id);
		$this -> meta_title = '留言详情';
		return $this -> fetch();
	}

	/**
	 * 删除留言
	 */
	public function del_message() {
		$ids = input('ids/a');
		if (empty($ids)) {
			$this -> error('请选择要操作的数据!');
		}
		$res = db('message_form') -> delete($ids);
		if ($res) {
			//添加行为记录
			action_log("messageform_del", "message_form", $ids, UID);
			$this -> success('删除成功', 'index');
		} else {
			$this -> error('删除失败！');
		}
	}

}
