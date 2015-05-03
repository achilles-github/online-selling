var Category = function(){
	
	var addCategoryValidate = function(event){
		var name = $("#name").val();		
		$("#name_error").html("");		
		if(name == "")
		{
			$("#name_error").html("Please provide a name.");
			event.preventDefault();
			return false;
		}
	}
	var editCategoryValidate = function(event){
		var name = $("#name").val();		
		$("#name_error").html("");		
		if(name == "")
		{
			$("#name_error").html("Please provide a name.");
			event.preventDefault();
			return false;
		}
	}
	return {
		addCategoryValidate : addCategoryValidate,
		editCategoryValidate : editCategoryValidate

	};
}();
