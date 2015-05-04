<?php $this->load->view('admin/header'); ?>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Customers</h1>
	    <?php
		$frmAttrs   = array("id"=>'viewFrm','class' => 'view_customers');
		echo  form_open_multipart('#',$frmAttrs); 
	    ?>
	
	    	<div>
		    	<label for="user_id">Name</label>
			<input type="text" id="name" name="name" value="<?php echo $customers['name'];?>" readonly="readonly">
			
		</div>
		<div>
		    	<label for="user_id">Address</label>
			<input type="text" id="address" name="address" value="<?php echo $customers['address'];?>" readonly="readonly">		
		</div>
		<div>
		    	<label for="user_id">City</label>
			<input type="text" id="city" name="city" value="<?php echo $customers['city'];?>" readonly="readonly">				
		</div>
		<div>
		    	<label for="user_id">State</label>
			<input type="text" id="state" name="state" value="<?php echo $customers['state'];?>" readonly="readonly">		
		</div>
		<div>
		    	<label for="user_id">Country</label>
			<input type="text" id="country" name="country" value="<?php echo $customers['country'];?>" readonly="readonly">	
		</div>
		<div>
		    	<label for="user_id">Zip</label>
			<input type="text" id="zip" name="zip" value="<?php echo $customers['zip'];?>" readonly="readonly">	
		</div>
		<div>
		    	<label for="user_id">Phone</label>
			<input type="text" id="phone" name="phone" value="<?php echo $customers['phone'];?>" readonly="readonly">	
		</div>		    	
	    <?=form_close()?>	   
</section>

<?php $this->load->view('admin/footer'); ?> 
