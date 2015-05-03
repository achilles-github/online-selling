var FeaturedProduct = function(){
	
	var addFeaturedProductValidate = function(event){
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
		addFeaturedProductValidate : addFeaturedProductValidate,
		editProductValidate : editProductValidate

	};
}();


