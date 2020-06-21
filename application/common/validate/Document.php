<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\common\validate;
use think\Validate;

/**
 * 后台菜单验证器
 */

class Document extends Validate {

    protected $rule =   [
        'title' => 'require|max:80',
        'uid' => 'number|max:10',
        'name' => 'max:40',
        'category_id' => 'require|number',
        'keywords' => 'max:255',
        'description' => 'max:255',
        'type' => 'number',
        'sort' => 'require|number',
        'link_str' => 'max:255',
        'cover_path' => 'max:255',
    ];

    protected $message  =   [
        'title.require' => '请输入文章标题!',
        'title.max' => '文章标题最多输入80个字符',
        'uid.number' => '用户id只能是数字',
        'uid.max' => '用户id最多输入10个字符',
        'name.max' => '标识最多输入40个字符',
        'category_id' => '请选择文章分类',
        'category_id.number' => '文章分类只能是数字',
        'keywords.max' => '关键字最多输入255个字符',
        'description.max' => '描述最多输入255个字符',
        'link_str.max' => '外链最多输入255个字符',
        'cover_path.max' => '封面最多输入255个字符',
        'type.number' => '内容类型只能是数字',
        'sort.require' => '请输入排序序号',
        'sort.number' => '排序序号只能是数字',

    ];
    //更新排序
    protected $scene = [
        'sort'  =>  ['sort']
    ];

}
