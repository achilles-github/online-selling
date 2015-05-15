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
	return {
		addCountryValidate : addCountryValidate,
		editCountryValidate : editCountryValidate

	};
}();


