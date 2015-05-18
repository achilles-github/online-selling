<?php $this->load->view('admin/header'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables_themeroller.css" type="text/css" />
<script src="<?php echo base_url();?>plugins/datatables/media/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/admin/product.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Products</h1>
	<div class="msg">
	<?php 
		if($this->session->flashdata('msg')){
			echo $this->session->flashdata('msg');
		    }
	?>
	</div>
	<a href="<?php echo base_url();?>admin/products/add">Add New</a>
	<table class="table table-striped table-bordered table-hover" id="products">
	<thead>
	<tr>
		<th>
			 SL No.
		</th>
		<th>
			 Category Name
		</th>
		<th>
			 Product Name
		</th>
		<th>
			 Quantity
		</th>
		<th>
			 Price
		</th>
		<th>
			 Created On
		</th>
		<th class="hidden-xs">
			 Action
		</th>		
	</tr>
	</thead>
	
	</table>
			   
</section>
<script>
$(document).ready(function(){    
	Product.productDataTable();
});
$("#products").on("click",".confirmDelete",function(){
	Product.deleteProduct(this);
})
$("#products").on("click",".changeStatus",function(){
	Product.changeStatus(this);
})
</script>
<?php $this->load->view('admin/footer'); ?> 
