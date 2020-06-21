layui.use(['form','layer','element'], function(){
    $(function () {
        //表单对象
        var form = layui.form;

        //监听表单事件
        form.on('submit(zz-btn-submit)', function(fromData){
            zzpost(fromData.form.action,fromData.field);
            return false;
        });

        //监听复选框事件
        form.on('checkbox(zz-checkbox-table)', function(data){
            var itemStatus = data.elem.checked;
            if (itemStatus == true) {
                $(".zz-table-chk-item").prop("checked", true);
                form.render('checkbox');
            } else {
                $(".zz-table-chk-item").prop("checked", false);
                form.render('checkbox');
            }
        });


        //搜索功能
        $(".zz-form-search .btn-search").click(function() {
            var url = $.trim($(this).attr('url'));
            if(url==''){
                zzError('错误：搜索没有设置目标链接地址！');
                return;
            }
            var query = $('.search-form').find('input').serialize();
            query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=layui.$))/g, '');
            query = query.replace(/^&/g, '');
            if (url.indexOf('?') > 0) {
                url += '&' + query;
            } else {
                url += '?' + query;
            }
            window.location.href = url;
        });

        //回车搜索
        $(".zz-search-form input").keyup(function(e) {
            if (e.keyCode === 13) {
                $("#search").click();
                return false;
            }
        });

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

        //添加，编辑页面取消按钮
        $('.zz-btn-cancel').click(function () {
            var windowName=window.name;
            //判断是否弹出的窗口
            if(windowName){
                //在iframe中
                var index = top.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                top.layer.close(index); //再执行关闭
            }
            else {
                //不在iframe中
                history.go(-1);
            }
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

        //数据表中，启用禁用，显示隐藏开关
        form.on('switch(zz-switch-display)', function(data){
            var itemDom=data.elem;

            var url=$.trim($(itemDom).attr('data-href'));
            if(url==''){
                zzError('错误：没有设置目标链接！');
            }

            var updateVal=data.value==1?0:1;

            zzpost(url,{val:updateVal},function(){
                itemDom.value=updateVal;
                return true;
            },function(){
                itemDom.checked=itemDom.checked?false:true;
                form.render('checkbox');
            });
        });

        //批量操作，多应用批量删除
        $('.zz-btn-delete-all,.zz-btn-select-all').click(function () {
            var that = this;
            parent.layer.confirm('您确认要执行该操作吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){

                var target=$.trim($(that).attr('href'));
                //判断是否选中要删除的对象
                var delDom=$(".layui-table .zz-table-chk-item:checked");

                if(delDom.length==0){
                    zzError('请选择要操作的数据');
                    return false;
                }
                var delItem=new Array();
                delDom.each(function (e) {
                    delItem.push(this.value);
                });
                zzpost(target,{ids:delItem});
            });
            return false;
        });

        //数据表中表单元素ajax修改
        $('.zz-form-datalist input').blur(function () {
            var zzForm=$(this).parents('.zz-form-datalist');
            var url=$.trim(zzForm.attr('action'));

            //判断是否值已改变
            if($(this).attr('data-source')==$(this).val()){
                return false;
            }

            if(url==''){
                zzError('错误：没有设置目标链接地址');
                return false;
            }
            var formFeild = form.val(zzForm.attr('lay-filter'));

            zzpost(url,formFeild);
        });


    })
});