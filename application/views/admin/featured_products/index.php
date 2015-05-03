<?php $this->load->view('admin/header'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables_themeroller.css" type="text/css" />
<script src="<?php echo base_url();?>plugins/datatables/media/js/jquery.dataTables.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Featured Products</h1>
	<div class="msg">
	<?php 
		if($this->session->flashdata('msg')){
			echo $this->session->flashdata('msg');
		    }
	?>
	</div>
	<a href="<?php echo base_url();?>admin/featured_products/add">Add New</a>
	<table class="table table-striped table-bordered table-hover" id="featured_products">
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
			 Featured On
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
	$('#featured_products').DataTable({
	  "bServerSide": true,
	  "sAjaxSource": BASE + "admin/featured_products/pages",
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
	    "mData": "feature_date",
	    "sTitle": "Featured On"
	  },{
	    "mData":"status",
	    "mRender": function(status){	    	
	      return "<a href='javascript:;' onclick='deleteFeaturedProduct("+status.id+",this)' alt='delete'>Delete</a>";
	    }
	  }],
	  "order": [[3, "desc"]],
	  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,4 ] }]
    });
});
function deleteFeaturedProduct(id,ele)
{
	$.ajax({
                type:'POST',
                url:BASE+'admin/featured_products/delete',
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
                        alert("Something is wrong.Please try later.");
                        return false;
                    }
                }
     });
}

</script>
<?php $this->load->view('admin/footer'); ?> 
