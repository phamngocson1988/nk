<script>
	function productList() {
	$('.group_product').select2({
	    placeholder: 'Sản phẩm',
	    width: '100%',
	    ajax: {
	        dataType : "json",
	        url      : '<?php echo CController::createUrl('order/getProductList'); ?>',
	        type     : "post",
	        delay    : 50,
	        data : function (params) {
				return {
					q: params.term, // search term
					page: params.page || 1
				};
			},
			processResults: function (data, params) {
				params.page = params.page || 1;
				return {
					results: data,
					pagination: {
						more:true
					}
				};
			},
			cache: true,
	    },
	});
}

function customerList() {
	$('#Order_id_customer').select2({
	    placeholder: 'Khách hàng',
	    width: '100%',
	    ajax: {
	        dataType : "json",
	        url      : '<?php echo CController::createUrl('order/getCustomerList'); ?>',
	        type     : "post",
	        delay    : 50,
	        data : function (params) {
				return {
					q: params.term, // search term
					page: params.page || 1
				};
			},
			processResults: function (data, params) {
				params.page = params.page || 1;
				
				return { 
					results: data,
					pagination: {
						more:true
					}
				};
			},
			cache: true,
	    },
	});
}




</script>