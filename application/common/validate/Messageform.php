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

class Messageform extends Validate {

    protected $rule =   [
        'content' => 'require',
        'tel' => 'number|max:11',
    ];
    protected $message  =   [
        'content.require' => '请输入留言内容！',
        'tel.number' => '手机号必须是数字！',
        'tel.max' => '手机号不得超过11位！',
    ];
}
