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
		    "mData": "order_no",
		    "sTitle": "Order No"
		  },{
		    "mData": "name",
		    "sTitle": "Customer Name"
		  },{
		    "mData": "amount",
		    "sTitle": "Amount"
		  },{
		    "mData": "payment_type",
		    "sTitle": "Payment Method"
		  },{
		    "mData": "created",
		    "sTitle": "Created On"
		  },{
		    "mData":"delivered",
		    "mRender": function(delivered){	    	
		      return "<a href='"+BASE+"admin/orders/view/"+delivered.id+"' alt='view'>View</a> | <a href='javascript:;' class='confirmDelete' rel='"+delivered.id+"' alt='delete'>Delete</a> | <a href='javascript:;' class='deliverStatus' rel='"+delivered.id+"' data-status='"+delivered.status+"' alt='active'>Undelivered</a>";
		    }
		  }],
		  "order": [[5, "desc"]],
		  "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,4,6 ] }]
	       });
	}
	var deleteOrderProduct = function(ele)
	{
		var id = $(ele).attr("rel");
		
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
	var deleteOrder = function(ele){
		var id = $(ele).attr("rel");
		
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
	var changeDeliveryStatus = function(ele){
		var id=$(ele).attr("rel");
		var status = $(ele).data('status');
		
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


