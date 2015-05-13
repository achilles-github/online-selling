<?php $this->load->view('admin/header'); ?>
<script src="<?php echo base_url();?>js/country.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Products</h1>
	<?php
		$frmAttrs   = array("id"=>'addFrm','class' => 'add_countries');
		echo  form_open_multipart('admin/countries/add',$frmAttrs); 
	    ?>
	    	<div>
		    	<label>Name</label>
			<input type="text" id="name" name="name" value="">
			<div class="error_block" id="name_error"></div>
		</div>
		
	    	<div>
			
		    	<input type="submit" value="Submit" id="submit"/>
		</div>
		
	    <?=form_close()?>	   
</section>
<script>
$("#addFrm").submit(function(event){
	Country.addCountryValidate(event)	;
});
</script>
<?php $this->load->view('admin/footer'); ?> 
