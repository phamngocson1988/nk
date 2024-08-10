<script>
function customer() {
    $('#order_customer').select2({
        placeholder: 'Khách hàng',
        width: '150px',
        allowClear: true,
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

function exportOrder(idorder) {
       
    var url="<?php echo CController::createUrl('order/exportOrder')?>?order="+idorder;
    window.open(url,'name');
}

function loadOrder(page,id,time,branch,customer,order_code) {
    $('.cal-loading').fadeIn('fast');
    $.ajax({ 
        type:"POST",
        url:"<?php echo Yii::app()->createUrl('itemsSales/Order/loadOrder')?>",
        dataType: 'html',
        data: {
            page        : page,
            id          : id,
            order_time        : time,
            order_branch      : branch,
            order_customer    : customer,
            order_code  : order_code,
        },
        success:function(data){
            if(data){
                $("#OrderList").html(data);
                $('.cal-loading').fadeOut('slow');
            }
        },
        error: function(data) {
            alert("Error occured.Please try again!");
        },
    });
}

function deleteOrder(id_order) {
   
    if(confirm("Bạn có thực sự muốn hủy đơn hàng?")) {
        $.ajax({ 
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsSales/order/deleteOrder')?>",
            data: {
               id_order: id_order,
            },
            success:function(data){
                if(data == 1){
                    alert("Hủy thành công!");
                    loadOrder(1,'');
                }
                else if(data == -1)
                    alert(data);
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    } 
}

$( document ).ready(function() {
$('#OrderList').on('show.bs.collapse','.collapse', function () {
    $('.collapse.in').collapse('hide');
});

$.fn.select2.defaults.set( "theme", "bootstrap" );
   
    loadOrder(1,'');
    customer();

    $('#oAdds').click(function (e) {
        e.preventDefault();
        x = 1;
        $('.currentRow').nextAll('tr').remove();
        $('.sNote').show();
        $('#sAddNote').addClass('hidden');
    });

    /*search quotations*/
    // search time
    $('#order_time').change(function(e){
        order_time = $('#order_time').val();
        order_branch = $('#order_branch').val();
        order_customer = $('#order_customer').val();

        loadOrder(1, '', order_time, order_branch, order_customer, '');
    })

    // search branch
    $('#order_branch').change(function(e){
        order_time = $('#order_time').val();
        order_branch = $('#order_branch').val();
        order_customer = $('#order_customer').val();

        loadOrder(1, '', order_time, order_branch, order_customer, '');
    })

    // search customer
    $('#order_customer').change(function(e){
        order_time = $('#order_time').val();
        order_branch = $('#order_branch').val();
        order_customer = $('#order_customer').val();

        loadOrder(1, '', order_time, order_branch, order_customer, '');
    })

    // search customer
    $('#order_srch').click(function(e){
       order_code = $('#order_code').val();

        loadOrder(1, '', '', '', '', order_code);
    })

  });
//create order
$( document ).ready(function() {
    if($('#order_modal div').length == 0){
        $('.cal-loading').fadeIn('fast');
        $.ajax({ 
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsSales/order/create')?>",
            datatype:'json',
            success:function(data){
               // console.log(data);
                if(data){
                    $("#order_modal").html(data);
                    $('.cal-loading').fadeOut('slow');
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
            cache: false, 
            contentType: false,
            processData: false
        });
    };
});
// update order
$( document ).ready(function() {
    $('#OrderList').on('click','.qUpdate',function(e){
         var id_order = $(this).parents('tr').find('input:hidden[name=id_order]').val();
       
    if(!id_order)
            return;
        $('.cal-loading').fadeIn('fast');
        $.ajax({ 
            type:"POST",
            url:"<?php echo CController::createUrl('order/updateOrder')?>",
            datatype:'json',
            data: {
                id_order: id_order,
            },
            success:function(data){
               
                if(data){
                    
                    $("#update_order_modal").html(data);
                    $('.cal-loading').fadeOut('slow');
                   
                      
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },     
           
        });
    });

});
//export pfd
$( document ).ready(function() {

    $('#OrderList').on('click','.print',function(e){
        var id_order = $(this).parents('tr').find('input:hidden[name=id_order]').val();
        var url="<?php echo CController::createUrl('order/exportOrder')?>?id_order="+id_order;
        window.open(url,'name');
       
    });
 
});



</script>