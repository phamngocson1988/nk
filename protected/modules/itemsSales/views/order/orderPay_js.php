<script>
function checkNum() {
	var balance = $('.balance').autoNumeric('get');
	var refund = $('#pay_refund').autoNumeric('get');

	if($('.pay_amount').autoNumeric('get') <= 0 || balance < 0 || refund < 0) {
		$('.pay_amount').css('border','1px solid red');
		$('.pay_insurance').css('border','1px solid red');
		$('#pay_receive').css('border','1px solid red');
		return 0;
	}
	else 
	{
		$('.pay_amount').css('border','1px solid #ccc');
		$('.pay_insurance').css('border','1px solid #ccc');
		$('#pay_receive').css('border','1px solid #ccc');
		return 1;
	}
}
$(function(){
	var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
	$('.autoNum').autoNumeric('init',numberOptions);

	var balance = parseInt($('input[name="hidden_balance"]').val());

	var today = moment().format('YYYY-MM-DD HH:mm:ss');
	$('.today').html(today);
	
	$('.pay').keyup(function(e){
		amount = $('.pay_amount').autoNumeric('get');
		insurance = $('.pay_insurance').autoNumeric('get');
		promotion = $('.pay_promotion').autoNumeric('get');
		minus = balance - (parseInt(amount) + parseInt(insurance) + parseInt(promotion));
		$('.balance').autoNumeric('set',minus);
	})

	$('.pay_amount').keyup(function(e){
		amount = $('.pay_amount').autoNumeric('get');

		$('#pay_receive').autoNumeric('set',amount);
	})

	$('.refund').keyup(function(e){
		amount = $('.pay_amount').autoNumeric('get');
		receive = $('#pay_receive').autoNumeric('get');

		refund = receive - amount;

		$('#pay_refund').autoNumeric('set',refund);

	})

	$('.pay_type').val(1);

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		pay_type = $(e.target).attr('id');
	 	console.log (pay_type);
		$('.pay_type').val(pay_type);	 	
	});

	$('form#frm-pay-invoice').submit(function(e){
		e.preventDefault();
		
		if(!checkNum())
			return false;

		pay_date = $('#InvoicePayment_pay_date').val();
		ch = moment(pay_date,'DD/MM/YYYY').format('YYYY-MM-DD HH:mm:ss');
		$('#InvoicePayment_pay_date').val(ch);


        var formData = new FormData($("#frm-pay-invoice")[0]);

        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({ type:"POST",
                url:"<?php echo CController::createUrl('order/orderPay')?>",
                data: formData,
                datatype:'json',

                success:function(data){
                    if(data > 0)
                    	location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsSales/invoices/View?id='+data;
                    return false;
                    
					$("#login-customer-modal").html(data);
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
</script>