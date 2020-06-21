<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\index\controller;
use app\common\validate\Messageform as MessageformValidate;


class Messageform extends Base
{
    /**
     * 新增留言
     */
    public function addMessageform(){
        if(request()->isPost()){
            $data=$_POST;

			//            验证
            $messageformValidate=new MessageformValidate();
            if (!$messageformValidate->check($data)) {
                $this->error($messageformValidate->getError());
            }
            $msgData['name']=isset($data['name'])?$data['name']:'';
            $msgData['tel']=isset($data['tel'])?$data['tel']:'';
            $msgData['email']=isset($data['email'])?$data['email']:'';
            $msgData['content']=$data['content'];
            $msgData['create_time']=time();

            $re=db('message_form')->insertGetId($msgData);
            if($re){
                $this->success('留言成功');
            } else {
                $this->error('留言失败');
            }
        } else {
            return $this->fetch();
        }
    }

}
