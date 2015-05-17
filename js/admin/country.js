var Country = function(){
	
	var addCountryValidate = function(event){
		var name = $("#name").val();
		
		if(name == "")
		{
			$("#name_error").html("Please provide a name.");
			event.preventDefault();
			return false;
		}
		
	}
	var editCountryValidate = function(event){
		var name = $("#name").val();
		if(name == "")
		{
			$("#name_error").html("Please provide a name.");
			event.preventDefault();
			return false;
		}
		
	}
	var deleteCountry = function(ele){
		var id = $(ele).attr("rel");
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
	var countryDataTable = function(){
		$('#countries').DataTable({
		  "bServerSide": true,
		  "sAjaxSource": BASE + "admin/countries/pages",
		  "aoColumns": [{
		    "mData":"serial_no",
		    "sTitle": "SL No.",
		    "bSortable": false,
		  },{
		    "mData": "country_name",
		    "sTitle": "Country Name"
		  },{
		    "mData":"id",
		    "mRender": function(id){
		    	
		      return "<a href='"+BASE+"admin/countries/edit/"+id+"' alt='edit'>Edit</a> | <a href='javascript:;' rel='"+id+"'  class='confirmDelete' alt='delete'>Delete</a>";
		    }
		  }],
		  "order": [[1, "desc"]],
		  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,2 ] }]
	    });
	    
	}
	
	return {
		addCountryValidate : addCountryValidate,
		editCountryValidate : editCountryValidate,
		deleteCountry : deleteCountry,
		countryDataTable : countryDataTable
	};
}();


