
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
        
        <section id="overview">
          <div class="page-header">
            <!-- <a href="#myModal" role="button" class="btn" data-toggle="modal">新增收货地址</a> -->
            <a href="/?action=address.add" role="button" class="btn" data-toggle="modal">新增收货地址</a>
          </div>
        </section>
        <!-- Button to trigger modal -->
        <!-- Modal -->
        <!--
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:670px">
          <form class="form-horizontal" action="/?action=address.add_submit" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">添加地址</h3>
          </div>
          <div class="modal-body" style="max-height:650px">
            <div class="control-group">
              <label for="exampleInputEmail1" class="control-label">所在地区</label>
              <div class="controls">
                <input type="text" name="email" class="form-control input-xlarge" id="exampleInputEmail1">
              </div>
            </div>
            <div class="control-group">
              <label for="inputAddress" class="control-label">详细地址</label>
              <div class="controls">
                <textarea name="address" rows="2" class="input-xlarge"><?=$data['addr']['address'] ?></textarea>
              </div>
            </div>
            <div class="control-group">
              <label for="inputPostcode" class="control-label">邮政编码</label>
              <div class="controls">
                <input type="text" name="post_code" class="form-control input-xlarge" id="inputPostcode" value="<?=$data['addr']['post_code'] ?>">
              </div>
            </div>
            <div class="control-group">
              <label for="inputName" class="control-label">收货人姓名</label>
              <div class="controls">
                <input type="text" name="name" class="form-control input-xlarge" id="inputName" value="<?=$data['addr']['name'] ?>">
              </div>
            </div>
            <div class="control-group">
              <label for="inputMobile" class="control-label">手机号</label>
              <div class="controls">
                <input type="text" name="mobile" class="form-control input-xlarge" id="inputMobile" value="<?=$data['addr']['mobile'] ?>">
              </div>
            </div>
            <div class="control-group">
              <label for="inputCivilId" class="control-label">身份证号码</label>
              <div class="controls">
                <input type="text" name="civil_id" class="form-control input-xlarge" id="inputCivilId" value="<?=$data['addr']['civil_id'] ?>">
              </div>
            </div>
            <div class="control-group">
              <label for="inputFile1" class="col-sm-2 control-label">身份证正面照</label>
              <div class="controls">
                <input type="file" id="inputFile1" name="file1"><?php if(!empty($data['addr']['civil_card_pic1'])) { ?><a href="<?=$data['addr']['civil_card_pic1'] ?>">点击查看</a><?php } ?>
                <p class="help-block">可选（在需要身份证的口岸时需要上传,图片小于2M,图像清晰.）请在同一张图片里上传收件人正面身份证照. 需要身份证的口岸正面照,正反面照请务必一起上传.  </p>
              </div>
            </div>
            <div class="control-group">
              <label for="inputFile2" class="col-sm-2 control-label">身份证背面照</label>
              <div class="controls">
                <input type="file" id="inputFile2" name="file2"><?php if(!empty($data['addr']['civil_card_pic2'])) { ?><a href="<?=$data['addr']['civil_card_pic2'] ?>">点击查看</a><?php } ?>
                <p class="help-block">可选（在需要身份证的口岸时需要上传,图片小于2M,图像清晰.(具体要求可参见身份证上传教程：点击下载）请在同一张图片里上传收件人正反面（双面）身份证照.图片不清晰导致的清关延误等后果需要客户自行负责.   </p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
            <button class="btn btn-primary" type="submit">提交</button>
          </div>                            
          </form>
        </div>
        -->

         <table class="table demo table-bordered" data-filter="#filter" data-page-size="5" data-page-previous-text="prev" data-page-next-text="next">
          <thead>         
            <tr>
              <th>收货人姓名</th>
              <th>地址</th>
              <th>默认</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data['addrs'] as $addr) { ?>
            <tr>
              <td><?=$addr['name'] ?></td>
              <td><?=$addr['address'] ?></td>
              <td><?php if($data['address_id'] == $addr['id']) { echo '是'; } ?></td>
              <td>
                <a href="/?action=address.set_default&id=<?=$addr['id'] ?>">设为默认</a>
                <a href="/?action=address.edit&id=<?=$addr['id'] ?>">修改</a>
                <a href="/?action=address.delete&id=<?=$addr['id'] ?>">删除</a>
              </td>
            </tr>
            <?php } ?>            
          </tbody>
        </table>
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
    
    <script src="js/footable.js"></script>
    <script type="text/javascript">
      $(function () {
        $('table').footable({
          breakpoints: {
            phone: 480,
            tablet: 768
          }
        });
      });


			function create_order() {
				var ids = [];
				$('input:checkbox:checked').each(function() {
					ids.push($(this).val());
				});
				if(ids.length == 0) {

				} else {
					window.location.href = '/?action=main.create_order&ids=' + ids.join(',');
				}
			}

    </script>
  </body>
</html>
