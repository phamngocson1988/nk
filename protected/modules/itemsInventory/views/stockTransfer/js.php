<script>
	var searchParam = {};
/**** Search phiếu nhập kho ****/
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
        if(fromtime > totime)
            $('#totime').datepicker( "setDate", fromtime);
    });

/**** Tạo mới ****/
    $('#oAdds').click(function (e) {
        $.ajax({
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsInventory/stockTransfer/create')?>",
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
/**** Lấy danh sách ****/
    function loadStockTransfer(searchParam){
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type    : "POST",
            url     : "<?php echo Yii::app()->createUrl('itemsInventory/stockTransfer/loadData')?>",
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
        var searchRepositoryTransfer = $('#searchRepositoryTransfer').val();
        searchParam['searchRepositoryTransfer'] = searchRepositoryTransfer;
        loadStockTransfer(searchParam);
    }); 
    $('#searchTime').change(function(e){
        var searchTime = $(this).val();
        if(searchTime < 5){
            searchParam['searchTime']   = searchTime;
            searchParam['page']         = 1;
            loadStockTransfer(searchParam);
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
        loadStockTransfer(searchParam);
    });
    $('#fromtime').change(function(e){
        var searchTime  = $('#searchTime').val();
        var fromtime    = $('#fromtime').val();
        var totime      = $('#totime').val();
        searchParam['searchTime']   = searchTime;
        searchParam['page']         = 1;
        searchParam['fromtime']     = fromtime;
        searchParam['totime']       = totime;
        loadStockTransfer(searchParam);
    });
    $('#searchRepositoryTransfer').change(function(e){
        var searchRepositoryTransfer = $(this).val();
        searchParam['searchRepositoryTransfer'] = searchRepositoryTransfer;
        searchParam['page']             = 1;
        loadStockTransfer(searchParam);
    });
    $('#searchRepositoryReceipt').change(function(e){
        var searchRepositoryReceipt = $(this).val();
        searchParam['searchRepositoryReceipt'] = searchRepositoryReceipt;
        searchParam['page']             = 1;
        loadStockTransfer(searchParam);
    });
    $('#searchStatus').change(function(e){
        var searchStatus = $(this).val();
        searchParam['searchStatus'] = searchStatus;
        searchParam['page']         = 1;
        loadStockTransfer(searchParam);
    });
    function paging(page) {
        searchParam['page'] = page;
        loadStockTransfer(searchParam);
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
        loadStockTransfer(searchParam);
    }, 800);
    $('#searchCode').on('keyup', handleClick);
    $('#btnSearchCode').click(function(){
        var searchCode =  $("#searchCode").val();
        searchParam['searchCode'] = searchCode;
        searchParam['page']       = 1;
        loadStockTransfer(searchParam);
    }); 
    /**** Xóa phiếu ****/
    $('.tableList').on('click','.btnDelete',function(e){
        var id_stock_transfer = $(this).parents('tr').find('input:hidden[name=id_stock_transfer]').val();
        if(!id_stock_transfer) return;
        if(confirm("Bạn có thực sự muốn xóa phiếu chuyển kho này ?")) {
            $.ajax({
                type:"POST",
                url:"<?php echo Yii::app()->createUrl('itemsInventory/stockTransfer/delete')?>",
                data: {
                   id_stock_transfer: id_stock_transfer,
                },
                success:function(data){
                    if(data == 0){
                        alert("Phiếu chuyển kho không tồn tại!");
                    }else if(data == 1) {
                        $.jAlert({
                            'title': "Thông báo",
                            'content': "Xóa thành công!"
                        });
                        loadStockTransfer(searchParam);
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
/**** update phiếu chuyển kho ****/
    $('.tableList').on('click','.btnUpdate',function(e){
        var id_stock_transfer = $(this).parents('tr').find('input:hidden[name=id_stock_transfer]').val();
        if(!id_stock_transfer) return;
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type    :"POST",
            url     :"<?php echo Yii::app()->createUrl('itemsInventory/stockTransfer/update')?>",
            datatype:'json',
            data    : {
                id_stock_transfer: id_stock_transfer
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
/**** Xác nhận phiếu chuyển kho ****/
    $('.tableList').on('click','.btnConfirm',function(e){
        var id_stock_transfer = $(this).parents('tr').find('input:hidden[name=id_stock_transfer]').val();
        if(!id_stock_transfer) return;
        if(confirm("Bạn có thực sự muốn xác nhận chuyển kho này ?")) {
            $.ajax({
                type:"POST",
                url:"<?php echo Yii::app()->createUrl('itemsInventory/stockTransfer/confirm')?>",
                data: {
                   id_stock_transfer: id_stock_transfer,
                },
                success:function(data){
                   
                    if(data == 1) {
                        $.jAlert({
                            'title': "Thông báo",
                            'content': "Chuyển kho thành công!"
                        });
                        loadStockTransfer(searchParam);
                    }else{
                        $.jAlert({
                            'title': "Thông báo",
                            'content': data
                        });
                    }
                },
                error: function(data) {
                    alert("Error occured.Please try again!");
                },
            });
        }
    });

</script>