<?php $this->load->view('admin/header'); ?>
<script src="<?php echo base_url();?>js/product.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Product</h1>
	    <?php
		$frmAttrs   = array("id"=>'editFrm','class' => 'edit_products');
		echo  form_open_multipart('admin/products/edit/'.$id,$frmAttrs); 
	    ?>
	    	<div>
		    	<label>Category</label>
			<select id="category_id" name="category_id">
				<option value="">--Select--</option>
				<?php foreach($categories as $key => $val)
				      {
				      	 if($val['id'] ==  $products['category_id'])
				      	 {
				?>
						<option value="<?php echo $val['id'];?>" selected><?php echo $val['cat_name'];?></option>
				<?php
					 }
					 else
					 {
				?>
						<option value="<?php echo $val['id'];?>"><?php echo $val['cat_name'];?></option>
				<?php		 
					 }
				      }
				?>
			</select>
			<div class="error_block" id="category_error"></div>
		</div>
	    	<div>
		    	<label for="user_id">Name</label>
			<input type="text" id="name" name="name" value="<?php echo $products['name'];?>">
			<div class="error_block" id="name_error"></div>
			
		</div>
		<div>
		    	<label for="user_id">Description</label>
			<textarea id="description" name="description"><?php echo $products['description'];?></textarea>			
		</div>
		<div>
		    	<label for="user_id">Quantity</label>
			<input type="text" id="quantity" name="quantity" value="<?php echo $products['quantity'];?>">
			<div class="error_block" id="quantity_error"></div>		
		</div>
		<div>
		    	<label>Units</label>
			<input type="text" id="units" name="units" value="<?php echo $products['units'];?>">
			<div class="error_block" id="units_error"></div>		
		</div>
		<div>
		    	<label for="user_id">Price</label>
			<input type="text" id="price" name="price" value="<?php echo $products['price'];?>">
			<div class="error_block" id="price_error"></div>		
		</div>
		<div>
		    	<label>Discount %</label>
			<input type="text" id="discount" name="discount" value="<?php echo $products['discount'];?>">
			<div class="error_block" id="discount_error"></div>		
		</div>
		<div>
		    	<label for="user_id">Image</label>
			<input type="file" id="image" name="image" value="">
			<?php if($products['image'] != NULL && $products['image'] != ""){ ?>
				<img src="<?php echo base_url();?>upload/products/thumb/<?php echo $products['image'];?>">\
			<?php } ?>
		</div>
	    	<div>
	    		<input type="hidden" id="id" name="id" value="<?php echo $products['id'];?>">
	    		<input type="hidden" id="old_image" name="old_image" value="<?php echo $products['image'];?>">
		    	<input type="submit" value="Submit" id="submit">
		</div>
		
	    <?=form_close()?>	   
</section>
<script>
$("#editFrm").submit(function(event){
	Product.editProductValidate(event)	;
});
</script>
<?php $this->load->view('admin/footer'); ?> 
