<ul>
	<li><a href="<?php echo base_url('admin/dashboard');?>" target="_self" <?php if($menu_select['dashboard'] == true){?> class="active" <?php } ?>>Dashboard</a></li>
	<li><a href="<?php echo base_url('admin/categories');?>" target="_self" <?php if($menu_select['categories'] == true){?> class="active" <?php } ?>>Categories</a></li>
	<li><a href="<?php echo base_url('admin/products');?>" target="_self" <?php if($menu_select['products'] == true){?> class="active" <?php } ?>>Products</a></li>
	<li><a href="<?php echo base_url('admin/featured_products');?>" target="_self" <?php if($menu_select['featured'] == true){?> class="active" <?php } ?>>Featured Products</a></li>
	<li><a href="<?php echo base_url('admin/customers');?>" target="_self" <?php if($menu_select['customers'] == true){?> class="active" <?php } ?>>Customers</a></li>
	<li><a href="<?php echo base_url('admin/orders');?>" target="_self" <?php if($menu_select['orders'] == true){?> class="active" <?php } ?>>Orders</a></li>
	<li><a href="<?php echo base_url('admin/payments');?>" target="_self" <?php if($menu_select['payments'] == true){?> class="active" <?php } ?>>Payments</a></li>
	<li><a href="<?php echo base_url('admin/cms');?>" target="_self" <?php if($menu_select['cms'] == true){?> class="active" <?php } ?>>CMS</a></li>
	<li><a href="<?php echo base_url('admin/countries');?>" target="_self" <?php if($menu_select['countries'] == true){?> class="active" <?php } ?>>Countries</a></li>
	<li><a href="<?php echo base_url('admin/states');?>" target="_self" <?php if($menu_select['states'] == true){?> class="active" <?php } ?>>State</a></li>
	<li><a href="<?php echo base_url('admin/cities');?>" target="_self" <?php if($menu_select['cities'] == true){?> class="active" <?php } ?>>Cities</a></li>
	<li><a href="<?php echo base_url('admin/contacts');?>" target="_self" <?php if($menu_select['contacts'] == true){?> class="active" <?php } ?>>Contacts</a></li>
	<li><a href="<?php echo base_url('admin/login/logout');?>" target="_self" >Logout</a></li>
</ul>

