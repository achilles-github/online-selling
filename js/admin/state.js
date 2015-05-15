var State = function(){
	
	var addStateValidate = function(event){
		var name = $("#name").val();
		var tax = $("#tax").val();
		var country_id = $("#country_id").val();
		$("#name_error").html("");
		$("#tax_error").html("");
		$("#country_error").html("");
		if(country_id == "")
		{
			$("#country_error").html("Please provide a country.");
			event.preventDefault();
			return false;
		}
		if(name == "")
		{
			$("#name_error").html("Please provide a name.");
			event.preventDefault();
			return false;
		}
		if(tax == "" || isNaN(tax) == true)
		{
			$("#tax_error").html("Please provide a tax percent.It must be 0 or greater.");
			event.preventDefault();
			return false;
		}
	}
	var editStateValidate = function(event){
		var name = $("#name").val();
		var country_id = $("#country_id").val();
		$("#name_error").html("");
		$("#tax_error").html("");
		$("#country_error").html("");
		if(country_id == "")
		{
			$("#country_error").html("Please provide a country.");
			event.preventDefault();
			return false;
		}
		if(name == "")
		{
			$("#name_error").html("Please provide a name.");
			event.preventDefault();
			return false;
		}
		if(tax == "" || isNaN(tax) == true)
		{
			$("#tax_error").html("Please provide a tax percent.It must be 0 or greater.");
			event.preventDefault();
			return false;
		}
		
	}
	var stateDataTable = function(){
		$('#states').DataTable({
		  "bServerSide": true,
		  "sAjaxSource": BASE + "admin/states/pages",
		  "aoColumns": [{
		    "mData":"serial_no",
		    "sTitle": "SL No.",
		    "bSortable": false,
		  },{
		    "mData": "country_name",
		    "sTitle": "Country Name"
		  },{
		    "mData": "state_name",
		    "sTitle": "State Name"
		  },{
		    "mData":"id",
		    "mRender": function(id){
		    	
		      return "<a href='"+BASE+"admin/states/edit/"+id+"' alt='edit'>Edit</a> | <a href='javascript:;' rel ='"+id+"'  alt='delete'  class='confirmDelete'>Delete</a>";
		    }
		  }],
		  "order": [[2, "desc"]],
		  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,3 ] }]
	    });
	}
	var deleteState = function(){
		var id = $(this).attr("rel");
		var ele = $(this);
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/states/delete',
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
		addStateValidate : addStateValidate,
		editStateValidate : editStateValidate,
		stateDataTable:stateDataTable,
		deleteState : deleteState

	};
}();


