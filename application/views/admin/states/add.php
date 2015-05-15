<?php $this->load->view('admin/header'); ?>
<script src="<?php echo base_url();?>js/admin/state.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>States</h1>
	<?php
		$frmAttrs   = array("id"=>'addFrm','class' => 'add_states');
		echo  form_open_multipart('admin/states/add',$frmAttrs); 
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
		    	<label>Name</label>
			<input type="text" id="name" name="name" value="">
			<div class="error_block" id="name_error"></div>
		</div>
		<div>
		    	<label>Tax %</label>
			<input type="text" id="tax" name="tax" value="0">
			<div class="error_block" id="tax_error"></div>
		</div>
	    	<div>
			
		    	<input type="submit" value="Submit" id="submit"/>
		</div>
		
	    <?=form_close()?>	   
</section>
<script>
$("#addFrm").submit(function(event){
	State.addStateValidate(event)	;
});
</script>
<?php $this->load->view('admin/footer'); ?> 
