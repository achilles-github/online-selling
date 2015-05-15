<?php $this->load->view('admin/header'); ?>
<script src="<?php echo base_url();?>js/admin/category.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Categories</h1>
	<?php
		$frmAttrs   = array("id"=>'addFrm','class' => 'add_categories');
		echo  form_open_multipart('admin/categories/add',$frmAttrs); 
	    ?>
	    	<div>
		    	<label for="user_id">Name</label>
			<input type="text" id="name" name="name" value="">
			<div class="error_block" id="name_error"></div>
		</div>
		<div>
		    	<label for="user_id">Image</label>
			<input type="file" id="image" name="image" value="">
			<div class="error_block" id="image_error"></div>
		</div>
	    	<div>
			
		    	<input type="submit" value="Submit" id="submit"/>
		</div>
		
	    <?=form_close()?>	   
</section>
<script>
$("#addFrm").submit(function(event){
	Category.addCategoryValidate(event)	;
});
</script>
<?php $this->load->view('admin/footer'); ?> 
