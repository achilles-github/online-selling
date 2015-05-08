<?php $this->load->view('admin/header'); ?>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Customers</h1>
	    <?php
		$frmAttrs   = array("id"=>'viewFrm','class' => 'view_orders');
		echo  form_open_multipart('#',$frmAttrs); 
	    ?>
	    	<div>
		    	<label for="user_id">Order No.</label>
			<input type="text" id="name" name="name" value="<?php echo $orders['order_no'];?>" readonly="readonly">
			
		</div>
	
	    	<div>
		    	<label for="user_id">Customer Name</label>
			<input type="text" id="name" name="name" value="<?php echo $orders['customer_name'];?>" readonly="readonly">
			
		</div>
		<div>
		    	<label for="user_id">Shipping Address</label>
			<textarea id="address" name="address" readonly="readonly"><?php echo $orders['shipping'];?></textarea>		
		</div>
		<div>
		<table>
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
			</tr>
			</thead>
			<tbody>
			<?php 
				$total = 0;
				foreach($orders['order_products'] as $key => $val){ 
				$total += $val['total'];
			?>
				<tr>
					<td><?php echo $val['product_name'];?></td>
					<td><?php echo $val['quantity'];?></td>
					<td><?php echo $val['price'];?></td>
					<td><?php echo $val['total'];?></td>
				</tr>
			<?php } ?>				
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3"></td>
					<td><?php echo $total;?></td>
				</tr>
			</tfoot>
		</table>
		</div>	    	
	    <?=form_close()?>	   
</section>

<?php $this->load->view('admin/footer'); ?> 
