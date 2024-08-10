<script>
var searchParam = {};
/**** Danh sách nguyên vật liệu trong kho ****/
    $('#searchExpirationDate').change(function () {
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

    function loadMaterialStock(searchParam){
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type    : "POST",
            url     : "<?php echo Yii::app()->createUrl('itemsInventory/materialStock/loadData')?>",
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
        loadMaterialStock(searchParam);
        listMaterial();
    });

    $('#searchExpirationDate').change(function(e){
        var searchExpirationDate = $(this).val();
        if(searchExpirationDate < 5){
            searchParam['searchExpirationDate']   = searchExpirationDate;
            searchParam['page']         = 1;
            loadMaterialStock(searchParam);
        }
    });
    $('#totime').change(function(e){
        var searchExpirationDate  = $('#searchExpirationDate').val();
        var fromtime    = $('#fromtime').val();
        var totime      = $('#totime').val();
        searchParam['searchExpirationDate']   = searchExpirationDate;
        searchParam['page']         = 1;
        searchParam['fromtime']     = fromtime;
        searchParam['totime']       = totime;
        loadMaterialStock(searchParam);
    });
    $('#fromtime').change(function(e){
        var searchExpirationDate  = $('#searchExpirationDate').val();
        var fromtime    = $('#fromtime').val();
        var totime      = $('#totime').val();
        searchParam['searchExpirationDate']   = searchExpirationDate;
        searchParam['page']         = 1;
        searchParam['fromtime']     = fromtime;
        searchParam['totime']       = totime;
        loadMaterialStock(searchParam);
    });
    $('#searchRepository').change(function(e){
        var searchRepository = $(this).val();
        searchParam['searchRepository'] = searchRepository;
        searchParam['page']             = 1;
        loadMaterialStock(searchParam);
    });
    $('#searchMaterial').change(function(e){
        var searchMaterial = $(this).val();
        searchParam['searchMaterial']   = searchMaterial;
        searchParam['page']             = 1;
    });

    function paging(page) {
        searchParam['page'] = page;
        loadMaterialStock(searchParam);
    }

    $('.tableList').on('show.bs.collapse','.collapse', function () {
        $('.collapse.in').collapse('hide');
    });
    function listMaterial() {
        $('#searchMaterial').select2({
            placeholder: 'Nguyên vật liệu',
            width: '100%',
            dropdownCssClass: "chooseMaterial",
            dropdownAutoWidth: true,
            ajax: {
                dataType: "json",
                url: '<?php echo CController::createUrl('purchaseRequisition/getListMaterial'); ?>',
                type: "post",
                delay: 1000,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page || 1,
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data,
                        pagination: {
                            more: true
                        }
                    };
                },
            },
        });
    }

</script>