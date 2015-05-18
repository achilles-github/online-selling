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
	var categoryDataTable = function(){
		$('#categories').DataTable({
		  "bServerSide": true,
		  "sAjaxSource": BASE + "admin/categories/pages",
		  "aoColumns": [{
		    "mData":"serial_no",
		    "sTitle": "SL No.",
		    "bSortable": false,
		  },{
		    "mData": "cat_name",
		    "sTitle": "Category Name"
		  },{
		    "mData": "datetime",
		    "sTitle": "Created On"
		  },{
		    "mData":"id",
		    "mRender": function(id){
		    	
		      return "<a href='"+BASE+"admin/categories/edit/"+id+"' alt='edit'>Edit</a> | <a href='javascript:;' class='confirmDelete'   rel = '"+id+"' alt='delete'>Delete</a>";
		    }
		  }],
		  "order": [[2, "desc"]],
		  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,3 ] }]
	    });
	}
	var deleteCategories = function(ele){
		var id = $(ele).attr("rel");
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/categories/delete',
			data:{id:id},
		        dataType:'json',
		        success:function(data){
		            //alert(data);
		            $('#show_Loader_stats').hide();
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
		addCategoryValidate : addCategoryValidate,
		editCategoryValidate : editCategoryValidate,
		categoryDataTable : categoryDataTable,
		deleteCategories : deleteCategories

	};
}();
