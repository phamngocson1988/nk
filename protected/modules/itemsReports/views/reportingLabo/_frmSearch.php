<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-multiselect.js" charset="utf-8"></script> 
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-multiselect.css" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel/jquery.table2excel.min.js"></script> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/excel/jquery.tabletoCSV.js" charset="utf-8"></script>

<style type="text/css">
    .multiselect-container{
        overflow: scroll;
        height: 300px;
    }
    .btn{
        color: black;
    }
    #searchCustomerModal .modal-body {
        background-color: #fff;
    }
    #txtSearchCustomer {
        width: 100%;
    }
    #searchCustomerModal .modal-dialog {
        width: 900px;
    }
    #searchCustomerModal ul {
        padding-left: 0;
    }
    #searchCustomerModal ul li {
        list-style: none;
        padding-top: 15px;
    }
    #searchCustomerResult{
        max-height: 500px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
</style>

<form class="form-inline">
    <div id="oSrchRight" class="pull-left">  

        <div class="form-group" style="margin-right: 20px;">
            <label>Bác sĩ: </label>
            <?php
            $listdata = array();
            $user         = GpUsers::model()->findAllByAttributes(array('block'=>0,'group_id'=>3));
            foreach($user as $temp){
                $listdata[$temp['id']] =  $temp['name'];
            }
            //echo CHtml::dropDownList('frm_search_user','',$listdata,array('onChange'=>"",'class'=>'form-control'));
            ?>
            <select id="frm_search_user" multiple="multiple" searchable="Search here..">
                <?php foreach ($listdata as $key => $value): ?>
                    <option value="<?php echo $key?>"><?php echo $value?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-group" style="margin-right: 20px;">
            <label>Khách hàng: </label>
            <input type="text" name="frm_search_customer" data-toggle="modal" data-target="#searchCustomerModal" id="frm_search_customer" class="form-control">
        </div>

        <input type="hidden" id="frm_search_cus" name="frm_search_cus" value="">

        <div class="form-group" style="margin-right: 20px">
            <label>Từ ngày: </label>
              <input  type="text" id="from_date" class="form-control" value="<?php echo date("d/m/Y"); ?>">
        </div>

        <div class="form-group" style="margin-right: 20px">
            <label>Đến ngày: </label>
              <input  type="text" id="to_date" class="form-control" value="<?php echo date("d/m/Y"); ?>">
        </div>

        <div class="form-group" style="margin-right: 20px;">
            <label>Labo: </label>
            <?php 
                $listdata     = array();
                $labo         = ListLabo::model()->findAll();
                foreach($labo as $temp){
                    $listdata[$temp['id']] =  $temp['name'];
                }
                //echo CHtml::dropDownList('frm_search_labo','',$listdata,array('class'=>'form-control')); 
            ?>
            <select id="frm_search_labo" multiple="multiple" searchable="Search here..">
                <?php foreach ($listdata as $key => $value): ?>
                    <option value="<?php echo $key?>"><?php echo $value?></option>
                <?php endforeach ?>
            </select>
        </div>    

    </div>
    
    <div id="oSrchLeft" class="pull-right" style="text-align: right;">
        <!-- Split button -->
        <div class="btn-group">
          <button type="button" class="btn btn_bookoke" onclick="search_labo()"><i class="fa fa-search-plus"></i>&nbsp;Xem</button>
          <button type="button" class="btn btn_bookoke dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu menu-export">
            <li><a href="#" class="print"><i class="fa fa-print"></i>&nbsp;In</a></li>
            <li><a href="#" class="excel"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</a></li>
            <li><a href="#" class="word"><i class="fa fa-file-word-o"></i>&nbsp;Word</a></li>
            <li><a href="#" class="csv"><i class="fa fa-file-o"></i>&nbsp;CSV</a></li>
          </ul>
        </div>
    </div>

    <div class="clearfix"></div>    

</form>

<div id="searchCustomerModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable" style="background-color: #fff">
        <div class="modal-body">
            <input type="text" id="txtSearchCustomer" placeholder="nhập tên khách hàng">
            <p id="searchProcess">Kết quả...</p>
            <div id="searchCustomerResult"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
$(function () {
    $('#from_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });
    $('#to_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });
}); 

$('#frm_search_user').multiselect({
    includeSelectAllOption: true,
    selectAllNumber: false,
    enableFiltering: true,
    enableCaseInsensitiveFiltering:true,
});

$('#frm_search_labo').multiselect({
    includeSelectAllOption: true,
    selectAllNumber: false,
    enableFiltering: true,
    enableCaseInsensitiveFiltering:true,
});

function search_labo() {
    var search_user = $("#frm_search_user").val();
    var fromtime = $('#from_date').val();
    var totime = $('#to_date').val();
    var labo = $('#frm_search_labo').val();
    var search_cus = $('#frm_search_cus').val();

    if (search_user == null) {
        search_user = '';
    } else {
        search_user = search_user.toString();
    }

    if (labo == null) {
        labo = '';
    } else {
        labo = labo.toString();
    }

    $('.cal-loading').fadeIn('fast');

    jQuery.ajax({
        type: "POST",
        url: "<?php echo CController::createUrl('reportingLabo/typeReport') ?>",
        data: {
            'search_user': search_user,
            'fromtime': fromtime,
            'totime': totime,
            'search_cus': search_cus,
            'labo': labo,
            'search_cus': search_cus
        },
        success: function(data) {
            $('.cal-loading').fadeOut('fast');

            if (data == '-1') {
                alert('Data not found');
            } else if (data != '') {
                $("#return_content").fadeIn("slow");
                $("#return_content").html(data);
            } else {
                alert('Data not found', 'Notice');
            }
        }
    });
}

var baseUrl = $('#baseUrl').val();
var is_ajax = false; // Biến dùng kiểm tra nếu đang gửi ajax thì ko thực hiện gửi thêm
var is_busy = false; // Biến dùng kiểm tra nếu đang gửi ajax thì ko thực hiện gửi thêm
var page = 1; // Biến lưu trữ trang hiện tại
var stopped = false; // Biến lưu trữ rạng thái phân trang

var search_page = 1;
var search_stop = false;

$('#txtSearchCustomer').keyup(delay(function(e){
    search_stop = false;
    search_page = 1;
    if ($(this).val() != '') {
        $.ajax({
            type: 'POST',
            url: baseUrl + '/itemsCustomers/Accounts/getCustomerList',
            data: {
                "q": $(this).val(),
                "page": 1,
            },
            success: function(resp) {
                var result = JSON.parse(resp);
                if (result.length > 0) {
                    var result_html = "<ul class='table table-condensed'>";
                    for (var i = 0; i < result.length; i++) {
                        result_html += '<li class="row"><a href="#" onclick="setSearchCustomer('+result[i]['id']+',\''+result[i]['text']+'\')"><div class="col-md-3">' + result[i]['text'] + '</div>';
                        result_html += '<div class="col-md-2">' + result[i]['birthdate'] + '</div>';
                        result_html += '<div class="col-md-2">' + result[i]['phone'] + '</div>';
                        result_html += '<div class="col-md-5">' + result[i]['address'] + '</div>' + '</a></li>';
                    }
                    result_html += '</ul>';    
                } else {
                    var result_html = 'Không có dữ liệu';
                }
                $('#searchCustomerResult').html(result_html);
            }
        })
        .always(function() {
            $('#searchProcess').addClass('hidden');
            is_busy = false;
        });
    }
}, 2000));

$(document).ready(function() {
    $('#searchCustomerResult').on("scroll", function() {
        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            if (search_stop == true) {
                return false;
            }
            if ($('#txtSearchCustomer').val() != '') {
                search_page++;
                $.ajax({
                    type: 'POST',
                    url: baseUrl + '/itemsCustomers/Accounts/getCustomerList',
                    data: {
                        "q": $('#txtSearchCustomer').val(),
                        "page": search_page
                    },
                    success: function(resp) {
                        var result = JSON.parse(resp);
                        if (result.length > 0) {
                            var result_html = "";
                            for (var i = 0; i < result.length; i++) {
                                result_html += '<li class="row"><a href="#" onclick="setSearchCustomer('+result[i]['id']+','+result[i]['text']+')"><div class="col-md-3">' + result[i]['text'] + '</div>';
                                result_html += '<div class="col-md-2">' + result[i]['birthdate'] + '</div>';
                                result_html += '<div class="col-md-2">' + result[i]['phone'] + '</div>';
                                result_html += '<div class="col-md-5">' + result[i]['address'] + '</div>' + '</a></li>';
                            }   
                            $('#searchCustomerResult ul').append(result_html);
                        }
                        if (result.length < 20) {
                            search_stop = true;
                        }
                    }
                })
                .always(function() {
                    $('#searchProcess').addClass('hidden');
                    is_busy = false;
                });
            }
        }
    });

    $('#searchCustomerModal').on('hidden.bs.modal', function () {
        $('#txtSearchCustomer').val('');
        $('#searchCustomerResult').html('');
        search_page = 1;
        search_stop = false;
    });
});

function delay(callback, ms) {
    var timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}

function setSearchCustomer(id, name) {
    $('#frm_search_cus').val(id);
    $('#frm_search_customer').val(name);
    $('#searchCustomerModal').modal('hide');
}

$('#oSrchBar').on('click','.print',function(e){
    var search_user = $("#frm_search_user").val();
    var fromtime = $('#from_date').val();
    var totime = $('#to_date').val();
    var labo = $('#frm_search_labo').val();
    var search_cus = $('#frm_search_cus').val();

    if (search_user == null) {
        search_user = '';
    } else {
        search_user = search_user.toString();
    }

    if (labo == null) {
        labo = '';
    } else {
        labo = labo.toString();
    }
    var url="<?php echo CController::createUrl('ReportingLabo/printListLabo')?>?search_user="+search_user+"&search_cus="+search_cus+"&fromtime="+fromtime+"&totime="+totime+"&labo="+labo+"&search_cus="+search_cus;

    window.open(url,'name');

});
$('.excel').click(function() {
    $('#list_export').table2excel({
        name: "file",
        filename: "DanhSachLabo",
        fileext: ".xls"
    });
});

$('.word').click(function() {
    $('#list_export').table2excel({
        name: "file",
        filename: "DanhSachLabo",
        fileext: ".doc"
    });
});

$(function() {
    $(".csv").click(function() {
        $("#list_export").tableToCSV();
    });
});
</script>
