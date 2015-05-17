<?php $this->load->view('admin/header'); ?>
<script src="<?php echo base_url();?>js/admin/order.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Order Details</h1>
	   
	    	<div>
		    	<label for="user_id">Order No.</label>
			<?php echo $orders['order_no'];?>
			
		</div>
	
	    	<div>
		    	<label for="user_id">Customer Name:</label>
			<?php echo $orders['customer_name'];?>
			
		</div>
		<div>
		    	<label for="user_id">Shipping Address:</label>
			<div><?php echo $orders['address'];?>,<br>
			<?php echo $orders['city'];?> - <?php echo $orders['zip'];?>,<br>
			<?php echo $orders['state'];?>, <?php echo $orders['country'];?> <br></div>
		</div>
		<div>
		<table id="order_products">
			<thead>
			<tr>
				<th>
					 SL No.
				</th>		
				<th>
					 Product Name.
				</th>
				<th>
					 Quantity
				</th>
				<th>
					 Price
				</th>
				<th class="hidden-xs">
					 Total
				</th>	
				<th>
					Action
				</th>	
			</tr>
			</thead>
			<tbody>
			<?php 
				$total = 0;
				$i = 1;
				foreach($orders['order_products'] as $key => $val){ 
				$total += $val['total'];
			?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $val['product_name'];?></td>
					<td><?php echo $val['quantity'];?></td>
					<td><?php echo $val['price'];?></td>
					<td><?php echo $val['total'];?></td>
					<td><a href="javascript:;" class="orderProductDelete" rel="<?php echo $val['id'];?>">Delete</a></td>
				</tr>
			<?php $i++;
			 	} ?>	
				<tr>
					<td colspan="5">Gross Total</td>
					<td><?php echo $total;?></td>
				</tr>
				<tr>
					<td colspan="5">Less : Tax</td>
					<td><?php echo $orders['tax'];?></td>
				</tr>
							
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5">Net Total</td>
					<td><?php echo $orders['amount'];?></td>
				</tr>
			</tfoot>
		</table>
		</div>	    	
	       
</section>
<script>
$("#order_products").on("click",".orderProductDelete",function(){
	Order.deleteOrderProduct(this);
});
</script>
<?php $this->load->view('admin/footer'); ?> 
