<form class="form-inline">
    <div id="oSrchRight" class="pull-left">           

        <div class="form-group" style="margin-right:20px;">
            <label>Từ ngày: </label>
              <input  type="text" id="from_date" onChange="search_invoice()" class="form-control">
        </div>

        <div class="form-group" style="margin-right:20px;">
            <label>Đến ngày: </label>
              <input  type="text" id="to_date" onChange="search_invoice()" class="form-control">
        </div>

        <div class="form-group" style="margin-right:20px;">
            <label>Nhóm: </label>
            <?php 

            $list_segment   = array();

            foreach(PriceBook::model()->findAll() as $value){
                $list_segment[$value['id']] =  $value['name'];
            }

            echo CHtml::dropDownList('id_segment','',$list_segment,array('onChange'=>"search_invoice()",'class'=>'form-control','empty' => 'Tất cả')); 

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

$(document).ready(function(){

    //search_invoice();
});

function search_invoice()
{
    
    var from_date  = $("#from_date").val();
    var to_date    = $("#to_date").val();
    var id_segment = $("#id_segment option:selected").text();

    if (id_segment == "Tất cả") {
        id_segment = "";
    }
    
    jQuery.ajax({   
        type:"POST",
        url:"<?php echo CController::createUrl('ReportingInvoice/TypeReport')?>",
        data:{
          
            'from_date' :from_date,
            'to_date' : to_date, 
            'id_segment' : id_segment,         
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

        var from_date      = $("#from_date").val();
        var to_date        = $('#to_date').val();     
        var id_segment     = $("#id_segment").val(); 

        var url="<?php echo CController::createUrl('ReportingInvoice/Export')?>?from_date="+from_date+"&to_date="+to_date+"&id_segment="+id_segment;
        window.open(url,'name');
       
    });

});

</script>