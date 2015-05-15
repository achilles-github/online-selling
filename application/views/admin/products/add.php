<?php $this->load->view('admin/header'); ?>
<script src="<?php echo base_url();?>js/admin/product.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Products</h1>
	<?php
		$frmAttrs   = array("id"=>'addFrm','class' => 'add_products');
		echo  form_open_multipart('admin/products/add',$frmAttrs); 
	    ?>
	    	<div>
		    	<label>Category</label>
			<select id="category_id" name="category_id">
				<option value="">--Select--</option>
				<?php foreach($categories as $key => $val)
				      {
				?>
					<option value="<?php echo $val['id'];?>"><?php echo $val['cat_name'];?></option>
				<?php
				      }
				?>
			</select>
			<div class="error_block" id="category_error"></div>
		</div>
	    	<div>
		    	<label>Name</label>
			<input type="text" id="name" name="name" value="">
			<div class="error_block" id="name_error"></div>
		</div>
		<div>
		    	<label>Description</label>
			<textarea id="description" name="description"></textarea>			
		</div>
		<div>
		    	<label>Quantity</label>
			<input type="text" id="quantity" name="quantity" value="">
			<div class="error_block" id="quantity_error"></div>		
		</div>
		<div>
		    	<label>Units</label>
			<input type="text" id="units" name="units" value="">
			<div class="error_block" id="units_error"></div>		
		</div>
		<div>
		    	<label>Price</label>
			<input type="text" id="price" name="price" value="">
			<div class="error_block" id="price_error"></div>		
		</div>
		<div>
		    	<label>Discount %</label>
			<input type="text" id="discount" name="discount" value="0">
			<div class="error_block" id="discount_error"></div>		
		</div>
		<div>
		    	<label>Image</label>
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
	Product.addProductValidate(event)	;
});
</script>
<?php $this->load->view('admin/footer'); ?> 
