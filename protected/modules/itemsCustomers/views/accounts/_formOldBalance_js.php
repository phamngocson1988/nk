<script>
		
</script>

<script>
/*********** Dinh dang tien te ***********/
	var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    $('.autoNum').autoNumeric('init',numberOptions);
/*********** Ngay thang ***********/
	$('.frm_datepicker').datepicker({
		dateFormat: 'dd/mm/yy',
		minDate: moment().format('DD/MM/YYYY'),
	})

	$('.frm_datepicker').change(function(e){
		create_date = $('#Invoice_create_date').datepicker( "getDate");
		last_date   = $('#Invoice_complete_date').datepicker( "getDate");
		if(create_date>=last_date)
			$('#Invoice_complete_date').datepicker( "setDate", create_date);
	})

	var today     = moment().format('DD/MM/YYYY');
	var user_name = '<?php echo $user_name; ?>';
	if(!$('#Invoice_create_date').val())
		$('#Invoice_create_date').val(today);
	if(!$('#Invoice_complete_date').val())
		$('#Invoice_complete_date').val(today);
/*********** Ghi chu ***********/
	$('.sNote').click(function(e){
	    e.preventDefault();
	   	if($('#sAddNote').hasClass('hidden'))
	    	$('#sAddNote').removeClass('hidden');
	    else 
	    	$('#sAddNote').addClass('hidden');
	});
/*********** Tinh gia tri thanh tien ***********/
	$('.old_set_price').on('input change keypress keydown', function(e){
		// so luong
		qty = $('.old_qty').val();
		// don gia
		unit_price = $('.old_unit_price').autoNumeric('get');

		if(!$.isNumeric(qty)){
			qty = 1;
		}

		if(isNaN(unit_price)){
			unit_price = 0;
		}

		// thanh tien = so luong * don gia
		amount = qty * unit_price;

		$('.old_amount').autoNumeric('set',amount);
	});
/*********** submit ***********/
	$('form#frm-old-balance').submit(function(e){
		e.preventDefault();

		id_customer = $('#Invoice_id_customer').val();
		id_invoice = $('#Invoice_id').val();

		if($('.old_qty').val() == ''){
			$('.old_qty').val(1);
		}

        $('.autoNum').each(function(i){
	        var self = $(this);
	        try{
	            var v = self.autoNumeric('get');
	            self.autoNumeric('destroy');
	            self.val(v);
	        }catch(err){
	            console.log("Not an autonumeric field: " + self.attr("name"));
	        }
	    });

	    $('.frm_datepicker').each(function(i) {
	    	var self = $(this);
	    	var v = self.val();
	        var formatDate = moment(v,'DD/MM/YYYY').format('YYYY-MM-DD HH:mm:ss');
	        self.val(formatDate);
	    });

	    var formData = new FormData($("#frm-old-balance")[0]);

        if (!formData.checkValidity || formData.checkValidity()) {
        	if(!id_invoice){
        		$.ajax({ 
	            	type:"POST",
	                url     : baseUrl+'/itemsCustomers/Accounts/addOldBalance',
	                data: formData,

	                success:function(data){
	                	console.log(data);
						// if(id_customer){
						// 	$("#addOldBalance").removeClass("in");
						// 	$(".modal-backdrop").remove();
	     //            		$("#addOldBalance").modal('hide');
	     //            		detailCustomer(id_customer);
	     //            	}
	                },
	                error: function(data) {
	                    alert("Error occured.Please try again!");
	                },
	                cache: false,
	                contentType: false,
	                processData: false
	            });
        	}
        	else {
        		$.ajax({ 
	            	type:"POST",
	                url     : baseUrl+'/itemsCustomers/Accounts/updateOldBalance',
	                data: formData,

	                success:function(data){
						if(id_customer){
							$("#addOldBalance").removeClass("in");
							$(".modal-backdrop").remove();
	                		$("#addOldBalance").modal('hide');
	                		detailCustomer(id_customer);
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
        }
       
        return false;
	})
</script>