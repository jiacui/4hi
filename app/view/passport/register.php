
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>注册</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../res/ace/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- // <script src="../../res/ace/js/ie-emulation-modes-warning.js"></script> -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="col-md-3"></div>
      <form class="form-horizontal col-xs-12 col-md-6" role="form" action="/?action=passport.register_submit" method="post">
        <div class="form-group">
          <label for="inputUsername" class="col-sm-2 control-label">登录名</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputUsername" placeholder="可以为字母+数字" 
              pattern="^[a-zA-Z]\w{5,17}$" name="username" onchange="checkUsername(this)" required autofocus>
          </div>
        </div>
        <div class="form-group">
          <label for="inputNickname" class="col-sm-2 control-label">昵称</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputNickname" placeholder="该昵称作为您海淘时的收货人名称" 
              pattern="^[a-zA-Z]\w{1,17}$" name="nickname" onchange="checkNickname(this)" required>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword1" class="col-sm-2 control-label">设置密码</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword1" name="password" required>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword2" class="col-sm-2 control-label">确认密码</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword2" onchange="checkPasswords()" required>
          </div>
        </div>
        <div class="form-group">
          <label for="inputMobile" class="col-sm-2 control-label">手机号</label>
          <div class="col-sm-10">
            <input type="mobile" class="form-control" id="inputMobile" name="mobile" onchange="checkMobile(this)" placeholder="方便海淘过程中及时通知您">
          </div>
        </div>
        <!-- <div class="form-group">
          <label for="inputEmail" class="col-sm-2 control-label">联系邮箱</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail" name="email" required>
          </div>
        </div> -->
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button class="btn btn-lg btn-primary active" style="width:100%" type="submit">注册</button>          
          </div>
        </div>
      </form>
      <div class="col-md-3"></div>
    </div> 
    <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!-- // <script src="../../res/ace/js/ie10-viewport-bug-workaround.js"></script> -->
    <script type="text/javascript">
      window.jQuery || document.write("<script src='ace/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
    </script> 

    <script type="text/javascript">
      function checkUsername(i) { 
          var v = i.validity;       
        if(true === v.patternMismatch){
          i.setCustomValidity("用户名需要字母开头，长度在6~18之间，只能包含字符、数字和下划线");
        }else{
          i.setCustomValidity("");
          var username = i.value;
          if(username) {
            $.get("/?action=passport_service.check_username&username="+username, function(data){
              if(data.code > 0) {
                i.setCustomValidity("用户名已存在");
              } else {
                i.setCustomValidity("");
              }
            }, 'json');
          }
        }     
      }
      
      function checkNickname(i) { 
          var v = i.validity;       
        if(true === v.patternMismatch){
          i.setCustomValidity("昵称需要字母开头，长度在2~18之间，只能包含字符、数字和下划线");
        }else{
          i.setCustomValidity("");
          var nickname = i.value;
          if(nickname) {
            $.get("/?action=passport_service.check_nickname&nickname="+nickname, function(data){
              if(data.code > 0) {
                i.setCustomValidity("该昵称已存在");
              } else {
                i.setCustomValidity("");
              }
            }, 'json');
          }
        }     
      }


      function checkMobile(i) { 
          var v = i.validity;       
        if(true === v.patternMismatch){
          i.setCustomValidity("昵称需要字母开头，长度在2~18之间，只能包含字符、数字和下划线");
        }else{
          i.setCustomValidity("");
          var mobile = i.value;
          if(mobile) {
            $.get("/?action=passport_service.check_mobile&mobile="+mobile, function(data){
              if(data.code > 0) {
                i.setCustomValidity("该手机号已被注册");
              } else {
                i.setCustomValidity("");
              }
            }, 'json');
          }
        }     
      }

      function checkPasswords() { 
        var passl = document.getElementById("inputPassword1");  
        var pass2 = document.getElementById("inputPassword2");  
        if (passl.value != pass2.value) 
          passl.setCustomValidity("两次密码必须输入一致！");
        else  
          passl.setCustomValidity('');
      }
    </script>
  </body>
</html>
