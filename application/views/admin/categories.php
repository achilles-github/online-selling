<?php $this->load->view('admin/header'); ?> 
<link rel="stylesheet" href="<?php echo base_url();?>plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" type="text/css" />
<script src="<?php echo base_url();?>plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Categories</h1>
	
	<table class="table table-striped table-bordered table-hover" id="categories">
	<thead>
	<tr>
		<th>
			 Rendering engine
		</th>
		<th>
			 Browser
		</th>
		<th class="hidden-xs">
			 Platform(s)
		</th>
		<th class="hidden-xs">
			 Engine version
		</th>
		<th class="hidden-xs">
			 CSS grade
		</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>
			 Trident
		</td>
		<td>
			 Internet Explorer 4.0
		</td>
		<td>
			 Win 95+
		</td>
		<td>
			 4
		</td>
		<td>
			 X
		</td>
	</tr>
	<tr>
		<td>
			 Trident
		</td>
		<td>
			 Internet Explorer 5.0
		</td>
		<td>
			 Win 95+
		</td>
		<td>
			 5
		</td>
		<td>
			 C
		</td>
	</tr>
	<tr>
		<td>
			 Trident
		</td>
		<td>
			 Internet Explorer 5.5
		</td>
		<td>
			 Win 95+
		</td>
		<td>
			 5.5
		</td>
		<td>
			 A
		</td>
	</tr>
	<tr>
		<td>
			 Trident
		</td>
		<td>
			 Internet Explorer 6
		</td>
		<td>
			 Win 98+
		</td>
		<td>
			 6
		</td>
		<td>
			 A
		</td>
	</tr>
	<tr>
		<td>
			 Trident
		</td>
		<td>
			 Internet Explorer 7
		</td>
		<td>
			 Win XP SP2+
		</td>
		<td>
			 7
		</td>
		<td>
			 A
		</td>
	</tr>
	<tr>
		<td>
			 Trident
		</td>
		<td>
			 AOL browser (AOL desktop)
		</td>
		<td>
			 Win XP
		</td>
		<td>
			 6
		</td>
		<td>
			 A
		</td>
	</tr>
	<tr>
		<td>
			 Gecko
		</td>
		<td>
			 Firefox 1.0
		</td>
		<td>
			 Win 98+ / OSX.2+
		</td>
		<td>
			 1.7
		</td>
		<td>
			 A
		</td>
	</tr>
	<tr>
		<td>
			 Gecko
		</td>
		<td>
			 Firefox 1.5
		</td>
		<td>
			 Win 98+ / OSX.2+
		</td>
		<td>
			 1.8
		</td>
		<td>
			 A
		</td>
	</tr>
	<tr>
		<td>
			 Gecko
		</td>
		<td>
			 Firefox 2.0
		</td>
		<td>
			 Win 98+ / OSX.2+
		</td>
		<td>
			 1.8
		</td>
		<td>
			 A
		</td>
	</tr>
	<tr>
		<td>
			 Gecko
		</td>
		<td>
			 Firefox 3.0
		</td>
		<td>
			 Win 2k+ / OSX.3+
		</td>
		<td>
			 1.9
		</td>
		<td>
			 A
		</td>
	</tr>
	<tr>
		<td>
			 Gecko
		</td>
		<td>
			 Camino 1.0
		</td>
		<td>
			 OSX.2+
		</td>
		<td>
			 1.8
		</td>
		<td>
			 A
		</td>
	</tr>
	<tr>
		<td>
			 Gecko
		</td>
		<td>
			 Camino 1.5
		</td>
		<td>
			 OSX.3+
		</td>
		<td>
			 1.8
		</td>
		<td>
			 A
		</td>
	</tr>
	
	</tbody>
	</table>
			   
</section>
<script>
$(document).ready(function(){    
	$('#categories').DataTable({
	  "bServerSide": true,
	  "sAjaxSource": "<?php echo base_url();?>admin/categories/pages",
	  "aoColumns": [{
	    "mData":"serial_no",
	    "sTitle": "SL No."
	  },{
	    "mData": "cat_name",
	    "sTitle": "Category Name"
	  },{
	    "mData":"id",
	    "mRender": function(data){
	      return "<a href='<?php echo base_url();?>admin/categories/edit/"+data.id+"' alt='edit'></a> | <a href='javascript:;' onclick='delete("+data.id+")' alt='delete'></a>";
	    }
	  }]
    });
});

</script>
<?php $this->load->view('admin/footer'); ?> 
