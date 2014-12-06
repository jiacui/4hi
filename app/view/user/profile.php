
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <title>用户中心</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Google Bootstrap是仿Google样式的Bootstrap。Bootstrap是Twitter推出的一个用于前端开发的开源工具包。它由Twitter的设计师Mark Otto和Jacob Thornton合作开发，是一个CSS/HTML框架。Bootstrap中文网致力于为广大国内开发者提供详尽的中文文档、代码实例等，助力开发者掌握并使用这一框架。">
    <meta name="author" content="Bootstrap中文网">
    <meta name="keywords" content="Google Bootstrap,CSS,CSS框架,CSS framework,javascript,bootcss,bootstrap开发,bootstrap代码,bootstrap入门">
    <meta name="robots" content="index,follow">
    <meta name="application-name" content="bootcss.com">

    <!-- Le styles -->
    <link href="bootstrap-2.2.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-2.2.2/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="css/footable.core.css" rel="stylesheet" type="text/css"/>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/cdnjs.bootcss.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->

    <link href="css/google-bootstrap.css" rel="stylesheet">
  </head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">

  <?php include __DIR__ . '/../common/navbar.php';?>

  <?php include __DIR__ . '/../common/subhead.php';?>


  <div class="container">
    <?php include __DIR__ . '/../common/menu.php';?>

    <section id="download-bootstrap">
      <form class="form-horizontal" action="/?action=user.update_profile" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$data['addr']['id'] ?>">
        <legend>用户信息</legend>
        <div class="control-group">
          <label for="inputName" class="control-label">账号</label>
          <div class="controls">
            <input type="text" class="form-control input-xxlarge" id="inputName" value="<?=$data['user']['username'] ?>" readonly>
          </div>
        </div>
        <div class="control-group">
          <label for="email" class="control-label">邮件</label>
          <div class="controls">
            <input type="email" class="form-control input-xxlarge" id="email" name="email" value="<?=$data['user']['email'] ?>"
              required <?php if(!empty($data['user']['email'])) echo 'readonly' ?>>
          </div>
        </div>
        <div class="control-group">
          <label for="exampleInputEmail1" class="control-label">所在地区</label>
          <div class="controls">
            <div id="city"> 
              <select class="prov" name="province"></select>  
              <select class="city" name="city" disabled="disabled"></select> 
            </div> 
          </div>
        </div>
        <div class="control-group">
          <label for="inputAddress" class="control-label">联系地址</label>
          <div class="controls">
            <textarea name="address" rows="3" class="input-xxlarge"><?=$data['user']['address'] ?></textarea>
          </div>
        </div>
        <div class="control-group">
          <label for="civil_id" class="control-label">身份证号</label>
          <div class="controls">
            <input type="text" name="civil_id" class="form-control input-xxlarge" id="civil_id" value="<?=$data['user']['civil_id'] ?>">
          </div>
        </div>
        <div class="control-group">
          <label for="inputMobile" class="control-label">手机号</label>
          <div class="controls">
            <input type="text" name="mobile" class="form-control input-xxlarge" id="inputMobile" required
               value="<?=$data['user']['mobile'] ?>">
          </div>
        </div>
        <div class="control-group">
          <label for="inputMobile" class="control-label">qq</label>
          <div class="controls">
            <input type="text" name="qq" class="form-control input-xxlarge" id="inputMobile" value="<?=$data['user']['qq'] ?>">
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn">提交</button>
          </div>
        </div>
      </form>
      </section>
    </div>
    </div>

  </div>


  <?php include __DIR__ . '/../common/foot.php';?>


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript">
			window.jQuery || document.write("<script src='ace/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
    <script src="bootstrap-2.2.2/js/bootstrap.min.js"></script>   
    <script type="text/javascript" src="/js/jquery.cityselect.js"></script>
    <script type="text/javascript">
      $("#city").citySelect({prov:"<?=$data['user']['province'] ?>", city:"<?=$data['user']['city'] ?>"});  
    </script> 
  </body>
</html>
