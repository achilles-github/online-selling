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
	
	<table class="table table-striped table-bordered table-hover" id="contacts">
	<thead>
	<tr>
		<th>
			 SL No.
		</th>		
		<th>
			 Email
		</th>
		<th>
			 Name
		</th>
		<th width="25%">
			 Contact No.
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
	$('#contacts').DataTable({
	  "bServerSide": true,
	  "sAjaxSource": BASE + "admin/contacts/pages",
	  "aoColumns": [{
	    "mData":"serial_no",
	    "sTitle": "SL No.",
	    "bSortable": false,
	  },{
	    "mData": "email",
	    "sTitle": "Email"
	  },{
	    "mData": "name",
	    "sTitle": "Name"
	  },{
	    "mData": "contact_no",
	    "sTitle": "Contact No."
	  },{
	    "mData": "created",
	    "sTitle": "Created On"
	  },{
	    "mData":"status",
	    "mRender": function(status){
	    	
	      return "<a href='"+BASE+"admin/contacts/view/"+status.id+"' alt='view'>View</a> | <a href='javascript:;' onclick='deleteContact("+status.id+",this)' alt='delete'>Delete</a>";
	    }
	  }],
	  "order": [[4, "desc"]],
	  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,5 ] }]
    });
});
function deleteContact(id,ele)
{
	$.ajax({
                type:'POST',
                url:BASE+'admin/contacts/delete',
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
