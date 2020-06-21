/*
//上传组件封装
//上传组件默认会渲染class=zzBtnUpload的元素
//元素按钮可以通过设置属性url=上传服务器地址，multi=是否批量上传。来指定
//zzUpload是暴露在外的方法，可以在页面调用。因加载回调原因，不能在页面加载时调用，须在页面加载完成，其他事件中执行。否则会报错。
//本文件只需要引入一次
 */
var zzUpload=null;
layui.use(['upload'], function(){
    var upload=layui.upload;
    /*
    *封装上传组件
    * upload=upload组件对象
    *obj=组件渲染元素，如'.zzBtnUploadPicMultiple'
    *multiple=是否批量上传，true|false
    *
    */
    zzUpload=function(obj,UPLOAD_URL,multiple){
        upload.render({
            elem: obj,
            url:UPLOAD_URL
            ,multiple:multiple
            ,done: function(res, index, upload){
                var item = this.item;
                $(item).removeAttr('disabled');
                $(item).html('<i class="layui-icon">&#xe67c;</i>上传图片');
                if(res.code==1){
                    var pic='';
                    if(res.data.url!=''){
                        pic=res.data.url;
                    }
                    else{
                        pic=res.data.path;
                    }
                    var uploadVal=$(item).parent().children('.zz-upload-value');
                    var uploadShow=$(item).parent().children('.zz-upload-pic-show');

                    //如果是批量上传
                    if(multiple){
                        var uploadValArr=[];
                        if($.trim(uploadVal.val())!=''){
                            uploadValArr=uploadVal.val().split(',')
                        }
                        uploadValArr.push(pic);
                        uploadVal.val(uploadValArr.join(','));
                        uploadShow.append('<div class="zz-upload-pic-show-item"><a class="layui-icon layui-icon-close" title="删除"></a><img alt="" src="'+pic+'"></div>');
                    }
                    else{
                        uploadVal.val(pic);
                        uploadShow.html('<div class="zz-upload-pic-show-item"><a class="layui-icon layui-icon-close" title="删除"></a><img alt="" src="'+pic+'"></div>');
                    }

                    uploadShow.show();
                }
                else{
                    zzError(res.msg,res.wait);
                }
            }
            ,choose:function (obj) {
                $(this.item).attr('disabled','disabled');
                $(this.item).html('<i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop"></i>上传中...');
            }
            ,error:function () {
                $(this.item).removeAttr('disabled');
                $(this.item).html('<i class="layui-icon">&#xe67c;</i>上传图片');
                zzError("上传失败");
            }
        });
    };

    //渲染class=zzBtnUpload的组件
    //初始化上传图片列表，多用于编辑页面
    $('.zzBtnUpload').each(function () {
        var that=$(this);
        //服务器响应地址
        var uploadServerUrl=$.trim(that.attr('url'));

        if(uploadServerUrl==''){
            //获取全局定义的上传文件服务器地址
            if(typeof(UPLOAD_URL)=='undefined'){
                console.error('上传组件没有指定上传服务器地址');
                return;
            }
            uploadServerUrl=UPLOAD_URL;
        }

        var multiple=$.trim(that.attr('multi'));

        multiple=multiple=='true'?true:false;

        zzUpload('.zzBtnUpload',uploadServerUrl,multiple);
    });

    //删除上传图片按钮事件
    $('.zz-upload-pic-show').on('click','.layui-icon-close',function () {
        var domParent=$(this).parent();
        var uploadVal=domParent.parent().prev();
        var uploadValArr=uploadVal.val().split(',');
        uploadValArr.splice(domParent.index(),1);
        uploadVal.val(uploadValArr.join(','));
        domParent.remove();
    });

    //初始化上传图片列表，多用于编辑页面
    $('.zz-upload-value').each(function () {
        var uploadVal=$(this).val();
        if($.trim(uploadVal)==''){
            return;
        }
        var uploadValArr=uploadVal.split(',');
        var uploadShow=$(this).next();
        for(var x in uploadValArr){
            uploadShow.append('<div class="zz-upload-pic-show-item"><a class="layui-icon layui-icon-close" title="删除"></a><img alt="" src="'+uploadValArr[x]+'"></div>');
        }
    });
});