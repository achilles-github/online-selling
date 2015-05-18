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
	var productDataTable = function(){
		$('#products').DataTable({
		  "bServerSide": true,
		  "sAjaxSource": BASE + "admin/products/pages",
		  "aoColumns": [{
		    "mData":"serial_no",
		    "sTitle": "SL No.",
		    "bSortable": false,
		  },{
		    "mData": "cat_name",
		    "sTitle": "Category Name"
		  },{
		    "mData": "name",
		    "sTitle": "Product Name"
		  },{
		    "mData": "quantity",
		    "sTitle": "Quantity"
		  },{
		    "mData": "price",
		    "sTitle": "Price"
		  },{
		    "mData": "created",
		    "sTitle": "Created On"
		  },{
		    "mData":"status",
		    "mRender": function(status){
		    	
		      return "<a href='"+BASE+"admin/products/edit/"+status.id+"' alt='edit'>Edit</a> | <a class='confirmDelete' href='javascript:;' rel='"+status.id+"' alt='delete'>Delete</a> | <a href='javascript:;' class='changeStatus' rel='"+status.id+"' alt='active'>Active</a>";
		    }
		  }],
		  "order": [[3, "desc"]],
		  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,6 ] }]
	    });
	}
	var deleteProduct = function(ele){
		var id = $(ele).attr("rel");
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/products/delete',
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
	var changeStatus = function(ele){
		var id = $(ele).attr("rel");
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/products/change_status',
			data:{id:id},
		        dataType:'json',
		        success:function(data){
		            if(data['status'] == "1")
		            {
		                $(ele).html("Active");
		            }
		            else
		            {
		                $(ele).html("InActive");
		            }
		        }
	     });
	}
	return {
		addProductValidate : addProductValidate,
		editProductValidate : editProductValidate,
		productDataTable : productDataTable,
		deleteProduct : deleteProduct,
		changeStatus:changeStatus
	};
}();


