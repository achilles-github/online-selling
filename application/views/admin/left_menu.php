<ul>
	<li><a href="#" target="_self" <?php if($menu_select['dashboard'] == true){?> class="active" <?php } ?>>Dashboard</a></li>
	<li><a href="#" target="_self" <?php if($menu_select['categories'] == true){?> class="active" <?php } ?>>Categories</a></li>
	<li><a href="#" target="_self" <?php if($menu_select['products'] == true){?> class="active" <?php } ?>>Products</a></li>
	<li><a href="#" target="_self" <?php if($menu_select['featured'] == true){?> class="active" <?php } ?>>Featured Products</a></li>
	<li><a href="#" target="_self" <?php if($menu_select['customers'] == true){?> class="active" <?php } ?>>Customers</a></li>
	<li><a href="#" target="_self" <?php if($menu_select['orders'] == true){?> class="active" <?php } ?>>Orders</a></li>
	<li><a href="#" target="_self" <?php if($menu_select['payments'] == true){?> class="active" <?php } ?>>Payments</a></li>
	<li><a href="#" target="_self" <?php if($menu_select['cms'] == true){?> class="active" <?php } ?>>CMS</a></li>
	<li><a href="<?php echo base_url();?>admin/login/logout" target="_self" >Logout</a></li>
</ul>

