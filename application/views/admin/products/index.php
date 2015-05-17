<?php $this->load->view('admin/header'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables_themeroller.css" type="text/css" />
<script src="<?php echo base_url();?>plugins/datatables/media/js/jquery.dataTables.js" type="text/javascript"></script>
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
	$('#products').DataTable({
	  "bServerSide": true,
	  "sAjaxSource": BASE + "admin/products/pages",
	  "aoColumns": [{
	    "mData":"serial_no",
	    "sTitle": "SL No.",
	    "bSortable": false,
	  },{
	    "mData": "cat_name",
	    "sTitle": "Category Name"
	  },{
	    "mData": "name",
	    "sTitle": "Product Name"
	  },{
	    "mData": "quantity",
	    "sTitle": "Quantity"
	  },{
	    "mData": "price",
	    "sTitle": "Price"
	  },{
	    "mData": "created",
	    "sTitle": "Created On"
	  },{
	    "mData":"status",
	    "mRender": function(status){
	    	
	      return "<a href='"+BASE+"admin/products/edit/"+status.id+"' alt='edit'>Edit</a> | <a href='javascript:;' onclick='deleteProduct("+status.id+",this)' alt='delete'>Delete</a> | <a href='javascript:;' onclick='changeStatus("+status.id+",this,"+status.status+")' alt='active'>Active</a>";
	    }
	  }],
	  "order": [[3, "desc"]],
	  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,6 ] }]
    });
});
function deleteProduct(id,ele)
{
	$.ajax({
                type:'POST',
                url:BASE+'admin/products/delete',
		data:{id:id},
                dataType:'json',
                success:function(data){
                    //alert(data);
                    
                    if(data['status'] == "1")
                    {
                        $(ele).closest('tr').remove();
                    }
                    else
                    {
                        alert(data['message']);
                        return false;
                    }
                }
     });
}
function changeStatus(id,ele)
{
	$.ajax({
                type:'POST',
                url:BASE+'admin/products/change_status',
		data:{id:id},
                dataType:'json',
                success:function(data){
                    //alert(data);
                   
                    if(data['status'] == "1")
                    {
                        $(ele).html("Active");
                    }
                    else
                    {
                        $(ele).html("InActive");
                    }
                }
     });
}
</script>
<?php $this->load->view('admin/footer'); ?> 
