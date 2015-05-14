var State = function(){
	
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
	var getStateForEdit = function(){
		var id = $(this).val();
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
		            	$.each( obj, function( key, value ) {
		            		if(state_id == value.id)
		            		{
		            			html += "<option value='"+value.id+"' selected>"+value.name+"</option>";
		            		}
					else
					{
						html += "<option value='"+value.id+"'>"+value.name+"</option>";
					}
				});		            	
		            	$("#state_id").html(html);
		            }		            
		        }
     		});
	}
	return {
		addCityValidate : addCityValidate,
		editCityValidate : editCityValidate,
		getStateByCountry : getStateByCountry

	};
}();


