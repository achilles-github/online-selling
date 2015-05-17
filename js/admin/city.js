var City = function(){	
	var addCityValidate = function(event){
		var name = $("#name").val();
		var state = $("#state_id").val();
		var country_id = $("#country_id").val();
		$("#name_error").html("");
		$("#state_error").html("");
		$("#country_error").html("");
		if(country_id == "")
		{
			$("#country_error").html("Please provide a country.");
			event.preventDefault();
			return false;
		}
		if(state == "")
		{
			$("#state_error").html("Please provide a state.");
			event.preventDefault();
			return false;
		}
		if(name == "")
		{
			$("#name_error").html("Please provide a name.");
			event.preventDefault();
			return false;
		}
		
	}
	var editCityValidate = function(event){
		var name = $("#name").val();
		var state = $("#state_id").val();
		var country_id = $("#country_id").val();
		$("#name_error").html("");
		$("#state_error").html("");
		$("#country_error").html("");
		if(country_id == "")
		{
			$("#country_error").html("Please provide a country.");
			event.preventDefault();
			return false;
		}
		if(state == "")
		{
			$("#state_error").html("Please provide a state.");
			event.preventDefault();
			return false;
		}
		if(name == "")
		{
			$("#name_error").html("Please provide a name.");
			event.preventDefault();
			return false;
		}
	}
	var getStateByCountry = function(){
		var id = $(this).val();
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/cities/get_states',
			data:{id:id},
		        dataType:'json',
		        success:function(data){
		        
		            if(data.length > 0)
		            { 
		            	var html = "";
		            	$.each( obj, function( key, value ) {
					html += "<option value='"+value.id+"'>"+value.name+"</option>";
				});		            	
		            	$("#state_id").html(html);
		            }		            
		        }
     		});
	}
	var getStateForEdit = function(ele){
		var id = $(ele).val();
		var state_id = $("#hidden_state_id").val();
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/cities/get_states',
			data:{id:id},
		        dataType:'json',
		        success:function(data){
		        
		            if(data.length > 0)
		            { 
		            	var html = "";
		            	$.each( data, function( key, value ) {
		            		if(state_id == value.id)
		            		{
		            			html += "<option value='"+value.id+"' selected>"+value.state_name+"</option>";
		            		}
					else
					{
						html += "<option value='"+value.id+"'>"+value.state_name+"</option>";
					}
				});		            	
		            	$("#state_id").html(html);
		            }		            
		        }
     		});
	}
	var cityDataTable = function(){
		$('#cities').DataTable({
		  "bServerSide": true,
		  "sAjaxSource": BASE + "admin/cities/pages",
		  "aoColumns": [{
		    "mData":"serial_no",
		    "sTitle": "SL No.",
		    "bSortable": false,
		  },{
		    "mData": "state_name",
		    "sTitle": "State Name"
		  },{
		    "mData": "name",
		    "sTitle": "City Name"
		  },{
		    "mData":"id",
		    "mRender": function(id){
		    	
		      return "<a href='"+BASE+"admin/cities/edit/"+id+"' alt='edit'>Edit</a> | <a class='confirmDelete' href='javascript:;' rel = '"+id+"' alt='delete'>Delete</a>";
		    }
		  }],
		  "order": [[2, "desc"]],
		  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,3 ] }]
	    });
	}
	var deleteCity = function(ele)
	{
		var id = $(ele).attr("rel");
		
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/cities/delete',
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
		addCityValidate : addCityValidate,
		editCityValidate : editCityValidate,
		getStateByCountry : getStateByCountry,
		getStateForEdit:getStateForEdit,
		cityDataTable : cityDataTable,
		deleteCity : deleteCity
	};
}();


