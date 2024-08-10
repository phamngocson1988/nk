<script type="text/javascript">
function deleteRelationFamily(id) {
	if(confirm("Bạn có thực sự muốn xóa?")) {
        $.ajax({ 
            type:"POST",
            url:'<?php echo CController::createUrl('Accounts/deleteRelationFamily'); ?>',
            data: {
               id: id,
            },
            success:function(data){
                if(data == 1){
                    alert("Xóa thành công!");
                     window.location.href = '<?php echo CController::createUrl("Accounts/admin");?>';
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    }
}
function deleteRelationSocial(id) {
    if(confirm("Bạn có thực sự muốn xóa?")) {
        $.ajax({ 
            type:"POST",
            url:'<?php echo CController::createUrl('Accounts/deleteRelationSocial'); ?>',
            data: {
               id: id,
            },
            success:function(data){
                if(data == 1){
                    alert("Xóa thành công!");
                     window.location.href = '<?php echo CController::createUrl("Accounts/admin");?>';
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    }
}

	function customer() {
	    $('#customer_relation').select2({
	        placeholder: 'Chọn người',
	        width: '100%',
	        allowClear: true,
	        ajax: {
	            dataType : "json",
	            url      : '<?php echo CController::createUrl('Accounts/getCustomerList_1'); ?>',
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
	function customer2() {
	    $('#customer_relation_social').select2({
	        placeholder: 'Chọn người',
	        width: '100%',
	        allowClear: true,
	        ajax: {
	            dataType : "json",
	            url      : '<?php echo CController::createUrl('Accounts/getCustomerList_1'); ?>',
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
	$( document ).ready(function() {
	    
	       $.fn.select2.defaults.set( "theme", "bootstrap" );
	       customer();
	       customer2();
	});

$('#frm-add-relation-family').submit(function(e) {
    e.preventDefault();    
    var formData = new FormData($("#frm-add-relation-family")[0]);    
    if (!formData.checkValidity || formData.checkValidity()) {
    	//$('.cal-loading').fadeIn('fast');
        jQuery.ajax({           
            type:"POST",
            url: baseUrl+'/itemsCustomers/Accounts/addRelationFamily',    
            data:formData,
            datatype:'json',
            success:function(data){  
            console.log(data);                          
                if(data == -1){                  
                }if(data == -2){                
                }else if(data >= 1){ 
                    $('#frm-add-relation-family')[0].reset();    
                    $('#familyPopover').hide(); 
                    //$('.cal-loading').fadeOut('fast');
                     window.location.href = '<?php echo CController::createUrl("Accounts/admin");?>';  
                    
                }
            },
            error: function(data) {
                alert("Error occured. Please try again!");
            },
            cache: false, 
            contentType: false,
            processData: false
        });
    }
    return false;
});

$('#frm-add-relation-social').submit(function(e) {
    e.preventDefault();    
    var formData = new FormData($("#frm-add-relation-social")[0]);    
    if (!formData.checkValidity || formData.checkValidity()) {
    	//$('.cal-loading').fadeIn('fast');
        jQuery.ajax({           
            type:"POST",
            url: baseUrl+'/itemsCustomers/Accounts/addRelationSocial',    
            data:formData,
            datatype:'json',
            success:function(data){  
            console.log(data);                          
                if(data == -1){                  
                }if(data == -2){                
                }else if(data >= 1){ 
                    $('#frm-add-relation-social')[0].reset();    
                    $('#societyPopover').hide(); 
                    //$('.cal-loading').fadeOut('fast');
                     window.location.href = '<?php echo CController::createUrl("Accounts/admin");?>';  
                    
                }
            },
            error: function(data) {
                alert("Error occured. Please try again!");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    return false;
});

$(function() {    
    $( "#birthdate" ).datepicker({
        changeMonth: true,
        changeYear: true,       
        dateFormat: 'dd/mm/yy',
        yearRange: '1900:+0'
    });
    $( "#last_day" ).datepicker({
        changeMonth: true,
        changeYear: true,       
        dateFormat: 'dd/mm/yy',
        yearRange: '1900:+0'
    });
    $( "#startdate" ).datepicker({
        changeMonth: true,
        changeYear: true,       
        dateFormat: 'yy-mm-dd'
    });
    $( "#enddate" ).datepicker({
        changeMonth: true,
        changeYear: true,       
        dateFormat: 'yy-mm-dd'
    });  
});

$( document ).ready(function() {

    $('.printProfile').on('click',function(e){
      
        var id_customer        = $("#id_customer").val();         
      
        if (id_customer) {
            var url="<?php echo CController::createUrl('Accounts/exportProfile')?>?id_customer="+id_customer;
            window.open(url,'name') 
        };
                      
    }); 

});

$( document ).ready(function() {

    var windowHeight =  $(window).height();
    var header       = $("#headerMenu").height();
    var tab_menu     = $("#tabcontent .menuTabDetail").height();
    var customer_action = $(".customersActionHolder").height();    
    var customer_search = $(".customerSearchHolder").height();

    $('#profileSideNav').height(windowHeight-header);

   $('.statsTabContent').height(windowHeight-header-tab_menu-45);   
   

   $('#customerList').css('max-height', windowHeight-header-customer_action-customer_search-80);

});

$('#showFamilyPopover').click(function(){ 
    $('#familyPopover').fadeToggle('fast');
});
$('#hideFamilyPopover').click(function(){ 
    $('#familyPopover').hide(); 
});

$('#showSocietyPopover').click(function(){ 
    $('#societyPopover').fadeToggle('fast');
});
$('#hideSocietyPopover').click(function(){ 
    $('#societyPopover').hide(); 
});

</script>