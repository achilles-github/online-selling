<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta content="charset=utf-8">
	<title>Welcome to Admin Panel</title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
	<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="screen" />
	<script src="<?php echo base_url();?>plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="<?php echo base_url();?>plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
</head>
<body>
<header>
	<div class="upper-header">
		<a href="<?php echo base_url();?>admin/dashboard" target="_self" class="logo">ADMIN LOGO</a>
		<ul class="user-information">
			<li>Welcome <span>Admin</span></li>
			<li>Last Login <?php echo date('H:i:s',strtotime($logged_admin['last_login']));?> on <?php echo date('d/m/Y',strtotime($logged_admin['last_login']));?></li>
		</ul>
	</div>
</header>
