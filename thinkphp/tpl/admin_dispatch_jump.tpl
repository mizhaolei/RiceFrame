{__NOLAYOUT__}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>跳转提示</title>
    <style type="text/css">
        *{ padding: 0; margin: 0; }
        body{ background: #f7f7f7; font-family: "Microsoft Yahei","Helvetica Neue",Helvetica,Arial,sans-serif; color: #333; font-size: 16px; }
        .system-message{ width:70%;padding: 24px 0; position: absolute;
        	top:50%;
        	left:15%;
        	margin-top: -150px;
        }
        .system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
        .system-message .msg{
        	padding: 10px 0;
        	text-align: center; line-height: 1.8em; font-size: 28px;
        }
        .system-message .jump{ font-size: 14px; text-align: center; }
        .system-message .jump a{ color: #333; }

        .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display: none; }
        .icon{
        	height:120px;
        	background-position: center center;
        	background-repeat: no-repeat;
        }
        .icon-error{
        	background-image: url('/theme/ico_stop.png');
        }
        .icon-success{
        	background-image: url('/theme/ico_success.png');
        }
        .copyright{
        	width: 100%;
        	position: absolute;
        	bottom: 0;
        	left:0;
        	text-align: center;
        	padding: 30px 0;
        	font-size:12px;
        	color: #bbb;
        }
        .copyright a{
        	color: #bbb;
        	text-decoration: none;
        }
    </style>

</head>
<body>
    <div class="system-message" id="system-message" style="display: none">
        <?php switch ($code) {?>
            <?php case 1:?>
            <h1 class="icon icon-success"></h1>
            <p class="msg success"><?php echo(strip_tags($msg));?></p>
            <?php break;?>
            <?php case 0:?>
            <h1 class="icon icon-error"></h1>
            <p class="msg error"><?php echo(strip_tags($msg));?></p>
            <?php break;?>
        <?php } ?>
        <p class="detail"></p>
        <p class="jump" id="jump">
            页面自动 <a id="href" href="<?php echo($url);?>">跳转</a> 等待时间： <b id="wait"><?php echo($wait);?></b>
        </p>
    </div>
    <div class="copyright">
    	Power by HulaCWMS &copy <a href="http://www.zhuopro.com/" target="_blank">灼灼文化</a>
    </div>

    <script type="text/javascript">
        (function(){
            var windowName=window.name;
            if(windowName&&top.layer){
                var index = top.layer.getFrameIndex(window.name);
                top.pageAction("<?php echo(strip_tags($msg));?>","<?php echo($url);?>",<?php echo($wait);?>);
                top.layer.close(index);
                return;
            }
            document.getElementById('system-message').style.display='block';
            //如果data==stop，停止跳转
            if("<?php echo($data);?>"=='stop'){
                document.getElementById('jump').style.display='none';
                return;
            }

            var wait = document.getElementById('wait'),
                href = document.getElementById('href').href;
            var interval = setInterval(function(){
                var time = --wait.innerHTML;
                if(time <= 0) {
                    location.href = href;
                    clearInterval(interval);
                };
            }, 1000);
        })();
    </script>
</body>
</html>
