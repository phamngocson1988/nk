<style>

.lable_phone_new{
    position: absolute;
    top: 7px;
    right: 10px;
    background: #3498db;
    color: #fff;
    padding: 1px 8px;
    text-transform:uppercase;
    border: 1px solid #3498db;
    box-sizing:border-box;
    border-radius: 10px;
    font-size: 9px;
    text-shadow: 0px 1px 1px #c2c8cd;
    border: 1px solid #3498db;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -o-box-sizing: border-box;
}
.lable_phone_invalid{
    position: absolute;
    top: 7px;
    right: 10px;
    background: red;
    color: #fff;
    padding: 1px 8px;
    text-transform:uppercase;
    border: 1px solid red;
    box-sizing:border-box;
    border-radius: 10px;
    font-size: 9px;
    text-shadow: 0px 1px 1px #c2c8cd;
    border: 1px solid red;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -o-box-sizing: border-box;
}
.key_search{ 
    color: #0072f4;
}
.input-icon-prepend .dropdown-menu{
    width: 300px;
}

.input-icon-prepend .dropdown-menu a{
    padding:5px;
}
.dropdown-menu>li{
    border-top: 1px solid #ccd6dd;
}
.dropdown-menu>li:first-child{
    border-top:none;
}
.dropdown-menu>li a:hover .typeahead_wrapper .typeahead_primary { color: #fff !important;}
.dropdown-menu .active{
    color: #fff !important;
}
.dropdown-menu>li a:hover .typeahead_wrapper .typeahead_secondary { color: #fff !important;}
.typeahead_wrapper                             { display: block;width: 100%;margin: 0px auto;}
.typeahead_wrapper .typeahead_labels           { float: left; line-height: 19px; }
.typeahead_wrapper .typeahead_labels::after    { clear:both; }
.typeahead_wrapper .typeahead_primary          { font-size: 15px;  }
.typeahead_wrapper .typeahead_secondary        { font-size: 11px; color: #666;  }
.typeahead_wrapper .typeahead_userinfo         { float: right; line-height: 17px;}
.typeahead_wrapper .typeahead_userinfo::after  { clear: both; } 
.typeahead_wrapper .typeahead_userinfo .lable_accounts{ display: inline-block;font-size: 11px; color: #8899a6;width: 60px; text-align: right;}
.typeahead_wrapper .typeahead_userinfo .users_name{ display: inline-block;font-size: 12px;margin-left: 5px; width: 85px; }
.typeahead_wrapper .typeahead_userinfo .status{ display: inline-block;font-size: 12px;margin-left: 5px; width: 85px; }
</style>
<form class="form-inline">
    <div id="oSrchRight" class="pull-left">
        <div class="form-group" style="margin-right:25px;">
            <button id="sumarizeTreatment" class="btn btn-info">Thống kê</button>
        </div>
        <div class="form-group" style="margin-right:25px;">
            <label class="col-xs-3">Từ ngày: </label>
            <div class="col-xs-9" style="padding: 0">
                <input type="text" id="fromtime" class="form-control" value="" autocomplete="off">
            </div>
        </div>

        <div class="form-group" style="margin-right:25px;">
            <label class="col-xs-3">Đến ngày: </label>
            <div class="col-xs-9" style="padding: 0">
                <input type="text" id="totime" class="form-control" value=""  autocomplete="off">
            </div>
        </div>

        <div class="form-group" style="margin-right:25px;">
            <label class="col-xs-3">Chọn ngày: </label>
            <div class="col-xs-9" style="padding: 0">
                <input type="text" id="createTime" class="form-control" value=""  autocomplete="off">
            </div>
        </div>
        <div class="form-group" style="margin-right:25px;">
            <button id="saveTreatment" class="btn btn-info">Tạo mới</button>
        </div>
        <div class="form-group" style="margin-right:25px;">
            <button id="updateScheduleTime" class="btn btn-info">Cập nhật lịch hẹn</button>
        </div>

    </div>

    <div id="oSrchLeft" class="pull-right" style="text-align: right;">
        <!-- Split button -->
        <div class="btn-group">
          <button type="button" class="btn btn-info" onclick="search_treatment()"><i class="fa fa-search-plus"></i>&nbsp;Xem</button>
          <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu menu-export">
            <li><a href="#" class="btn_excel"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</a></li>
            <li><a href="#" class="btn_word"><i class="fa fa-file-word-o"></i>&nbsp;Word</a></li>
            <li><a href="#" class="btn_pdf"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</a></li>
            <li><a href="#" class="btn_csv"><i class="fa fa-file-o"></i>&nbsp;CSV</a></li>
          </ul>
        </div>
    </div>

    <div class="clearfix"></div>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

        $('.datepicker').val(moment().format('YYYY-MM-DD'));

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

        $('#createTime').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

        $('#sumarizeTreatment').on('click', function(){
            if ($(this).hasClass('opened')) {
                $(this).removeClass('opened');
                $(this).text('Thống kê');
                jQuery("#sumarize_wrapper").html('');
            } else {
                jQuery.ajax({   
                    type:"POST",
                    url:"<?php echo CController::createUrl('reportingTreatmentAfter/sumarize')?>",
                    data:{
                        start_time: $('#fromtime').val(),
                        end_time: $('#totime').val()
                    },
                    beforeSend: function() {
                        jQuery("#idwaiting_search").html('<img src="<?php echo Yii::app()->params['image_url']; ?>/images/vtbusy.gif" alt="waiting....." />'); 
                    },
                    success:function(data){
                        if(data == '-1'){
                            alert('Error');
                        }else if(data != ''){
                            jQuery("#sumarize_wrapper").fadeIn("slow");
                            jQuery("#sumarize_wrapper").html(data);
                            $('#sumarizeTreatment').addClass('opened');
                            $('#sumarizeTreatment').text('Ẩn thống kê');
                        }else{
                            jAlert('Error','Notice');
                        }
                        jQuery("#idwaiting_search").html('');
                    }
                });   
            }
            return false;
        });

        $('#updateScheduleTime').on('click', function(){
            jQuery.ajax({   type:"POST",
                url:"<?php echo CController::createUrl('reportingTreatmentAfter/updateScheduleTime')?>",
                data:{
                    start_time: $('#fromtime').val(),
                    end_time: $('#totime').val()
                },
                beforeSend: function() {
                    jQuery("#idwaiting_search").html('<img src="<?php echo Yii::app()->params['image_url']; ?>/images/vtbusy.gif" alt="waiting....." />'); 
                },
                success:function(data){
                    if(data == '-1'){
                        alert('Error');
                    }else if(data != ''){
                        alert('Success');
                        jQuery("#return_content").fadeIn("slow");
                        search_treatment();
                    }else{
                        jAlert('Error','Notice');
                    }
                    jQuery("#idwaiting_search").html('');
                }
            });   
            return false; 
        });

        $('#saveTreatment').on('click', function() {
            // check exist data
            jQuery.ajax({   type:"POST",
                url:"<?php echo CController::createUrl('reportingTreatmentAfter/checkExistData')?>",
                data:{
                    create_date: $('#createTime').val()
                },
                beforeSend: function() {
                    jQuery("#idwaiting_search").html('<img src="<?php echo Yii::app()->params['image_url']; ?>/images/vtbusy.gif" alt="waiting....." />'); 
                },
                success:function(data){
                    if(data == '-1'){
                        alert('Vui lòng chọn ngày');
                    }else if(data == '0'){
                        jQuery("#return_content").fadeIn("slow");
                        $('#fromtime').val($('#createTime').val());
                        $('#totime').val($('#createTime').val());
                        //save new data
                        jQuery.ajax({   type:"POST",
                            url:"<?php echo CController::createUrl('reportingTreatmentAfter/saveTreatment')?>",
                            data:{
                                create_date: $('#createTime').val()
                            },
                            beforeSend: function() {
                                jQuery("#idwaiting_search").html('<img src="<?php echo Yii::app()->params['image_url']; ?>/images/vtbusy.gif" alt="waiting....." />'); 
                            },
                            success:function(data){
                                if(data == '-1'){
                                    alert('Error');
                                }else if(data != ''){
                                    alert('Success');
                                    jQuery("#return_content").fadeIn("slow");
                                    $('#fromtime').val($('#createTime').val());
                                    $('#totime').val($('#createTime').val());
                                    search_treatment();
                                }else{
                                    jAlert('Error','Notice');
                                }
                                jQuery("#idwaiting_search").html('');
                            }
                        });
                    }else{
                        if (confirm('Dữ liệu đã được tạo.Bạn muốn load lại dữ liệu đã có?')) {
                            $('#fromtime').val($('#createTime').val());
                            $('#totime').val($('#createTime').val());
                            search_treatment();
                        }
                    }
                    jQuery("#idwaiting_search").html('');
                }
            });

            return false; 
        });
    });

    function search_treatment() {
        jQuery.ajax({   type:"POST",
            url:"<?php echo CController::createUrl('reportingTreatmentAfter/searchTreatment')?>",
            data:{
                start_time: $('#fromtime').val(),
                end_time: $('#totime').val()
            },
            beforeSend: function() {
                jQuery("#idwaiting_search").html('<img src="<?php echo Yii::app()->params['image_url']; ?>/images/vtbusy.gif" alt="waiting....." />'); 
            },
            success:function(data){
                if(data == '-1'){
                    alert('Data not found');
                }else if(data != ''){
                    jQuery("#return_content").fadeIn("slow");
                    jQuery("#return_content").html(data);
                    resizeWindows();
                }else{
                    jAlert('Data not found','Notice');
                }
                jQuery("#idwaiting_search").html('');
            }
        }); 
    }

    $('.btn_excel').click(function() {
        $('#list_export').table2excel({
            name: "file",
            filename: "KHSauDieuTri",
            fileext: ".xls"
        });
    });

    $('.btn_word').click(function() {
        $('#list_export').table2excel({
            name: "file",
            filename: "KHSauDieuTri",
            fileext: ".doc"
        });
    });
    $(".btn_csv").click(function() {
        $("#list_export").tableToCSV();
    });
</script>