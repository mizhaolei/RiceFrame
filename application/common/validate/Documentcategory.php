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

class Documentcategory extends Validate {

    protected $rule =   [
        'title' => 'require|max:50',
        'name' => 'max:30',
        'pid'=>'require|number',
        'display'=>'require|number',
        'type' => 'require|number',
        'sort' => 'require|number',
        'link_str' => 'max:255',
        'keywords' => 'max:255',
        'description' => 'max:255',
        'meta_title' => 'max:50',
        'template_index'=>['regex' => '/^[a-zA-Z0-9]/'],
        'template_lists'=>['regex' => '/^[a-zA-Z0-9]/'],
        'template_detail'=>['regex' => '/^[a-zA-Z0-9]/'],
    ];

    protected $message  =   [
        'title.require' => '请输入文章标题!',
        'title.max' => '文章标题最多输入50个字符',
        'name.max' => '标识最多输入30个字符',
        'type.number' => '分类类别只能是数字',
        'sort.number' => '排序只能是数字!',
        'link_str.max' => '外链最多输入255个字符',
        'keywords.max' => '关键字最多输入255个字符',
        'description.max' => '描述最多输入255个字符',
        'meta_title.max' => 'SEO的网页标题最多输入50个字符',
        'template_index'=>'模板文件名必须以字母或数字开头！',
        'template_lists'=>'模板文件名必须以字母或数字开头！',
        'template_detail'=>'模板文件名必须以字母或数字开头！'
    ];
    //更新排序
    protected $scene = [
        'sort'  =>  ['sort']
    ];
}
