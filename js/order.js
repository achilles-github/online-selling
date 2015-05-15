var Order = function(){
		
	var orderDataTable = function(){
		$('#orders').DataTable({
		  "bServerSide": true,
		  "sAjaxSource": BASE + "admin/orders/pages",
		  "aoColumns": [{
		    "mData":"serial_no",
		    "sTitle": "SL No.",
		    "bSortable": false,
		  },{
		    "mData": "Order No",
		    "sTitle": "order_no"
		  },{
		    "mData": "name",
		    "sTitle": "Customer Name"
		  },{
		    "mData": "total_amount",
		    "sTitle": "Amount"
		  },{
		    "mData": "created",
		    "sTitle": "Created On"
		  },{
		    "mData":"delivered",
		    "mRender": function(delivered){	    	
		      return "<a href='"+BASE+"admin/orders/view/"+delivered.id+"' alt='view'>View</a> | <a href='javascript:;' class='confirmDelete' rel='"+delivered.id+"' alt='delete'>Delete</a> | <a href='javascript:;' class='deliverStatus' rel='"+delivered.id+"' data-status='"+delivered.status+"' alt='active'>Undelivered</a>";
		    }
		  }],
		  "order": [[3, "desc"]],
		  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,4 ] }]
	       });
	}
	var deleteOrderProduct = function()
	{
		var id = $(this).attr("rel");
		var ele =  $(this);
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/orders/product_delete',
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
	var deleteOrder = function(){
		var id = $(this).attr("rel");
		var ele =  $(this);
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/orders/delete',
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
	var changeDeliveryStatus = function(){
		var id=$(this).attr("rel");
		var status = $(this).data('status');
		var ele =  $(this);
		$.ajax({
		        type:'POST',
		        url:BASE+'admin/orders/change_delivery_status',
			data:{id:id,status:status},
		        dataType:'json',
		        success:function(data){
		            //alert(data);
		           
		            if(data['status'] == "1")
		            {
		                $(ele).html("Delivered");
		            }
		            else
		            {
		                $(ele).html("UnDelivered");
		            }
		        }
	     });
	}
	return {
		orderDataTable : orderDataTable,
		deleteOrderProduct : deleteOrderProduct,
		deleteOrder:deleteOrder,
		changeDeliveryStatus : changeDeliveryStatus
	};
}();


