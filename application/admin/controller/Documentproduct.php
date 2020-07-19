<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\common\validate\Document as DocumentValidate;

class Documentproduct extends Base {
	/**
	 * 后台产品列表首页
	 * @return none
	 */
	public function index() {
		$nickname = trim(input('get.nickname'));
		$category_id = trim(input('get.category_id'));
		$map[] = ['a.type','=','product'];
		$map[] =['a.status','>=',0];
		if ($category_id) {
			$map[] =['a.category_id','=',$category_id];
		}
		$this -> assign('category_id', $category_id);
		if ($nickname) {
			$map[] =['a.title','like',"%$nickname%"];
		}
		$this -> assign('nickname', $nickname);
		$lists = db('document') -> alias('a') -> join('document_category b', 'a.category_id = b.id') -> field('a.*,b.title as categorytitle') -> order('create_time desc') -> where($map) -> paginate(config('LIST_ROWS'),false,['query' => request()->param()]);
		$this->ifPageNoData($lists);
		$page = $lists -> render();
		$this -> assign('lists', $lists);
		$this -> assign('page', $page);

		//        分类列表
		$categorylist = db('document_category') -> where('status',1) -> field('id,title,status') -> select();
		$this -> assign('categorylist', $categorylist);

		$this -> meta_title = '产品列表';
		return $this -> fetch();
	}

	/**
	 * 新增产品
	 */
	public function add() {
		if ( request() -> isPost()) {
			$data = $_POST;
			//验证
			$documentValidate = new DocumentValidate();
			if (!$documentValidate -> check($data)) {
				$this -> error($documentValidate -> getError());
			}

			//添加到产品表$documentData；添加到产品附表$dcdata
			$documentData = array();
			$documentExtData = array();

			
			//是否推荐
			$documentData['isrecommend'] = isset($data['isrecommend']) ? 1 : 0;
			//是否置顶
			$documentData['istop'] = isset($data['istop']) ? 1 : 0;
			//是否可见
			$documentData['display'] = isset($data['display']) ? 1 : 0;

			$documentData['uid'] = UID;
			$documentData['type'] = 'product';
			$documentData['title'] = $data['title'];
			$documentData['writer'] = db('admin_member') -> where('id', UID) -> value('username');
			$documentData['category_id'] = $data['category_id'];
			$documentData['keywords'] = keyword_repalce_split($data['keywords']);
			$documentData['link_str'] = $data['link_str'];
			if ($data['piclist']) {
				//首图做封面
				$piclistArr = explode(',', $data['piclist']);
				$documentData['cover_path'] = $piclistArr[0];
			}

			$documentData['sort'] = $data['sort'];
			$documentData['description'] = $data['description'];
			$documentData['create_time'] = time();
			$documentData['update_time'] = time();
			$documentData['status'] = 1;
			$re1 = db('document') -> insertGetId($documentData);
			if ($re1) {
				//附表添加数据
				$documentExtData['id'] = $re1;
				//产品附加表数据
				$documentExtData['content'] = $data['content'];
				$documentExtData['piclist'] = $data['piclist'];
				$documentExtData['price'] = $data['price'];
				$documentExtData['market_price'] = $data['market_price'];
				db('document_product') -> insert($documentExtData);
				action_log("document_product_add", "document_article", $re1, UID);
				$this -> success('新增成功', 'index');
			} else {
				$this -> error('新增失败');
			}
		} else {
			//查询产品分类列表
			$whereDocument['status'] = 1;
			$document_category = db('document_category') -> where($whereDocument) -> field('id,title,pid') -> select();
			$document_category=list_to_tree($document_category);
			$document_category=list_to_char_tree($document_category);
			$this -> assign('dclist', $document_category);
			$this -> meta_title = '新增产品';
			return $this -> fetch();
		}
	}

	/**
	 * 编辑产品
	 */
	public function edit($id = 0) {
		$info = db('document') -> find($id);
		if(!$info){
			$this->error('产品不存在或已删除！');
		}
		if ( request() -> isPost()) {
			$data = $_POST;
			//验证
			$documentValidate = new DocumentValidate();
			if (!$documentValidate -> check($data)) {
				$this -> error($documentValidate -> getError());
			}
			//添加到产品表$documentData；添加到产品附表$dcdata
			$documentData = array();
			$documentExtData = array();

			//是否推荐
			$documentData['isrecommend'] = isset($data['isrecommend']) ? 1 : 0;
			//是否置顶
			$documentData['istop'] = isset($data['istop']) ? 1 : 0;
			//是否可见
			$documentData['display'] = isset($data['display']) ? 1 : 0;

			$documentData['id'] = $data['id'];
			$documentData['writer'] = db('admin_member') -> where('id', UID) -> value('username');
			$documentData['uid'] = UID;
			$documentData['type'] = 'product';
			$documentData['title'] = $data['title'];
			$documentData['category_id'] = $data['category_id'];
            $documentData['keywords'] = keyword_repalce_split($data['keywords']);
			$documentData['link_str'] = $data['link_str'];
			if ($data['piclist']) {
				//首图做封面
				$piclistArr = explode(',', $data['piclist']);
				$documentData['cover_path'] = $piclistArr[0];
			}
			$documentData['sort'] = $data['sort'];
			$documentData['description'] = $data['description'];
			$documentData['update_time'] = time();
			$re1 = db('document') -> update($documentData);
			//          附表添加数据
			if ($re1) {
				$documentExtData['id'] = $data['id'];
				//产品附加表数据
				$documentExtData['content'] = $data['content'];
				$documentExtData['piclist'] = $data['piclist'];
				$documentExtData['price'] = $data['price'];
				$documentExtData['market_price'] = $data['market_price'];
				db('document_product') -> update($documentExtData);
				action_log("document_product_edit", "document_article", $data['id'], UID);
				$referer=$this->getPageReferer();
				$this -> success('编辑成功', $referer);
			} else {
				$this -> error('编辑失败');
			}
		} else {
			//查询产品分类列表
			$whereDocument['status'] =1;
			$document_category = db('document_category') -> where($whereDocument) -> field('id,title,pid') -> select();
			$document_category=list_to_tree($document_category);
			$document_category=list_to_char_tree($document_category);
			$this -> assign('dclist', $document_category);

			$this -> assign('id', $id);
			
			$this -> assign('info', $info);
			$infos = db('document_product') -> find($id);
			$this -> assign('infos', $infos);
			$this -> meta_title = '编辑产品';
			$this->savePageRefererToCookie();
			return $this -> fetch();
		}
	}

	/**
	 * 显示隐藏产品
	 */
	public function set_display() {
		if ( request() -> isPost()) {
			$data['id'] = input('id');
			$data['display'] = input('val');
			if ($data['display'] == 1) {
				//隐藏
				$setDisplay = "document_display_xian";
			}
			if ($data['display'] == 0) {
				//显示
				$setDisplay = "document_display_yin";
			}
			$res = db('document') -> update($data);
			if ($res) {
				action_log($setDisplay, "document", $data['id'], UID);
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
			//验证
			$documentValidate = new DocumentValidate();
			if (!$documentValidate -> scene('sort') -> check($data)) {
				$this -> error($documentValidate -> getError());
			}
			$res = db('document') -> update($data);
			if ($res) {
				action_log("document_sort", "document", $data['id'], UID);
				$this -> success('排序修改成功！');
			} else {
				$this -> error('排序修改失败！');
			}
		} else {
			$this -> error('非法请求！');
		}
	}

	/**
	 * 删除产品
	 */
	public function del() {
		$ids = input('ids/a');
		if (empty($ids)) {
			$this -> error('请选择要操作的数据!');
		}
        $where[] =['id','in',$ids];
		$res1 = db('document')->where($where) -> update(['status'=>-1]);
		if ($res1) {
			action_log("document_article_del", "document_article", $ids, UID);
			$this -> success('删除成功');
		} else {
			$this -> error('删除失败！');
		}
	}

}
