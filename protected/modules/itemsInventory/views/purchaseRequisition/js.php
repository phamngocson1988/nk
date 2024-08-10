<script>
    var searchParam = {};
/**** Tạo mới phiếu đề xuất ****/
	$('#oAdds').click(function (e) {
		$.ajax({
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsInventory/purchaseRequisition/create')?>",
            datatype:'json',
            success:function(data){
                if(data){
                    $("#createModal").html(data);
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
	}); 
/**** Search phiếu đề xuất ****/
    $('#searchTime').change(function () {
        if ($(this).val() ==5) {
            $('.hiddenTime').removeClass('hidden');
        }else{
            $('.hiddenTime').addClass('hidden');
        }
    });
    $(function () {
        $('#fromtime').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
        $('#totime').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    });

    $('.hiddenTime').change(function(e){
        fromtime = $('#fromtime').datepicker( "getDate");
        totime   = $('#totime').datepicker( "getDate");
        if(fromtime > totime){
            $('#totime').datepicker( "setDate", fromtime);
        }
    });

    function loadPurchaseRequisition(searchParam){
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type    : "POST",
            url     : "<?php echo Yii::app()->createUrl('itemsInventory/PurchaseRequisition/loadPurchaseRequisition')?>",
            dataType: 'html',
            data: searchParam,
            success:function(data){
                $('.cal-loading').fadeOut('fast');
                if(data) {
                    $(".tableList").html(data);
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    } 
    $(document).ready(function(){
        var searchRepository = $('#searchRepository').val();
        searchParam['searchRepository'] = searchRepository;
        loadPurchaseRequisition(searchParam);
    });
    $('#searchTime').change(function(e){
        var searchTime = $(this).val();
        if(searchTime < 5){
            searchParam['searchTime']   = searchTime;
            searchParam['page']         = 1;
            loadPurchaseRequisition(searchParam);
        }
    });
    $('#totime').change(function(e){
        var searchTime  = $('#searchTime').val();
        var fromtime    = $('#fromtime').val();
        var totime      = $('#totime').val();
        searchParam['searchTime']   = searchTime;
        searchParam['page']         = 1;
        searchParam['fromtime']     = fromtime;
        searchParam['totime']       = totime;
        loadPurchaseRequisition(searchParam);
    });
    $('#fromtime').change(function(e){
        var searchTime  = $('#searchTime').val();
        var fromtime    = $('#fromtime').val();
        var totime      = $('#totime').val();
        searchParam['searchTime']   = searchTime;
        searchParam['page']         = 1;
        searchParam['fromtime']     = fromtime;
        searchParam['totime']       = totime;
        loadPurchaseRequisition(searchParam);
    });
    $('#searchRepository').change(function(e){
        var searchRepository = $(this).val();
        searchParam['searchRepository'] = searchRepository;
        searchParam['page']             = 1;
        loadPurchaseRequisition(searchParam);
    });
    $('#searchStatus').change(function(e){
        var searchStatus = $(this).val();
        searchParam['searchStatus'] = searchStatus;
        searchParam['page']         = 1;
        loadPurchaseRequisition(searchParam);
    });

    function paging(page) {
        searchParam['page'] = page;
        loadPurchaseRequisition(searchParam);
    }
    function debounce(func, wait) {
        var timeout;
        return function() {
            var context = this,
                args = arguments;
            var executeFunction = function() {
              func.apply(context, args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(executeFunction, wait);
        };
    }; 
    var handleClick = debounce(function (e) {
        var searchCode =  $("#searchCode").val();
        searchParam['searchCode'] = searchCode;
        searchParam['page']       = 1;
        loadPurchaseRequisition(searchParam);
    }, 800);
    $('#searchCode').on('keyup', handleClick);
    $('#btnSearchCode').click(function(){
        var searchCode =  $("#searchCode").val();
        searchParam['searchCode'] = searchCode;
        searchParam['page']       = 1;
        loadPurchaseRequisition(searchParam);
    });

    $('.tableList').on('show.bs.collapse','.collapse', function () {
        $('.collapse.in').collapse('hide');
    });

/**** update phiếu đề xuất ****/
    $('.tableList').on('click','.btnUpdate',function(e){
        var id_purchase_requisition = $(this).parents('tr').find('input:hidden[name=id_purchase_requisition]').val();
        if(!id_purchase_requisition) return;
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type    :"POST",
            url     :"<?php echo Yii::app()->createUrl('itemsInventory/PurchaseRequisition/update')?>",
            datatype:'json',
            data    : {
                id_purchase_requisition: id_purchase_requisition
            },
            success:function(data){
                if(data) {
                    $("#updateModal").html(data);
                    $('.cal-loading').fadeOut('slow');
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    });
/**** Xóa phiếu đề xuất ****/
    $('.tableList').on('click','.btnDelete',function(e){
        var id_purchase_requisition = $(this).parents('tr').find('input:hidden[name=id_purchase_requisition]').val();
        if(!id_purchase_requisition) return;
        if(confirm("Bạn có thực sự muốn xóa ?")) {
            $.ajax({
                type:"POST",
                url:"<?php echo Yii::app()->createUrl('itemsInventory/PurchaseRequisition/delete')?>",
                data: {
                   id_purchase_requisition: id_purchase_requisition,
                },
                success:function(data){
                    if(data == 0){
                        alert("Phiếu đề xuất không tồn tại!");
                    } else if(data == 1) {
                        alert("Xóa thành công!");
                        loadPurchaseRequisition();
                    } else if(data == -1) {
                        alert(data);
                    }
                },
                error: function(data) {
                    alert("Error occured.Please try again!");
                },
            });
        }
    }); 
/**** In phiếu đề xuất ****/
    $('.tableList').on('click','.btnPrint',function(e){
        var id_purchase_requisition = $(this).parents('tr').find('input:hidden[name=id_purchase_requisition]').val();
        var url="<?php echo CController::createUrl('PurchaseRequisition/print')?>?id="+id_purchase_requisition;
        window.open(url,'name');
    });
    
/**** chuyển vào kho phiếu ****/ 
    $('.tableList').on('click','.btnConfirm',function(e){
        $('.cal-loading').fadeIn('fast');
        var id_purchase_requisition = $(this).parents('tr').find('input:hidden[name=id_purchase_requisition]').val();
        if(!id_purchase_requisition) return;
        $.ajax({
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsInventory/PurchaseRequisition/goodsReceipt')?>",
            data: {
               id_purchase_requisition: id_purchase_requisition,
            },
            success:function(data){
                $("#goodsReceiptModal").html(data);
                $('.cal-loading').fadeOut('slow');
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    });
</script>