<?php $this->load->view('admin/header'); ?>
<script src="<?php echo base_url();?>js/featured_product.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Featured Product</h1>
	    <?php
		$frmAttrs   = array("id"=>'addFrm','class' => 'add_products');
		echo  form_open_multipart('admin/products/add',$frmAttrs); 
	    ?>    	
	    	<div>
		    	<label for="user_id">Product Name</label>
			<input type="text" id="name" name="name" value="">
			<div class="error_block" id="name_error"></div>
			
		</div>		
	    	<div>
	    		<input type="hidden" id="id" name="id" value="">
		    	<input type="submit" value="Submit" id="submit">
		</div>
		
	    <?=form_close()?>	   
</section>
<script>
$("#addFrm").submit(function(event){
	FeaturedProduct.addFeaturedProductValidate(event)	;
});
</script>
<?php $this->load->view('admin/footer'); ?> 
