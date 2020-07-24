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
 * 获取数据库中的配置列表
 * @return array 配置数组
 * $c=1 前台配置，$c=2后台配置
 */
function get_db_config($c=1){
    $c=(int)$c;
    $data   = db('config')->where('status',1);
    $data=$data->where('module','in',"0,$c");
    $data   = $data->field('type,name,value')->select();

    $config = array();
    if($data && is_array($data)){
        foreach ($data as $value) {
            //解析数组
            if($value['type']==3){
                $array = preg_split('/[,;\r\n]+/', trim($value['value'], ",;\r\n"));
                if(strpos($value['value'],':')){
                    $value['value']  = array();
                    foreach ($array as $val) {
                        list($k, $v) = explode(':', $val);
                        $value['value'][$k]   = $v;
                    }
                }else{
                    $value['value'] =    $array;
                }

            }
            $config[$value['name']] = $value['value'];
        }
    }
    return $config;
}

/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($hook,$params=array()){
    think\facade\Hook::listen($hook,$params);
}