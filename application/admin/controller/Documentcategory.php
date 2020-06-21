<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\common\validate\Documentcategory as DocumentcategoryValidate;
use think\db;

class Documentcategory extends Base {
	/**
	 * 后台文章分类首页
	 * @return none
	 */
	public function index() {
		$lists = db('document_category') -> where('status','>',-1) -> field('id,pid,title,sort,display') -> order('sort asc,id asc') -> select();


		foreach($lists as $item){
            $child_id=list_to_tree($lists,$item['id'],0);
        }

		$lists=list_to_tree($lists);

		$this -> assign('listJson', json_encode($lists));
		$this -> meta_title = '文章分类';
		
		return $this -> fetch();
	}

	/**
	 * 新增子分类
	 */
	public function add_category($pid = 0) {
		if ( request() -> isPost()) {
			$data = $_POST;
            //验证
            $documentcategoryValidate = new DocumentcategoryValidate();
            if (!$documentcategoryValidate -> check($data)) {
                $this -> error($documentcategoryValidate -> getError());
            }
			
			$data['create_time'] = time();
			$data['update_time'] = time();
			$data['status'] = 1;
			if(isset($data['content'])){
				$content = $data['content'];
				unset($data['content']);
			}
			else{
				$content = '';
			}
			if(isset($data['file'])){
				unset($data['file']);
			}
			$reid = db('document_category') -> insertGetId($data);
			if ($reid) {
				//如果有填写分类内容，将数据保存到分类附表
				$contentData['id'] = $reid;
				$contentData['content'] = $content;
				db('document_category_content') -> insert($contentData);
				
				if((int)$data['pid']!=0){
					//更新上级分类child_id
                    $data['id']=$reid;
					$this->edit_category_child_item(0,$data['pid'],$data);
                    $this->set_category_parent_id($data['id'],'');
				}
				
				//删除分类缓存
				cache('DATA_DOCUMENT_CATEGORY_LIST', null);
				
				//添加行为记录
				action_log("documentcategory_add", "document_category", $reid, UID);

				$this -> success('新增成功', 'index');
			} else {
				$this -> error('新增失败');
			}
		} else {
			$categorylist = db('document_category') -> where('status',1) -> field('id,title,status,pid') -> select();
			$categorylist=list_to_tree($categorylist);
			$categorylist=list_to_char_tree($categorylist);
			$this -> assign('dclist', $categorylist);
			$this -> assign('cid', $pid);
			$this -> meta_title = '新增子分类';
			return $this -> fetch();
		}
	}

	/**
	 * 编辑文章分类
	 */
	public function edit_category($id) {
		//判断是否为顶级分类
		$categoryInfo = db('document_category') -> where('id', $id) -> find();
		if (!$categoryInfo) {
			$this -> error('分类不存在或已删除！');
		}
		if ( request() -> isPost()) {
			$data = $_POST;
            //验证
            $documentcategoryValidate = new DocumentcategoryValidate();
            if (!$documentcategoryValidate -> check($data)) {
                $this -> error($documentcategoryValidate -> getError());
            }

			$data['update_time'] = time();
			if(isset($data['content'])){
				$content = $data['content'];
				unset($data['content']);
			}
			else{
				$content = '';
			}
			if(isset($data['file'])){
				unset($data['file']);
			}
			$re = db('document_category') -> update($data);
			if ($re) {
				
				//如果有填写分类内容，将数据保存到分类附表
				//获取内容，看是否存在
				$dcContent = db('document_category_content') -> find($data['id']);
				$contentData['id'] = $data['id'];
				$contentData['content'] = $content;
				if ($dcContent) {
					db('document_category_content') -> update($contentData);
				} else {
					db('document_category_content') -> insert($contentData);
				}
				
				//判断是否更改了上级分类
				if($categoryInfo['pid']!=$data['pid']){
                    //更新原分类树
                    $this->edit_category_child_item($categoryInfo['pid'],$data['pid'],$categoryInfo);

                    //更新父级ids
                    $this->set_category_parent_id($data['id'],$categoryInfo['child']);
				}
				
				//删除分类缓存
				cache('DATA_DOCUMENT_CATEGORY_LIST', null);
				//添加行为记录
				action_log("documentcategory_edit", "document_category", $id, UID);
				$this -> success('编辑成功', 'index');
			} else {
				$this -> error('编辑失败');
			}
		} else {
			//获取分类列表，这里去除它自己
			$categorylist = db('document_category') -> where('status','>',-1)->where('id','<>',$id) -> field('id,title,status,pid') -> select();
			$categorylist=list_to_tree($categorylist);
			$categorylist=list_to_char_tree($categorylist);
			$this -> assign('dclist', $categorylist);
			//获取分类信息
			$content = db('document_category_content') -> where('id', $id) -> field('content') -> find();
			$categoryInfo['content'] = $content ? $content['content'] : '';
			$this -> assign('info', $categoryInfo);
			$this -> assign('id', $id);

			$this -> meta_title = '编辑分类';
			return $this -> fetch();
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
			$documentcategoryValidate = new DocumentcategoryValidate();
			if (!$documentcategoryValidate -> scene('sort') -> check($data)) {
				$this -> error($documentcategoryValidate -> getError());
			}
			$res = db('document_category') -> update($data);
			if ($res) {
				cache('DATA_DOCUMENT_CATEGORY_LIST', null);
				//添加行为记录
				action_log("documentcategory_sort", "document_category", $data['id'], UID);
				$this -> success('排序修改成功！');
			} else {
				$this -> error('排序修改失败！');
			}
		} else {
			$this -> error('非法请求！');
		}
	}

	/**
	 * 删除分类
	 */
	public function del_category() {

		$ids = input('ids/d');
		if (empty($ids)) {
			$this -> error('请选择要操作的数据!');
		}
		//判断该分类下有没有子分类，有则不允许删除
		$child = db('document_category') -> where('pid','=',$ids) -> where('status','>',-1) -> field('id') -> find();
		if (!empty($child)) {
			$this -> error('请先删除该分类下的子分类');
		}
		//判断该分类下有没有文章
        $categoryWhere[] =['status','=',1];
        $categoryWhere[] =['category_id','=',$ids];
		$document_list = db('document') -> where($categoryWhere) -> field('id') -> find();
		if (!empty($document_list)) {
			$this -> error('请先删除该分类下的文章');
		}

		$res = db('document_category') -> where('id',$ids)->update(['status'=>-1]);
		if ($res) {
			//删除分类附表 内容
			db('document_category_content') -> delete($ids);
			//更新上级child_id
			$this->del_category_child_item($ids);
			//清除缓存
			cache('DATA_DOCUMENT_CATEGORY_LIST', null);
			//添加行为记录
			action_log("documentcategory_del", "document_category", $ids, UID);
			$this -> success('删除成功');
		} else {
			$this -> error('删除失败！');
		}
	}

	/**
	 * 显示隐藏文章
	 */
	public function set_display() {
		if ( request() -> isPost()) {
			$data['id'] = input('id');
			$data['display'] = input('val');
			if ($data['display'] == 1) {
				//隐藏
				$setDisplay = "document_category_display_xian";
			}
			if ($data['display'] == 0) {
				//显示
				$setDisplay = "document_category_display_yin";
			}
			$res = db('document_category') -> update($data);
			if ($res) {
				cache('DATA_DOCUMENT_CATEGORY_LIST', null);
				action_log($setDisplay, "document_category", $data['id'], UID);
				$this -> success('操作成功！');
			} else {
				$this -> error('操作失败！');
			}
		} else {
			$this -> error('非法请求！');
		}
	}

    /**
     * 更新上级child_id
     */
	private function del_category_child_item($cid){
        $cid=(int)$cid;
        if(!$cid){
            return;
        }
		//获取所有上级
		$lists = db('document_category') -> where("CONCAT(',',child,',') like '%,$cid,%'") -> field('id,child') -> select();

		$prefix=config('database.prefix');
		foreach($lists as $item){
			$child=explode(',',$item['child']);
			$child=array_diff($child,[$cid]);
			$child=implode(',',$child);
			$id=$item['id'];
			$sql="update ".$prefix."document_category set child='$child' where id=$id;";
			Db::execute($sql);
		}
	}
    /**
     * 更新上级child_id
     * $oldpid=原上级分类id
     * $newpid=现上级分类id
     * $category=栏目分类对象
     */
	private function edit_category_child_item($oldpid,$newpid,$category){

        $prefix=config('database.prefix');
        //原上级分类，需要删除当前分类及当前分类下的子孙分类id
        //找到所有上级分类->删除当前分类id->获取当前分类子孙id->删除分类子孙分类id
        $oldpid=(int)$oldpid;
        if($oldpid){
            //找到所有上级分类
            $lists = db('document_category')
			 -> where("CONCAT(',',child,',') like '%,$oldpid,%'")
			 ->whereOr('id',$oldpid) 
			 -> field('id,child')
			 ->order('pid asc') 
			 -> select();
            foreach ($lists as $item){
                $childArr=explode(',',$item['child']);
                if(!$childArr){
                    continue;
                }
                //删除当前分类id
                $childArr=array_diff($childArr,[$category['id']]);
                //获取当前分类子孙id
                if($category['child']){
                    $currCategoryChildArr=explode(',',$category['child']);
                    $childArr=array_diff($childArr,$currCategoryChildArr);
                }
                $newchild=implode(',',$childArr);
                $sql="update ".$prefix."document_category set child='$newchild' where id=".$item['id'].";";
                Db::execute($sql);
            }
        }

        //现上级分类，需要添加当前分类及当前分类下的子孙分类id
        //找到所有上级分类->添加当前分类->获取当前分类子孙id->添加分类子孙分类id
        $newpid=(int)$newpid;
        if($newpid){
            //找到所有上级分类
            $lists = db('document_category') -> where("CONCAT(',',child,',') like '%,$newpid,%'")->whereOr('id',$newpid) -> field('id,child')->order('pid asc') -> select();
            foreach ($lists as $item){
                $newchild=$item['child'];
                $newchild=$newchild?$newchild.',':'';
                //添加当前分类
                $newchild=$newchild.$category['id'];
                //获取当前分类子孙id
                if(isset($category['child'])&&$category['child']!=''){
                    //添加分类子孙分类id
                    $newchild=$newchild.','.$category['child'];
                }
                $sql="update ".$prefix."document_category set child='$newchild' where id=".$item['id'].";";
                Db::execute($sql);
            }
        }
	}
    /**
     * 设置栏目分类中parent_id
     * $id=分类id
     * $child_id=当前分类的所有子孙分类id
     */
    private function set_category_parent_id($id,$child_id){
        $id=(int)$id;
        if(!$id){
            $this -> error('参数错误，非法请求！');
        }
        //$id和$child_id放到一个数组中，循环改变其parent_id;
        $idArr=explode(',',$child_id);
        array_push($idArr,$id);

        foreach ($idArr as $item){
            //获取分类的所有父id
            $lists = db('document_category') -> where("CONCAT(',',child,',') like '%,$item,%'") -> field('id')->order('pid asc') -> select();
            $parentArr=array();
            foreach ($lists as $category){
                array_push($parentArr,$category['id']);
            }
            db('document_category')->where('id',$item)->update(['parent_id'=>implode(',',$parentArr)]);
        }
    }
    /**
     * 工具页面：重置所有分类的child_id和parent_id
     */
    public  function reset_category_child_parent_id(){
        $category_lists = db('document_category') -> field('id,pid')->order('id asc') -> select();
		
        foreach ($category_lists as $var){
        	//更新子类（child 字段） begin
			//每次循环前 将数组清空		
			array_splice($this->childList, 0, count($this->childList));
			//调用递归方法
			$list_child=$this->new_get_category_child_id($category_lists,$var['id']);
			
			if($list_child){
				//有子类 处理数据
				$var_child_lists=implode(",", array_reverse($list_child));//array_reverse()以相反的元素顺序返回数组。
				//将处理好的字符串 更新到child字段	
				db('document_category') ->where('id',$var['id'])->setField('child',$var_child_lists);
			}else{
				//没有子类  更新为空
				db('document_category') ->where('id',$var['id'])->setField('child','');
			}
			//更新子类 over
			
			//更新 父类 parent_id字段 begin
			//每次循环前 将数组清空		
			array_splice($this->parentList, 0, count($this->parentList));
			//调用递归方法
			$list_parent=$this->new_get_category_parent_id($category_lists,$var['pid']);
			if($var['pid']==0){
				//顶级分类  更新为空
				db('document_category') ->where('id',$var['id'])->setField('parent_id','');
			}else{
				//有父类 处理数据
				//将根id加入到数组
				array_push($list_parent,$var['pid']);
				//去除 数组中的 0、null、""。
				$list_parent=array_filter($list_parent);
				//转换为 字符串
				$var_parent_lists=implode(",",$list_parent);
				//将处理好的字符串 更新到child字段	
				db('document_category') ->where('id',$var['id'])->setField('parent_id',$var_parent_lists);
			}
        }
        $this -> success('已重置所有分类的child和parent_id！',null,'stop');
    }
	//定义全局变量 子类列表数组
	private $childList=array();
	//子类递归方法
	private function new_get_category_child_id($lists,$pid){
	    foreach ($lists as $item){
	        if($item['pid']==$pid){
	            $arr=$this->new_get_category_child_id($lists,$item['id']);
				array_push($this->childList ,$item['id']);
	        }
	    }
	    return $this->childList;
	}
	
	//定义全局变量 父类列表数组
	private $parentList=array();
	//父类递归方法
	private function new_get_category_parent_id($lists,$pid){
	    foreach ($lists as $item){
	        if($item['id']==$pid){
	            $arr=$this->new_get_category_parent_id($lists,$item['pid']);
				array_push($this->parentList ,$item['pid']);
	        }
	    }
	    return $this->parentList;
	}
	
	
	
	
    public  function reset_category_child_parent_ids($id,$child_id){
        $this->set_category_parent_id($id,$child_id);
        $this -> success('已重置所有分类的child_id和parent_id！',null,'stop');
    }
	
	
	//循环获取列表中每个元素的子元素id
	private function get_category_child_id($lists,$pid){
		$treeList=[];
	    foreach ($lists as $item){
	        if($item['pid']==$pid){
	        	array_push($treeList,$item['id']);

	            $childItem=$this->get_category_child_id($lists,$item['id']);
	            if($childItem){
	                $treeList=array_merge($treeList,$childItem);
	            }
	        }
	    }
	    return $treeList;
	}
	
	/**
	 * 分类转换为数据树（栏目分类页面）
	 */
	private function list_to_html_tree($lists) {
	
		$treeList=[];
		foreach($lists as $key=>$item){
			$item['line']='';
			
			for($x=0;$x<$item['level'];$x++){
				$item['line']='<span class="zz-tree-item-line"></span>'.$item['line'];
			}
	
			if(isset($item['child'])){
				$item['icon']='<span class="zz-tree-icon '.($item['level']>0?'zz-tree-after-line':'').'"><i class="layui-icon zz-tree-ctrl layui-icon-subtraction"></i></span>';
	            $treeItem=$this->list_to_html_tree($item['child']);
				unset($item['child']);
				array_push($treeList,$item);
	            $treeList=array_merge($treeList,$treeItem);
	        }
			else{
				$item['icon']='<span class="zz-tree-icon '.($item['level']>0?'zz-tree-after-line':'').'"><i class="layui-icon zz-tree-sigle layui-icon-file"></i></span>';
				array_push($treeList,$item);
			}
		}
	    return $treeList;
	}
}
