var Customer = function(){
	var customerDataTable = function(){
		$('#customers').DataTable({
		  "bServerSide": true,
		  "sAjaxSource": BASE + "admin/customers/pages",
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
		    "mData": "address",
		    "sTitle": "Address"
		  },{
		    "mData": "created",
		    "sTitle": "Created On"
		  },{
		    "mData":"status",
		    "mRender": function(status){
		    	
		      return "<a href='"+BASE+"admin/customers/view/"+status.id+"' alt='view'>View</a> | <a href='javascript:;' rel='"+status.id+"' class='confirmDelete' alt='delete'>Delete</a> | <a href='javascript:;' rel='"+status.id+"' alt='active' class='changeStatus'>Active</a>";
		    }
		  }],
		  "order": [[4, "desc"]],
		  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,3,5 ] }]
	    });
	}
	var deleteCustomer = function(ele){
		var id = $(ele).attr("rel");
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/customers/delete',
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
	var changeStatus = function(ele){
		var id = $(ele).attr("rel");
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/customers/change_status',
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
	return {
		
		customerDataTable:customerDataTable,
		deleteCustomer : deleteCustomer,
		changeStatus : changeStatus

	};
}();


