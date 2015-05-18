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
	var featureProductDataTable = function(){
		$('#featured_products').DataTable({
		  "bServerSide": true,
		  "sAjaxSource": BASE + "admin/featured_products/pages",
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
		    "mData": "feature_date",
		    "sTitle": "Featured On"
		  },{
		    "mData":"status",
		    "mRender": function(status){	    	
		      return "<a href='javascript:;' rel='"+status.id+"' class='confirmDelete' alt='delete'>Delete</a>";
		    }
		  }],
		  "order": [[3, "desc"]],
		  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,4 ] }]
	    });
	}
	var deleteFeaturedProduct = function(ele){
		var id = $(ele).attr("rel");
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/featured_products/delete',
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
		                alert("Something is wrong.Please try later.");
		                return false;
		            }
		        }
	     });
	}
	return {
		addFeaturedProductValidate : addFeaturedProductValidate,
		deleteFeaturedProduct:deleteFeaturedProduct,
		featureProductDataTable : featureProductDataTable

	};
}();


