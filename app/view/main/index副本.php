<?php
use Lavender\Validator;

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../favicon.ico">

		<title>用户中心</title>

		<!-- Bootstrap core CSS -->
		<link href="bootstrap-3.3.0/css/bootstrap.min.css" rel="stylesheet">
		<title><?php echo L_SITE_NAME?></title>
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">用户中心</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse navbar-right">
					<div class="navbar-brand">你好<?=$session['user_id'] ?></div>
					<a class="navbar-brand" href="/?action=passport.logout">退出</a>
				</div><!--/.navbar-collapse -->
			</div>
		</nav>
		<div class="jumbotron" style="margin:20px 0;background-color:white">
			<div class="container">
				<table id="sample-table-1" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th class="center">
								<label>
									<input type="checkbox" class="ace" />
									<span class="lbl"></span>
								</label>
							</th>
							<th>商品名</th>
							<th class="hidden-480">重量（磅）</th>

							<th>
								<i class="icon-time bigger-110 hidden-480"></i>
								入库时间
							</th>
							<th class="hidden-480">状态</th>

						</tr>
					</thead>

					<tbody>
						<?php foreach ($items as $item) { ?>
						<tr>
							<td class="center">
								<label>
									<input type="checkbox" class="ace" value="<?=$item['id'] ?>" />
									<span class="lbl"></span>
								</label>
							</td>
								
							<td>
								<a href="#"><?=$item['name'] ?></a>
							</td>
							<td class="hidden-480"><?=$item['weight'] ?></td>
							<td><?=$item['create_time'] ?></td>

							<td class="hidden-480">
								<?php switch ($item['status']) {
									case 1:
										echo '<span class="label label-sm label-warning">已入库</span>';
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
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<button type="button" class="btn btn-sm btn-success" onclick="create_order()">
					转运选中项
					<i class="icon-arrow-right icon-on-right bigger-110"></i>
				</button>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		window.jQuery || document.write("<script src='ace/js/jquery-2.0.3.min.js'>"+"<"+"/script>");

		function create_order() {
			var ids = [];
			$('input:checkbox:checked').each(function() {
				ids.push($(this).val());
			});
			if(ids.length == 0) {

			} else {
				window.location.href = '/?action=main.pay&ids=' + ids.join(',');
			}
		}
	</script>



</html>