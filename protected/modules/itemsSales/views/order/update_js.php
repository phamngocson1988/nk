<script>
 
$(function() {
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    $('.autoNum').autoNumeric('init',numberOptions);
	$.fn.select2.defaults.set( "theme", "bootstrap" );
  
	 var uItem = <?php echo CJSON::encode($this->renderPartial('item_detail',array('orderdetail'=>$order_up,'form'=>$form,'i'=>'iTemp'),true)); ?>;

	/*********** Thêm trường dịch vụ mới trong form hóa đơn ***********/
	var max_fields  = 10; //maximum input boxes allowed
	var wrapper     = $(".sItem tbody"); //Fields wrapper

	var i= <?php echo $x; ?>;
	var x = <?php echo $x; ?>;

	$('.sbtnAdd').click(function(e){
		e.preventDefault();
		$('#usProduct').animate({
       			 scrollTop: $('#usProduct')[0].scrollHeight}, 1000);
	})

	
	$('#upAddProduct').click(function(e){
	    if(x < max_fields){ 
	        x++;
	        i++;
		
	        $(wrapper).append(uItem.replace(/iTemp/g,i)); 
			 productList();
		}
	});

	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
	    e.preventDefault(); 
	    $(this).parents('.currentRow').remove(); 
	    x--;
        sum_amounts();
	})

	$(wrapper).on("click",".remove_field_hidden", function(e){ //thêm
        e.preventDefault();

        var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    	$('.autoNum').autoNumeric('init',numberOptions);
	    
	    sum = $(this).parents('tr').find('.cal_sum').autoNumeric('get');
	    total = $('#t_sum_amount').autoNumeric('get');
	    
	    $('#t_sum_amount').autoNumeric('set', total - sum);
	    $('#h_sum_amount').val(total - sum);
        $(this).parents('.currentRow').addClass('hidden');
        $(this).parents('.currentRow').find('.order_del').val(1);
        x--;
    })

	$('.sNote').click(function(e){
	    e.preventDefault();
	    $('.sNote').hide();
	    $('#usAddNote').removeClass('hidden');
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
 
	$('form#frm-update-order').submit(function(e){
		e.preventDefault();	
        var formData = new FormData($("#frm-update-order")[0]);
        var code_number = $('#code_number').val();
        if (!formData.checkValidity || formData.checkValidity()) {
        	$('.cal-loading').fadeIn('fast');
            jQuery.ajax({ type:"POST",
                url:"<?php echo CController::createUrl('order/updateOrder')?>",
                data: formData,

                datatype:'json',

                success:function(data){
                	
                    if(data == '1'){
                    	if(code_number){
	                    	alert("Cập nhật thông tin đơn hàng thành công!");
	                        location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsCustomers/Accounts/admin?code_number='+code_number;
	                    }else if(code_number==''){
	                    	alert("Cập nhật thông tin đơn hàng thành công!");
	                        location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsSales/order/view';
	                    }
                    }
                  
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
	})

})

function sum_amounts(){
    var sum = 0;
        $('.cal_sum').each(function(){
            sum += +$(this).autoNumeric('get');
        })
        $('#t_sum_amount').autoNumeric('set', sum);
        $('#h_sum_amount').val(sum);
}

</script>