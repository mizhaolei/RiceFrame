<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\common\taglib;
use think\template\TagLib;
class Zz extends TagLib{
    /**
     * 定义标签列表
     */
    protected $tags   =  [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'channel'=> ['attr' => 'type,typeid,row,void,where,orderby,display', 'close' => 1],
        'arclist'=> ['attr' => 'typeid,orderby,row,void,model,type,where,display,ids,limit', 'close' => 1],
        'type'=> ['attr' => 'typeid', 'close' => 1],
        'list'=> ['attr' => 'orderby,pagesize,type,typeid,void,model,where,display', 'close' => 1],
        'prenext'=> ['attr' => 'get,cid,void', 'close' => 1],
        'flink'=> ['attr' => 'type,row,void', 'close' => 1],
        'sql'=> ['attr' => 'sql', 'close' => 1],
        'article'=> ['attr' => 'id,void,model', 'close' => 1],
        'tags'=> ['attr' => 'tags,void', 'close' => 1],
    ];


    /**
     * 栏目列表
     * type,栏目分类数据读取分类
     * typeid,栏目分类，数字，字符串，或者变量
     */
    public function tagChannel($tag,$content)
    {
        $type=isset($tag['type'])?$tag['type']:'son';
        $typeid=isset($tag['typeid'])?$tag['typeid']:'$cid';
        $row=isset($tag['row'])?$tag['row']:100;
        $void=isset($tag['void'])?$tag['void']:'field';
        $where=isset($tag['where'])?$tag['where']:'';
        $orderby=isset($tag['orderby'])?$tag['orderby']:'sort asc';

        $display=isset($tag['display'])?$tag['display']:1;
        $display=$display==1?1:0;

        //3中传参类型
        //1、栏目id，数字类型
        //2、多个栏目id，逗号隔开
        //3、变量
        //只有当多个栏目id时，才需要单引号加持。保证生成的为字符串
        if(strpos($typeid,',')){
            $typeid="'$typeid'";
        }

        $parse = '<?php ';
        $parse .= '$__LIST__ = '."tpl_get_channel(\"$type\",$typeid,$row,\"$where\",\"$orderby\",$display);";
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="'.$void.'"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    /**
     * 文章列表
     */
    public function tagArclist($tag,$content)
    {
        $typeid = isset($tag['typeid'])?$tag['typeid']:'$cid';
        $orderby=isset($tag['orderby'])?$tag['orderby']:'sort asc,create_time desc';
        $row=isset($tag['row'])?$tag['row']:'100';
        $void=isset($tag['void'])?$tag['void']:'field';
        $model=isset($tag['model'])?$tag['model']:'article';
        $type=isset($tag['type'])?$tag['type']:'find';
        $where=isset($tag['where'])?$tag['where']:'';
        $ids=isset($tag['ids'])?$tag['ids']:'';
        $limit=isset($tag['limit'])?$tag['limit']:'100';
        //limit参数优先于row
        if(isset($tag['limit'])){
            $row=$tag['limit'];
        }

        $display=isset($tag['display'])?$tag['display']:1;
        $display=$display==1?1:0;

        //3中传参类型
        //1、栏目id，数字类型
        //2、多个栏目id，逗号隔开
        //3、变量
        //只有当多个栏目id时，才需要单引号加持。保证生成的为字符串
        if(strpos($typeid,',')){
            $typeid="'$typeid'";
        }

        $parse = '<?php ';
        $parse .= '$__LIST__ = '."tpl_get_article_list($typeid,\"$row\",\"$orderby\",\"$model\",\"$type\",\"$where\",$display,\"$ids\");";;
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="'.$void.'"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    /**
     * 栏目分类-单个
     */
    public function tagType($tag,$content)
    {
        if(!isset($tag['typeid'])){
            return '';
        }
        $typeid = $tag['typeid'];

        $parse = '<?php ';
        $parse .= '$__LIST__ =[];array_push($__LIST__,get_document_category('.$typeid.'));';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="field"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }


    /**
     * 列表分页
     */
    public function tagList($tag,$content)
    {
        $orderby=isset($tag['orderby'])?$tag['orderby']:'sort asc,create_time desc';
        $pagesize=isset($tag['pagesize'])?$tag['pagesize']:15;
        $type=isset($tag['type'])?$tag['type']:'find';
        $typeid=isset($tag['typeid'])?$tag['typeid']:'$cid';
        $void=isset($tag['void'])?$tag['void']:'field';
        $model=isset($tag['model'])?$tag['model']:'article';
        $where=isset($tag['where'])?$tag['where']:'';

        $display=isset($tag['display'])?$tag['display']:1;
        $display=$display==1?1:0;

        $parse = '<?php ';
        $parse .= '$__FUN__ ='."tpl_get_list(\"$orderby\",$pagesize,$typeid,\"$type\",\"$model\",\"$where\",$display);";
        $parse .= '$__LIST__ =$__FUN__["lists"];$pager = $__FUN__["model"]->render();';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="'.$void.'"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    /**
     * 详情页 上一篇 下一篇
     * get=pre|next获取上一篇还是下一篇
     * cid=栏目分类id，获取当前分类下的上一篇下一篇
     */
    public function tagPrenext($tag,$content)
    {
        $get=isset($tag['get'])?$tag['get']:'pre';
        $cid=isset($tag['cid'])?$tag['cid']:'$cid';
        $void=isset($tag['void'])?$tag['void']:'field';

        $parse = '<?php ';
        $parse .= '$__LIST__ =[];array_push($__LIST__,'."tpl_get_prenext(\"$get\",$cid));";
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="'.$void.'"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    /**
     * 友情链接
     */
    public function tagFlink($tag,$content)
    {
        $type=isset($tag['type'])?$tag['type']:'text';
        $type=$type=='text'?0:1;
        $row=isset($tag['row'])?$tag['row']:100;
        $void=isset($tag['void'])?$tag['void']:'field';

        $parse = '<?php ';
        $parse .= '$__LIST__ ='."tpl_get_friend_link($type,$row);";
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="'.$void.'"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    /**
     * 执行SQL
     */
    public function tagSql($tag,$content)
    {
        if(!isset($tag['sql'])){
            return '';
        }
        $sql=$tag['sql'];
        $parse = '<?php ';
        $parse .= '$__LIST__ ='."db()->query(\"$sql\");";
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="field"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    /**
     * 获取单篇文章
     */
    public function tagArticle($tag,$content)
    {
        if(!isset($tag['id'])){
            return '';
        }
        $void=isset($tag['void'])?$tag['void']:'field';
        $model=isset($tag['model'])?$tag['model']:'article';
        $id=$tag['id'];
        $parse = '<?php ';
        $parse .= '$__LIST__ =[];array_push($__LIST__,'."tpl_get_article($id,'$model'));";
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="'.$void.'"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

    /**
     * 文章标签
     */
    public function tagTags($tag,$content)
    {
        if(!isset($tag['tags'])){
            return false;
        }
        $tags=$tag['tags'];
        $void=isset($tag['void'])?$tag['void']:'field';

        $parse = '<?php ';
        $parse .= '$__TAG_LIST__ ='."tpl_get_tags_list($tags);";
        $parse .= ' ?>';
        $parse .= '{volist name="$__TAG_LIST__" id="'.$void.'"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

}