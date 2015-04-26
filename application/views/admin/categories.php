<?php $this->load->view('admin/header'); ?> 
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables_themeroller.css" type="text/css" />
<script src="<?php echo base_url();?>plugins/datatables/media/js/jquery.dataTables.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Categories</h1>
	
	<table class="table table-striped table-bordered table-hover" id="categories">
	<thead>
	<tr>
		<th>
			 SL No.
		</th>
		<th>
			 Category Name
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
	$('#categories').DataTable({
	  "bServerSide": true,
	  "sAjaxSource": "<?php echo base_url();?>admin/categories/pages",
	  "aoColumns": [{
	    "mData":"serial_no",
	    "sTitle": "SL No.",
	    "bSortable": false,
	  },{
	    "mData": "cat_name",
	    "sTitle": "Category Name"
	  },{
	    "mData": "datetime",
	    "sTitle": "Created On"
	  },{
	    "mData":"id",
	    "mRender": function(id){
	    	
	      return "<a href='<?php echo base_url();?>admin/categories/edit/"+id+"' alt='edit'>Edit</a> | <a href='javascript:;' onclick='delete("+id+")' alt='delete'>Delete</a>";
	    }
	  }],
	  "order": [[2, "desc"]],
	  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,3 ] }]
    });
});

</script>
<?php $this->load->view('admin/footer'); ?> 
