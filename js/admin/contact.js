var Contact = function(){
	
	
	var contactDataTable = function(){
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
			    "mData":"id",
			    "mRender": function(id){
			    	
			      return "<a href='"+BASE+"admin/contacts/view/"+id+"' alt='view'>View</a> | <a href='javascript:;' class='confirmDelete' rel='"+id+"' alt='delete'>Delete</a>";
			    }
			  }],
			  "order": [[4, "desc"]],
			  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,5 ] }]
		    });
	}
	var deleteContact = function(ele)
	{
		var id = $(ele).attr("rel");
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
	return {
		
		contactDataTable:contactDataTable,
		deleteContact : deleteContact

	};
}();


