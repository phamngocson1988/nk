<script>
var searchParam = {};
/**** load time ****/
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
        fromtime = $('#fromtime').datepicker("getDate");
        totime   = $('#totime').datepicker("getDate");
        if(fromtime > totime)
            $('#totime').datepicker( "setDate", fromtime);
    });

    $(document).ready(function(){        
        var searchRepository = $('#searchRepository').val();
        searchParam['searchRepository'] = searchRepository;
        loadData(searchParam);
    });
/**** Tạo mới phiếu hủy ****/
    $('#oAdds').click(function (e) {
		$.ajax({
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsInventory/useMaterial/create')?>",
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
    function loadData(searchParam){
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type    : "POST",
            url     : "<?php echo Yii::app()->createUrl('itemsInventory/useMaterial/loadData')?>",
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

    $('#searchTime').change(function(e){
        var searchTime = $(this).val();
        if(searchTime < 5){
            searchParam['searchTime']   = searchTime;
            searchParam['page']         = 1;
            loadData(searchParam);
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
        loadData(searchParam);
    });
    $('#fromtime').change(function(e){
        var searchTime  = $('#searchTime').val();
        var fromtime    = $('#fromtime').val();
        var totime      = $('#totime').val();
        searchParam['searchTime']   = searchTime;
        searchParam['page']         = 1;
        searchParam['fromtime']     = fromtime;
        searchParam['totime']       = totime;
        loadData(searchParam);
    });
    $('#searchRepository').change(function(e){
        var searchRepository = $(this).val();
        searchParam['searchRepository'] = searchRepository;
        searchParam['page']             = 1;
        loadData(searchParam);
    });
    function paging(page) {
        searchParam['page'] = page;
        loadData(searchParam);
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
        loadData(searchParam);
    }, 800);
    $('#searchCode').on('keyup', handleClick);
    $('#btnSearchCode').click(function(){
        var searchCode =  $("#searchCode").val();
        searchParam['searchCode'] = searchCode;
        searchParam['page']       = 1;
        loadData(searchParam);
    }); 
</script>