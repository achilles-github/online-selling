<?php $this->load->view('admin/header'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables_themeroller.css" type="text/css" />
<script src="<?php echo base_url();?>plugins/datatables/media/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/order.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Customers</h1>
	<div class="msg">
	<?php 
		if($this->session->flashdata('msg')){
			echo $this->session->flashdata('msg');
		    }
	?>
	</div>
	
	<table class="table table-striped table-bordered table-hover" id="orders">
	<thead>
	<tr>
		<th>
			 SL No.
		</th>		
		<th>
			 Order No.
		</th>
		<th>
			 Customer Name
		</th>
		<th>
			 Amount
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
	Order.orderDataTable();
});
$(".confirmDelete").click(function(){
	Order.deleteOrder();
});
$(".deliverStatus").click(function(){
	Order.changeDeliveryStatus();
});
</script>
<?php $this->load->view('admin/footer'); ?> 
