
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../favicon.ico">

		<title>登录</title>

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

			<form class="form-signin" role="form" action="/?action=passport.login_submit" method="post">
				<h2 class="form-signin-heading"><?php echo($msg); ?></h2>
				<input type="username" name="username" class="form-control" placeholder="邮箱或手机号" required autofocus>
				<input type="password" name="password" class="form-control" placeholder="密码" required>
				<div class="checkbox">
					<label>
						<input type="checkbox" value="remember-me"> Remember me
					</label>
				</div>
				<p>
					<button class="btn btn-lg btn-primary active" style="width:49%" type="submit">登录</button>
					<a href = "/?action=passport.register" class="btn btn-lg btn-default active" style="width:49%" onclick="register()">注册</a>
				</p>
			</form>

		</div> <!-- /container -->


		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<!-- // <script src="../../res/ace/js/ie10-viewport-bug-workaround.js"></script> -->
	</body>
</html>
