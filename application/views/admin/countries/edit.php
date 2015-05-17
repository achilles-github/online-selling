<?php $this->load->view('admin/header'); ?>
<script src="<?php echo base_url();?>js/admin/country.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Country</h1>
	    <?php
		$frmAttrs   = array("id"=>'editFrm','class' => 'edit_countries');
		echo  form_open_multipart('admin/countries/edit/'.$id,$frmAttrs); 
	    ?>
	    	
	    	<div>
		    	<label for="user_id">Name</label>
			<input type="text" id="name" name="name" value="<?php echo $countries['country_name'];?>">
			<div class="error_block" id="name_error"></div>
			
		</div>
		
	    	<div>
	    		<input type="hidden" id="id" name="id" value="<?php echo $countries['id'];?>">
		    	<input type="submit" value="Submit" id="submit">
		</div>
		
	    <?=form_close()?>	   
</section>
<script>
$("#editFrm").submit(function(event){
	Country.editCountryValidate(event)	;
});
</script>
<?php $this->load->view('admin/footer'); ?> 
