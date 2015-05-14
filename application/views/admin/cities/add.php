<?php $this->load->view('admin/header'); ?>
<script src="<?php echo base_url();?>js/city.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Cities</h1>
	<?php
		$frmAttrs   = array("id"=>'addFrm','class' => 'add_cities');
		echo  form_open_multipart('admin/cities/add',$frmAttrs); 
	    ?>
	    	<div>
		    	<label>Country</label>
			<select id="country_id" name="country_id">
				<option value="">--Select--</option>
				<?php foreach($countries as $key => $val)
				      {
				?>
					<option value="<?php echo $val['id'];?>"><?php echo $val['country_name'];?></option>
				<?php
				      }
				?>
			</select>
			<div class="error_block" id="country_error"></div>
		</div>
		<div>
		    	<label>State</label>
			<select id="state_id" name="state_id">
				<option value="">--Select--</option>
			</select>
			<div class="error_block" id="state_error"></div>
		</div>
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
	City.addCityValidate(event);
});
$("#country_id").change(function(){
	City.getStateByCountry();
})
</script>
<?php $this->load->view('admin/footer'); ?> 
