<script>
//danh sách khách hàng
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

// danh sách sản phẩm
function productList() {
	$('.group_product').select2({
	    placeholder: 'Sản phẩm',
	    width: '270px',
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

$(document).ready(function(){
	
	$.fn.select2.defaults.set( "theme", "bootstrap" );

	var Item = <?php echo CJSON::encode($this->renderPartial('item_detail',array('orderdetail'=>$orderdetail,'form'=>$form,'i'=>'iTemp'),true)); ?>;
	/*********** Thêm trường dịch vụ mới trong form báo giá ***********/
	var max_fields  = 10; //maximum input boxes allowed
	var wrapper     = $(".sItem tbody"); //Fields wrapper

	<?php if(!$id_customer){ ?>
		customerList();
	<?php } ?>

	productList();
	var i= <?php echo $x; ?>;
	var x = <?php echo $x; ?>;
	$('.sbtnAdd').click(function(e){
		e.preventDefault();
		$('#sProduct').animate({
       			 scrollTop: $('#sProduct')[0].scrollHeight}, 1000);
	})

	$('#addProduct').click(function(e){
	    if(x < max_fields){ 
	        x++;
	        i++;
	        $(wrapper).append(Item.replace(/iTemp/g,i)); 
			productList();
		}
	});
		$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		    e.preventDefault(); $(this).parents('.currentRow').remove(); x--;
		    sum_amounts();
		})

		$('.sNote').click(function(e){
		    e.preventDefault();
		    $('.sNote').hide();
		    $('#sAddNote').removeClass('hidden');
		    
		})

		$(wrapper).on('change','.cal',function(e){
			var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    		$('.autoNum').autoNumeric('init',numberOptions);
    		data = $('.group').select2('data');
    		price = data[0].price;
    		qty = $(this).parents('tr').find('.group_qty').val();
		    stock = data[0].stock;

		  //   if(qty >stock){
		  //   	alert('số lượng hiện tại không đủ');
		  //   	qty = $(this).parents('tr').find('.group_qty').val(0);
		  //   	sum_amount = price * qty;
				// $(this).parents('tr').find('.group_unit').autoNumeric('set', price);
				// $(this).parents('tr').find('.group_amount').autoNumeric('set', sum_amount);
				// $(this).parents('tr').find('.s_group_unit').val(price);
				// $(this).parents('tr').find('.s_group_amount').val(sum_amount);
				// sum_amounts();
		  //   }else{
	    		sum_amount = price * qty;
				$(this).parents('tr').find('.group_unit').autoNumeric('set', price);
				$(this).parents('tr').find('.group_amount').autoNumeric('set', sum_amount);
				$(this).parents('tr').find('.s_group_unit').val(price);
				$(this).parents('tr').find('.s_group_amount').val(sum_amount);
				sum_amounts();
			//}
		})

		$('form#frm-order').submit(function(e){
			e.preventDefault();
			var code_number = $('#code_number').val();
	        var formData = new FormData($("#frm-order")[0]);

	        if (!formData.checkValidity || formData.checkValidity()) {
	        	$('.cal-loading').fadeIn('fast');
	            jQuery.ajax({ type:"POST",
	                url:"<?php echo CController::createUrl('order/create')?>",
	                data: formData,
	                datatype:'json',

	                success:function(data){
	                     if(data == '1'){
	                     	if(code_number){
	                     		alert("Tạo đơn hàng thành công!");
	                     		location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsCustomers/Accounts/admin?code_number='+code_number;
	                     	}else if(code_number ==''){
		                     	alert("Tạo đơn hàng thành công!");
		                        location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsSales/order/view';
		                    }
	                      }
	                    return false;
	                    
						$("#frm-order").html(data);
	                },
	                error: function(data) {
	                    alert("Error occured.Please try again!");
	                },
	                cache: false,
	                contentType: false,
	                processData: false
	            });
	        }
	       
	        return false;
		});
		
	});

	function sum_amounts(){
		var sum = 0;
		$('.cal_sum').each(function(){
			sum += +$(this).autoNumeric('get');
		})
		$('#sum_amount_t').autoNumeric('set', sum);
		$('#sum_amount_h').val(sum);
	}



$( "#Order_id_customer" ).change(function() {
  var id_customer = $('#Order_id_customer').val();
  	jQuery.ajax({   
            type:"POST",
            url:"<?php echo CController::createUrl('order/ChangeCustomer')?>",
            data:{
                'id_customer' :  id_customer,
            },
            success:function(data){
            	json = JSON.parse(data);
            	$('#OrderRecipient_name_recipient').val(json.fullname);
            	$('#OrderRecipient_phone_recipient').val(json.phone);
            	$('#OrderRecipient_email_recipient').val(json.email);
            	$('#OrderRecipient_address_recipient').val(json.address);
            }
    });
});

</script>