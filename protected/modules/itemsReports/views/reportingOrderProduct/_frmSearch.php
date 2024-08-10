<form class="form-inline">
    <div id="oSrchRight" class="pull-left">
        <div class="form-group" style="margin-right:20px;">
            <label>Văn phòng: </label>
              <?php 
                $listdata     = array();
                $listdata[""] = "Tất cả";
                $branch         = Branch::model()->findAll();
                foreach($branch as $temp){
                    $listdata[$temp['id']] =  $temp['name'];
                }
                echo CHtml::dropDownList('search_branch','',$listdata,array('class'=>'form-control')); 
            ?>
        </div>        
        <div class="form-group" style="margin-right:20px;">
            <label>Sản phẩm: </label>
              <?php 
                $listdata     = array();
                $listdata[""] = "Tất cả";
                $branch         = Product::model()->findAll();
                foreach($branch as $temp){
                    $listdata[$temp['id']] =  $temp['name'];
                }
                echo CHtml::dropDownList('search_product','',$listdata,array('class'=>'form-control input_product')); 
            ?>
        </div>   
        <div class="form-group" style="margin-right:20px;">
                <label>Thời gian: </label>
               <?php 
                    
                    $listdata        = array();
                    $listdata['5']   = "Chọn thời gian";
                    $listdata['1']   = "Hôm nay";
                    $listdata['2']   = "Tuần này";
                    $listdata['3']   = "Tháng này";
                    $listdata['4']   = "Tháng trước";
                    echo CHtml::dropDownList('search_time',3,$listdata,array('class'=>'form-control '));
                    
                ?>
        </div>
        <div class="form-group" style="margin-right:20px;">
                <label>Trạng thái: </label>
               <?php 
                    
                    $listdata        = array();
                    $listdata[""]    = "Tất cả";
                    $listdata['1']   = "Mới";
                    $listdata['2']   = "Đang chờ";
                    $listdata['3']   = "Thành công";
                    $listdata['4']   = "Hủy";
                    echo CHtml::dropDownList('search_status','',$listdata,array('class'=>'form-control'));
                    
                ?>
        </div>
        <div id="time" class="hidden">
            <div class="form-group" style="margin-right:20px;margin-top: 20px;">
                <label>Từ ngày: </label> 
                <input  type="text" id="fromtime" class="form-control" value="<?php echo date("Y-m-01", strtotime("first day of this month"));?>">
            </div>
            <div class="form-group" style="margin-right:20px;margin-top: 20px;">
                <label>Đến ngày: </label>
                <input  type="text" id="totime" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                 
            </div>
        </div>
    </div>
    
    <div id="oSrchLeft" class="pull-right" style="text-align: right;">
        <!-- Split button -->
        <div class="btn-group">
          <button type="button" class="btn btn_bookoke" onclick="search_data()"><i class="fa fa-search-plus"></i>&nbsp;Xem</button>
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
    
  $('#search_time').click(function () {
        if ($(this).val() == 5) {
          
            $('#time').removeClass('hidden');
        }else{
              $('#time').addClass('hidden');
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

     $('#time').change(function(e){
        fromtime = $('#fromtime').datepicker( "getDate");
        totime   = $('#totime').datepicker( "getDate");
        if(fromtime > totime)
            $('#totime').datepicker( "setDate", fromtime);
    })

    function search_data(){
        var search_branch   = $("#search_branch").val();
        var search_product  = $("#search_product").val();
        var search_time     = $("#search_time").val();
        var fromtime        = $("#fromtime").val();
        var totime          = $('#totime').val();
        var search_status    = $("#search_status").val();
        $('.cal-loading').fadeIn('fast');
        jQuery.ajax({   
            type:"POST",
            url:"<?php echo CController::createUrl('reportingOrderProduct/typeReport')?>",
            data:{
                'search_branch'         :  search_branch,
                'search_product'        :  search_product,
                'search_time'           :  search_time,
                'fromtime'              :  fromtime,
                'totime'                :  totime,
                'search_status'         :  search_status
            },
            beforeSend: function() {
               
            },
            success:function(data){
                if(data == '-1'){
                    alert('Data not found');
                }else if(data != ''){
                    $('.cal-loading').fadeOut('fast');
                    jQuery("#return_content").fadeIn("slow");
                    jQuery("#return_content").html(data);
                }else{
                    jAlert('Data not found','Notice');
                }
                jQuery("#idwaiting_search").html('');
            }
        });                
    }
    $(document).ready(function(){
        //search_data();
    })

    $( document ).ready(function() {

        $('#oSrchBar').on('click','.pdf',function(e){  
            var search_branch   = $("#search_branch").val();
            var search_product  = $("#search_product").val();
            var search_time     = $("#search_time").val();
            var search_status    = $("#search_status").val();
            if(search_time==5){
                var fromtime      = $("#fromtime").val();
                var totime        = $('#totime').val();
            }
            else{
                var fromtime      ='';
                var totime        ='';
            }
            var url="<?php echo CController::createUrl('reportingOrderProduct/exportPDF')?>?branch="+search_branch+"&product="+search_product+"&search_time="+search_time+"&fromtime="+fromtime+"&totime="+totime+"&status="+search_status;
            window.open(url,'name');
           
        });

        $('#oSrchBar').on('click','.print',function(e){  
            var search_branch   = $("#search_branch").val();
            var search_product  = $("#search_product").val();
            var search_time     = $("#search_time").val();
            var search_status    = $("#search_status").val();
            if(search_time==5){
                var fromtime      = $("#fromtime").val();
                var totime        = $('#totime').val();
            }
            else{
                var fromtime      ='';
                var totime        ='';
            }
            var url="<?php echo CController::createUrl('reportingOrderProduct/exportPrint')?>?branch="+search_branch+"&product="+search_product+"&search_time="+search_time+"&fromtime="+fromtime+"&totime="+totime+"&status="+search_status;
            window.open(url,'name');
           
        });

    });
</script>