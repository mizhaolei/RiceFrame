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

class Adminactionlog extends Validate {

    protected $rule =   [
        'remark' => 'max:255',
        'action_id' => 'number',
        'status' => 'number',
    ];
    protected $message  =   [
        'remark.max' => '日志备注最多输入255个字符',
        'action_id.number' => '行为id只能为数字',
        'status.number' => '行为状态只能为数字',
    ];

}
