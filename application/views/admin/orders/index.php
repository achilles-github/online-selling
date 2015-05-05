<?php $this->load->view('admin/header'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables_themeroller.css" type="text/css" />
<script src="<?php echo base_url();?>plugins/datatables/media/js/jquery.dataTables.js" type="text/javascript"></script>
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
	
	<table class="table table-striped table-bordered table-hover" id="customers">
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
	$('#customers').DataTable({
	  "bServerSide": true,
	  "sAjaxSource": BASE + "admin/customers/pages",
	  "aoColumns": [{
	    "mData":"serial_no",
	    "sTitle": "SL No.",
	    "bSortable": false,
	  },{
	    "mData": "Order No",
	    "sTitle": "order_no"
	  },{
	    "mData": "name",
	    "sTitle": "Customer Name"
	  },{
	    "mData": "created",
	    "sTitle": "Created On"
	  },{
	    "mData":"status",
	    "mRender": function(status){
	    	
	      return "<a href='"+BASE+"admin/orders/view/"+status.id+"' alt='view'>View</a> | <a href='javascript:;' onclick='deleteOrder("+status.id+",this)' alt='delete'>Delete</a> | <a href='javascript:;' onclick='changeStatus("+status.id+",this,"+status.status+")' alt='active'>Active</a>";
	    }
	  }],
	  "order": [[3, "desc"]],
	  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,4 ] }]
    });
});
function deleteCustomer(id,ele)
{
	$.ajax({
                type:'POST',
                url:BASE+'admin/orders/delete',
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
                url:BASE+'admin/orders/change_status',
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
