<form class="form-inline">
    <div id="oSrchRight" class="pull-left">           

        <div class="form-group" style="margin-right:20px;">
            <label>Từ ngày: </label>
            <input type="text" id="from_date" onChange="search_receipt()" class="form-control">
        </div>

        <div class="form-group" style="margin-right:20px;">
            <label>Đến ngày: </label>
            <input type="text" id="to_date" onChange="search_receipt()" class="form-control">
        </div>

        <div class="form-group" style="margin-right:20px;">
            <label>Loại tiền: </label>

            <?php 
                $list_pay_type = array();
                $list_pay_type[1] = "Tiền mặt";
                $list_pay_type[2] = "Thẻ tín dụng";
                $list_pay_type[3] = "Chuyển khoản";            

                echo CHtml::dropDownList('pay_type', '', $list_pay_type, 
                    array('onChange' => "changePayType(this)", 'class' => 'form-control', 'empty' => 'Tất cả')
                );
            ?> 
        </div>

        <div id="insurrance_type" class="form-group hide" style="margin-right:20px;">
            <label>Hình thức: </label>
            <?php
                $listInsurranceType = array();  
                $listInsurranceType[0] = "Người dùng";
                foreach(InsurranceType::model()->findAll() as $value){
                    $listInsurranceType[$value['name']] = $value['name'];
                }
             
                echo CHtml::dropDownList('trans_name', '', $listInsurranceType,
                    array('onChange'=>"search_receipt()",'class'=>'form-control')
                );
            ?>            
        </div>

        <div class="form-group" style="margin-right:20px;">
            <label>Đối tác: </label>

            <?php 
                echo CHtml::dropDownList('partner', '', CHtml::listData($partner, 'id', 'name'), 
                    array('onChange' => "search_receipt()", 'class' => 'form-control', 'empty' => 'Tất cả')
                );
            ?> 
        </div>

    </div>
    
    <div id="oSrchLeft" class="pull-right" style="text-align: right;">
        <!-- Split button -->
        <div class="btn-group">
            <button type="button" class="btn btn_bookoke" onclick="search_cus()"><i class="fa fa-search-plus"></i>&nbsp;Xem</button>
            <button type="button" class="btn btn_bookoke dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>

            <ul class="dropdown-menu menu-export">
                <li><a href="#" class="print"><i class="fa fa-print"></i>&nbsp;In</a></li>
                <li><a href="#" class="excel"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</a></li>
                <li><a href="#" class="word"><i class="fa fa-file-word-o"></i>&nbsp;Word</a></li>
                <li><a href="#" class="pdf"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</a></li>
                <li><a href="#" class="csv"><i class="fa fa-file-o"></i>&nbsp;CSV</a></li>
            </ul>
        </div>
    </div>

    <div class="clearfix"></div>    

</form>

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

function changePayType(sel) {
    var value = sel.value; 

    if (value == 3) {
        $('#insurrance_type').removeClass('hide');
    } else {
        $('#insurrance_type').addClass('hide');
    }
    search_receipt();  
}

$(document).ready(function(){
    //search_receipt();
});

function search_receipt() { 
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
    var pay_type = $("#pay_type").val();
    var trans_name = $("#trans_name").val();
    var partner = $('#partner').val();

    jQuery.ajax({   
        type : "POST",
        url : "<?php echo CController::createUrl('ReportingCashFlow/TypeReport')?>",
        data : {
            'from_date' :from_date,
            'to_date'   : to_date, 
            'pay_type'  : pay_type,  
            'trans_name'  : trans_name,
            'partner' : partner    
        },
        beforeSend: function() {
            
        },
        success:function(data) {
            jQuery("#return_content").fadeIn("slow");
            jQuery("#return_content").html(data);           
            jQuery("#idwaiting_search").html('');
        }
    });                
}

$( document ).ready(function() {

    $('#oSrchBar').on('click','.print',function(e) {
        var from_date      = $("#from_date").val();
        var to_date        = $('#to_date').val();     
        var pay_type       = $("#pay_type").val(); 
        var trans_name   = $("#trans_name").val();

        var url="<?php echo CController::createUrl('ReportingCashFlow/Export')?>?from_date="+from_date+"&to_date="+to_date+"&pay_type="+pay_type+"&trans_name="+trans_name;
        window.open(url,'name');   
    });
});

</script>