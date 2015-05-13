<?php $this->load->view('admin/header'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/media/css/jquery.dataTables_themeroller.css" type="text/css" />
<script src="<?php echo base_url();?>plugins/datatables/media/js/jquery.dataTables.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Countries</h1>
	<div class="msg">
	<?php 
		if($this->session->flashdata('msg')){
			echo $this->session->flashdata('msg');
		    }
	?>
	</div>
	<a href="<?php echo base_url();?>admin/states/add">Add New</a>
	<table class="table table-striped table-bordered table-hover" id="states">
	<thead>
	<tr>
		<th>
			 SL No.
		</th>
		<th>
			 Country Name
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
	  "sAjaxSource": BASE + "admin/countries/pages",
	  "aoColumns": [{
	    "mData":"serial_no",
	    "sTitle": "SL No.",
	    "bSortable": false,
	  },{
	    "mData": "name",
	    "sTitle": "Country Name"
	  },{
	    "mData":"id",
	    "mRender": function(id){
	    	
	      return "<a href='"+BASE+"admin/countries/edit/"+id+"' alt='edit'>Edit</a> | <a href='javascript:;' onclick='deleteCountry("+id+",this)' alt='delete'>Delete</a>";
	    }
	  }],
	  "order": [[1, "desc"]],
	  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,2 ] }]
    });
});
function deleteCountry(id,ele)
{
	$.ajax({
                type:'POST',
                url:BASE+'admin/countries/delete',
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

</script>
<?php $this->load->view('admin/footer'); ?> 
