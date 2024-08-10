<?php 
    $disable ="";
    $group_id =  Yii::app()->user->getState('group_id');
    if($group_id ==3){
        $disable ="disabled";
    }
    $user_id =  Yii::app()->user->getState('user_id');
?>
<form class="form-inline">
    <div id="oSrchRight" class="pull-left">
        <div class="form-group" style="margin-right:20px;" id='search_user'>
            <label>Bác sĩ: </label>
            <span id="lstStaff">
                <?php 
                $listdata     = array();
                $listdata[""] = "Tất cả";
                $User         = GpUsers::model()->findAllByAttributes(array('block'=>0,'group_id'=>3));
                foreach($User as $temp){
                    $listdata[$temp['id']] =  $temp['name'];
                }
                echo CHtml::dropDownList('frm_search_user_id',$user_id,$listdata,array('onChange'=>"search_cus()",'class'=>'form-control','disabled'=>$disable)); 
                ?>
            </span>
             
        </div>           

        <div class="form-group" style="margin-right:20px;">
            <label>Từ ngày: </label>
              <input  type="text" id="fromtime" onChange="search_cus()" class="form-control">
        </div>

        <div class="form-group" style="margin-right:20px;">
            <label>Đến ngày: </label>
              <input  type="text" id="totime" onChange="search_cus()" class="form-control">
        </div>

        <div class="form-group" style="margin-right:20px;">
            <label>Tình trạng: </label>
            <?php
                $listdebt = array();
                $listdebt[""] = "Tất cả";
                $listdebt[TransactionInvoice::ConNo] = "Nợ";
                $listdebt[TransactionInvoice::ThanhToan] = "Đã thanh toán";
                $listdebt[TransactionInvoice::PhongKhamChuyen] = "Phòng khám chuyển";
                echo CHtml::dropDownList('frm_search_debt','',$listdebt,array('onChange'=>'search_cus()','class'=>'form-control'));
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
    $('#fromtime').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });
    $('#totime').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });
}); 

$(document).ready(function(){

    //search_cus();
});

function search_cus()
{
    var lstUser    = $("#frm_search_user_id").val();
    var from_date  = $("#fromtime").val();
    var to_date    = $("#totime").val();
    var debt       = $("#frm_search_debt").val();
    
    jQuery.ajax({   
        type:"POST",
        url:"<?php echo CController::createUrl('ReportingTransaction/TypeReport')?>",
        data:{
            'lstUser':  lstUser,  
            'from_date' :from_date,
            'to_date' : to_date, 
            'debt' : debt,         
        },
        beforeSend: function() {
            
        },
        success:function(data){

    
            jQuery("#return_content").fadeIn("slow");
            jQuery("#return_content").html(data);           
            jQuery("#idwaiting_search").html('');

        }
    });                
}

$( document ).ready(function() {

    $('#oSrchBar').on('click','.print',function(e){    

        var lstUser       = $("#frm_search_user_id").val();
        var fromtime      = $("#fromtime").val();
        var totime        = $('#totime').val();     
        var debt          = $("#frm_search_debt").val();  

        var url="<?php echo CController::createUrl('ReportingTransaction/Export')?>?lstUser="+lstUser+"&fromtime="+fromtime+"&totime="+totime+"&debt="+debt;
        window.open(url,'name');
       
    });

});

</script>