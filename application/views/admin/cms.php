<?php $this->load->view('admin/header'); ?>
<script src="<?php echo base_url();?>plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>CMS</h1>
	<div class="msg">
	<?php 
		if($this->session->flashdata('msg')){
			echo $this->session->flashdata('msg');
		    }
	?>
	</div>
	    <?php
		$frmAttrs   = array("id"=>'editFrm','class' => 'edit_cms');
		echo  form_open_multipart('admin/cms',$frmAttrs); 
	    ?>
	    	<div>
		    	<label for="user_id">About Us</label>
			<textarea id="aboutus" name="aboutus" class="ckeditor"><?php echo $cms['about_us'];?></textarea>
			<div class="error_block" id="aboutus_error"></div>
			
		</div>
		
		<div>
		    	<label for="user_id">Terms and Policies</label>
			<textarea id="policy" name="policy" class="ckeditor"><?php echo $cms['policies'];?></textarea>
			<div class="error_block" id="policy_error"></div>
		</div>
	    	<div>
	    		<input type="hidden" id="id" name="id" value="<?php echo $cms['id'];?>">
	    		
		    	<input type="submit" value="Submit" id="submit">
		</div>
		
	    <?=form_close()?>	   
</section>

<?php $this->load->view('admin/footer'); ?> 
