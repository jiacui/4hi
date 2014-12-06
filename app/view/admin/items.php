<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Bootstrap表格插件 - Bootstrap后台管理系统模版Ace下载</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- basic styles -->

    <link href="ace/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="ace/css/font-awesome.min.css" />

    <!--[if IE 7]>
      <link rel="stylesheet" href="ace/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts -->

    <!-- <link rel="stylesheet" href="http://fonts.useso.com/css?family=Open+Sans:400,300" /> -->

    <!-- ace styles -->

    <link rel="stylesheet" href="ace/css/ace.min.css" />
    <link rel="stylesheet" href="ace/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="ace/css/ace-skins.min.css" />

    <!--[if lte IE 8]>
      <link rel="stylesheet" href="ace/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->

    <script src="ace/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="ace/js/html5shiv.js"></script>
    <script src="ace/js/respond.min.js"></script>
    <![endif]-->

    <!-- <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"> -->
  </head>

  <body>
    <?php include __DIR__ . '/../admin/head.php';?>

    <div class="main-container" id="main-container">
      <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
      </script>

      <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
          <span class="menu-text"></span>
        </a>

        <?php include __DIR__ . '/../admin/menu.php';?>

        <div class="main-content">
          <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
              try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>

            <ul class="breadcrumb">
              <li>
                <i class="icon-home home-icon"></i>
                <a href="#">Home</a>
              </li>

              <li>
                <a href="#">Tables</a>
              </li>
              <li class="active">Simple &amp; Dynamic</li>
            </ul><!-- .breadcrumb -->

          </div>

          <div class="page-content">
            <div class="page-header">
              <div class="input-group">
                <input type="text" class="form-control search-query" placeholder="Type your query">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-purple btn-sm">
                    Search
                    <i class="icon-search icon-on-right bigger-110"></i>
                  </button>
                </span>
                <a class="btn btn-primary" href="#modal-form" role="button" data-toggle="modal" onclick="reset_form()">
                  <i class="icon-cloud-download align-top bigger-160"></i>
                  入库登记
                </a>
                <a class="btn btn-primary" href="#modal-form" role="button" data-toggle="modal" onclick="reset_form()">
                  <i class="icon-cloud-upload align-top bigger-160"></i>
                  出库按钮
                </a>
              </div>
                      
            </div><!-- /.page-header -->
            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->

                <div class="row">
                  <div class="col-xs-12">
                    <div class="table-responsive">
                      <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <th class="center">
                              <label>
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                              </label>
                            </th>
                            <th>（国外）运单</th>
                            <th>货物概述</th>
                            <th>重量（磅）</th>                            
                            <th>运费</th>
                            <th>
                              <i class="icon-time bigger-110 hidden-480"></i>
                              入库时间
                            </th>
                            <th class="hidden-480">状态</th>

                            <th></th>
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
                              <a href="#"><?=$item['trade_us_no'] ?></a>
                            </td>
                            <td><?=$item['desc'] ?></td>
                            <td><?=$item['weight'] ?></td>
                            <td><?=$item['amount'] ?></td>
                            <td><?=$item['create_time'] ?></td>

                            <td class="hidden-480">
                              <?php switch ($item['status']) {
                                case 1:
                                  echo '<span class="label label-sm label-warning">已入库</span>';
                                  break;
                                case 2:
                                  echo '<span class="label label-sm label-danger">已付款</span>';
                                  break;
                                case 3:
                                  echo '<span class="label label-sm label-success">已发货/清关中</span>';
                                  break;
                                default:
                                  break;
                              }; ?>
                              
                            </td>

                            <td>
                              <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                <?php if($item['status'] == 2) { ?>                               
                                <button class="btn btn-xs btn-success" onclick="clearance_item(<?=$item['id'] ?>)">
                                  <i class="icon-ok bigger-120">物品清单</i>
                                </button>
                                <?php } ?>

                                <?php if($item['status'] == 3) { ?>                               
                                <button class="btn btn-xs btn-success" onclick="mail_item(<?=$item['id'] ?>)">
                                  <i class="icon-ok bigger-120">转运</i>
                                </button>
                                <?php } ?>

                                <a class="btn btn-xs btn-info" href="#modal-form" role="button" data-toggle="modal" onclick="get_info(<?=$item['id'] ?>)">
                                  <i class="icon-edit bigger-120">修改</i>
                                </a>

                                <!-- <button class="btn btn-xs btn-warning">
                                  <i class="icon-flag bigger-120"></i>
                                </button> -->
                              </div>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div><!-- /.table-responsive -->
                  </div><!-- /span -->
                </div><!-- /row -->


              </div>
            </div>
            <div id="modal-form" class="modal" tabindex="-1" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 id='form-title' class="blue bigger">包裹入库</h4>
                  </div>
                  <form id="item-form" role="form" action="/?action=admin.add_item" method="post">
                    <input type="hidden" id="item-id" name="id">
                    <div class="modal-body overflow-visible">
                      <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-xs-12 col-md-10">
                          <div class="form-group">
                            <label for="username">用户名</label>
                            <div>
                              <input class="input-large" type="text" id="username" name="username" onchange="check_username()">
                              <span id='username-tip'></span>
                            </div>
                          </div>

                          <div class="space-4"></div>

                          <div class="form-group">
                            <label for="expre_in">物流公司</label>
                            <div>
                              <input class="form-control" type="text" id="expre_in" name="expre_in">
                            </div>
                          </div>

                          <div class="space-4"></div>

                          <div class="form-group">
                            <label for="trade_us_no">运单号</label>
                            <div>
                              <input class="form-control" type="text" id="trade_us_no" name="trade_us_no">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="desc">货物概述</label>
                            <div>
                              <textarea rows="2" class="form-control" type="text" id="desc" name="desc"></textarea>
                            </div>
                          </div>

                          <div class="space-4"></div>

                          <div class="form-group">
                            <label for="item_weight">货物重量</label>
                            <div>
                              <input class="form-control" type="text" id="item_weight" name="weight">
                            </div>
                          </div>

                          <div class="space-4"></div>

                          <div class="form-group" id="amount_input">
                            <label for="item_amount">运费</label>
                            <div>
                              <input class="form-control" type="text" id="item_amount" name="amount">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-1"></div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button class="btn btn-sm" data-dismiss="modal">
                        <i class="icon-remove"></i>
                        Cancel
                      </button>
                      <button class="btn btn-sm btn-primary" type="submit">
                        <i class="icon-ok"></i>
                        Save
                      </button>
                      <button id="save_new_btn" class="btn btn-sm btn-primary" type="submit">
                        <i class="icon-ok"></i>
                        Save & New
                      </button>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>      
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->

    <!-- // <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> -->

    <!-- <![endif]-->

    <!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

    <!--[if !IE]> -->

    <script type="text/javascript">
      window.jQuery || document.write("<script src='ace/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='ace/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

    <script type="text/javascript">
      if("ontouchend" in document) document.write("<script src='ace/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="ace/js/bootstrap.min.js"></script>
    <script src="ace/js/typeahead-bs2.min.js"></script>

    <!-- page specific plugin scripts -->

    <script src="ace/js/jquery.dataTables.min.js"></script>
    <script src="ace/js/jquery.dataTables.bootstrap.js"></script>

    <!-- ace scripts -->

    <script src="ace/js/ace-elements.min.js"></script>
    <script src="ace/js/ace.min.js"></script>

    <script type="text/javascript">
      function check_username() {
        var username = $('#username').val();
        $.get("/?action=admin_service.check_username&username="+username, function(data){
          console.log(data);
          if(data.code == 0) {
            if(data.user) {
              $('#username-tip').text('匹配到用户'); 
            } else {
              $('#username-tip').text('未匹配到用户');  
            }
            
          }
        }, 'json');
      }

      function reset_form() {
        $('#form-title').text('包裹入库');
        $('#item-form').attr('action', '/?action=admin.add_item');
        $('#username-tip').text('');
        $('#item-id').val('');
        $('#username').val('');
        $('#item-name').val('');
        $('#item-count').val('');
        $('#item_weight').val('');
        $('#item_amount').val('');
        $('#amount_input').hide();
        $('#save_new_btn').show();
      }

      function get_info(id) {
        $('#form-title').text('修改包裹');
        $('#amount_input').show();
        $('#save_new_btn').hide();
        $('#item-form').attr('action', '/?action=admin.update_item');
        $.get('/?action=admin_service.get_item&id=' + id, function(data){
          if(data.code == 0) {
            $('#item-id').val(data.item.id);
            $('#username').val(data.item.username);
            $('#item-name').val(data.item.name);
            $('#item-count').val(data.item.count);
            $('#item_weight').val(data.item.weight);
            $('#item_amount').val(data.item.amount);  
          }
          
        }, 'json');
      }

      function clearance_item(id) {
        window.location.href = '/?action=admin.update_item_clearance&id=' + id;
      }

    </script>

  
</body>
</html>
