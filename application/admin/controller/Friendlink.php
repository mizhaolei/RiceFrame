<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\common\validate\Friendlink as FriendlinkValidate;

class Friendlink extends Base {
	/**
	 * 友情链接管理
	 */
	public function index() {
		$nickname = trim(input('get.nickname'));
		$map[] = ['status','>',-1];
		if ($nickname) {
            $map[]=['title','like','%'.$nickname.'%'];
		}
		$this -> assign('nickname', $nickname);
		$lists = db('friend_link') -> order('sort asc') -> where($map) -> paginate(config('LIST_ROWS'),false,['query' => request()->param()]);
		$this->ifPageNoData($lists);
		$page = $lists -> render();
		$this -> assign('lists', $lists);
		$this -> assign('page', $page);

		$this -> meta_title = '友情链接管理';
		return $this -> fetch();
	}

	/**
	 * 新增友情链接
	 */
	public function add_link() {
		if ( request() -> isPost()) {
			$data = $_POST;
			//            验证
			$friendlinkValidate = new FriendlinkValidate();
			if (!$friendlinkValidate -> check($data)) {
				$this -> error($friendlinkValidate -> getError());
			}
			//            判断链接名称是否重复
			
			$checkNwhere[] =['title','=',$data['title']];
			$checkNwhere[] = ['status','>',-1];
			$checkName = db('friend_link') -> where($checkNwhere) -> find();
			if ($checkName) {
				$this -> error('链接名称重复！');
			}
			//            判断链接地址是否重复
			$checkUwhere[] = ['url','=',$data['url']];
			$checkUwhere[] = ['status','>',-1];
			$checkUrl = db('friend_link') -> where($checkUwhere) -> find();
			if ($checkUrl) {
				$this -> error('链接地址重复！');
			}
			$data['update_time'] = time();
			$data['create_time'] = time();
			//清除上传文件的字段
			unset($data['file']);
			$re = db('friend_link') -> insertGetId($data);
			if ($re) {
				cache('DATA_FRIEND_LINK', null);
				//                添加行为记录
				action_log("friendlink_add", "friend_link", $re, UID);
				$this -> success('新增成功', 'index');
			} else {
				$this -> error('新增失败','');
			}
		} else {
			$this -> meta_title = '新增友情链接';
			return $this -> fetch();
		}
	}

	/**
	 * 编辑友情链接
	 */
	public function edit_link($id = 0) {
		$linkInfo = db('friend_link') -> where('id', $id) -> find();
		if(!$linkInfo){
			$this->error('友情链接不存在或已删除！');
		}
		if ( request() -> isPost()) {
			$data = $_POST;
			//            验证
			$friendlinkValidate = new FriendlinkValidate();
			if (!$friendlinkValidate -> check($data)) {
				$this -> error($friendlinkValidate -> getError());
			}
			//            判断链接名称是否重复
            $checkNwhere[] =['title','=',$data['title']];
            $checkNwhere[] = ['status','>',-1];
            $checkNwhere[] = ['id','<>',$data['id']];
			$checkName = db('friend_link') -> where($checkNwhere) -> find();
			if ($checkName) {
				$this -> error('链接名称重复！');
			}
			//            判断链接地址是否重复
            $checkUwhere[] =['url','=',$data['url']];
            $checkUwhere[] = ['status','>',-1];
            $checkUwhere[] = ['id','<>',$data['id']];
			$checkUrl = db('friend_link') -> where($checkUwhere) -> find();
			if ($checkUrl) {
				$this -> error('链接地址重复！');
			}
			$data['update_time'] = time();
			//清除上传文件的字段
			unset($data['file']);
			$re = db('friend_link') -> update($data);
			if ($re) {
				cache('DATA_FRIEND_LINK', null);
				//                添加行为记录
				action_log("friendlink_edit", "friend_link", $data['id'], UID);
				$this -> success('编辑成功','');
			} else {
				$this -> error('编辑失败');
			}
		} else {
			
			$this -> assign('infos', $linkInfo);
			$this -> assign('id', $id);
			$this -> meta_title = '编辑友情链接';
			return $this -> fetch();
		}
	}

	/**
	 * 启用禁用友情链接
	 */
	public function set_status() {
		if ( request() -> isPost()) {
			$data['id'] = input('id');
			$data['status'] = input('val');
			if ($data['status'] == 1) {
				//禁用
				$friendlink_status = "friendlink_status_qi";
			}
			if ($data['status'] == 0) {
				//启用
				$friendlink_status = "friendlink_status_jin";
			}
			$res = db('friend_link') -> update($data);
			if ($res) {
				cache('DATA_FRIEND_LINK', null);
				//添加行为记录
				action_log($friendlink_status, "friend_link", $data['id'], UID);
				$this -> success('操作成功！');
			} else {
				$this -> error('操作失败！');
			}
		} else {
			$this -> error('非法请求！');
		}
	}

	/**
	 * 排序
	 */
	public function sort() {
		if ( request() -> isPost()) {
			$data['id'] = input('id');
			$data['sort'] = input('sort');

			$friendlinkValidate = new FriendlinkValidate();
			if (!$friendlinkValidate -> scene('sort') -> check($data)) {
				$this -> error($friendlinkValidate -> getError());
			}
			$res = db('friend_link') -> update($data);
			if ($res) {
				cache('DATA_FRIEND_LINK', null);
				//                添加行为记录
				action_log("friendlink_sort", "friend_link", $data['id'], UID);
				$this -> success('排序修改成功！');
			} else {
				$this -> error('排序修改失败！');
			}
		} else {
			$this -> error('非法请求！');
		}
	}

	/**
	 * 删除友情链接
	 */
	public function del_link() {
		$ids = input('ids/a');
		if (empty($ids)) {
			$this -> error('请选择要操作的数据!');
		}
		$res = db('friend_link') -> delete($ids);
		if ($res) {
			cache('DATA_FRIEND_LINK', null);
			//                添加行为记录
			action_log("friendlink_del", "friend_link", $ids, UID);
			$this -> success('删除成功', 'index');
		} else {
			$this -> error('删除失败！');
		}
	}

}
