
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <title>用户中心</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
        <form action="/?action=order.create" method="post">
        <section>
          <?php foreach ($data['addrs'] as $key => $addr) { ?>
          <label class="radio">
            <input type="radio" name="address_id" id="optionsRadios1"
             value="<?=$addr['id'] ?>" <?php if($data['address_id']==$addr['id']){ echo 'checked'; } ?>>
            <?php echo $addr['name'] . " " . $addr['address'] ?>
          </label>
          <?php } ?>
        </section>
        <!-- Download
        ================================================== -->
        <section id="download-bootstrap">
         <div>确认订单</div>
         <table class="table demo table-bordered" data-filter="#filter" data-page-size="5" data-page-previous-text="prev" data-page-next-text="next">
          <thead>         
						<tr>
							<th>商品名</th>
							<th data-hide="phone,tablet">重量（磅）</th>
						</tr>
          </thead>
          <tbody>
          	<?php foreach ($data['items'] as $item) { ?>
            <input type="hidden" name="item_ids" value="<?=$item['id'] ?>">
						<tr>
							<td>
								<a href="#"><?=$item['name'] ?></a>
							</td>
							<td><?=$item['weight'] ?></td>
						</tr>
						<?php } ?>
            <tr>                
              <td>总计</td>
              <td><?=$data['weight'] ?></td>
            </tr> 
            <tr>                
              <td>运费</td>
              <td><?=$data['weight'] ?></td>
            </tr>            
          </tbody>
        </table>
				<button type="submit" class="btn btn-sm btn-success">
					提交订单
					<i class="icon-arrow-right icon-on-right bigger-110"></i>
				</button>
        </section>
      </div>
    </div>
    </form>
  </div>


  <?php include __DIR__ . '/../common/foot.php';?>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript">
			window.jQuery || document.write("<script src='ace/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
    <script src="bootstrap-2.2.2/js/bootstrap.min.js"></script>
  </body>
</html>
