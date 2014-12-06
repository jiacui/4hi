
    <!-- Docs nav
    ================================================== -->
    <div class="row">
      <div class="span3 bs-docs-sidebar">
        <ul class="nav nav-list bs-docs-sidenav">        
          <li <?php if($view == 'main/index'){ ?>class="active"<?php } ?>><a href="/?action=main.index"><i class="icon-chevron-right"></i> 到仓货物</a></li>
          <li><a href="#file-structure"><i class="icon-chevron-right"></i> 仓库信息</a></li>
          <li <?php if($view == 'order/index'){ ?>class="active"<?php } ?>><a href="/?action=order.index"><i class="icon-chevron-right"></i> 运单管理</a></li>
          <li <?php if($view == 'address/index'){ ?>class="active"<?php } ?>><a href="/?action=address.index"><i class="icon-chevron-right"></i> 收货地址</a></li>
          <li <?php if($view == 'user/profile'){ ?>class="active"<?php } ?>><a href="/?action=user.profile"><i class="icon-chevron-right"></i> 个人资料</a></li>
        </ul>
      </div>
      <div class="span9">