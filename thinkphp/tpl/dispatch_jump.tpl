{__NOLAYOUT__}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>跳转提示</title>
    <style type="text/css">
        *{ padding: 0; margin: 0; }
        body{ background: #fff; font-family: "Microsoft Yahei","Helvetica Neue",Helvetica,Arial,sans-serif; color: #333; font-size: 16px; }
        .system-message{ padding: 24px 48px; }
        .system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
        .system-message .jump{ padding-top: 20px;}
        .system-message .jump a{ color: #333; }
        .system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px; }
        .system-message .error ,.system-message .success{width:300px;margin:0 auto;box-sizing:border-box;text-align:center;}
        .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display: none; }
    </style>
</head>
<body>
<div class="text-center" style="margin: 100px auto;">
    <div class="system-message">
        <?php switch ($code) {?>
        <?php case 1:?>
        <img src="/static/images/success.jpg" alt="success" style="width: 300px;margin:0 auto;display:block;">
        <div class="success"><?php echo(strip_tags($msg));?></div>
        <?php break;?>
        <?php case 0:?>
        <img src="/static/images/error.jpg" alt="error" style="width: 300px;margin:0 auto;display:block;">
        <div class="error"><?php echo(strip_tags($msg));?></div>
        <?php break;?>
        <?php } ?>
        <p class="detail"></p>
        <h4 class="jump" style="text-align: center;">
            页面自动 <b><a id="href" href="<?php echo($url);?>">跳转</a></b> 等待时间： <b id="wait"><?php echo($wait);?></b>
        </h4>
    </div>
</div>
    <script type="text/javascript">
        (function(){
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
