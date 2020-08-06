function initIndex(){
    //从本地存储中获得最后访问记录
    var localAdmin = layui.data('layuiAdmin');
    if(localAdmin.current_url){
        $("#zz-iframe").attr("src", localAdmin.current_url);
        //高亮显示左侧菜单
        $('#LAY-system-side-menu a').each(function () {
            var that=$(this);
            if(that.attr('href')==localAdmin.current_url){
                that.addClass('layui-this');
                that.parents('.layui-nav-item').addClass('layui-nav-itemed');
                return false;
            }
        });
    }
    else{
        $("#zz-iframe").attr("src", "?s=index/main.html");
    }

    //存储最后访问的url
    $('#LAY-system-side-menu a').click(function () {
        var target=$(this).attr('href');
        if(target){
            $("#zz-iframe").attr("src", target);
            //记录当前访问的url.
            layui.data('layuiAdmin', {
                key: 'current_url'
                ,value: target
            });
        }
        return false;
    });

    //用来处理弹出的框架里的,服务端返回的信息
    window.pageAction=function(msg,url,wait){
        layer.msg(msg,{icon: 7,time:wait*1000},function () {
            if(url=='javascript:history.back(-1);'){
                return;
            }
            $("#zz-iframe").attr("src", url);
            //记录当前访问的url.
            layui.data('layuiAdmin', {
                key: 'current_url'
                ,value: url
            });
        });
    }

    //弹出操作窗口
    $('.open-win').click(function () {
        var that=$(this);
        var url=$.trim(that.attr('href'));

        if(url==''){
            zzError('错误：没有设置目标链接！');
            return ;
        }
        var title=$.trim(that.attr('title'));

        title=title==''?'信息':title;

        var winWidth=$.trim(that.attr('win-width'));
        winWidth=winWidth==''?'700px':winWidth+'px';

        var winHeight=$.trim(that.attr('win-height'));
        winHeight=winHeight==''?'auto':winHeight+'px';


        top.layer.open({
            type:2,
            title:title,
            area: [winWidth,winHeight], //宽高
            content:url,
            success:function(e,index){
                if(winHeight=='auto')
                    parent.layer.iframeAuto(index);
            }
        });
        return false;
    });
    //ajax-post操作，一般用于单个删除
    $('.ajax-post').click(function(){
        var that = this;
        var url=$.trim($(that).attr('href'));
        if(url==''){
            zzError('错误：没有设置目标链接！');
            return;
        }
        if ($(this).hasClass('confirm') ) {
            var confirmLayer=top.layer.confirm('您确认要执行该操作吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                top.layer.close(confirmLayer);
                var target=$(that).attr('href');
                zzpost(target);
            });
        }
        else{
            var target=$(that).attr('href');
            zzpost(target);
        }
        return false;
    });
}