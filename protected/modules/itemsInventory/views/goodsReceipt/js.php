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
    function loadGoodsReceipt(searchParam){
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type    : "POST",
            url     : "<?php echo Yii::app()->createUrl('itemsInventory/GoodsReceipt/loadData')?>",
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
        loadGoodsReceipt(searchParam);
    }); 
    $('#searchTime').change(function(e){
        var searchTime = $(this).val();
        if(searchTime < 5){
            searchParam['searchTime']   = searchTime;
            searchParam['page']         = 1;
            loadGoodsReceipt(searchParam);
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
        loadGoodsReceipt(searchParam);
    });
    $('#fromtime').change(function(e){
        var searchTime  = $('#searchTime').val();
        var fromtime    = $('#fromtime').val();
        var totime      = $('#totime').val();
        searchParam['searchTime']   = searchTime;
        searchParam['page']         = 1;
        searchParam['fromtime']     = fromtime;
        searchParam['totime']       = totime;
        loadGoodsReceipt(searchParam);
    });
    $('#searchRepository').change(function(e){
        var searchRepository = $(this).val();
        searchParam['searchRepository'] = searchRepository;
        searchParam['page']             = 1;
        loadGoodsReceipt(searchParam);
    });
    $('#searchStatus').change(function(e){
        var searchStatus = $(this).val();
        searchParam['searchStatus'] = searchStatus;
        searchParam['page']         = 1;
        loadGoodsReceipt(searchParam);
    });
    function paging(page) {
        searchParam['page'] = page;
        loadGoodsReceipt(searchParam);
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
        loadGoodsReceipt(searchParam);
    }, 800);
    $('#searchCode').on('keyup', handleClick);
    $('#btnSearchCode').click(function(){
        var searchCode =  $("#searchCode").val();
        searchParam['searchCode'] = searchCode;
        searchParam['page']       = 1;
        loadGoodsReceipt(searchParam);
    });

    $('.tableList').on('show.bs.collapse','.collapse', function () {
        $('.collapse.in').collapse('hide');
    });
 
/**** Xóa phiếu ****/
    $('.tableList').on('click','.btnDelete',function(e){
        var id_goods_receipt = $(this).parents('tr').find('input:hidden[name=id_goods_receipt]').val();
        if(!id_goods_receipt) return;
        if(confirm("Bạn có thực sự muốn xóa ?")) {
            $.ajax({
                type:"POST",
                url:"<?php echo Yii::app()->createUrl('itemsInventory/GoodsReceipt/delete')?>",
                data: {
                   id_goods_receipt: id_goods_receipt,
                },
                success:function(data){
                    if(data == 0){
                        alert("Phiếu nhập kho không tồn tại!");
                    }else if(data == 1) {
                        $.jAlert({
                            'title': "Thông báo",
                            'content': "Xóa thành công!"
                        });
                        loadGoodsReceipt(searchParam);
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
/**** Tạo mới ****/
    $('#oAdds').click(function (e) {
        $.ajax({
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsInventory/goodsReceipt/create')?>",
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

/**** update phiếu đề xuất ****/
    $('.tableList').on('click','.btnUpdate',function(e){
        var id_goods_receipt = $(this).parents('tr').find('input:hidden[name=id_goods_receipt]').val();
        if(!id_goods_receipt) return;
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type    :"POST",
            url     :"<?php echo Yii::app()->createUrl('itemsInventory/goodsReceipt/update')?>",
            datatype:'json',
            data    : {
                id_goods_receipt: id_goods_receipt
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
</script>