var Product = function(){
	
	var addProductValidate = function(event){
		var name = $("#name").val();
		var price = $("#price").val();
		var quantity = $("#quantity").val();
		var category_id = $("#category_id").val();
		var units = $("#units").val();
		var discount = $("#discount").val();
		$("#units_error").html("");
		$("#discount_error").html("");
		$("#category_error").html("");
		$("#name_error").html("");
		$("#price_error").html("");
		$("#quantity_error").html("");
		if(category_id == "")
		{
			$("#category_error").html("Please select a category.");
			event.preventDefault();
			return false;
		}
		if(name == "")
		{
			$("#name_error").html("Please provide a name.");
			event.preventDefault();
			return false;
		}
		
		if(quantity == "" || isNaN(quantity) == true)
		{
			$("#quantity_error").html("Please provide a quantity.");
			event.preventDefault();
			return false;
		}
		if(units == "")
		{
			$("#units_error").html("Please provide a units.");
			event.preventDefault();
			return false;
		}
		if(price == "" || isNaN(price) == true)
		{
			$("#price_error").html("Please provide a price.");
			event.preventDefault();
			return false;
		}
		if(discount == "" || isNaN(price) == true)
		{
			$("#discount_error").html("Please provide a discount.Its must 0 or greater.");
			event.preventDefault();
			return false;
		}		
		//event.preventDefault();
	}
	var editProductValidate = function(event){
		var name = $("#name").val();
		var price = $("#price").val();
		var quantity = $("#quantity").val();
		var category_id = $("#category_id").val();
		var units = $("#units").val();
		var discount = $("#discount").val();
		$("#units_error").html("");
		$("#discount_error").html("");
		$("#category_error").html("");
		$("#name_error").html("");
		$("#price_error").html("");
		$("#quantity_error").html("");
		if(category_id == "")
		{
			$("#category_error").html("Please selecgt a category.");
			event.preventDefault();
			return false;
		}
		if(name == "")
		{
			$("#name_error").html("Please provide a name.");
			event.preventDefault();
			return false;
		}
		if(quantity == "" || isNaN(quantity) == true)
		{
			$("#quantity_error").html("Please provide a quantity.");
			event.preventDefault();
			return false;
		}
		if(units == "")
		{
			$("#units_error").html("Please provide a units.");
			event.preventDefault();
			return false;
		}
		if(price == "" || isNaN(price) == true)
		{
			$("#price_error").html("Please provide a price.");
			event.preventDefault();
			return false;
		}
		if(discount == "" || isNaN(price) == true)
		{
			$("#discount_error").html("Please provide a discount.Its must 0 or greater.");
			event.preventDefault();
			return false;
		}	
	}
	return {
		addProductValidate : addProductValidate,
		editProductValidate : editProductValidate

	};
}();


