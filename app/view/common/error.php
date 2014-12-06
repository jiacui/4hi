<?php
use Lavender\Validator;

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php
    if($code== 1211|| $code==1212){
        echo '<meta http-equiv="refresh" content="5" url="?action=admin_manage.login" />';
    }
    ?>
    <title> <?php echo($code); ?></title>
    <script type="text/javascript">
        function run(){
            var s = document.getElementById("dd");
            if(s.innerHTML == 0){
                return false;
            }
            s.innerHTML = s.innerHTML * 1 - 1;
        }
        function tologin(){
            window.setInterval("run();", 1000);
        }
    </script>
    <link type="text/css" rel="stylesheet" href="style/layout.css" />
</head>

<body class="login_box">
<div class="login">
    <div class="box_top"></div>
    <div class="box">
            <?php
            if($code== 1211|| $code==1212){
                echo '未登录或会话已过期，<span id="dd">5</span>秒后将会重置到登录页面，请重新登录';
                echo '<script type="text/javascript">tologin();</script>';
            }else{
                echo($msg);
            }
            ?>
    </div>
    <div class="box_bottom"></div>
</div>
</body>
</html>
