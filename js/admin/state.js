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
	return {
		addStateValidate : addStateValidate,
		editStateValidate : editStateValidate

	};
}();


