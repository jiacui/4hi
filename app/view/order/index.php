
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


        <!-- Download
        ================================================== -->
        <section id="download-bootstrap">
         <table class="table demo table-bordered" data-filter="#filter" data-page-size="5" data-page-previous-text="prev" data-page-next-text="next">
          <thead>         
						<tr>
              <th class="center">序号</th>
              <th class="center">运单号</th>
							<th>包裹</th>
							<th data-hide="phone,tablet">重量（磅）</th>
							<th>运费</th>
							<th data-hide="phone">
								<i class="icon-time bigger-110 hidden-480"></i>
								生成日期
							</th>
							<th>状态</th>

						</tr>
          </thead>
          <tbody>
          	<?php foreach ($data['orders'] as $i => $order) { ?>
            <?php foreach ($order['items'] as $j => $item) { ?>
						<tr>              
              <?php if($j == 0) { ?>
              <td rowspan="<?=count($order['items']) ?>" style="vertical-align:middle"><?=($i+1) ?></td>  
              <td rowspan="<?=count($order['items']) ?>" style="vertical-align:middle"><?=$order['id'] ?></td>  
              <?php }?>
              <td>
                <a href="#"><?=$item['name'] ?></a>
              </td>
              <?php if($j == 0) { ?>
              <td rowspan="<?=count($order['items']) ?>" style="vertical-align:middle"><?=$order['weight'] ?></td>
              <td rowspan="<?=count($order['items']) ?>" style="vertical-align:middle"><?=$order['amount'] ?></td>
              <td rowspan="<?=count($order['items']) ?>" style="vertical-align:middle"><?=$order['create_time'] ?></td>              

							<td class="hidden-480" rowspan="<?=count($order['items']) ?>" style="vertical-align:middle">
								<?php switch ($order['status']) {
									case 1:
										echo '<span class="label label-sm label-warning">待支付</span>';
										break;
									case 2:
										echo '<span class="label label-sm label-success">已付款</span>';
										break;
									case 3:
										echo '<span class="label label-sm label-info">已发货/清关中</span>';
										break;
									default:
										break;
								}; ?>
							</td>
              <?php }?>
						</tr>
            <?php } ?>  
						<?php } ?>            
          </tbody>
        </table>
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
    </script>
  </body>
</html>
