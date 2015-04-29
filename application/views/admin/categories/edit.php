<?php $this->load->view('admin/header'); ?>
<script src="<?php echo base_url();?js/category.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Categories</h1>
	    <?php
		$frmAttrs   = array("id"=>'editFrm','class' => 'edit_categories');
		echo  form_open_multipart('admin/categories/edit/'.$id,$frmAttrs); 
	    ?>
	    	<div>
		    	<label for="user_id">Name</label>
			<input type="text" id="name" name="name" value="<?php echo $categories['cat_name'];?>">
			<div class="error_block" id="name_error"></div>
			
		</div>
		<div>
		    	<label for="user_id">Image</label>
			<input type="file" id="image" name="image" value="">
			<img src="<?php echo base_url();?>upload/categories/thumb/<?php echo $categories['img'];?>">
		</div>
	    	<div>
	    		<input type="hidden" id="id" name="id" value="<?php echo $categories['id'];?>">
	    		<input type="hidden" id="old_image" name="old_image" value="<?php echo $categories['img'];?>">
		    	<input type="submit" value="Submit" id="submit">
		</div>
		
	    <?=form_close()?>	   
</section>
<script>

</script>
<?php $this->load->view('admin/footer'); ?> 
