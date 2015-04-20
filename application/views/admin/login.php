<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta content="charset=utf-8">
	<title>Welcome to Admin Panel</title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">

	<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="screen" />
	<script src="<?php echo base_url();?>js/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>js/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="<?php echo base_url();?>js/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
	
	
	<script type="text/javascript" src="<?php echo base_url();?>js/login.js"></script>
</head>
<body>
<div class="mid-panel">
	<div class="login_panel">
		    <div class="error_block">
		    <?php 
		    	if($this->session->flashdata('msg')){
                                echo $this->session->flashdata('msg');
                            }
		    ?>
		    </div>
		    <?php
                        $frmAttrs   = array("id"=>'loginFrm');
                        echo form_open('admin/login/verify',$frmAttrs); 
                    ?>
			<label for="user_id">Username</label>
			<input type="text" id="username" name="username" value="">
			<div class="error_block" id="username_error"></div>
			<label for="user_password">Password</label>
			<input type="password" id="password" name="password" value="">
			<div class="error_block" id="password_error"></div>
			<input type="submit" value="Sign In" id="signin"/>
		    <?=form_close()?>
		    <?php
                        $frmAttrs   = array("id"=>'forgotFrm',"class" => "forgotpassword");
                        echo form_open('admin/send_password',$frmAttrs); 
                    ?>
			<label for="user_id">Email</label>
			<input type="text" id="forgot_email" name="forgot_email" value="">
			<div class="error_block" id="forgot_email_error"></div>
			<input type="button" value="Back" id="back"/> <input type="submit" value="Submit" id="submit"/>
		    <?=form_close()?>
	</div>
	<ul class="forgotnav">
		<li><a href="javascript:;" target="_self" id="forgot">Forgot Password?</a></li>
	</ul>
</div>
<footer>
	<h6>MindDNA All right reserved | &copy; <?php echo date('Y');?></h6>
</footer>
<script>
$("#forgot").click(function(){
	Login.openForgotPassword();
});
$("#back").click(function(){
	Login.openLogin();
});
</script>
</body>
</html>
