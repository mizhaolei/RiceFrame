//信息提示-成功
function zzSuccess(msg,wait,fun){
    if(!wait){
        wait=2;
    }
    top.layer.msg(msg?msg:'操作成功',{icon: 1,time:wait*1000,shade:[0.1, '#ffffff']},fun);
}
//信息提示-失败
function zzError(msg,wait,fun){
    if(!wait){
        wait=2;
    }
    top.layer.msg(msg?msg:'操作失败',{icon: 2,time:wait*1000,shade: [0.1, '#ffffff']},fun);
}
/*
//封装Jquery ajax方法
//必须要求引入jquery
//必须引用layer
*url=请求地址
*data=请求参数
*fun1=后台返回结果成功时，执行的回调，回调返回true，将跳出封装方法。
*fun0=后台返回结果失败时，执行的回调，回调返回true，将跳出封装方法。
*/
//封装post方法
function zzpost(url,data,fun1,fun0){
    url=$.trim(url);
    if(url==''){
        zzError('错误：AJAX没有设置目标地址！');
        return;
    }
    var loadIndex=top.layer.load(1, {
        shade: [0.2,'#000'] //0.1透明度的白色背景
    });
    $.ajax({
        url:url,
        type:'POST',
        data:data,
        dataType:'JSON',
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            top.layer.close(loadIndex);
            var errMsg=XMLHttpRequest.status;
            //几种状态码
            switch (XMLHttpRequest.status) {
                case 400:errMsg='请求错误，CODE:'+errMsg;break;
                case 401:errMsg='请求未授权，CODE:'+errMsg;break;
                case 403:errMsg='拒绝请求，CODE:'+errMsg;break;
                case 404:errMsg='404 NOT FOUND，CODE:'+errMsg;break;
                case 500:errMsg='服务器错误，CODE:'+errMsg;break;
                case 503:errMsg='服务器错误，CODE:'+errMsg;break;
            }
            top.layer.msg(errMsg,{icon: 2,time:2000});
        },
        success:function (data) {
            top.layer.close(loadIndex);
            if (data.code==1) {
                //如果有成功的回调，执行成功的回调。
                if(fun1){
                    //如果成功的回调返回true，跳出方法
                    var funre=fun1(data);
                    if(funre){
                        return;
                    }
                }
                //判断是否要执行返回上一页
                if(data.data=="back"){
                    //弹出后台返回的结果信息
                    zzSuccess(data.msg,data.wait,function(){
                        history.back();
                        if(window.name){
                            var index = top.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                            top.layer.close(index); //再执行关闭
                        }
                    });

                    return;
                }
                //判断是否要整个页面刷新
                if(data.data=="top"){
                    zzSuccess(data.msg,data.wait,function(){
                        top.location.reload();
                    });
                    return;
                }
                //判断是否禁用刷新
                if(data.data=="norefresh"){
                    return;
                }

                //判断是否在弹出的模态窗口中执行的
                if(window.name){
                    if(typeof (top.frames["zz-iframe"])=='undefined'){
                        zzSuccess(data.msg,data.wait,function(){
                            if(data.url==''||data.url=='javascript:history.back(-1);'){
                                top.location.reload(true);
                            }
                            else{
                                top.location.href=data.url;
                            }
                        });
                    }
                    else{
                        //对iframe中的子页面进行操作
                        if(data.url==''||data.url=='javascript:history.back(-1);'){
                            top.frames["zz-iframe"].contentWindow.location.reload();
                        }
                        else{
                            top.frames["zz-iframe"].contentWindow.location.href=data.url;
                        }
                        //弹出后台返回的结果信息
                        zzSuccess(data.msg,data.wait);

                    }
                    var index = top.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    top.layer.close(index); //再执行关闭
                    return;
                }



                zzSuccess(data.msg,data.wait,function () {
                    if(data.url){
                        location.href=data.url;
                    }
                    else{
                        location.reload();
                    }
                });

            }else{
                //如果有失败的回调，执行失败回调
                if(fun0){
                    //如果失败回调返回true，跳出方法。
                    var funre=fun0(data);
                    if(funre){
                        return;
                    }
                }
                zzError(data.msg,data.wait);
            }
        }

    });
}
