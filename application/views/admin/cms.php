<?php $this->load->view('admin/header'); ?>
<script src="<?php echo base_url();?>plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/cms.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Product</h1>
	    <?php
		$frmAttrs   = array("id"=>'editFrm','class' => 'edit_cms');
		echo  form_open_multipart('admin/categories/edit/'.$id,$frmAttrs); 
	    ?>
	    	<div>
		    	<label for="user_id">About Us</label>
			<textarea id="aboutus" name="aboutus" class="ckeditor"><?php echo $cms['aboutus'];?></textarea>
			<div class="error_block" id="aboutus_error"></div>
			
		</div>
		<div>
		    	<label for="user_id">Terms and Policies</label>
			<textarea id="policy" name="policy" class="ckeditor"><?php echo $cms['policy'];?></textarea>
			<div class="error_block" id="policy_error"></div>
		</div>
	    	<div>
	    		<input type="hidden" id="id" name="id" value="<?php echo $cms['id'];?>">
	    		
		    	<input type="submit" value="Submit" id="submit">
		</div>
		
	    <?=form_close()?>	   
</section>
<script>
$("#editFrm").submit(function(event){
	Cms.editCmsValidate(event)	;
});
</script>
<?php $this->load->view('admin/footer'); ?> 
