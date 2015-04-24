<?php $this->load->view('admin/header'); ?> 
<script type="text/javascript" src="<?php echo base_url();?>js/login.js"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Welcome to ADMIN PANEL</h1>
	
	    <?php
		$frmAttrs   = array("id"=>'editFrm','class' => 'edit_profile');
		echo form_open('admin/dashboard/edit_profile',$frmAttrs); 
	    ?>
	    	<div>
		    	<label for="user_id">First Name</label>
			<input type="text" id="first_name" name="first_name" value="<?php echo $profile['firstname'];?>">
			<div class="error_block" id="fname_error"></div>
		</div>
		<div>
		    	<label for="user_id">Last Name</label>
			<input type="text" id="last_name" name="last_name" value="<?php echo $profile['lastname'];?>">
			<div class="error_block" id="lname_error"></div>
		</div>
	    	<div>
		    	<label for="user_id">Email</label>
			<input type="text" id="email" name="email" value="<?php echo $profile['email'];?>">
			<div class="error_block" id="email_error"></div>
		</div>
		<div>
		    	<label for="user_id">Username</label>
			<input type="text" id="username" name="username" value="<?php echo $profile['username'];?>">
			<div class="error_block" id="username_error"></div>
		</div>
		<div>
		    	<label for="user_id">Change Password</label>
			<input type="checkbox" name="change_password" id="change_password" value="1">
		</div>
		<div>
		    	<label for="user_password">New Password</label>
			<input type="password" id="password" name="password" value="" disabled>
			<div class="error_block" id="password_error"></div>
		</div>
		<div>
			<input type="hidden" name="user_id" value="<?php echo $profile['id'];?>">
		    	<input type="submit" value="Edit" id="edit"/>
		</div>
		
		
		
		
	    <?=form_close()?>
</section>
<script>
$(document).ready(function(){
	Login.changePassword();	
});
$("#change_password").click(function(){
	Login.changePassword();	
});
$("#editFrm").submit(function(event){
	//event.preventDefault();		
	Login.validateEditProfile(event);
});
</script>
<?php $this->load->view('admin/footer'); ?> 
