<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 中文字符截取
 */
function cn_substr($str,$len){
    return mb_substr($str,0,$len,'utf-8');
}
/**
 * 时间戳格式化
 */
function MyDate($ft,$data){
    return date($ft,$data);
}
/**
 * 过滤html标签
 */
function html2text($str){
    return strip_tags($str);
}
/**
 * 获取文章分类的内容
 * $id=文章id
 * $strip=true过滤html
 */
function get_type_content($id,$strip=false){
    $dc=db('document_category_content')->find($id);
    if(!$dc){
        exception('分类不存在或已删除！');
    }
    if($strip){
        return html2text($dc['content']);
    }
    return $dc['content'];
}
/**
 * 获取文章分类
 */
function get_document_category_list(){
    //缓存文章菜单
    $docuemtCategory=cache('DATA_DOCUMENT_CATEGORY_LIST');
    if($docuemtCategory===false){
        $docuemtCategoryList=db('document_category')->where('status',1)->order('sort asc')->select();

        //转换，让id作为数组的键
        $docuemtCategory=[];
        foreach ($docuemtCategoryList as $key=>$item){
            //根据栏目类型，生成栏目url
            $item['url']=curl($item);

            $docuemtCategory[$item['id']]=$item;
        }
        cache('DATA_DOCUMENT_CATEGORY_LIST',$docuemtCategory);
    }
    return $docuemtCategory;
}


/**
 * 获取一个文章分类
 */
function get_document_category($x,$field=false){
    if(!$x){
        exception('请指定要获取的栏目分类id！');
    }
    //获取缓存的文章菜单
    $docuemtCategoryList=get_document_category_list();
	
	$docuemtCategory=$docuemtCategoryList[$x];
	if(!$docuemtCategory){
        exception('分类不存在或已删除！');
    }
    if($field){
        return $docuemtCategory[$field];
    }
    else{
        return $docuemtCategory;
    }
}

/**
 * 获取一个文章分类-通个分类标识
 */
function get_document_category_by_name($name,$field=false){
    if(!$name){
        exception('请指定要获取的栏目分类标识！');
    }
    //获取缓存的文章菜单
    $docuemtCategoryList=get_document_category_list();
    $docuemtCategory=false;
    foreach ($docuemtCategoryList as $item){
        if($item['name']==$name){
            $docuemtCategory=$item;
            break;
        }
    }
    if(!$docuemtCategory){
        exception('分类不存在或已删除！');
    }
    if($field){
        return $docuemtCategory[$field];
    }
    else{
        return $docuemtCategory;
    }
}

/**
 * 模板-获取文章分类
 */
function tpl_get_channel($type,$typeid,$row,$where='',$orderby='',$display=1){

    switch($type){
        case 'top':
            //获取顶级分类
            return get_document_category_by_parent(0,$row,$display);
            break;
        case 'son':
            //获取子级分类
            if(!$typeid){
                exception('请指定要获取的栏目分类id！');
            }
            return get_document_category_by_parent($typeid,$row,$display);
            break;
        case 'self':
            //获取同级分类
            if(!$typeid){
                exception('请指定要获取的栏目分类id！');
            }
            $dc=get_document_category($typeid);
            if(!$dc){
                exception('分类不存在或已删除！');
            }
            return get_document_category_by_parent($dc['pid'],$row,$display);;
            break;
        case 'find':
            //获取所有子孙分类，此操作读取数据库，非缓存！
            if(!$typeid){
                exception('请指定要获取的栏目分类id！');
            }
            $dc=get_document_category($typeid);
            if(!$dc){
                exception('分类不存在或已删除！');
            }
            $tempArr=db('document_category')->where('id','in',$dc['child'])->where('status',1)->select();
            if($display){
                $tempArr=$tempArr->where('display',1);
            }
            $tempArr=$tempArr->select();
            foreach ($tempArr as $key=>$item){
                //根据栏目类型，生成栏目url
                $item['url']=curl($item);
                $tempArr[$key]=$item;
            }
            return $tempArr;
            break;
        case 'parent':
            //获取父级分类
            if(!$typeid){
                exception('请指定要获取的栏目分类id！');
            }
            $dc=get_document_category($typeid);
            $tempArr=array();
            $parent=get_document_category($dc['pid']);
            array_push($tempArr,$parent);
            return $tempArr;
            break;
        case 'root':

            if(!$typeid){
                exception('请指定要获取的栏目分类id！');
            }
            $dc=get_document_category($typeid);
            if($dc['pid']!=0){
                //获取根分类，此操作读取数据库，非缓存！
                $dc=db('document_category')->where('pid',0)->where('status',1)
                    -> where("CONCAT(',',child,',') like '%,$typeid,%'");
                if($display){
                    $dc=$dc->where('display',1);
                }
                $dc=$dc->find();
            }


            //根据栏目类型，生成栏目url
            $dc['url']=curl($dc);
            $tempArr=[];
            array_push($tempArr,$dc);
            return $tempArr;
            break;
        case 'where':
            //根据自定义条件获取分类（where语句），此操作读取数据库，非缓存！
            $tempArr=db('document_category')->where('status',1)-> where($where)->order($orderby);
            if($display){
                $tempArr=$tempArr->where('display',1);
            }
            $tempArr=$tempArr->select();
            foreach ($tempArr as $key=>$item){
                //根据栏目类型，生成栏目url
                $item['url']=curl($item);
                $tempArr[$key]=$item;
            }
            return $tempArr;
            break;
        case 'ids':
            //根据多个栏目id，逗号隔开的那种，获得栏目列表
            $tempArr=db('document_category')->where('status',1)-> where('id','in',$typeid)->order($orderby);
            if($display){
                $tempArr=$tempArr->where('display',1);
            }
            $tempArr=$tempArr->select();
            foreach ($tempArr as $key=>$item){
                //根据栏目类型，生成栏目url
                $item['url']=curl($item);
                $tempArr[$key]=$item;
            }
            return $tempArr;
            break;
		default:
            $tempArr=[];
            return $tempArr;
			break;
    }
}
/**
 * 根据父级分类id获取子分类
 * $pid=父级id
 * $row=获取多少数目
 */
function get_document_category_by_parent($pid,$row,$display=1){
    $docmentCategoryList=get_document_category_list();
    $x=1;
    $tempArr=array();
    foreach ($docmentCategoryList as $item){
        if($x>$row){
            break;
        }
        if($item['pid']==$pid&&($display?$item['display']==1:true)){
            $x=$x+1;
            array_push($tempArr,$item);
        }
    }
    return $tempArr;
}
/**
 * 模板-获取上一篇和下一篇
 * $get=上一篇|下一篇
 * $cid=栏目分类id
 */
function tpl_get_prenext($get,$cid=false){
    //文档id
    $id=input('id');
    if(!$get){
        $get='next';
    }

    $document=db('document')->where('display',1)->where('status',1);
    $document=$get=='pre'?$document->where("id",'<',$id):$document->where("id",'>',$id);

    //如果表明在同一分类下查询
    if($cid){
        $document=$document->where("category_id",$cid);
    }
    $document=$document->field('id,title')->order($get=='pre'?'id desc':'id asc')->find();
	
    if($document){
        $document['url']=url('article/detail?id='.$document['id']);
    }
    else{
        $document['id']=false;
        $document['url']='javascript:void(0)';
        $document['title']='没有了';
    }

    return $document;
}

/**
 * 模板-获取文章列表
 * $orderby=数据排序方式
 * $pagesize=每页显示的数据数目
 * $cid=栏目分类id
 * $type=读取数据的方式（son:'获取栏目下文章以及所有子孙分类文章',self:'获取栏目下文章',search:'获取关键字搜索的文章',where:'根据自定义条件获取文章（where语句）'）
 * $table=文章内容扩展表名，默认article
 * $where=自定义条件
 */
function tpl_get_list($orderby,$pagesize,$cid,$type,$table='article',$where=false,$display=1){

    $docmentListModel=db('document')
        ->alias('a')
        ->join(config('database.prefix').'document_category b','a.category_id=b.id','LEFT')
        ->join(config('database.prefix')."document_$table c",'a.id=c.id','RIGHT')
        ->where("a.type='$table'")
        ->where('a.status',1)->where('b.status',1)
        ->field('a.*,b.title as category_title,c.*');

    if($display){
        $docmentListModel=$docmentListModel->where('a.display',1);
    }


	//判断当前是否搜索页面
    if(request()->action()=='search'){
        $type='search';
    }
    switch ($type){
        case 'find':
            //获取栏目下文章以及所有子孙分类文章
            $dc=get_document_category($cid);
            $child=$dc['child'];
            if($child){
                $docmentListModel=$docmentListModel->where('a.category_id','in',"$cid,$child");
            }
            else{
                $docmentListModel=$docmentListModel->where('a.category_id',$cid);
            }
            break;
        case 'son':
            //获取栏目下文章
            $docmentListModel=$docmentListModel->where('a.category_id',$cid);
            break;
        case 'search':
            //获取关键字搜索的文章
            $kw=input('kw'); //搜索关键词
            $tid=input('cid');//文章分类Id
            if($kw){
                $docmentListModel=$docmentListModel->where('a.title','like',"%$kw%");
            }
            if($tid){
                $docmentListModel=$docmentListModel->where('a.category_id',$tid);
            }
            break;
        case 'where':
            //根据自定义条件获取文章（where语句）
            $docmentListModel=$docmentListModel->where($where);
            break;
        case 'tag':
            //读取指定tag的文章
            $docmentListModel=$docmentListModel->where('a.keywords','like',"%$where%");
            break;
    }

    $docmentListModel=$docmentListModel->order($orderby);
    //获取当前请求的请求参数，以确定分页是否要带上这些请求参数
	$query=request()->query();
	if($query){
		$docmentListModel=$docmentListModel->paginate($pagesize,false,['query' => request()->param()]);
	}
	else{
		$docmentListModel=$docmentListModel->paginate($pagesize);
	}
    $lists=[];
    foreach ($docmentListModel as $key=>$item){
        //生成文章url
        $item['url']=aurl($item);
        $lists[$key]=$item;
    }

    $re=[
        'model'=>$docmentListModel,
        'lists'=>$lists
    ];

    return $re;
}


/**
 * 根据栏目类型，生成栏目url
 */
function curl($item){
    if((int)$item['type']==0){
        return url('article/lists?id='.$item['id']);
    }
    elseif((int)$item['type']==1){
        return url('article/lists?id='.$item['id']);
    }
    elseif((int)$item['type']==2){
        return $item['link_str'];
    }
}

/**
 * 生成文章url
 */
function aurl($item){
    //根据栏目类型，生成栏目url
    if($item['link_str']){
        return $item['link_str'];
    }
    else{
        return url('article/detail?id='.$item['id']);
    }
}


/**
 * 模板-根据指定的文章id获取文章内容
 */
function tpl_get_article($id,$table){
    $docmentModel=db('document')
        ->alias('a')
        ->join(config('database.prefix').'document_category b','a.category_id=b.id','LEFT')
        ->join(config('database.prefix')."document_$table c",'a.id=c.id','LEFT')
        ->where('a.status',1)->where('a.display',1)->where('a.id',$id)->where("a.type='article'")
        ->field('a.*,b.title as category_title,c.content');

    $doc=$docmentModel->find();

    if(!$doc){
        return false;
    }

    $doc['url']=aurl($doc);

    return $doc;
}


/**
 * 模板-根据指定的栏目id获取文章列表
 * $cid=栏目分类id
 * $row=读取数据数目
 * $orderby=排序方式
 * $table=文章内容扩展表名，默认article
 * $type=读取数据的方式（son:'获取栏目下文章以及所有子孙分类文章',self:'获取栏目下文章',search:'获取关键字搜索的文章',where:'根据自定义条件获取文章（where语句）'）
 * $where=自定义条件
 */
function tpl_get_article_list($cid,$row,$orderby,$table='article',$type='son',$where=false,$display=1,$ids=''){

    $docmentListModel=db('document')
        ->alias('a')
        ->join(config('database.prefix').'document_category b','a.category_id=b.id','LEFT')
        ->join(config('database.prefix')."document_$table c",'a.id=c.id','RIGHT')
        ->where("a.type='$table'")
        ->where('a.status',1)->where('b.status',1)
        ->limit($row)
        ->field('a.*,b.title as category_title,c.*');

    if($display){
        $docmentListModel=$docmentListModel->where('a.display',1);
    }

    switch ($type){
        case 'find':
            //获取栏目下文章以及所有子孙分类文章
            $dc=get_document_category($cid);
            $child=$dc['child'];
            if($child){
                $docmentListModel=$docmentListModel->where('a.category_id','in',"$cid,$child");
            }
            else{
                $docmentListModel=$docmentListModel->where('a.category_id',$cid);
            }
            break;
        case 'son':
            //获取栏目下文章
            $docmentListModel=$docmentListModel->where('a.category_id',$cid);
            break;
        case 'where':
            //根据自定义条件获取文章（where语句）
            $docmentListModel=$docmentListModel->where($where);
            break;
        case 'ids':
            //读取指定id的文章
            $docmentListModel=$docmentListModel->where('a.id','in',$ids);
            break;
        case 'tag':
            //读取指定tag的文章
            $docmentListModel=$docmentListModel->where('a.keywords','like',"%$where%");
            break;
    }

    $docmentListModel=$docmentListModel->order($orderby)->select();
    $lists=[];
    foreach ($docmentListModel as $key=>$item){
        //生成文章url
        $item['url']=aurl($item);
        $lists[$key]=$item;
    }
    return $lists;
}

/**
 * 模板-根据指定的栏目id获取产品列表
 * $cid=栏目分类id
 * $row=读取数据数目
 * $orderby=排序方式
 * $table=文章内容扩展表名，默认article
 * $type=读取数据的方式（son:'获取栏目下文章以及所有子孙分类文章',self:'获取栏目下文章',search:'获取关键字搜索的文章',where:'根据自定义条件获取文章（where语句）'）
 * $where=自定义条件
 */
function tpl_get_product_list($cid,$row,$orderby,$table='article',$type='son',$where=false,$display=1){
    return tpl_get_article_list($cid,$row,$orderby,'product',$type,$where,$display);
}

/**
 * 模板-友情链接
 */
function tpl_get_friend_link($type,$row){
    $flinkList=cache('DATA_FRIEND_LINK');
    if($flinkList===false){
        $flinkList=db('friend_link')->where('status',1)->order('sort asc')->limit($row)->select();
        cache('DATA_FRIEND_LINK',$flinkList);
    }
    if($type===0){
        return $flinkList;
    }
    $flinkListTemp=[];
    foreach ($flinkList as $key=>$item){
        if($item['image']){
            array_push($flinkListTemp,$item);
        }
    }
    return $flinkListTemp;
}


/**
 * 模板-文章标签
 */
function tpl_get_tags_list($tags){
    if(!$tags){
        return false;
    }
    $tagArr=explode(',',$tags);
    $tagTemp=[];
    foreach ($tagArr as $item){
        $data['title']=$item;
        $data['url']=url('article/tag?t='.urlencode($item));
        array_push($tagTemp,$data);
    }
    return $tagTemp;
}


/**
 * 模板-获取页面的面包屑导航
 */
function tpl_get_position($dc,$positionList=array()){
    array_push($positionList,$dc);
    if($dc['pid']==0){
        $htmlstr='<a href="/">首页</a>';
        $positionListCount=count($positionList);
        for ($x=$positionListCount-1;$x>=0;$x--){
            $htmlstr=$htmlstr.'><a href="'.$positionList[$x]['url'].'">'.$positionList[$x]['title'].'</a>';
        }
        return $htmlstr;
    }
    //获取父级栏目分类
    $parentDc=get_document_category($dc['pid']);
    return tpl_get_position($parentDc,$positionList);
}


//获取顶级栏目名
function GetTopTypename($id=false)
{
    $id=$id?$id:input('id');
    $dc=get_document_category($id);
    if((int)$dc['pid']===0){
        return $dc['title'];
    }

    return GetTopTypename($dc['pid']);
}

//获取顶级id
function GetTopTypeid($id=false)
{
    $id=$id?$id:input('id');
    $dc=get_document_category($id);
    if((int)$dc['pid']===0){
        return $dc['id'];
    }

    return GetTopTypeid($dc['pid']);
}

//获取顶级栏目图片
function GetTopTypeimg($id=false)
{
    $id=$id?$id:input('id');
    $dc=get_document_category($id);
    if((int)$dc['pid']===0){
        return $dc['icon'];
    }
    return GetTopTypeimg($dc['pid']);
}
//获取顶级栏目描述
function GetTopDescription($id=false)
{
    $id=$id?$id:input('id');
    $dc=get_document_category($id);
    if((int)$dc['pid']===0){
        return $dc['description'];
    }

    return GetTopDescription($dc['pid']);
}
//获取顶级英文名称
function GetTopTypenameen($id=false)
{
    $id=$id?$id:input('id');
    $dc=get_document_category($id);
    if((int)$dc['pid']===0){
        return $dc['name'];
    }

    return GetTopTypenameen($dc['pid']);
}
/**
 * 判断当前页面是否在此栏目下
 * 主要用于菜单高亮
 * $cid=栏目id,首页可不填此参数
 * $curr_id=当前页面栏目id,首页可不填此参数
*/
function IsActiveNav($curr_cid=false,$cid=false)
{
    if(request()->action()=='search'){
        return false;
    }
    //首页
    if(!$curr_cid&&!$cid){
        return true;
    }

    //一般在首页中，要比对的栏目id会为false
    if($cid==false){
        return false;
    }

    //如果分类id相等，是在同一页面中
    if($cid==$curr_cid){
        return true;
    }

    //判断是否在同一栏目树下。
    $parent_id=cache('CURR_CATEGORY_PATENT_ID');

    $parent_id=explode(',',$parent_id);

    if(in_array($cid,$parent_id)){
        return true;
    }

    return false;
}