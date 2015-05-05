<?php $this->load->view('admin/header'); ?>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Customers</h1>
	    <?php
		$frmAttrs   = array("id"=>'viewFrm','class' => 'view_orders');
		echo  form_open_multipart('#',$frmAttrs); 
	    ?>
	    	<div>
		    	<label for="user_id">Order No.</label>
			<input type="text" id="name" name="name" value="<?php echo $orders['order_no'];?>" readonly="readonly">
			
		</div>
	
	    	<div>
		    	<label for="user_id">Customer Name</label>
			<input type="text" id="name" name="name" value="<?php echo $orders['customer_name'];?>" readonly="readonly">
			
		</div>
		<div>
		    	<label for="user_id">Shipping Address</label>
			<textarea id="address" name="address" readonly="readonly"><?php echo $orders['shipping'];?></textarea>		
		</div>
			    	
	    <?=form_close()?>	   
</section>

<?php $this->load->view('admin/footer'); ?> 
