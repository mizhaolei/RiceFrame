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

class Adminauthgroup extends Validate {

    protected $rule =   [
        'title' => 'require|max:20',
        'type' => 'number',
        'description' => 'max:80',
    ];

    protected $message  =   [
        'title.require' => '请输入用户组名称!',
        'title.max' => '用户组名称最多输入20个字符',
        'type.number' => '组类型只能为数字',
        'description.max' => '描述信息最多输入80个字符',
    ];

}
