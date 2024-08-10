<?php 
$cst = new CsServiceType;
$v = new CDbCriteria(); 
$v->addCondition('t.status = 1');
$v->order= 'id DESC';
$cst_all=$cst->findAll($v);
 $group_service_priority = array();
?>
<table id="stock" class="table" role="grid" aria-describedby="stock_info" style="border-collapse:collapse;">
    <thead>
        <tr role="row">
            <th tabindex="0" aria-controls="stock" rowspan="1" colspan="1"  aria-label="Name: activate to sort column ascending">
            Mã dịch vụ
            </th>
            <th tabindex="0" aria-controls="stock" rowspan="1" colspan="1" aria-label="SKU: activate to sort column ascending">
            Tên dịch vụ
            </th>
            <th tabindex="0" aria-controls="stock" rowspan="1" colspan="1" aria-label="Quantity: activate to sort column ascending">Thời gian thực hiện</th><th tabindex="0" aria-controls="stock" rowspan="1" colspan="1"  aria-label="Price: activate to sort column ascending">
            Giá bán
            </th>          
        </tr>
    </thead>
    <tbody id="bodyTblContent">
    <?php     
    if(!empty($cs))
    {          
        foreach ($cs as $k => $v) 
        {
    ?>
        <tr data-toggle="collapse" data-target="#demo<?php echo $k+1;?>" class="accordion-toggle" style="background-color: <?php if(($k+1) % 2 == 1){ echo "#fff";} else{ echo "#F2F2F2";}?>;">
            <td><?php echo $v['code'];?></td>
            <td><?php echo $v['name'];?></td>
            <td><?php echo $v['length'];?> phút</td>
            <td class="autoNum"><?php echo $v['price'];?></td>            
        </tr>
        <tr>
            <td colspan="4" class="hiddenRow" style="text-align: left;">
                <div class="accordian-body collapse oView col-md-12 <?php if(count($cs)==1) echo "in";?>" id="demo<?php echo $k+1;?>">
                    <?php         
                    $dts=$v;                  
                    ?>
                    <div class="oViewDetail col-md-12">
                        <div id="oInfo" class="col-md-12">
                            <form class="ud-service-form" id="" action="" onsubmit="return false;" method="post" novalidate="">    
                                <div class="rg-row">     
                                    <div class="col-md-12" style="margin-top:10px;">      
                                        <div class="rg-row">
                                            <div class="col-sm-6">
                                                <div class="form-group required" id="">
                                                    <span class="" for="code_service">Mã dịch vụ</span>
                                                    <input id="id_service" name="id_service" type="hidden" value="<?php echo $dts['id'];?>">
                                                    <input disabled class="form-control" id="" name="code_service" required="" type="text" value="<?php echo $dts['code'];?>" data-parsley-id="0931">                        
                                                    <span class="help-block validation-error" id=""></span>
                                                </div>
                                            </div>
                                           
                                                <div class="col-sm-6">
                                                    <div class="form-group required" id="">
                                                        <span class="" for="id_service_type">Nhóm dịch vụ</span>                          
                                                        <?php
                                                        $group_service = array();
                                                        //$group_service_priority = array();
                                                        foreach($cst_all as $temp){
                                                            $group_service[$temp['id']] = $temp['name'];
                                                            $group_service_priority[$temp['id']] = $temp['priority_pay'];
                                                        }                            
                                                        echo CHtml::dropDownList('id_service_type','',$group_service,array('disabled'=>'disabled','class'=>'form-control','required'=>'required','empty' => 'Chọn nhóm dịch vụ','options'=>array($dts['id_service_type']=>array('selected'=>true))));
                                                        ?>                 
                                                        <span class="help-block validation-error" id=""></span>
                                                    </div>
                                                </div>
                                        </div>

                                        <div class="rg-row">
                                          
                                            <div class="col-sm-6">                     
                                                <div class="form-group required" id="">
                                                    <span class="" for="name_service">Tên dịch vụ</span>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <div class="btn-group service-color-pallet-holder">
                                                                <a class="dropdown-toggle">
                                                                    <code id="" name="color_service" class="<?php echo $dts['color'];?>"></code>
                                                                    <span class="caret"></span>
                                                                </a>                                                       
                                                            </div>
                                                        </div>
                                                        <input disabled class="form-control" id="" name="name_service" required="" type="text" value="<?php echo $dts['name'];?>" data-parsley-id="0932">
                                                       
                                                    </div>
                                                <span class="help-block validation-error" id=""></span></div>
                                            </div>
                                               
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <span>Tên dịch vụ tiếng Anh</span>                                     
                                                    <input disabled class="form-control" type="text" value="<?php echo $dts['name_en'];?>">   
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <span class="" for="description_service">Mô tả</span>
                                            <span class="char-count-container">
                                                <textarea disabled class="char-count-1000 form-control" cols="20" id="description_service" name="description_service" rows="2"><?php echo $dts['description'];?></textarea>
                                            </span>
                                            <span class="help-block validation-error"></span>
                                        </div>
                               
                                        <div class="form-group" style="padding: 0px;">
                                            <div class="checkbox">
                                                <label>
                                                    <input disabled <?php if($dts['status_hiden']==1) echo "checked"; else echo "";?> type="checkbox" value="true" data-parsley-multiple="ServiceOnlineBookings">
                                                    <input name="Service.OnlineBooking" type="hidden" value="false"> Khách hàng có thể đăng kí dịch vụ trực tuyến
                                                </label>  
                                            </div>
                                            <span class="help-block validation-error"></span>

                                        </div>    
                                        <div class="clearfix"></div>
                                        <div class="rg-row">
                                            <div class="col-sm-3">
                                                <div class="form-group ">
                                                    <span class="" for="price_service">Giá dịch vụ</span><br>
                                                    <div class="inline-group">
                                                
                                                        <span class="price-display">
                                                            <div class="input-group">
                                                                
                                                                <input disabled value="<?php echo number_format($dts['price'],0,"","");?>" class="price-input form-control input-narrow autoNum" id="price_service" name="price_service" type="text">
                                                                <div class="input-group-addon"><?php if($dts['flag_price']==2){echo "USD";}else{echo "VND";}?></div>
                                                            </div>
                                                            
                                                        </span>
                                                    </div>
                                                    <span class="help-block validation-error"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3" style="padding-top:25px; padding-left: 20px;">
                                                <label>
                                                    <input id="flag_price" name="flag_price" type="checkbox" value="2" <?php if($dts['flag_price']==2){echo "checked";}?>>
                                                    Check USD
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <span>Thuế</span><br>
                                                    <div class="inline-group">
                                                    <div class="input-group">
                                                        
                                                        <input disabled class="tax-input form-control input-narrow" type="text" value="<?php echo $dts['tax'];?>">                             
                                                          <div class="input-group-addon">%</div> 
                                                    </div>
                                                    </div>
                                                <span class="help-block validation-error"></span></div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group required ">
                                                    <span class="" for="length_service">Thời gian thực hiện</span><br>
                                                    <div class="input-group-duration">
                                                        <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                                        <span class="ui-timepicker-container">
                                                        <input disabled class="duration-input form-control input-narrow ui-timepicker-input" id="length_service" name="length_service" pattern="^([0-1]?[0-9]|2[0-3]):([0-5][0-9])(:[0-5][0-9])?$" required="" type="number" value="<?php echo $dts['length'];?>" autocomplete="off">                    
                                                      
                                                        </span>
                                                    </div>
                                                    <span class="help-block validation-error"></span>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                               <div id="select-staff" class="rg-row" style="margin-bottom: 10px; margin-top:15px;">
                                                    <div class="col-md-12">                                        
                                                     <span class="">Nhân viên thực hiện</span><br>

                                                        <div class="rg-row staff-services">
                                                            <div class="col-md-12">
                                                                <select disabled id="example-enableCollapsibleOptGroups-enableClickableOptGroup" name="example-enableCollapsibleOptGroups-enableClickableOptGroup[]" class="example-enableCollapsibleOptGroups-enableClickableOptGroup" multiple="multiple">
                                                                    <optgroup label="Chọn tất cả">
                                                                        <?php                                                         
                                                                        $cs_service=new CsService;
                                                                        $staff_list=$cs_service->getListDentists();
                                                                        $csserviceusers=new CsServiceUsers;
                                                                        $selected=$csserviceusers->findAllByAttributes(array('id_service'=>$dts['id']));   
                                                                        foreach ($staff_list as $s_l) 
                                                                        {
                                                                        ?>
                                                                        <option value="<?php echo $s_l['id'];?>" <?php foreach ($selected as $s) {if ($s_l['id']==$s['id_dentist']) { echo "selected";break;}}?>><?php echo $s_l['name'];?></option>
                                                                        <?php 
                                                                        }
                                                                        ?>
                                                                    </optgroup>                                          
                                                                </select>  
                                                            </div>
                                                               
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="rg-row">
                                    <div class="col-md-12">
                            
                                        <div class="rg-row">
                                            <div class="col-sm-6">
                                                <div class="form-group  margin-bottom-05em">

                                                    <span for="point_buy_service" style="padding:0px;">Điểm được tặng khi mua dịch vụ</span>
                                                    <span style="width: 45px;margin-left: 15px;display: inline-block;">
                                                        <input disabled class="form-control" id="point_buy_service" name="point_buy_service" required="" onkeypress=" return isNumberKey(event)" type="text" value="<?php echo $dts['point_donate'];?>">
                                                    </span>
                                                <span class="help-block validation-error"></span></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group margin-bottom-05em">
                                                    <span for="point_change_service" style="padding:0px;">Điểm cần có để quy đổi dịch vụ</span>
                                                    <span style="width: 45px;margin-left: 15px; display: inline-block;"> 
                                                        <input disabled class="form-control" id="point_change_service" name="point_change_service" required="" onkeypress=" return isNumberKey(event)" type="text" value="<?php echo $dts['point_exchange'];?>">
                                                    </span>
                                                <span class="help-block validation-error"></span></div>
                                            </div>
                                              <!-- stt show-->
                                            <div class="col-sm-6">
                                                <div class="form-group margin-bottom-05em">
                                                    <span for="" style="padding:0px;">Số thứ tự hiển thị: </span>
                                                    <span style="width: 45px;margin-left: 15px; display: inline-block;"> 
                                                        <input class="form-control" disabled id="stt_show" name="stt_show" required="" onkeypress=" return isNumberKey(event)" type="text" value="<?php echo $dts['stt_show'];?>" ">
                                                    </span>
                                                <span class="help-block validation-error"></span></div>
                                            </div>
                                            <!-- stt show-->

                                            <div class="col-sm-6">
                                                <div class="form-group margin-bottom-05em">
                                                    <span for="" style="padding:0px;">Ưu tiên thanh toán: </span>
                                                    <span style="width: 45px;margin-left: 15px; display: inline-block;"> 
                                                        <input class="form-control" disabled id="stt_show" name="stt_show" required="" onkeypress=" return isNumberKey(event)" type="text" value="<?php echo $dts['priority_pay'];?>" ">
                                                    </span>
                                                <span class="help-block validation-error"></span></div>
                                            </div>
                                           
                                        </div>

                                    </div>

                                </div>

                            </form>
                        </div>
                        <div class="col-md-12">
                            <div id="pBtn">
                                <div id="pBtnL">
                                <button type="" id="" onclick="showEditService(<?php echo $dts['id'];?>);" class="btn btn-success btn-fw">Chỉnh sửa</button>
                                <span class="pull-right"><button type="button" class="btn btn-danger" onclick="deleteService(<?php echo $dts['id'];?>);">Xóa</button></span>
                                </div>
                            </div>
                        </div>
                    </div>   

                    <?php include("popup_edit_service.php");?>
                </div> 
            </td>
        </tr>
    <?php 
        }  
    }
    else
    {                                      
    ?>  
    <tr role="row" class="odd">
        <td colspan="4" align="center">Không có dữ liệu!</td>
    </tr>             
    <?php 
    }
    ?>            
    </tbody>
</table>
<br>
<div style="clear:both"></div>
<div align="center">
    <?php echo $lst;?>          
</div>



<script>   
var priority_service_type = JSON.parse('<?php echo json_encode($group_service_priority); ?>');
function getColor(color,id){    
    $('#color_service-'+id).removeClass(function() {return $('#color_service-'+id).attr( "class" );});
    $('#color_service-'+id).addClass(color); 
}
function error_update_service(id){

    var status = true;

    if($('#code_service_'+id).val() == ''){
        status = false;       
        $('#ud-service-code-'+id).addClass('error');
        $("#parsley-id-0931-"+id).addClass('filled').html('<span class="parsley-required">Vui lòng nhập mã dịch vụ.</span>');       
    }
    else{
        $('#ud-service-code-'+id).removeClass('error');
    }

    if($('#name_service_'+id).val() == ''){
        status = false;       
        $('#ud-service-name-'+id).addClass('error');
        $("#parsley-id-0932-"+id).addClass('filled').html('<span class="parsley-required">Vui lòng nhập tên dịch vụ.</span>');       
    }
    else{
        $('#ud-service-name-'+id).removeClass('error');
    }

    if($('#id_service_type_'+id).val() == ''){
        status = false;       
        $('#ud-service-group-'+id).addClass('error');
        $("#parsley-id-0933-"+id).addClass('filled').html('<span class="parsley-required">Vui lòng chọn nhóm dịch vụ.</span>');       
    }
    else{
        $('#ud-service-group-'+id).removeClass('error');
    }

    return status;
}

function showEditService(id){

    var elem = $('#edit-service-blur-'+id)[0];

    $(elem).fadeToggle(200,function(){
    });

    $(document).mouseup(function (e)
    {   

        var container = $(".edit-service-container");
        if(templock == 0){
            if (!container.is(e.target) && container.has(e.target).length === 0){        
               if($(elem).is(':visible')){
                    templock = 1;
                    $(elem).fadeToggle(200,function(){
                        templock = 0;
                    });
                }        
            } 
        }
    
    });

    $('.cancel').on('click',function(e){
        if(templock == 0){                   
                if($(elem).is(':visible')){
                    templock = 1;   
                    $(elem).fadeToggle(200,function(){
                        templock = 0;
                    }); 
                }                    
        }
    });

    $( document ).on( 'keydown', function ( e ) {
        if(templock == 0){
            if($(elem).is(':visible')){
                if ( e.keyCode === 27 ) {
                    templock = 1;
                    $(elem).fadeToggle(200,function(){
                        templock = 0;
                    });
                }
            }
        }
    });
   
}

function updateService(id){
    if(error_update_service(id)){    
        $('.cal-loading').fadeIn('fast');     
        var formData = new FormData($('#ud-service-form-'+id)[0]); 
        formData.append('color_service',$('#color_service-'+id).attr( "class" ));
        if (!formData.checkValidity || formData.checkValidity()) {
        jQuery.ajax({
            type:'POST',
            url: baseUrl+'/itemsProducts/ProductService/updateService',
            data:formData,
            datatype:'json',
            success:function(data){
            // console.log(data);
            // return;               
                if (data == '-1') {                         
                    $('#ud-service-code-'+id).addClass('error');
                    $("#parsley-id-0931-"+id).addClass('filled').html('<span class="parsley-required">Mã dịch vụ đã tồn tại.</span>'); 
                    $('.cal-loading').fadeOut('slow');
                    return false;
                }
                else
                {
                    $('#ud-service-code-'+id).removeClass('error');

                    //$("#searchService").val(data);   
                    var elem = $('#edit-service-blur-'+id)[0];
                    if(templock == 0){                   
                        if($(elem).is(':visible')){
                            templock = 1;   
                            $(elem).fadeToggle(200,function(){
                                templock = 0;
                            }); 
                        }                    
                    }
                    $('#glyphicon-search').click();
                    
                    $('.cal-loading').fadeOut('slow');
                } 
            },
            error: function(data){
                console.log("error");
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        }
    }
}

function deleteService(id){
    if (confirm("Bạn có thật sự muốn xóa?")) {     
        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type:'POST',
            url: baseUrl+'/itemsProducts/ProductService/deleteService',    
            data: {"id":id},   
            success:function(data){
                if(data == '1')
                {
                    $('.cal-loading').fadeOut('slow'); 
                    window.location.assign("<?php echo CController::createUrl('ProductService/View')?>"); 
                }                 
            },
            error: function(data){
            console.log("error");
            console.log(data);
            }
        });
    }      
}

function onChangeUpdateGroupService(id) {
    idSVT = $('#id_service_type_'+id).val();
    $('#priority_pay_'+id).val(priority_service_type[idSVT]);
}

function checkClick(){     
    $( ".accordion-toggle" ).each(function( index ) {        
        if ($(this).attr("aria-expanded")=="true") {            
            $(this).addClass("at");
        }
    });
}
$('.accordion-toggle').click(function(){

    $( ".accordion-toggle" ).each(function( index ) {        
        $(this).removeClass("at");
    });

    var st =  $(this).attr("aria-expanded");   

    if(st == 'false' || st == undefined){        
        $(this).addClass("at");
    }else if(st == 'true'){

        $(this).removeClass("at");
    }
});

$('.collapse').on('show.bs.collapse', function () {    
    $('.collapse.in').collapse('hide');   
});
$(document).ready(function() {
        $('.example-enableCollapsibleOptGroups-enableClickableOptGroup').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true
        });
});

$(window).resize(function() {
    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    var title     = $(".t-settings-head").height();

    $('#bodyTblContent').height(windowHeight-header-title-130);
    
});
$( document ).ready(function() {

    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    var title     = $(".t-settings-head").height();

    $('#bodyTblContent').height(windowHeight-header-title-130);
});

$(function(){
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    $('.autoNum').autoNumeric('init',numberOptions);
});
</script>





