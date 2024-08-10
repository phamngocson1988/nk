<?php $baseUrl = Yii::app()->baseUrl;?>

<!-- THÔNG TIN ĐỢT ĐIỀU TRỊ -->
<?php include('mr_alert_medical.php'); ?> 

<!-- BỆNH SỬ Y KHOA --> 
<?php  include('mr_group_history.php'); ?>

<?php  if(isset($id_mhg) &&  $id_mhg) {     

    // TÌNH TRẠNG RĂNG
    include('mr_teeth_status.php');

    $existQuotation = $model->existQuotation($model->id,$id_mhg);


    
    // if($model->checkToothData($id_mhg) || $existQuotation) { 

    //     // QUÁ TRÌNH ĐIỀU TRỊ  
    //     include('mr_treatment_process.php');

    // }else{
        
    //     // QUÁ TRÌNH ĐIỀU TRỊ  
    //     echo "<div style='display: none;'>";
    //         include('mr_treatment_process.php');
    //     echo "</div>";

    // } 

    include('mr_treatment_process.php'); 


} ?>

<script>
// HỒ SƠ BỆNH ÁN    
var templock = 0;   
var aClone   = $("#action-prescription").clone(); 
var aLabClone   = $("#action-lab").clone();    
var divClone = $("#dntd").clone(); 
var containerTreatmentClone = $("#containerTreatment").clone(); 
var GlobalTeeth;

function customer() {
    $('#id_family').select2({
        placeholder: 'Chọn người',
        width: '100%',
        allowClear: true,
        ajax: {
            dataType : "json",
            url      : baseUrl+'/itemsCustomers/Accounts/getCustomerList',      
            type     : "post",
            delay    : 50,
            data : function (params) {
                return {
                    q: params.term, // search term
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                
                return {
                    results: data,
                    pagination: {
                        more:true
                    }
                };
            },
            cache: true,
        },
    });

    $('#id_society').select2({
        placeholder: 'Chọn người',
        width: '100%',
        allowClear: true,
        ajax: {
            dataType : "json",
            url      : baseUrl+'/itemsCustomers/Accounts/getCustomerList',      
            type     : "post",
            delay    : 50,
            data : function (params) {
                return {
                    q: params.term, // search term
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                
                return {
                    results: data,
                    pagination: {
                        more:true
                    }
                };
            },
            cache: true,
        },
    });
}
$( document ).ready(function() {
    customer();  
});
$('#showFamilyPopover').click(function(){ 
    $('#familyPopover').fadeToggle('fast');
});
$('#hideFamilyPopover').click(function(){    
    $('#familyPopover').hide(); 
});
$('#showSocietyPopover').click(function(){ 
    $('#societyPopover').fadeToggle('fast');
});
$('#hideSocietyPopover').click(function(){    
    $('#societyPopover').hide(); 
});

function detailTreatment(id){
    
    $('.cal-loading').fadeIn('fast');

    var id_customer = $('#id_customer').val();

    $.ajax({
        type:'POST',
        url: baseUrl+'/itemsCustomers/Accounts/detailTreatment',    
        data: {"id":id,"id_customer":id_customer},   
        success:function(data){         

            $('#medical_record').html(data); 

            $('.cal-loading').fadeOut('slow');

        },
        error: function(data){
        console.log("error");
        console.log(data);
        }
    });

}

$(".uT").click(function(e) {
   e.stopPropagation();
})

function updateTreatment(id){  

    var check_change_status_process =  $('#check_change_status_process').html();

    if(check_change_status_process != 0){

        $('.cal-loading').fadeIn('fast');
   
        var evt = window.event || arguments.callee.caller.arguments[0];   
        evt.stopPropagation();

        var id_customer = $('#id_customer').val();

        $.ajax({
            type:'POST',
            url: baseUrl+'/itemsCustomers/Accounts/updateTreatment',    
            data: {"id":id,"id_customer":id_customer},   
            success:function(data){      

                $('#medical_record').html(data); 

                $('.cal-loading').fadeOut('slow');             
            },
            error: function(data){
            console.log("error");
            console.log(data);
            }
        });

    }else{

        var evt = window.event || arguments.callee.caller.arguments[0];   
        evt.stopPropagation();
        return false;
    } 
    
}

/*Note Medical History*/
$("input[name='chk[]']").change(function() {
    if(this.checked) {
        var id = $(this).val();
        $(this).parents(".col-md-4.col-md-offset-2.col-sm-4.col-sm-offset-2").append("<label data-toggle='modal' data-target='#noteModal"+id+"' class='note_medical_history'><i id='i-note"+id+"'>(Thêm ghi chú)</i><input type='hidden' name='ipt[]' id='ipt"+id+"'></label");
    }
    else{
        $(this).parents(".checkbox").next().remove();
    }
});
function noteMedicalHistory(id){

    var ipt_note =  $('#ipt-note'+id).val();  

    $('#ipt'+id).val(ipt_note);
    $('#i-note'+id).html(ipt_note);
    $('#noteModal'+id).modal('hide');

}
/* End Note Medical History*/

/*Sidenav*/
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

function showUniversalKid() { 

    $('#typeTooth').text('RĂNG TRẺ EM');

    $('#typeTooth').val('RĂNG TRẺ EM');  

    $('#universal_kid').removeClass('hide');

}

$(function(){
  
    $(".dropdown-menu li a").click(function(){

        var typeTooth = $('#typeTooth').val();        
              
        $('#typeTooth').text($(this).text());
        $('#typeTooth').val($(this).text());

        if ($(this).text() == "RĂNG TRẺ EM" && typeTooth == "RĂNG NGƯỜI LỚN") {

            $('#universal_kid').removeClass('hide');

        }else if ($(this).text() == "RĂNG NGƯỜI LỚN" && typeTooth == "RĂNG TRẺ EM") {

            $('#universal_kid').addClass('hide');

        }      

    });

});

function onOpacityZero() {   
    $('#mat-nhai').addClass('opacity-0');
    $('#mat-ngoai').addClass('opacity-0');
    $('#mat-trong').addClass('opacity-0');
    $('#mat-gan').addClass('opacity-0');
    $('#mat-xa').addClass('opacity-0');
}
function offOpacityZero() {    
    $('#mat-nhai').removeClass('opacity-0');
    $('#mat-ngoai').removeClass('opacity-0');
    $('#mat-trong').removeClass('opacity-0');
    $('#mat-gan').removeClass('opacity-0');
    $('#mat-xa').removeClass('opacity-0');
}
function onOpacityZeroType1() {    
    $('#mat-ngoai').addClass('opacity-0');
    $('#mat-trong').addClass('opacity-0');
    $('#mat-gan').addClass('opacity-0');
    $('#mat-xa').addClass('opacity-0');
}

function unlockAll() {

    $(".restoration").each(function() {              
        $(this).attr('onclick',$(this).attr("onclick")).unbind('click');   
    });
    $(".decay").each(function() {              
        $(this).attr('onclick',$(this).attr("onclick")).unbind('click');   
    });
    $(".toothache").each(function() {              
        $(this).attr('onclick',$(this).attr("onclick")).unbind('click');   
    });
    $(".fractured").each(function() {              
        $(this).attr('onclick',$(this).attr("onclick")).unbind('click');   
    });
    $(".calculus").each(function() {              
        $(this).attr('onclick',$(this).attr("onclick")).unbind('click');   
    });
    $(".mobility").each(function() {              
        $(this).attr('onclick',$(this).attr("onclick")).unbind('click');   
    }); 
    $(".periodontal").each(function() {              
        $(this).attr('onclick',$(this).attr("onclick")).unbind('click');   
    });   
    $(".rang_moc_lech").each(function() {              
        $(this).attr('onclick',$(this).attr("onclick")).unbind('click');   
    }); 
    $(".rang_moc_ngam").each(function() {              
        $(this).attr('onclick',$(this).attr("onclick")).unbind('click');   
    });  

    $('#missing').attr('onclick',$('#missing').attr("onclick")).unbind('click'); 
    $('#residual_crown').attr('onclick',$('#residual_crown').attr("onclick")).unbind('click'); 
    $('#crown').attr('onclick',$('#crown').attr("onclick")).unbind('click');   
    $('#pontic').attr('onclick',$('#pontic').attr("onclick")).unbind('click');
    $('#residual_root').attr('onclick',$('#residual_root').attr("onclick")).unbind('click');
    $('#implant').attr('onclick',$('#implant').attr("onclick")).unbind('click');    
}
function lockOfCrown() {    
    $('#missing').prop('onclick',null).off('click');
    $('#residual_crown').prop('onclick',null).off('click'); 
    $('.restoration').prop('onclick',null).off('click');     
    $('#pontic').prop('onclick',null).off('click');
    $('#residual_root').prop('onclick',null).off('click');
    $('#implant').prop('onclick',null).off('click');
}
function lockOfPontic() {
    $('#missing').prop('onclick',null).off('click');
    $('#crown').prop('onclick',null).off('click');
    $('#residual_root').prop('onclick',null).off('click');
    $('#implant').prop('onclick',null).off('click');
    $('#residual_crown').prop('onclick',null).off('click');    
    $('.restoration').prop('onclick',null).off('click');
    $('.decay').prop('onclick',null).off('click');
    $('.toothache').prop('onclick',null).off('click');
    $(".fractured:nth-child(2)").prop('onclick',null).off('click');
    $(".fractured:nth-child(3)").prop('onclick',null).off('click');
    $('.calculus').prop('onclick',null).off('click');
}
function lockOfResidualCrown() {
    $('#missing').prop('onclick',null).off('click');
    $('#crown').prop('onclick',null).off('click');
    $('#pontic').prop('onclick',null).off('click');
    $('#implant').prop('onclick',null).off('click');
    $('#residual_root').prop('onclick',null).off('click');

    $('.restoration').prop('onclick',null).off('click');
    $('.decay').prop('onclick',null).off('click'); 
    $(".fractured:nth-child(1)").prop('onclick',null).off('click');
    $(".fractured:nth-child(3)").prop('onclick',null).off('click');
}
function lockOfResidualRoot() {
    $('#missing').prop('onclick',null).off('click');
    $('#crown').prop('onclick',null).off('click');
    $('#pontic').prop('onclick',null).off('click');
    $('#implant').prop('onclick',null).off('click');
    $('#residual_crown').prop('onclick',null).off('click');  

    $('.restoration').prop('onclick',null).off('click');
    $('.decay').prop('onclick',null).off('click'); 
    $('.fractured').prop('onclick',null).off('click');   
}
function lockOfMissing() {
    $('.restoration').prop('onclick',null).off('click');
    $('.decay').prop('onclick',null).off('click'); 
    $('.toothache').prop('onclick',null).off('click');
    $('.fractured').prop('onclick',null).off('click');   
    $('.calculus').prop('onclick',null).off('click');
    $('.mobility').prop('onclick',null).off('click');
    $('.periodontal').prop('onclick',null).off('click');
    $('#residual_crown').prop('onclick',null).off('click');
    $('.restoration').prop('onclick',null).off('click');
    $('#crown').prop('onclick',null).off('click');
    $('#pontic').prop('onclick',null).off('click');
    $('#residual_root').prop('onclick',null).off('click');
    $('#implant').prop('onclick',null).off('click');
}
function lockOfImplant() {

    $('#missing').prop('onclick',null).off('click');
    $('#crown').prop('onclick',null).off('click');
    $('#pontic').prop('onclick',null).off('click');    
    $('#residual_root').prop('onclick',null).off('click');
    $('#residual_crown').prop('onclick',null).off('click');

    $('.restoration').prop('onclick',null).off('click');
    $('.decay').prop('onclick',null).off('click'); 
    $('.toothache').prop('onclick',null).off('click');
    $(".fractured:nth-child(2)").prop('onclick',null).off('click');
    $(".fractured:nth-child(3)").prop('onclick',null).off('click');   
    $('.calculus').prop('onclick',null).off('click');  
}
function lockOfRangMocLech() {
    $('#missing').prop('onclick',null).off('click');
    $('.restoration').prop('onclick',null).off('click');
    $('#crown').prop('onclick',null).off('click');
    $('#pontic').prop('onclick',null).off('click');    
    $('#residual_root').prop('onclick',null).off('click');
    $('#implant').prop('onclick',null).off('click');
    $('.rang_moc_ngam').prop('onclick',null).off('click');
}
function lockOfRangMocNgam() {
    $('#missing').prop('onclick',null).off('click');
    $('.restoration').prop('onclick',null).off('click');
    $('#crown').prop('onclick',null).off('click');
    $('#pontic').prop('onclick',null).off('click');    
    $('#residual_root').prop('onclick',null).off('click');
    $('#implant').prop('onclick',null).off('click');
    $('.rang_moc_lech').prop('onclick',null).off('click');
}
function openNav() {   

    $("#toggle-dental").hide();

    $('#mySidenav1').css("width",$("#teeth_model").width()); 

    
}
function openNav2() {     

    $("#toggle-dental").hide(); 

    $('#mySidenav2').css("width",$("#teeth_model").width());
       
}

$('#frmNote').submit(function(e) {    

    var number = $('#txtNoteNumber').val();
    var note   = $('#txtNoteTooth').val();

    if( $("#ket_luan_"+number).is(':empty') ) {      
        $("#ket_luan_"+number).html('<i>Răng '+number+':</i>');
        $("#ghi_chu_"+number).data("note",note).html('Ghi chú: '+note);
    }else{   
        $("#ghi_chu_"+number).data("note",note).html('Ghi chú: '+note);
    }   

    $('#noteToothModal').modal('hide');

    return false;
  
});



$('#frmAssign').submit(function(e) {
    
    var formData = new FormData($("#frmAssign")[0]);
    var number   = $('#txtNumber').val();
    var assign   = $('#txtAssign').val();

    if (!formData.checkValidity || formData.checkValidity()) {

       $("#chi_dinh_"+number).data("assign",assign).html('Chỉ định: '+assign);
       $('#assignModal').modal('hide')

    }

    return false;

});

$('#noteToothModal').on('hidden.bs.modal', function (e) {
    $('#txtNoteTooth').val('');
});

function retype() {

    var number = $('#hidden_number').val();     

    offOpacityZero();

    if(($("#mat_nhai_"+number).length > 0)){
        $("#mat_nhai_"+number).empty(); 
    }
    if(($("#mat_ngoai_"+number).length > 0)){
        $("#mat_ngoai_"+number).empty(); 
    }
    if(($("#mat_trong_"+number).length > 0)){
        $("#mat_trong_"+number).empty(); 
    }
    if(($("#mat_gan_"+number).length > 0)){
        $("#mat_gan_"+number).empty(); 
    }  
    if(($("#mat_xa_"+number).length > 0)){
        $("#mat_xa_"+number).empty(); 
    } 
    if(($("#ket_luan_"+number).length > 0)){
        $("#ket_luan_"+number).empty(); 
    } 
    if(($("#ghi_chu_"+number).length > 0)){
        $("#ghi_chu_"+number).empty(); 
    } 
    if(($("#chi_dinh_"+number).length > 0)){
        $('#chi_dinh_'+number).data("assign","").empty();
    }     

    $(".tooth").each(function() {  
        if(this.title == "RĂNG "+number+"") {

            if($(this).attr("data-tooth")=='1') {               
                var src = $(this).attr("src").replace("/rangbenh/", "/rangACTIVE/");
                $(this).attr("src", src);                
            }  
            else if($(this).attr("data-tooth")=='101') {               
                var src = $(this).attr("src").replace("/rangmat/", "/rangACTIVE/");
                $(this).attr("src", src);                
            }  
            else if($(this).attr("data-tooth")=='102') {               
                var src = $(this).attr("src").replace("/rangtramA/", "/rangACTIVE/");
                $(this).attr("src", src);                
            }          
            else if($(this).attr("data-tooth")=='103') {               
                var src = $(this).attr("src").replace("/ranggiacodinh/", "/rangACTIVE/");
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth")=='104') {               
                var src = $(this).attr("src").replace("/vitricauranggia/", "/rangACTIVE/");
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth")=='105') {               
                var src = $(this).attr("src").replace("/rangbenh/", "/rangACTIVE/");
                $(this).attr("src", src);                
            }             
            else if($(this).attr("data-tooth")=='106') {               
                var src = $(this).attr("src").replace("/rangphuchoiIMPLANT/", "/rangACTIVE/");
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth")=='107') {               
                var src = $(this).attr("src").replace("/rangyeu/", "/rangACTIVE/");
                $(this).attr("src", src);                
            }
            
            $(this).removeAttr("data-tooth");
      
        }
    }); 

    $("#toggle-dental").hide();      

}

$(document).ready(function(){   
  $(".tooth").each(function() {  
        if($(this).attr("data-tooth")) {

            if($(this).attr("data-tooth")=='1') {               
                var src = $(this).attr("src").replace("rang", "rangbenh");
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth")=='101') {               
                var src = $(this).attr("src").replace("rang", "rangmat");
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth")=='102') {               
                var src = $(this).attr("src").replace("rang", "rangtramA");
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth")=='103') {               
                var src = $(this).attr("src").replace("rang", "ranggiacodinh");
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth")=='104') {               
                var src = $(this).attr("src").replace("rang", "vitricauranggia");
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth")=='105') {               
                var src = $(this).attr("src").replace("rang", "rangbenh");
                $(this).attr("src", src);                
            }            
            else if($(this).attr("data-tooth")=='106') {               
                var src = $(this).attr("src").replace("rang", "rangphuchoiIMPLANT");
                $(this).attr("src", src);                
            }
            else if($(this).attr("data-tooth")=='107') {               
                var src = $(this).attr("src").replace("rang", "rangyeu");
                $(this).attr("src", src);                
            }
           
        }
    });  
});

function closeNav() {
    $('.sidenav').css("width","0");   
}

$(document).click(function(e) {
  var sidenav = $(".sidenav, .open");
  if (!sidenav.is(e.target) && sidenav.has(e.target).length === 0) {
    $('.sidenav').css("width","0");   
  }
});

$('.collapse').on('show.bs.collapse', function () {    
    $('.collapse.in').collapse('hide');
});

function checkElementExist(number){

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");
    
    for (var i = 0; i < data_array.length; i++) {
          
        if (data_array[i] == number){  
            return false;
        }
      
    } 

    return true;

}



function checkSick(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];   
    var types =    [6, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0;   

}

function checkStatus(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];   
    var types =    [101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0;   

}

function checkDecay(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];
    var types = [8, 9, 10, 11, 12, 13, 14, 15, 16];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0;   

}

function checkFractured(number){

    var faces = ['matnhai', 'matngoai', 'mattrong'];
    var types = [21, 22, 23];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0;   

}

function checkResidualCrownRoot(type,number){ 

    if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){    

        if ($("#matngoai-"+type+"-"+number).attr('src').indexOf('residualcrownroot') != -1 && $("#mattrong-"+type+"-"+number).attr('src').indexOf('residualcrownroot') != -1){           
            
            return 1;
        }

        return 0;
    }

    return 0;
}

function checkResidualCrown(number){

    var faces = ['matngoai', 'mattrong', 'matgan', 'matxa'];    
    var type  = 6;

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    } 

    return 0;   

}

function checkCrown(number){

    var face = 'matnhai';    
    var type = 21;
                   
    if ($("#"+face+"-"+type+"-"+number).length > 0){  
        return 1;
    }  

    return 0;   

}

function checkCrownStatus(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];    
    var type  = 103;

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    } 

    return 0;  

}

function checkPonticStatus(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];    
    var type  = 104;

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    } 

    return 0;  

}

function checkResidualRootStatus(number){

    var faces = ['matngoai', 'mattrong', 'matgan', 'matxa'];    
    var type  = 105;

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    } 

    return 0;  

}

function checkMissingStatus(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];    
    var type  = 101;

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    } 

    return 0;  

}

function checkImplantStatus(number){

    var faces = ['matngoai', 'mattrong', 'matgan', 'matxa'];    
    var type  = 106;

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    } 

    return 0;  

}

function checkRoot(number){

    var faces = ['matngoai', 'mattrong'];      
    var type = 22;  

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    }

    return 0;   

}

function checkCalculus(number){

    var faces = ['matngoai', 'mattrong', 'matgan', 'matxa'];     
    var types = [24, 25, 26, 27];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0;   

}

function checkToothache(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];     
    var types = [17, 18, 19, 20];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0;   

}

function checkCrownRoot(number){

    var faces = ['matngoai', 'mattrong'];      
    var type = 23;  

    for (var i = 0; i < faces.length; i++) {                 
        if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){  
            return 1;
        }        
    }

    return 0;   

}

function checkRestorationStatus(number){

    var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];
    var types = [107, 108, 109, 110, 111, 112, 113, 114, 115];

    for (var i = 0; i < faces.length; i++) {
        for (var j = 0; j < types.length; j++) {          
            if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){  
                return 1;
            }
        }
    } 

    return 0; 

}

function checkRangMocLechStatus(number){

    var face = 'matnhai';    
    var type = 116;
                   
             
    if ($("#"+face+"-"+type+"-"+number).length > 0){  
        return 1;
    }
    

    return 0;      

}

function checkRangMocNgamStatus(number){

    var face = 'matnhai';    
    var type = 117;
                   
             
    if ($("#"+face+"-"+type+"-"+number).length > 0){  
        return 1;
    }
    

    return 0;      

}

function getLastRestorationStatus(number){

    
    var types = [107, 108, 109, 110, 111, 112, 113, 114, 115];
    var last  = 0;
    for (var i = 0; i < types.length; i++) {          
        if ($("#ketluan-"+types[i]+"-"+number).length > 0){  
            last = types[i];
        }
    }

    return last; 

}

function getLastDecay(number){

    var types = [8, 9, 10, 11, 12, 13, 14, 15, 16];
    var last  = 0;
    for (var i = 0; i < types.length; i++) {          
        if ($("#ketluan-"+types[i]+"-"+number).length > 0){  
            last = types[i];
        }
    }

    return last; 

}

function getLastToothache(number){

    var types = [17, 18, 19, 20];
    var last  = 0;
    for (var i = 0; i < types.length; i++) {          
        if ($("#ketluan-"+types[i]+"-"+number).length > 0){  
            last = types[i];
        }
    }

    return last; 

}

function getLastFractured(number){

    var types = [21, 22, 23];
    var last  = 0;
    for (var i = 0; i < types.length; i++) {          
        if ($("#ketluan-"+types[i]+"-"+number).length > 0){  
            last = types[i];
        }
    }

    return last; 

}

function getLastCalculus(number){

    var types = [24, 25, 26, 27];
    var last  = 0;
    for (var i = 0; i < types.length; i++) {          
        if ($("#ketluan-"+types[i]+"-"+number).length > 0){  
            last = types[i];
        }
    }

    return last; 

}

function getLastMobility(number){

    var types = [28, 29, 30];
    var last  = 0;
    for (var i = 0; i < types.length; i++) {          
        if ($("#ketluan-"+types[i]+"-"+number).length > 0){  
            last = types[i];
        }
    }

    return last; 

}

function getLastPeriodontal(number){

    var types = [31, 32, 33, 34, 35];
    var last  = 0;
    for (var i = 0; i < types.length; i++) {          
        if ($("#ketluan-"+types[i]+"-"+number).length > 0){  
            last = types[i];
        }
    }

    return last; 

}

function incisalUsal(status){  

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");


    if(status==1){  
        
        for (var i = 0; i < data_array.length; i++) { 

            var number = data_array[i]; 
            var type=107;    
            var flag=102;
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
            var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");    

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);  
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>');
                $('#chi_dinh_'+number).html('Thêm chỉ định');
            }       

            if (($("#matnhai-"+type+"-"+number).length > 0)){  

                $("#matnhai-"+type+"-"+number).remove(); 

                $("#ketluan-"+type+"-"+number).remove();

                if (getLastRestorationStatus(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{         
                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai'+number+'-trongtrai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
               
                if (getLastRestorationStatus(number) == 0) {   
                    $('#ket_luan_'+number+' i:first-child').after('<i id="muc-'+flag+"-"+number+'"> Phục hồi miếng trám</i>');       
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt nhai (X)</i>');  
                }else {
                    var last = getLastRestorationStatus(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt nhai (X)</i>');            
                } 
                
            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }     
                $('#chi_dinh_'+number).data("assign","").empty();       
            }

        }

    } 
    else if(status==2){  
        
        for (var i = 0; i < data_array.length; i++) { 

            var number = data_array[i];  
            var type     = 8;
            var flag=1;
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

            if (checkSick(number) == 0 && checkStatus(number) == 0){                
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);    
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();    
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định');                
            }       

            if($("#matnhai-"+type+"-"+number).length > 0){    
                $("#matnhai-"+type+"-"+number).remove();
                $("#ketluan-"+type+"-"+number).remove(); 

                if (getLastDecay(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{   
                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matnhai'+number+'-trongtrai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');   

                if (getLastDecay(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Sâu răng</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt nhai (X)</i>');  
                }else {
                    var last = getLastDecay(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt nhai (X)</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();   
            }

        }

    }   
}

function incisalSal(status){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");   

    if(status==1){

        for (var i = 0; i < data_array.length; i++) { 

            var number = data_array[i];
            var type=108;     
            var flag=102;  
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
            var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");    

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);    
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();          
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>');
                $('#chi_dinh_'+number).html('Thêm chỉ định');  
            }      

            if (($("#matnhai-"+type+"-"+number+"").length > 0)){   

                $("#matnhai-"+type+"-"+number+"").remove(); 

                $("#ketluan-"+type+"-"+number+"").remove();

                if (getLastRestorationStatus(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }
            else{                  

                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai'+number+'-trongphai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');     

                if (getLastRestorationStatus(number) == 0) {   
                    $('#ket_luan_'+number+' i:first-child').after('<i id="muc-'+flag+"-"+number+'"> Phục hồi miếng trám</i>');       
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt nhai (G)</i>');  
                }else {
                    var last = getLastRestorationStatus(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt nhai (G)</i>');            
                }                

            }

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();   
            }

        }
    }   
    else if(status==2){        
        
        for (var i = 0; i < data_array.length; i++) { 

            var number = data_array[i];  
            var type=9;
            var flag=1;
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);      
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();     
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>');
                $('#chi_dinh_'+number).html('Thêm chỉ định');  
            } 

            if ($("#matnhai-"+type+"-"+number).length > 0){    
                $("#matnhai-"+type+"-"+number).remove(); 
                $("#ketluan-"+type+"-"+number).remove();  

                if (getLastDecay(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{
                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matnhai'+number+'-trongphai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');   

                if (getLastDecay(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Sâu răng</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt nhai </i>');  //(G)
                }else {
                    var last = getLastDecay(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt nhai </i>');   //(G)         
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();  
            }

        }

    }    
}

function distal(status){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");    

    if(status==1){

        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i];
            var type=109;   
            var flag=102;      
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
            var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");   

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);       
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();       
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>');
                $('#chi_dinh_'+number).html('Thêm chỉ định');  
            }    

            if (($("#matnhai-"+type+"-"+number+"").length > 0)){   

                $("#matnhai-"+type+"-"+number+"").remove();  

                $("#ketluan-"+type+"-"+number+"").remove();

                if (getLastRestorationStatus(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }
            else{                          

                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai'+number+'-trai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

                if (getLastRestorationStatus(number) == 0) {   
                    $('#ket_luan_'+number+' i:first-child').after('<i id="muc-'+flag+"-"+number+'"> Phục hồi miếng trám</i>');       
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt xa</i>');  
                }else {
                    var last = getLastRestorationStatus(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt xa</i>');            
                }     

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();  
            }
        }
    }  
    else if(status==2){        
        
        for (var i = 0; i < data_array.length; i++) { 

            var number = data_array[i];  
            var type=10;
            var flag=1;
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);    
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();    
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            } 

            if ($("#matnhai-"+type+"-"+number).length > 0){    
                $("#matnhai-"+type+"-"+number).remove(); 
                $("#ketluan-"+type+"-"+number).remove();  

                if (getLastDecay(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{
                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matnhai'+number+'-trai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');  

                if (getLastDecay(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Sâu răng</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt xa</i>');  
                }else {
                    var last = getLastDecay(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt xa</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }

    }else if(status==3){        
        
        for (var i = 0; i < data_array.length; i++) { 

            var number = data_array[i]; 
            var flag=7;
            var type=32;
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);   
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            }

            if ($("#matxa-"+type+"-"+number).length > 0){    
                $("#matxa-"+type+"-"+number).remove(); 
                $("#ketluan-"+type+"-"+number).remove();

                if (getLastPeriodontal(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{
                $('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/periodontal-'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');        
            

                if (getLastPeriodontal(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Túi nha chu</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt xa</i>');  
                }else {
                    var last = getLastPeriodontal(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt xa</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }

    }      
}

function mesial(status){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");    

    if(status==1){

        for (var i = 0; i < data_array.length; i++) { 

            var number = data_array[i];  
            var type=110;   
            var flag=102;   
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
            var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");    

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);    
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();      
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>');
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            }

            if (($("#matnhai-"+type+"-"+number+"").length > 0)){

                $("#matnhai-"+type+"-"+number+"").remove(); 

                $("#ketluan-"+type+"-"+number+"").remove();

                if (getLastRestorationStatus(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }
            else{                    

                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai'+number+'-phai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            
                if (getLastRestorationStatus(number) == 0) {   
                    $('#ket_luan_'+number+' i:first-child').after('<i id="muc-'+flag+"-"+number+'"> Phục hồi miếng trám</i>');       
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt gần</i>');  
                }else {
                    var last = getLastRestorationStatus(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt gần</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }
        }
    }  
    else if(status==2){        
        
        for (var i = 0; i < data_array.length; i++) { 

            var number = data_array[i];  
            var type=11;
            var flag=1;
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            }

            if ($("#matnhai-"+type+"-"+number).length > 0){    
                $("#matnhai-"+type+"-"+number).remove(); 
                $("#ketluan-"+type+"-"+number).remove();

                if (getLastDecay(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{
                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matnhai'+number+'-phai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');     

                if (getLastDecay(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Sâu răng</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt gần</i>');  
                }else {
                    var last = getLastDecay(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt gần</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }

    }

    else if(status==3){

        for (var i = 0; i < data_array.length; i++) { 

            var number = data_array[i]; 
            var type=31;
            var flag=7;
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);   
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();   
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            }

            if ($("#matgan-"+type+"-"+number).length > 0){    
                $("#matgan-"+type+"-"+number).remove(); 
                $("#ketluan-"+type+"-"+number).remove();

                if (getLastPeriodontal(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{
                $('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/periodontal--'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');        
    

                if (getLastPeriodontal(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Túi nha chu</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt gần</i>');  
                }else {
                    var last = getLastPeriodontal(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt gần</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }

    }   

}

function proximalD(status){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");    

    if(status==1){

        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i]; 
            var type=111;  
            var flag=102;        
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
            var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");    

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);  
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();        
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            }     

            if (($("#matngoai-"+type+"-"+number+"").length > 0) && ($("#mattrong-"+type+"-"+number+"").length > 0)){    

                $("#matngoai-"+type+"-"+number+"").remove();   

                $("#mattrong-"+type+"-"+number+"").remove(); 

                $("#ketluan-"+type+"-"+number+"").remove();

                if (getLastRestorationStatus(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }
            else{                           

                $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matngoai'+number+'-trai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mattrong'+number+'-phai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

                if (getLastRestorationStatus(number) == 0) {   
                    $('#ket_luan_'+number+' i:first-child').after('<i id="muc-'+flag+"-"+number+'"> Phục hồi miếng trám</i>');       
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt bên xa</i>');  
                }else {
                    var last = getLastRestorationStatus(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt bên xa</i>');            
                }             
                
            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }
    }  
    else if(status==2){        
        
        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i];  
            var type=12;   
            var flag=12;   
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");  

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();       
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            } 

            if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){    
                $("#matngoai-"+type+"-"+number).remove();   
                $("#mattrong-"+type+"-"+number).remove();
                $("#ketluan-"+type+"-"+number).remove(); 

                if (getLastDecay(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{
                $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matngoai'+number+'-trai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-mattrong'+number+'-phai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');        

                if (getLastDecay(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Sâu răng</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt bên (X)</i>');  
                }else {
                    var last = getLastDecay(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt bên (X)</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }

    }        
}

function proximalM(status){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");   

    if(status==1){

        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i]; 
            var type=112;
            var flag=102;
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
            var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");    
            
            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA); 
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            }

            if (($("#matngoai-"+type+"-"+number+"").length > 0) && ($("#mattrong-"+type+"-"+number+"").length > 0)){    
                $("#matngoai-"+type+"-"+number+"").remove();   
                $("#mattrong-"+type+"-"+number+"").remove();  

                $("#ketluan-"+type+"-"+number+"").remove();

                if (getLastRestorationStatus(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }
            else{                          

                $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matngoai'+number+'-phai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mattrong'+number+'-trai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            
                if (getLastRestorationStatus(number) == 0) {   
                    $('#ket_luan_'+number+' i:first-child').after('<i id="muc-'+flag+"-"+number+'"> Phục hồi miếng trám</i>');       
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt bên gần</i>');  
                }else {
                    var last = getLastRestorationStatus(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt bên gần</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
                $('#chi_dinh_'+number).data("assign","").empty(); 
            }

        }
    } 
    else if(status==2){        
        
        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i]; 
            var type=13; 
            var flag=1; 
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);       
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();   
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định');                 
            }         

            if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){    
                $("#matngoai-"+type+"-"+number).remove();   
                $("#mattrong-"+type+"-"+number).remove();
                $("#ketluan-"+type+"-"+number).remove();

                if (getLastDecay(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{
                $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matngoai'+number+'-phai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-mattrong'+number+'-trai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');     

                if (getLastDecay(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Sâu răng</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt bên (G)</i>');  
                }else {
                    var last = getLastDecay(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt bên (G)</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }

    }     
}

function abfractionV(status){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");    

    if(status==1){

        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i]; 
            var type=113;  
            var flag=102;    
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
            var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");  

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);   
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();  
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            }

            if (($("#matngoai-"+type+"-"+number+"").length > 0) && ($("#mattrong-"+type+"-"+number+"").length > 0)){    

                $("#matngoai-"+type+"-"+number+"").remove();   
                $("#mattrong-"+type+"-"+number+"").remove();
                $("#ketluan-"+type+"-"+number+"").remove();

                if (getLastRestorationStatus(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }
            else{                

                $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matngoai'+number+'-giua.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mattrong'+number+'-giua.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            
                if (getLastRestorationStatus(number) == 0) {   
                    $('#ket_luan_'+number+' i:first-child').after('<i id="muc-'+flag+"-"+number+'"> Phục hồi miếng trám</i>');       
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Cổ răng</i>');  
                }else {
                    var last = getLastRestorationStatus(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Cổ răng</i>');            
                } 

            }

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }
    } 
    else if(status==2){        
        
        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i]; 
            var type=14; 
            var flag=1; 
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");      

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định');
            }   

            if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){    
                $("#matngoai-"+type+"-"+number).remove();   
                $("#mattrong-"+type+"-"+number).remove();  
                $("#matgan-"+type+"-"+number).remove();   
                $("#matxa-"+type+"-"+number).remove();
                $("#ketluan-"+type+"-"+number).remove(); 

                if (getLastDecay(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{
                $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matngoai'+number+'-giua.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-mattrong'+number+'-giua.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matgan'+number+'-giua.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matxa'+number+'-giua.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');     

                if (getLastDecay(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Sâu răng</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Cổ răng</i>');  
                }else {
                    var last = getLastDecay(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Cổ răng</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }

    }    
}

function facialBuccal(status){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");    

    if(status==1){

        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i];
            var type=114;  
            var flag=102;     
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
            var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");  

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA); 
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();                
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định');
            }

            if (($("#matnhai-"+type+"-"+number+"").length > 0)){  

                $("#matnhai-"+type+"-"+number+"").remove(); 

                $("#ketluan-"+type+"-"+number+"").remove();

                if (getLastRestorationStatus(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }
            else{               

                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai'+number+'-duoi.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            
                if (getLastRestorationStatus(number) == 0) {   
                    $('#ket_luan_'+number+' i:first-child').after('<i id="muc-'+flag+"-"+number+'"> Phục hồi miếng trám</i>');       
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt ngoài</i>');  
                }else {
                    var last = getLastRestorationStatus(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt ngoài</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }
        }
    } 
    else if(status==2){        
        
        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i]; 
            var type=15;
            var flag=1;
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);  
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định');
            }   

            if ($("#matnhai-"+type+"-"+number).length > 0){    
                $("#matnhai-"+type+"-"+number).remove(); 
                $("#ketluan-"+type+"-"+number).remove(); 

                if (getLastDecay(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{
                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matnhai'+number+'-duoi.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');   

                if (getLastDecay(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Sâu răng</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt ngoài</i>');  
                }else {
                    var last = getLastDecay(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt ngoài</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }

    }else if(status==3){        
        
        for (var i = 0; i < data_array.length; i++) { 

            var number = data_array[i]; 
            var type=33;
            var flag=7;
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);   
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();       
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            }

            if ($("#matngoai-"+type+"-"+number).length > 0){    
                $("#matngoai-"+type+"-"+number).remove(); 
                $("#ketluan-"+type+"-"+number).remove();

                if (getLastPeriodontal(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{
                $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/periodontal--'+number+'---matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');        
               	

               	if (getLastPeriodontal(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Túi nha chu</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt ngoài</i>');  
                }else {
                    var last = getLastPeriodontal(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt ngoài</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }

    }       
}

function palateLingual(status){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");    

    if(status==1){

        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i];
            var type=115;  
            var flag=102;       
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
            var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");   

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);         
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định');
            }  

            if (($("#matnhai-"+type+"-"+number+"").length > 0)){  

                $("#matnhai-"+type+"-"+number+"").remove();  

                $("#ketluan-"+type+"-"+number+"").remove();

                if (getLastRestorationStatus(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }
            else{                         

                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai'+number+'-tren.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
           
                if (getLastRestorationStatus(number) == 0) {   
                    $('#ket_luan_'+number+' i:first-child').after('<i id="muc-'+flag+"-"+number+'"> Phục hồi miếng trám</i>');       
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt trong</i>');  
                }else {
                    var last = getLastRestorationStatus(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt trong</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }
        }
    }   
    else if(status==2){        
        
        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i]; 
            var type=16;
            var flag=1;
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>');
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            } 

            if ($("#matnhai-"+type+"-"+number).length > 0){    
                $("#matnhai-"+type+"-"+number).remove(); 
                $("#ketluan-"+type+"-"+number).remove(); 

                if (getLastDecay(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{
                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matnhai'+number+'-tren.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');  

                if (getLastDecay(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Sâu răng</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt trong</i>');  
                }else {
                    var last = getLastDecay(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt trong</i>');            
                } 

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }

    }else if(status==3){        
        
        for (var i = 0; i < data_array.length; i++) { 

            var number = data_array[i]; 
            var type=34;
            var flag=7;
            var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            }

            if ($("#mattrong-"+type+"-"+number).length > 0){    
                $("#mattrong-"+type+"-"+number).remove(); 
                $("#ketluan-"+type+"-"+number).remove();

                if (getLastPeriodontal(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }

            }else{
                $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/periodontal--'+number+'---mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');        
               	
               	if (getLastPeriodontal(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Túi nha chu</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt trong</i>');  
                }else {
                    var last = getLastPeriodontal(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Mặt trong</i>');            
                } 
            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            }

        }

    } 
}

function sensitive(){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");
        
    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i]; 
        var type=17; 
        var flag=2;   
        var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
        var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");  

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);  
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        } 

        if ($("#matnhai-"+type+"-"+number).length > 0){    
            $("#matnhai-"+type+"-"+number).remove();  
            $("#ketluan-"+type+"-"+number).remove(); 

            if (getLastToothache(number) == 0) {   
                $("#muc-"+flag+"-"+number).remove();
            }

        }else{
            $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/sensitive-tooth.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');    


            if (getLastToothache(number) == 0) {   
                $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Đau răng</i>');             
                $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Nhạy cảm</i>');  
            }else {
                var last = getLastToothache(number);
                $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Nhạy cảm</i>');            
            } 

        }   

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
            $('#chi_dinh_'+number).data("assign","").empty();
        }   

    }    
    
}

function pulpitis(){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");
        
    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i]; 
        var type=18;    
        var flag=2;    
        var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
        var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");   

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        } 

        if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){    
            $("#matngoai-"+type+"-"+number).remove();   
            $("#mattrong-"+type+"-"+number).remove();  
            $("#matgan-"+type+"-"+number).remove();   
            $("#matxa-"+type+"-"+number).remove(); 
            $("#ketluan-"+type+"-"+number).remove(); 

            if (getLastToothache(number) == 0) {   
                $("#muc-"+flag+"-"+number).remove();
            }

        }else{
            $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pulpitis'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pulpitis'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pulpitis'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pulpitis'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');    
   

            if (getLastToothache(number) == 0) {   
                $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Đau răng</i>');             
                $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Viêm tủy</i>');  
            }else {
                var last = getLastToothache(number);
                $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Viêm tủy</i>');            
            }

        }

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
            $('#chi_dinh_'+number).data("assign","").empty();
        } 

    } 
       
}

function acutePeriapical(){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");
        
    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i]; 
        var type=19;     
        var flag=2;  
        var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
        var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");   

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        } 

        if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){    
            $("#matngoai-"+type+"-"+number).remove();   
            $("#mattrong-"+type+"-"+number).remove();  
            $("#matgan-"+type+"-"+number).remove();   
            $("#matxa-"+type+"-"+number).remove(); 
            $("#ketluan-"+type+"-"+number).remove(); 

            if (getLastToothache(number) == 0) {   
                $("#muc-"+flag+"-"+number).remove();
            }

        }else{
            $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/acute'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/acute'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/acute'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/acute'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');    

            if (getLastToothache(number) == 0) {   
                $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Đau răng</i>');             
                $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Viêm quanh chóp cấp</i>');  
            }else {
                var last = getLastToothache(number);
                $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Viêm quanh chóp cấp</i>');            
            }

        } 

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
            $('#chi_dinh_'+number).data("assign","").empty();
        } 

    } 
       
}

function chronicPeriapical(){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");
        
    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i];
        var type=20;   
        var flag=2; 
        var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
        var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/"); 

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        }    

        if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){    
            $("#matngoai-"+type+"-"+number).remove();   
            $("#mattrong-"+type+"-"+number).remove();  
            $("#matgan-"+type+"-"+number).remove();   
            $("#matxa-"+type+"-"+number).remove(); 
            $("#ketluan-"+type+"-"+number).remove();

            if (getLastToothache(number) == 0) {   
                $("#muc-"+flag+"-"+number).remove();
            }

        }else{
            $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/chroni'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/chroni'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/chroni'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/chroni'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');      

            if (getLastToothache(number) == 0) {   
                $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Đau răng</i>');             
                $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Viêm quanh chóp mãn</i>');  
            }else {
                var last = getLastToothache(number);
                $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Viêm quanh chóp mãn</i>');            
            }

        } 

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
            $('#chi_dinh_'+number).data("assign","").empty();
        }

    } 
       
}

function crown(){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");
        
    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i]; 
        var type=21;
        var flag=3; 
        var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
        var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");   

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        }  

        if (($("#matnhai-"+type+"-"+number).length > 0)){              
            $("#matnhai-"+type+"-"+number).remove();         
            $('#mat-nhai').removeClass('opacity-0');          

            // pontic-fractured-crown
            if($("#matnhai-104-"+number).length > 0){ 
                var srcIf = $("#matnhai-104-"+number).attr("src").replace("crown", "pontic");
                $("#matnhai-104-"+number).attr("src", srcIf);             
            }
            // end pontic-fractured-crown
            
            $("#ketluan-"+type+"-"+number).remove();  

            if (getLastFractured(number) == 0) {   
                $("#muc-"+flag+"-"+number).remove();
            }     
            
        }else{         
            $("#matngoai-22-"+number).remove();   
            $("#mattrong-22-"+number).remove(); 
            $("#matngoai-23-"+number).remove();   
            $("#mattrong-23-"+number).remove();
            $('#mat-ngoai').removeClass('opacity-0'); 
            $('#mat-trong').removeClass('opacity-0');
            $('#mat-nhai').addClass('opacity-0');

            // pontic-fractured-crown
            if($("#matnhai-104-"+number).length > 0){
                $('#mat-ngoai').addClass('opacity-0'); 
                $('#mat-trong').addClass('opacity-0');  
                var srcElse = $("#matnhai-104-"+number).attr("src").replace("pontic", "crown");
                $("#matnhai-104-"+number).attr("src", srcElse); 
            }// implant-fractured-crown    
            else if($("#matngoai-106-"+number).length > 0 && $("#mattrong-106-"+number).length > 0){             
                $('#mat-ngoai').addClass('opacity-0'); 
                $('#mat-trong').addClass('opacity-0');     
            }         
            // end         
            
            $('#mat_nhai_'+number).prepend('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');    

            if (getLastFractured(number) == 0) {   
                $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Nứt răng</i>');             
                $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Nứt thân răng</i>');  
            }else {
                var last = getLastFractured(number);
                $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Nứt thân răng</i>');            
            }

            $("#ketluan-22-"+number+"").remove();
            $("#ketluan-23-"+number+"").remove(); 

        }  

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
            $('#chi_dinh_'+number).data("assign","").empty();
        }  

    }       
    
}

function root(){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");
        
    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i];  
        var type=22;
        var flag=3; 
        var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
        var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/"); 

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        }     

        if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){         
            $('#mat-ngoai').removeClass('opacity-0'); 
            $('#mat-trong').removeClass('opacity-0'); 

            // residualCrown-fractured-root
            if ($("#matngoai-"+type+"-"+number).attr('src').indexOf('residualcrownroot') != -1 && $("#mattrong-"+type+"-"+number).attr('src').indexOf('residualcrownroot') != -1){ 
                $('#mat-ngoai').addClass('opacity-0'); 
                $('#mat-trong').addClass('opacity-0');
                $('#mat_ngoai_'+number).prepend('<img id="matngoai-6-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).prepend('<img id="mattrong-6-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');  
            }// end residualCrown-fractured-root

            $("#matngoai-"+type+"-"+number).remove();   
            $("#mattrong-"+type+"-"+number).remove(); 
            $("#ketluan-"+type+"-"+number).remove();

            if (getLastFractured(number) == 0) {   
                $("#muc-"+flag+"-"+number).remove();
            }   


        }// residualCrown-fractured-root
        else if(checkResidualCrownRoot(6,number) == 1){
            $("#matngoai-6-"+number).remove();    
            $("#mattrong-6-"+number).remove(); 
            $('#mat_ngoai_'+number).prepend('<img id="matngoai-6-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_trong_'+number).prepend('<img id="mattrong-6-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');  
            $("#ketluan-"+type+"-"+number).remove();
        }// end residualCrown-fractured-root
        else{        
            $("#matnhai-21-"+number).remove(); 
            $("#matngoai-23-"+number).remove();   
            $("#mattrong-23-"+number).remove(); 
            $('#mat-nhai').removeClass('opacity-0');
            $('#mat-ngoai').addClass('opacity-0'); 
            $('#mat-trong').addClass('opacity-0');

            // residualCrown-fractured-root
            if(($("#matngoai-6-"+number+"").length > 0) && ($("#mattrong-6-"+number+"").length > 0)){    
                $("#matngoai-6-"+number).remove();    
                $("#mattrong-6-"+number).remove();         
                $('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrownroot'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrownroot'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');     
            }// end residualCrown-fractured-root
            else{
                $('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/root'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/root'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');     
            }   

            if (getLastFractured(number) == 0) {   
                $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Nứt răng</i>');             
                $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Nứt chân răng</i>');  
            }else {
                var last = getLastFractured(number);
                $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Nứt chân răng</i>');            
            } 

            $("#ketluan-21-"+number).remove();
            $("#ketluan-23-"+number).remove(); 
        } 

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
            $('#chi_dinh_'+number).data("assign","").empty();
        }  

    }
    
}

function crownRoot(){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");
        
    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i];  
        var type=23;
        var flag=3; 
        var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
        var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/"); 

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>');
            $('#chi_dinh_'+number).html('Thêm chỉ định'); 
        }  

        if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){             
            $("#matngoai-"+type+"-"+number).remove();   
            $("#mattrong-"+type+"-"+number).remove();
            $('#mat-ngoai').removeClass('opacity-0'); 
            $('#mat-trong').removeClass('opacity-0');
            $("#ketluan-"+type+"-"+number).remove();  

            if (getLastFractured(number) == 0) {   
                $("#muc-"+flag+"-"+number).remove();
            }  

        }else{
            $("#matnhai-21-"+number).remove(); 
            $("#matngoai-22-"+number).remove();   
            $("#mattrong-22-"+number).remove(); 
            $('#mat-ngoai').addClass('opacity-0'); 
            $('#mat-trong').addClass('opacity-0'); 
            $('#mat-nhai').removeClass('opacity-0');        
            $('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crownroot'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crownroot'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');      

            if (getLastFractured(number) == 0) {   
                $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Nứt răng</i>');             
                $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Nứt thân- chân răng</i>');  
            }else {
                var last = getLastFractured(number);
                $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Nứt thân- chân răng</i>');            
            } 

            $("#ketluan-21-"+number).remove();
            $("#ketluan-22-"+number).remove();        
    
        } 

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
            $('#chi_dinh_'+number).data("assign","").empty();
        } 

    }  
    
}

function gradeI(status){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]"); 

    if(status==1){

        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i]; 
            var type=24; 
            var flag=4; 
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/"); 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            }      

            if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){    
                $("#matngoai-"+type+"-"+number).remove();   
                $("#mattrong-"+type+"-"+number).remove();  
                $("#matgan-"+type+"-"+number).remove();   
                $("#matxa-"+type+"-"+number).remove(); 
                $("#ketluan-"+type+"-"+number).remove(); 

                if (getLastCalculus(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }  

            }else{
                $("#matngoai-25-"+number).remove();   
                $("#mattrong-25-"+number).remove();  
                $("#matgan-25-"+number).remove();   
                $("#matxa-25-"+number).remove();
                $("#matngoai-26-"+number).remove();   
                $("#mattrong-26-"+number).remove();  
                $("#matgan-26-"+number).remove();   
                $("#matxa-26-"+number).remove();

                $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade1-'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade1-'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade1-'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade1-'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

                if (getLastCalculus(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Vôi răng</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Độ 1</i>');  
                }else {
                    var last = getLastCalculus(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Độ 1</i>');            
                } 
                
                $("#ketluan-25-"+number).remove();
                $("#ketluan-26-"+number).remove();        
          
            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            } 

        } 

    } 
    else if(status==2){

        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i];
            var type=28;
            var flag=5; 
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/"); 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty(); 
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            } 

            if ($("#matnhai-"+type+"-"+number).length > 0){    
                $("#matnhai-"+type+"-"+number).remove();
                $("#ketluan-"+type+"-"+number).remove();  

                if (getLastMobility(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }  

            }else{
                $("#matnhai-29-"+number).remove(); 
                $("#matnhai-30-"+number).remove(); 

                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mobility-img-grade1.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

                if (getLastMobility(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Lung lay</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Độ 1</i>');  
                }else {
                    var last = getLastMobility(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Độ 1</i>');            
                } 
            
                $("#ketluan-29-"+number).remove();
                $("#ketluan-30-"+number).remove();        

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); } 
                $('#chi_dinh_'+number).data("assign","").empty();
            } 

        }

    }  

}

function gradeII(status){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");        

    if(status==1){

        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i]; 
            var type=25;  
            var flag=4; 
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");  

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            }    

            if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number+"").length > 0 && $("#matgan-"+type+"-"+number+"").length > 0 && $("#matxa-"+type+"-"+number+"").length > 0){    
                $("#matngoai-"+type+"-"+number).remove();   
                $("#mattrong-"+type+"-"+number).remove();  
                $("#matgan-"+type+"-"+number).remove();   
                $("#matxa-"+type+"-"+number).remove();
                $("#ketluan-"+type+"-"+number).remove(); 

                if (getLastCalculus(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }  

            }else{
                $("#matngoai-24-"+number).remove();   
                $("#mattrong-24-"+number).remove();  
                $("#matgan-24-"+number).remove();   
                $("#matxa-24-"+number).remove(); 
                $("#matngoai-26-"+number).remove();   
                $("#mattrong-26-"+number).remove();  
                $("#matgan-26-"+number).remove();   
                $("#matxa-26-"+number).remove();

                $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade2-'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade2-'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade2-'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade2-'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

                if (getLastCalculus(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Vôi răng</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Độ 2</i>');  
                }else {
                    var last = getLastCalculus(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Độ 2</i>');            
                } 
            
                $("#ketluan-24-"+number).remove();
                $("#ketluan-26-"+number).remove();        

            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
                $('#chi_dinh_'+number).data("assign","").empty();
            } 
        }
    } 
    else if(status==2){

        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i]; 
            var type=29;
            var flag=5; 
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định'); 
            } 

            if ($("#matnhai-"+type+"-"+number).length > 0){    
                $("#matnhai-"+type+"-"+number).remove(); 
                $("#ketluan-"+type+"-"+number).remove();   

                if (getLastMobility(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                } 

            }else{
                $("#matnhai-28-"+number).remove(); 
                $("#matnhai-30-"+number).remove(); 

                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mobility-img-grade2.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                
                if (getLastMobility(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Lung lay</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Độ 2</i>');  
                }else {
                    var last = getLastMobility(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Độ 2</i>');            
                } 

                $("#ketluan-28-"+number).remove();
                $("#ketluan-30-"+number).remove();        
               
            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
                $('#chi_dinh_'+number).data("assign","").empty();
            } 

        }

    }  

}

function gradeIII(status){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]"); 
       

    if(status==1){

        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i];
            var type=26; 
            var flag=4; 
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/"); 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định');
            }        

            if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){    
                $("#matngoai-"+type+"-"+number).remove();   
                $("#mattrong-"+type+"-"+number).remove();  
                $("#matgan-"+type+"-"+number).remove();   
                $("#matxa-"+type+"-"+number).remove(); 

                $("#ketluan-"+type+"-"+number).remove();

                if (getLastCalculus(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                }  

            }else{
                $("#matngoai-24-"+number).remove();   
                $("#mattrong-24-"+number).remove();  
                $("#matgan-24-"+number).remove();   
                $("#matxa-24-"+number).remove(); 
                $("#matngoai-25-"+number).remove();   
                $("#mattrong-25-"+number).remove();  
                $("#matgan-25-"+number).remove();   
                $("#matxa-25-"+number).remove();

                $('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade3-'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade3-'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade3-'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade3-'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                
                if (getLastCalculus(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Vôi răng</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Độ 3</i>');  
                }else {
                    var last = getLastCalculus(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Độ 3</i>');            
                } 

                $("#ketluan-24-"+number).remove();
                $("#ketluan-25-"+number).remove();        
               
            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
                $('#chi_dinh_'+number).data("assign","").empty();
            } 
        }

    } 
    else if(status==2){

        for (var i = 0; i < data_array.length; i++) {

            var number = data_array[i];
            var type=30;
            var flag=5; 
            var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
            var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/"); 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
                if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty(); 
                $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
                $('#chi_dinh_'+number).html('Thêm chỉ định');
            } 

            if ($("#matnhai-"+type+"-"+number).length > 0){    
                $("#matnhai-"+type+"-"+number).remove(); 

                $("#ketluan-"+type+"-"+number).remove();  

                if (getLastMobility(number) == 0) {   
                    $("#muc-"+flag+"-"+number).remove();
                } 

            }else{
                $("#matnhai-28-"+number).remove(); 
                $("#matnhai-29-"+number).remove(); 

                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mobility-img-grade3.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

                if (getLastMobility(number) == 0) {   
                    $('#ket_luan_'+number).append('<i id="muc-'+flag+"-"+number+'"> Lung lay</i>');             
                    $("#muc-"+flag+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Độ 3</i>');  
                }else {
                    var last = getLastMobility(number);
                    $("#ketluan-"+last+"-"+number).after('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Độ 3</i>');            
                } 
            
                $("#ketluan-28-"+number).remove();
                $("#ketluan-29-"+number).remove();        
         
            } 

            if (checkSick(number) == 0 && checkStatus(number) == 0){
                $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
                $('#ket_luan_'+number).empty();
                if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
                $('#chi_dinh_'+number).data("assign","").empty();
            } 

        }

    }  

}

function residualCrown(){ 

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]"); 

    for (var i = 0; i < data_array.length; i++) {   

        var number = data_array[i];
        var type=6;   
        var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
        var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");  

        // lock residualCrown
        if (checkRestorationStatus(number) == 1 || checkDecay(number) == 1 || checkCrown(number) == 1 || checkCrownRoot(number) == 1){  
            return false;
        }
        // end lock residualCrown

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh); 
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        } 

        if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){    
            unlockAll();
            offOpacityZero();

            // fractured-root-residualCrown        
            if (checkResidualCrownRoot(type,number)){    
                $('#mat-ngoai').addClass('opacity-0'); 
                $('#mat-trong').addClass('opacity-0');          
                $('#mat_ngoai_'+number).prepend('<img id="matngoai-22-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/root'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).prepend('<img id="mattrong-22-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/root'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');     
            }// end fractured-root-residualCrown

            $("#matngoai-"+type+"-"+number).remove();   
            $("#mattrong-"+type+"-"+number).remove();  
            $("#matgan-"+type+"-"+number).remove();   
            $("#matxa-"+type+"-"+number).remove();  
            $("#ketluan-"+type+"-"+number).remove(); 

            if (checkResidualCrown(number) == 0) {   
                $("#muc-"+flag+"-"+number).remove();
            } 

        }// fractured-root-residualCrown
        else if(checkResidualCrownRoot(22,number) == 1){
            $("#matngoai-22-"+number).remove();    
            $("#mattrong-22-"+number).remove(); 
            $("#matgan-"+type+"-"+number).remove();   
            $("#matxa-"+type+"-"+number).remove(); 
            $('#mat-gan').removeClass('opacity-0'); 
            $('#mat-xa').removeClass('opacity-0');     
            $('#mat_ngoai_'+number).prepend('<img id="matngoai-22-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/root'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_trong_'+number).prepend('<img id="mattrong-22-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/root'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $("#ketluan-"+type+"-"+number).remove();      

            

        }// end fractured-root-residualCrown
        else{

            // fractured-root-residualCrown
            if (checkRoot(number) == 1){
                $("#matngoai-22-"+number).remove();  
                $("#mattrong-22-"+number).remove();
                $('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrownroot'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrownroot'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');      
            }// end fractured-root-residualCrown
            else{
                $('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
                $('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">'); 
            }       
            $('#mat_gan_'+number).prepend('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_xa_'+number).prepend('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');        
            $('#ket_luan_'+number).append('<i id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">Răng bể</i>');      
            lockOfResidualCrown();
            onOpacityZeroType1();
        }

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
            $('#chi_dinh_'+number).data("assign","").empty();
        }  

    }
       
}

function missingStatus(){

	var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");

    for (var i = 0; i < data_array.length; i++) {   

        var number = data_array[i];   
        var type=101;
        var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangmat/", "/rangACTIVE/");
        var rangmat  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangmat/"); 

        //lock missing
        if (checkSick(number) == 1 || checkRestorationStatus(number) == 1){  
            return false;
        }
        //end lock missing

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth",type).attr("src", rangmat); 
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>').append('<i id="ketluan-'+type+"-"+number+'" data-user="'+id_user+'">Răng mất</i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        } 

        if ($("#matnhai-"+type+"-"+number).length > 0 && $("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){ 
            unlockAll();
            offOpacityZero();
            $("#matnhai-"+type+"-"+number).remove();
            $("#matngoai-"+type+"-"+number).remove();   
            $("#mattrong-"+type+"-"+number).remove();  
            $("#matgan-"+type+"-"+number).remove();   
            $("#matxa-"+type+"-"+number).remove();  
            
        }else{
            lockOfMissing();
            onOpacityZero(); 
            $('#mat_nhai_'+number).prepend('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/missing'+number+'-matnhai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/missing'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/missing'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_gan_'+number).prepend('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/missing'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_xa_'+number).prepend('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/missing'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');        
                
        }  

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
            $('#chi_dinh_'+number).data("assign","").empty();
        } 

    }
}

function crownStatus(){

	var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");

    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i];    
        var type=103;    
        var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/ranggiacodinh/", "/rangACTIVE/");
        var ranggiacodinh  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/ranggiacodinh/"); 

        //lock crown status
        if (checkRestorationStatus(number) == 1){  
            return false;
        }
        //end lock crown status   

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth",type).attr("src", ranggiacodinh); 
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        } 

        if ($("#matnhai-"+type+"-"+number).length > 0 && $("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){ 
            unlockAll();
     
            $("#matnhai-"+type+"-"+number).remove();
            $("#matngoai-"+type+"-"+number).remove();   
            $("#mattrong-"+type+"-"+number).remove();  
            $("#matgan-"+type+"-"+number).remove();   
            $("#matxa-"+type+"-"+number).remove(); 

            $("#ketluan-"+type+"-"+number).remove();       
            
        }else{
            lockOfCrown();

             // fractured-crown-crown
            if(checkCrown(number) == 1){           
                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-matnhai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');        
            }// end fractured-crown-crown
            else{
                $('#mat_nhai_'+number).prepend('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-matnhai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            }
            
            $('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_gan_'+number).prepend('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_xa_'+number).prepend('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');        
                
             
            $('#ket_luan_'+number+' i:first-child').after('<i id="ketluan-'+type+"-"+number+'" data-user="'+id_user+'">Mão</i>');       
               

        }  

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
            $('#chi_dinh_'+number).data("assign","").empty();
        } 

    }
}

function ponticStatus(){

	var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");

    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i];  
        var type=104;
        var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/vitricauranggia/", "/rangACTIVE/");
        var vitricauranggia  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/vitricauranggia/"); 


        //lock pontic status
        if (checkRestorationStatus(number) == 1 || checkDecay(number) == 1 || checkToothache(number) == 1 || checkRoot(number) == 1 || checkCrownRoot(number) == 1 || checkCalculus(number) == 1){  
            return false;
        }
        //end lock pontic status 

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth",type).attr("src", vitricauranggia); 
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        } 

        if ($("#matnhai-"+type+"-"+number).length > 0 && $("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){ 
            unlockAll();
            offOpacityZero();    

            // fractured-crown-pontic
            if(checkCrown(number) == 1){           
                $('#mat-nhai').addClass('opacity-0');        
            }// end fractured-crown-pontic

            $("#matnhai-"+type+"-"+number).remove();
            $("#matngoai-"+type+"-"+number).remove();   
            $("#mattrong-"+type+"-"+number).remove();  
            $("#matgan-"+type+"-"+number).remove();   
            $("#matxa-"+type+"-"+number).remove();  

            $("#ketluan-"+type+"-"+number).remove();  
            
        }else{
            lockOfPontic();
            onOpacityZero();

            // fractured-crown-pontic
            if(checkCrown(number) == 1){           
                $('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-matnhai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');         
            }// end fractured-crown-pontic 
            else{
                $('#mat_nhai_'+number).prepend('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pontic'+number+'-matnhai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            } 
            $('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pontic'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pontic'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_gan_'+number).prepend('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pontic'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_xa_'+number).prepend('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pontic'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');        
                
            $('#ket_luan_'+number+' i:first-child').after('<i id="ketluan-'+type+"-"+number+'" data-user="'+id_user+'">Nhịp cầu</i>');    
        }  

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE); 
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
            $('#chi_dinh_'+number).data("assign","").empty();
        } 

    }
}

function residualRootStatus(){

	var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");

    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i]; 
        var type=105;
        var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
        var rangbenh  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/"); 


        //lock residualRoot status
        if (checkRestorationStatus(number) == 1 || checkDecay(number) == 1 || checkFractured(number) == 1){  
            return false;
        }
        //end lock residualRoot status  

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth",type).attr("src", rangbenh); 
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        } 

        if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){ 
            unlockAll();
            offOpacityZero();    


            $("#matngoai-"+type+"-"+number).remove();   
            $("#mattrong-"+type+"-"+number).remove();  
            $("#matgan-"+type+"-"+number).remove();   
            $("#matxa-"+type+"-"+number).remove();  

            $("#ketluan-"+type+"-"+number).remove();  
            
        }else{
            lockOfResidualRoot();
            onOpacityZeroType1();  
          
            $('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualroot'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
        	$('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualroot'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
        	$('#mat_gan_'+number).prepend('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualroot'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
        	$('#mat_xa_'+number).prepend('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualroot'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');    
             
            $('#ket_luan_'+number+' i:first-child').after('<i id="ketluan-'+type+"-"+number+'" data-user="'+id_user+'">Còn chân răng</i>');       
                
        }  

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
            $('#chi_dinh_'+number).data("assign","").empty();
        } 
    }
}

function implantStatus(){

	var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");

    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i];  
        var type=106;  
        var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangphuchoiIMPLANT/", "/rangACTIVE/");
        var rangphuchoiIMPLANT  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangphuchoiIMPLANT/"); 


        //lock implant status
        if (checkRestorationStatus(number) == 1 || checkDecay(number) == 1 || checkToothache(number) == 1 || checkRoot(number) == 1 || checkCrownRoot(number) == 1 || checkCalculus(number) == 1 || number == 18 || number == 28 || number == 38 || number == 48){  
            return false;
        }
        //end lock implant status 


        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth",type).attr("src", rangphuchoiIMPLANT);
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        } 

        if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){ 
            unlockAll();
            offOpacityZero();    

            // fractured-crown-implant
            if (checkCrown(number) == 1){
                $('#mat-nhai').addClass('opacity-0'); 
            }
            // end fractured-crown-implant

            $("#matngoai-"+type+"-"+number).remove();   
            $("#mattrong-"+type+"-"+number).remove();  
            $("#matgan-"+type+"-"+number).remove();   
            $("#matxa-"+type+"-"+number).remove();  

            $("#ketluan-"+type+"-"+number).remove(); 
            
        }else{
            lockOfImplant();
            onOpacityZeroType1();  

            // fractured-crown-implant
            if (checkCrown(number) == 1){
                $('#mat-nhai').addClass('opacity-0'); 
            }
            // end fractured-crown-implant
          
            $('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/implant'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/implant'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_gan_'+number).prepend('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/implant'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
            $('#mat_xa_'+number).prepend('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/implant'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');       
       
            $('#ket_luan_'+number+' i:first-child').after('<i id="ketluan-'+type+"-"+number+'" data-user="'+id_user+'">Implant</i>');    
                
        }  

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
            $('#chi_dinh_'+number).data("assign","").empty();
        } 
    }
}

function rangMocLech(){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");

    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i];  
        var type=116;  
        var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangyeu/", "/rangACTIVE/");
        var rangyeu  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangyeu/"); 
        
         


        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth",107).attr("src", rangyeu);
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        } 

        if ($("#matnhai-"+type+"-"+number).length > 0){ 
            unlockAll();           

            $("#matnhai-"+type+"-"+number).remove();             

            $("#ketluan-"+type+"-"+number).remove();  
            
        }else{
            lockOfRangMocLech();
         
            $('#mat_nhai_'+number).prepend('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/transparent.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');         
       
            $('#ket_luan_'+number+' i:first-child').after('<i id="ketluan-'+type+"-"+number+'" data-user="'+id_user+'">Răng mọc lệch</i>');    
                
        }  

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
            $('#chi_dinh_'+number).data("assign","").empty();
        } 
    } 
    
}

function rangMocNgam(){

    var id_user = $('#id_user').val();

    var string = $('#hidden_string_number').val();

    var data_array = JSON.parse("[" + string + "]");

    for (var i = 0; i < data_array.length; i++) {

        var number = data_array[i];  
        var type=117;  
        var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangyeu/", "/rangACTIVE/");
        var rangyeu  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangyeu/"); 
        
         


        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).attr("data-tooth",107).attr("src", rangyeu);
            if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
            $('#ket_luan_'+number).append('<i>Răng '+number+': </i>'); 
            $('#chi_dinh_'+number).html('Thêm chỉ định');
        } 

        if ($("#matnhai-"+type+"-"+number).length > 0){ 
            unlockAll();           

            $("#matnhai-"+type+"-"+number).remove();             

            $("#ketluan-"+type+"-"+number).remove();  
            
        }else{
            lockOfRangMocNgam();
         
            $('#mat_nhai_'+number).prepend('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/transparent.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');         
       
            $('#ket_luan_'+number+' i:first-child').after('<i id="ketluan-'+type+"-"+number+'" data-user="'+id_user+'">Răng mọc ngầm</i>');    
                
        }  

        if (checkSick(number) == 0 && checkStatus(number) == 0){
            $('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
            $('#ket_luan_'+number).empty();
            if( $("#ghi_chu_"+number).is(':empty') ) { }else{ $("#ket_luan_"+number).html('<i>Răng '+number+':</i>'); }
            $('#chi_dinh_'+number).data("assign","").empty();
        } 
    } 
    
}

/*End Sidenav*/
$('#table_treatment').click(function(){     
    $('#col-md-3').removeClass('col-md-3 col-lg-4').addClass('col-md-4 col-lg-5');
    $('#triangle').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top');
    $('.treatment').fadeToggle('fast');
});

$(document).mouseup(function (e)
{
    var container = $(".treatment");
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {    
        $('#col-md-3').removeClass('col-md-4 col-lg-5').addClass('col-md-3 col-lg-4');
        $('#triangle').removeClass('glyphicon-triangle-top').addClass('glyphicon-triangle-bottom');    
        container.hide();        
    }
     
});

$('#more1').click(function (e) {      
    $('#toggle_more1').fadeToggle('fast');
});

$(document).mouseup(function (e)
{
    var container = $("#toggle_more1");
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {   
        
        container.hide();        
    }
     
});

$('.tooth').contextmenu(function (e) {

    e.preventDefault();     

    $('#row_opacity').removeClass('opacity-0');
    var position = $( this ).position();  
    var title=$( this ).attr("title");  
    var ret = title.split(" ");
    var number = ret[1]; 

    var str_number =  $('#hidden_string_number').val();   
    var rangACTIVE = $(this).attr("src").replace("/rang/", "/rangACTIVE/"); 
    if(e.shiftKey) { 
        if(str_number){     
            if(checkElementExist(number)){
                $('#hidden_string_number').val(str_number+','+number);
                $(this).attr("src", rangACTIVE);
            }     
        }else{
            $('#hidden_string_number').val(str_number+number);
            $(this).attr("src", rangACTIVE);
        }
    }else{
        $('#hidden_string_number').val(number);  
        $(".tooth").each(function() {  
            if($(this).attr("src").indexOf("/rangACTIVE/") !== -1) { 
                var rang = $(this).attr("src").replace("/rangACTIVE/", "/rang/"); 
                $(this).attr("src", rang);
            }
        });                 
        $(this).attr("src", rangACTIVE);
    }

    var src1 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai-"+number+".png";
    var src2 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matngoai-"+number+".png";
    var src3 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mattrong-"+number+".png";
    var src4 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matgan-"+number+".png";
    var src5 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matxa-"+number+".png";   
    $('#toggle-dental').css({"top": position.top+25, "left": position.left+25});
    $('#tooth_number').html("- "+title+" -");
    $('#tooth_title').html("- "+title+" -");    

    var string = $('#hidden_string_number').val();

    $('.title_sidenav').html(string);

    var data_array = JSON.parse("[" + string + "]");
    
    for (var i = 0; i < data_array.length; i++) {  

        var number_array = data_array[i];   

        if (($("#mat_nhai_"+number_array).length > 0) && ($("#mat_ngoai_"+number_array).length > 0) && ($("#mat_trong_"+number_array).length > 0) && ($("#mat_gan_"+number_array).length > 0) && ($("#mat_xa_"+number_array).length > 0)){

        }else{
            $('#nhai').append('<div id="mat_nhai_'+number_array+'" class="mat"></div>');
            $('#ngoai').append('<div id="mat_ngoai_'+number_array+'" class="mat"></div>');
            $('#trong').append('<div id="mat_trong_'+number_array+'" class="mat"></div>');
            $('#gan').append('<div id="mat_gan_'+number_array+'" class="mat"></div>');
            $('#xa').append('<div id="mat_xa_'+number_array+'" class="mat"></div>'); 
        } 

        if (($("#ket_luan_"+number_array).length > 0) && ($("#ghi_chu_"+number_array).length > 0) && ($("#chi_dinh_"+number_array).length > 0)){
            
        }else{          
           
            $('#table_conclude').prepend('<tr><td id="ket_luan_'+number_array+'" class="ket"></td><td style="text-align:center;" id="ghi_chu_'+number_array+'" class="ghi" data-toggle="modal" data-target="#noteToothModal" data-number="'+number_array+'" data-note=""></td><td style="text-align:center;" id="chi_dinh_'+number_array+'" class="chi" data-toggle="modal" data-target="#assignModal" data-number="'+number_array+'" data-assign=""></td></tr>');                  
        } 

    }

    $('#hidden_number').val(number);
    $('#mat-nhai').attr("src", src1); 
    $('#mat-ngoai').attr("src", src2);
    $('#mat-trong').attr("src", src3);
    $('#mat-gan').attr("src", src4);
    $('#mat-xa').attr("src", src5);  
    $('.mat').addClass("hidden");
    $('#mat_nhai_'+number).removeClass("hidden");
    $('#mat_ngoai_'+number).removeClass("hidden");
    $('#mat_trong_'+number).removeClass("hidden");
    $('#mat_gan_'+number).removeClass("hidden");
    $('#mat_xa_'+number).removeClass("hidden");  
    $('#toggle-dental').fadeToggle('fast');
    unlockAll();
    offOpacityZero();  

    if (checkMissingStatus(number) == 1) {
        onOpacityZero(); 
        lockOfMissing();                             
    }else if (checkCrownStatus(number) == 1) {        
        lockOfCrown();                             
    }else if (checkPonticStatus(number) == 1) {
        onOpacityZero();  
        lockOfPontic();
    }else if (checkResidualRootStatus(number) == 1) {
        onOpacityZeroType1();
        lockOfResidualRoot();
    }else if (checkImplantStatus(number) == 1) {
        onOpacityZeroType1();
        lockOfImplant();
    }else if (checkResidualCrown(number) == 1) {
        onOpacityZeroType1();
        lockOfResidualCrown();
    }else if (checkRangMocLechStatus(number) == 1) {      
        lockOfRangMocLech();
    }else if (checkRangMocNgamStatus(number) == 1) {      
        lockOfRangMocNgam();
    }

    if (checkCrown(number) == 1) {
        $('#mat-nhai').addClass('opacity-0');
    }else if (checkRoot(number) == 1) {
        $('#mat-ngoai').addClass('opacity-0');
        $('#mat-trong').addClass('opacity-0');
    }else if (checkCrownRoot(number) == 1) {
        $('#mat-ngoai').addClass('opacity-0');
        $('#mat-trong').addClass('opacity-0');
    }       

    var note = $('#ghi_chu_'+number).html();

    if (note) {

        var note_split  = note.split(": ");
        var note        = note_split[1]; 
        $('#saveNote').attr('data-note', note);

    } else {

        $('#saveNote').attr('data-note', '');

    }    

    e.stopPropagation();    
});
$('.tooth').click(function (e) {  

    $('#row_opacity').removeClass('opacity-0');
    var title=$( this ).attr("title"); 
    var ret = title.split(" ");
    var number = ret[1];

    var str_number =  $('#hidden_string_number').val(); 
    var rangACTIVE = $(this).attr("src").replace("/rang/", "/rangACTIVE/"); 
    if(e.shiftKey) { 
        if(str_number){     
            if(checkElementExist(number)){
                $('#hidden_string_number').val(str_number+','+number);                    
                $(this).attr("src", rangACTIVE);
            }     
        }else{
            $('#hidden_string_number').val(str_number+number);           
            $(this).attr("src", rangACTIVE);
        }
    }else{
        $('#hidden_string_number').val(number);  
        $(".tooth").each(function() {  
            if($(this).attr("src").indexOf("/rangACTIVE/") !== -1) { 
                var rang = $(this).attr("src").replace("/rangACTIVE/", "/rang/"); 
                $(this).attr("src", rang);
            }
        });                 
        $(this).attr("src", rangACTIVE);
    }

    var src1 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai-"+number+".png";
    var src2 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matngoai-"+number+".png";
    var src3 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mattrong-"+number+".png";
    var src4 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matgan-"+number+".png";
    var src5 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matxa-"+number+".png";            
    $('#tooth_title').html("- "+title+" -");
 
    var string = $('#hidden_string_number').val();

    $('.title_sidenav').html(string);

    var data_array = JSON.parse("[" + string + "]");
    
    for (var i = 0; i < data_array.length; i++) {  

        var number_array = data_array[i];   

        if (($("#mat_nhai_"+number_array).length > 0) && ($("#mat_ngoai_"+number_array).length > 0) && ($("#mat_trong_"+number_array).length > 0) && ($("#mat_gan_"+number_array).length > 0) && ($("#mat_xa_"+number_array).length > 0)){

        }else{
            $('#nhai').append('<div id="mat_nhai_'+number_array+'" class="mat"></div>');
            $('#ngoai').append('<div id="mat_ngoai_'+number_array+'" class="mat"></div>');
            $('#trong').append('<div id="mat_trong_'+number_array+'" class="mat"></div>');
            $('#gan').append('<div id="mat_gan_'+number_array+'" class="mat"></div>');
            $('#xa').append('<div id="mat_xa_'+number_array+'" class="mat"></div>'); 
        } 

        // if (($("#ket_luan_"+number_array).length > 0) && ($("#ghi_chu_"+number_array).length > 0) && ($("#chi_dinh_"+number_array).length > 0)){
            
        // }else{          
           
        //     $('#table_conclude').prepend('<tr><td id="ket_luan_'+number_array+'" class="ket"></td><td style="text-align:center;" id="ghi_chu_'+number_array+'" class="ghi"></td><td style="text-align:center;" id="chi_dinh_'+number_array+'" class="chi" data-toggle="modal" data-target="#assignModal" data-number="'+number_array+'" data-assign=""></td></tr>');                                     
        // } 

    }

    $('#hidden_number').val(number);    
    $('#mat-nhai').attr("src", src1); 
    $('#mat-ngoai').attr("src", src2);
    $('#mat-trong').attr("src", src3);
    $('#mat-gan').attr("src", src4);
    $('#mat-xa').attr("src", src5);
    $('.mat').addClass("hidden");
    $('#mat_nhai_'+number).removeClass("hidden");
    $('#mat_ngoai_'+number).removeClass("hidden");
    $('#mat_trong_'+number).removeClass("hidden");
    $('#mat_gan_'+number).removeClass("hidden");
    $('#mat_xa_'+number).removeClass("hidden"); 
    offOpacityZero();  

    if (checkMissingStatus(number) == 1) {
        onOpacityZero();
        lockOfMissing();                              
    }else if (checkCrownStatus(number) == 1) {        
        lockOfCrown();                             
    }else if (checkPonticStatus(number) == 1) {
        onOpacityZero();  
        lockOfPontic();
    }else if (checkResidualRootStatus(number) == 1) {
        onOpacityZeroType1();
        lockOfResidualRoot();
    }else if (checkImplantStatus(number) == 1) {
        onOpacityZeroType1();
        lockOfImplant();
    }else if (checkResidualCrown(number) == 1) {
        onOpacityZeroType1();
        lockOfResidualCrown();
    }else if (checkRangMocLechStatus(number) == 1) {      
        lockOfRangMocLech();
    }else if (checkRangMocNgamStatus(number) == 1) {      
        lockOfRangMocNgam();
    }

    if (checkCrown(number) == 1) {        
        $('#mat-nhai').addClass('opacity-0');
    }else if (checkRoot(number) == 1) {
        $('#mat-ngoai').addClass('opacity-0');
        $('#mat-trong').addClass('opacity-0');
    }else if (checkCrownRoot(number) == 1) {
        $('#mat-ngoai').addClass('opacity-0');
        $('#mat-trong').addClass('opacity-0');
    }                                    
    

});

!function(source) {
    function extractor(query) {
        var result = /([^,]+)$/.exec(query);
        if(result && result[1])
            return result[1].trim();
        return '';
    }
    
    $('#txtAssign').typeahead({
        source: source,
        updater: function(item) {
            return this.$element.val().replace(/[^,]*$/,'')+item+',';
        },
        matcher: function (item) {
          var tquery = extractor(this.query);
          if(!tquery) return false;
          return ~item.toLowerCase().indexOf(tquery)
        },
        highlighter: function (item) {
          
          var query = extractor(this.query).replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
          return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
            return '<strong>' + match + '</strong>'
          })
        }
    });
    
}(["Nha chu - Cạo vôi","Nhổ răng","Tiểu phẫu","Trám","Nội nha","Phuc hình cố định","Phuc hình tháo lắp","Tẩy trắng răng","Implant","Chỉnh nha"]);

$('#assignModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('assign') // Extract info from data-* attributes
  var number = button.data('number') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-body input').val(number)
  modal.find('.modal-body textarea').val(recipient)
})


$('#noteToothModal').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget);

    if (button.attr('data-number')) {

        var number = button.data('number'); 
        
        var note   = button.data('note'); 
     
    } else { 

        var number = $('#hidden_number').val();

        var note   = $('#saveNote').attr("data-note");   

    }
    
    var modal = $(this);
    modal.find('.modal-body input').val(number)    
    modal.find('.modal-body textarea').val(note);

})

// var $set = $('img[data-tooth]');
// var len = $set.length;
// $set.each(function(index, element) {
//     var $this = $(this);
//     if (index == len - 1) {
//         $(this).click();
//     }
// });

$(document).mouseup(function (e)
{
    var container = $("#toggle-dental");
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {   
        
        container.hide();        
    }
     
});

function clickAddNewTreatment(){

   var id_mhg = $('#id_mhg').val();

   var id_customer = $('#id_customer').val(); 

   if (id_mhg == 0) {    

        $.ajax({
            type:'POST',
            url: baseUrl+'/itemsCustomers/Accounts/addNewTreatment',    
            data: {"id_customer":id_customer},   
            success:function(data){       

                $('#medical_record').html(data);

            },
            error: function(data){
            console.log("error");
            console.log(data);
            }
        }); 

   }

}

clickAddNewTreatment();

function unsetSessionAddPrescription(){

    $.ajax({
        type:'POST',
        url: baseUrl+'/itemsCustomers/Accounts/unsetSessionAddPrescription',    
        data: {},   
        success:function(data){ 

        },
        error: function(data){
        console.log("error");
        console.log(data);
        }
    });

}

function unsetSessionAddLab(){

    $.ajax({
        type:'POST',
        url: baseUrl+'/itemsCustomers/Accounts/unsetSessionAddLab',    
        data: {},   
        success:function(data){ 

        },
        error: function(data){
        console.log("error");
        console.log(data);
        }
    });

}

function set_null_ipt_id_mh(){ 

    unsetSessionAddPrescription();   

    unsetSessionAddLab();

    $("#treatment_process_title").html('Thêm Quá Trình Điều Trị');

    var evt = window.event || arguments.callee.caller.arguments[0];
    var elem = $('#add-treatment-process-blur')[0];   
    $(elem).fadeToggle(200,function(){});
    evt.stopPropagation();

    $("#id_medical_history").val('');  

    $("#id_cs_medical_history").val(''); 

    $("#id_cs_m3dical_history").val(''); 
}

// $('#reviewdate').on('dp.change', function(e){ 

//     var today = new Date();
//     var dd = today.getDate();
//     var mm = today.getMonth()+1; //January is 0!
//     var yyyy = today.getFullYear();

//     if(dd<10) {
//         dd='0'+dd
//     } 

//     if(mm<10) {
//         mm='0'+mm
//     }     

//     var today = mm+'/'+dd+'/'+yyyy;

//     var reviewdate_val = $("#reviewdate").val().substring(0, 10);;  
//     var split          = reviewdate_val.split("-");
//     var reviewdate     = split[1]+'/'+split[2]+'/'+split[0]; 

//     var date1 = new Date(today);
//     var date2 = new Date(reviewdate);
//     var timeDiff = Math.abs(date2.getTime() - date1.getTime());
//     var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 

//     $("#examination_after").val(diffDays);
    
// });

$('#prescriptionModal').on('hidden.bs.modal', function (e) {
    if ($('#add-treatment-process-blur').css('display') == 'none'){

        $('#frm-save-medical-history')[0].reset();
        $(".tooth_numbers").val('').trigger('change'); 
        $("#frm-prescription")[0].reset();
        CKEDITOR.instances.advise.setData("");
        $("#frm-lab")[0].reset();
        CKEDITOR.instances.n0te.setData(""); 
        $("#action-prescription").replaceWith(aClone.clone());
        $("#action-lab").replaceWith(aLabClone.clone());   
        $("#dntd").replaceWith(divClone.clone());           

    }
})

$('#labModal').on('hidden.bs.modal', function (e) {
    if ($('#add-treatment-process-blur').css('display') == 'none'){

        $('#frm-save-medical-history')[0].reset();
        $(".tooth_numbers").val('').trigger('change');
        $("#frm-prescription")[0].reset();
        CKEDITOR.instances.advise.setData("");
        $("#frm-lab")[0].reset();
        CKEDITOR.instances.n0te.setData("");
        $("#action-prescription").replaceWith(aClone.clone());
        $("#action-lab").replaceWith(aLabClone.clone());   
        $("#dntd").replaceWith(divClone.clone());           

    }
})

function viewPrescriptionAndLab(id,type){       

    var evt = window.event || arguments.callee.caller.arguments[0];
    if (type == 1) {
        $('#prescriptionModal').modal('show'); 
    }else{
        $('#labModal').modal('show'); 
    }       
    evt.stopPropagation();    

    jQuery.ajax({
        type:"POST",
        url: baseUrl+'/itemsCustomers/Accounts/view_frm_treatment',
        data:{
            id  : id,
        },
        success:function(data){ 
            var getData = $.parseJSON(data);           
            if(getData){                
                $("#id_medical_history").val(getData.id);
                $("#id_cs_medical_history").val(getData.id);
                $("#id_cs_m3dical_history").val(getData.id);
                $("#id_dentist").val(getData.id_dentist);                 
                $("#medicalhistoryToothNumber").val(getData.tooth_number);                  

                $('#containerTreatment').html('');
                var listTreatmentWork = getData.listTreatmentWork;   
                var data_treatment    = 0;
                $.each(listTreatmentWork, function(i, item) {     

                    data_treatment = parseInt(i);                                                           
                    if (data_treatment == 0) {                        

                        $('#containerTreatment').append($('<div data-treatment="'+data_treatment+'">')

                            .append($('<div class="col-md-6">')

                                .append('<label class="control-label">Số răng:</label>')

                                .append($('<select name="tooth_numbers['+data_treatment+'][]" class="form-control tooth_numbers" multiple style="width: 100%;padding:2px 12px;">') 
                                    .append('<option value="11">11</option>')               
                                    .append('<option value="12">12</option>')
                                    .append('<option value="13">13</option>')
                                    .append('<option value="14">14</option>')
                                    .append('<option value="15">15</option>')
                                    .append('<option value="16">16</option>')
                                    .append('<option value="17">17</option>')
                                    .append('<option value="18">18</option>')
                                    .append('<option value="21">21</option>')
                                    .append('<option value="22">22</option>')
                                    .append('<option value="23">23</option>')
                                    .append('<option value="24">24</option>')
                                    .append('<option value="25">25</option>')
                                    .append('<option value="26">26</option>')
                                    .append('<option value="27">27</option>')
                                    .append('<option value="28">28</option>')
                                    .append('<option value="31">31</option>')
                                    .append('<option value="32">32</option>')
                                    .append('<option value="33">33</option>')
                                    .append('<option value="34">34</option>')
                                    .append('<option value="35">35</option>')
                                    .append('<option value="36">36</option>')
                                    .append('<option value="37">37</option>')
                                    .append('<option value="38">38</option>')
                                    .append('<option value="41">41</option>')
                                    .append('<option value="42">42</option>')
                                    .append('<option value="43">43</option>')
                                    .append('<option value="44">44</option>')
                                    .append('<option value="45">45</option>')
                                    .append('<option value="46">46</option>')
                                    .append('<option value="47">47</option>')
                                    .append('<option value="48">48</option>')
                                    .append('<option value="51">51</option>')  
                                    .append('<option value="52">52</option>') 
                                    .append('<option value="53">53</option>') 
                                    .append('<option value="54">54</option>') 
                                    .append('<option value="55">55</option>')
                                    .append('<option value="61">61</option>')  
                                    .append('<option value="62">62</option>') 
                                    .append('<option value="63">63</option>') 
                                    .append('<option value="64">64</option>') 
                                    .append('<option value="65">65</option>')
                                    .append('<option value="71">71</option>')  
                                    .append('<option value="72">72</option>') 
                                    .append('<option value="73">73</option>') 
                                    .append('<option value="74">74</option>') 
                                    .append('<option value="75">75</option>')
                                    .append('<option value="81">81</option>')  
                                    .append('<option value="82">82</option>') 
                                    .append('<option value="83">83</option>') 
                                    .append('<option value="84">84</option>') 
                                    .append('<option value="85">85</option>')   
                                )                               

                            )   

                            .append($('<div class="col-md-6 margin-bottom-15">')

                                .append('<label class="control-label">Công tác điều trị:</label>')

                                .append('<textarea required class="form-control" name="treatment_work[]" rows="3" placeholder="Công tác điều trị">'+listTreatmentWork[i].treatment_work+'</textarea>')             

                            )   

                        ); 

                        $(".tooth_numbers").select2({
                            placeholder: "Số răng",
                            allowClear: true      
                        }); 

                        if (listTreatmentWork[i].tooth_numbers) {   
                            var selectedValues = listTreatmentWork[i].tooth_numbers.split(','); 
                             $('#frm-save-medical-history select[name="tooth_numbers['+data_treatment+'][]"]').val(selectedValues).trigger("change");
                        }   

                    }else {

                        $('#containerTreatment').append($('<div data-treatment="'+data_treatment+'">')

                            .append($('<div class="col-md-6">')

                                .append('<label class="control-label">Số răng:</label>')

                                .append($('<select name="tooth_numbers['+data_treatment+'][]" class="form-control tooth_numbers" multiple style="width: 100%;padding:2px 12px;">') 
                                    .append('<option value="11">11</option>')               
                                    .append('<option value="12">12</option>')
                                    .append('<option value="13">13</option>')
                                    .append('<option value="14">14</option>')
                                    .append('<option value="15">15</option>')
                                    .append('<option value="16">16</option>')
                                    .append('<option value="17">17</option>')
                                    .append('<option value="18">18</option>')
                                    .append('<option value="21">21</option>')
                                    .append('<option value="22">22</option>')
                                    .append('<option value="23">23</option>')
                                    .append('<option value="24">24</option>')
                                    .append('<option value="25">25</option>')
                                    .append('<option value="26">26</option>')
                                    .append('<option value="27">27</option>')
                                    .append('<option value="28">28</option>')
                                    .append('<option value="31">31</option>')
                                    .append('<option value="32">32</option>')
                                    .append('<option value="33">33</option>')
                                    .append('<option value="34">34</option>')
                                    .append('<option value="35">35</option>')
                                    .append('<option value="36">36</option>')
                                    .append('<option value="37">37</option>')
                                    .append('<option value="38">38</option>')
                                    .append('<option value="41">41</option>')
                                    .append('<option value="42">42</option>')
                                    .append('<option value="43">43</option>')
                                    .append('<option value="44">44</option>')
                                    .append('<option value="45">45</option>')
                                    .append('<option value="46">46</option>')
                                    .append('<option value="47">47</option>')
                                    .append('<option value="48">48</option>')
                                    .append('<option value="51">51</option>')  
                                    .append('<option value="52">52</option>') 
                                    .append('<option value="53">53</option>') 
                                    .append('<option value="54">54</option>') 
                                    .append('<option value="55">55</option>')
                                    .append('<option value="61">61</option>')  
                                    .append('<option value="62">62</option>') 
                                    .append('<option value="63">63</option>') 
                                    .append('<option value="64">64</option>') 
                                    .append('<option value="65">65</option>')
                                    .append('<option value="71">71</option>')  
                                    .append('<option value="72">72</option>') 
                                    .append('<option value="73">73</option>') 
                                    .append('<option value="74">74</option>') 
                                    .append('<option value="75">75</option>')
                                    .append('<option value="81">81</option>')  
                                    .append('<option value="82">82</option>') 
                                    .append('<option value="83">83</option>') 
                                    .append('<option value="84">84</option>') 
                                    .append('<option value="85">85</option>')    
                                )

                                .append($('<button onclick="removeTreatment('+data_treatment+');" class="btn sbtnAdd">')
                                    .append('<span class="glyphicon glyphicon-minus"></span>')
                                )

                            )   

                            .append($('<div class="col-md-6 margin-bottom-15">')

                                .append('<label class="control-label">Công tác điều trị:</label>')

                                .append('<textarea required class="form-control" name="treatment_work[]" rows="3" placeholder="Công tác điều trị">'+listTreatmentWork[i].treatment_work+'</textarea>')             

                            )   

                        ); 

                        $(".tooth_numbers").select2({
                            placeholder: "Số răng",
                            allowClear: true      
                        }); 

                        if (listTreatmentWork[i].tooth_numbers) {   
                            var selectedValues = listTreatmentWork[i].tooth_numbers.split(','); 
                            $('#frm-save-medical-history select[name="tooth_numbers['+data_treatment+'][]"]').val(selectedValues).trigger("change");
                        } 

                    }
                });   

                // $("#description").val(getData.description);                   
                // $("#length_time").val(getData.length_time); 
                $("#medicine_during_treatment").val(getData.medicine_during_treatment);
                // if (getData.reviewdate != '0000-00-00 00:00:00') {                                   
                //     $("#reviewdate").val(getData.reviewdate);    
                // }    
                if (getData.diagnose != null) {
                    $("#action-prescription").html('Xem toa thuốc');
                    $(".print").css('background-color','#94c63f'); 
                }
                //***********thêm button xóa toa thuốc *************//
                if (getData.id_prescription != null) {
                    $("#cancelPrescription").html('<button type="button" class="btn btn-danger" onclick="deletePrescription('+getData.id_prescription+')">'+
                                                        'Xóa toa thuốc </button>');
                }else if(getData.id_prescription == null){
                    $("#cancelPrescription").html('');
                }
                //***********thêm button xóa labo *************//
                if (getData.id_labo != null) {
                    $("#cancelLaob").html('<button type="button" class="btn btn-danger" onclick="deleteLabo('+getData.id_labo+')">'+
                                                        'Xóa labo </button>');
                }else if(getData.id_labo == null){
                    $("#cancelLaob").html('');
                }

                if (getData.id_branch != null) { 
                    $("#action-lab").html('Xem lab'); 
                    $(".print_lab").css('background-color','#94c63f');
                    var sent_date     = getData.sent_date.substr(0,10); 
                    var received_date = getData.received_date.substr(0,10); 
                    $("#sent_date").val(sent_date);
                    $("#received_date").val(received_date);
                }         
                $("#diagnose").val(getData.diagnose);
                CKEDITOR.instances['advise'].setData(getData.advise);   
                $("#examination_after").val(getData.examination_after); 
                //List Drug And Usage
                if(getData.listDrugAndUsage != ''){  
                    var listDrugAndUsage = getData.listDrugAndUsage; 
                    var str = '';
                    var data_drug = 1;
                    $.each(listDrugAndUsage, function(i, item) {     
                        data_drug = data_drug + parseInt(i);                                                           
                        if (data_drug == 1) {
                            str = str+'<div data-drug="'+data_drug+'"><div class="input-group"><span class="input-group-addon spn-dots">'+data_drug+'.</span><input required type="text" class="form-control ipt-dots" name="drug_name[]" value="'+listDrugAndUsage[i].drug_name+'"></div><div class="input-group"><span class="input-group-addon dots spn-dots">Ngày</span><input required type="number" class="form-control ipt-dots" name="times[]" value="'+listDrugAndUsage[i].times+'"><span class="input-group-addon dots spn-dots">lần, mỗi lần:</span><input required type="text" class="form-control ipt-dots" name="dosage[]" value="'+listDrugAndUsage[i].dosage+'"></div></div>';
                        }else {
                            str = str+'<div data-drug="'+data_drug+'"><div class="input-group"><span class="input-group-addon spn-dots">'+data_drug+'.</span><input required type="text" class="form-control ipt-dots" name="drug_name[]" value="'+listDrugAndUsage[i].drug_name+'"></div><div class="input-group"><span class="input-group-addon dots spn-dots">Ngày</span><input required type="number" class="form-control ipt-dots" name="times[]" value="'+listDrugAndUsage[i].times+'"><span class="input-group-addon dots spn-dots">lần, mỗi lần:</span><input required type="text" class="form-control ipt-dots" name="dosage[]" value="'+listDrugAndUsage[i].dosage+'"><div class="input-group-addon dots spn-dots"><button onclick="minusDelete('+data_drug+');" class="btn sbtnAdd"><span class="glyphicon glyphicon-minus"></span></button></div></div></div>';
                        }
                    });
                    $('#dntd').html(str);
                }
                //End List Drug And Usage
                $("#id_br4nch").val(getData.id_branch);
                $("#id_d3ntist").val(getData.id_d3ntist);                
                $("#assign").val(getData.assign);
                CKEDITOR.instances['n0te'].setData(getData.note);  
                                      
            }
        },
        error: function(data){ 
            alert("Error occured.Please try again!");
        },
    });
}

function view_frm_treatment(id){   

    $("#treatment_process_title").html('Cập Nhật Quá Trình Điều Trị');

    var evt = window.event || arguments.callee.caller.arguments[0];
    var elem = $('#add-treatment-process-blur')[0];
    $(elem).fadeToggle(200,function(){});
    evt.stopPropagation();

    jQuery.ajax({
        type:"POST",
        url: baseUrl+'/itemsCustomers/Accounts/view_frm_treatment',
        data:{
            id  : id,
        },
        success:function(data){ 
            // console.log(data);
            // return;
            var getData = $.parseJSON(data);           
            if(getData){                
                $("#id_medical_history").val(getData.id);
                $("#id_cs_medical_history").val(getData.id);
                $("#id_cs_m3dical_history").val(getData.id);
                $("#id_dentist").val(getData.id_dentist);

                $('#containerTreatment').html('');
                $('#newest_schedule').val(getData.newest_schedule);
                var listTreatmentWork = getData.listTreatmentWork;                      
                var data_treatment    = 0;
                $.each(listTreatmentWork, function(i, item) {     
                  
                    data_treatment = parseInt(i);                                                           
                    if (data_treatment == 0) {                        

                        $('#containerTreatment').append($('<div data-treatment="'+data_treatment+'">')

                            .append($('<div class="col-md-6">')

                                .append('<label class="control-label">Số răng:</label>')

                                .append($('<select name="tooth_numbers['+data_treatment+'][]" class="form-control tooth_numbers" multiple style="width: 100%;padding:2px 12px;">') 
                                    .append('<option value="11">11</option>')               
                                    .append('<option value="12">12</option>')
                                    .append('<option value="13">13</option>')
                                    .append('<option value="14">14</option>')
                                    .append('<option value="15">15</option>')
                                    .append('<option value="16">16</option>')
                                    .append('<option value="17">17</option>')
                                    .append('<option value="18">18</option>')
                                    .append('<option value="21">21</option>')
                                    .append('<option value="22">22</option>')
                                    .append('<option value="23">23</option>')
                                    .append('<option value="24">24</option>')
                                    .append('<option value="25">25</option>')
                                    .append('<option value="26">26</option>')
                                    .append('<option value="27">27</option>')
                                    .append('<option value="28">28</option>')
                                    .append('<option value="31">31</option>')
                                    .append('<option value="32">32</option>')
                                    .append('<option value="33">33</option>')
                                    .append('<option value="34">34</option>')
                                    .append('<option value="35">35</option>')
                                    .append('<option value="36">36</option>')
                                    .append('<option value="37">37</option>')
                                    .append('<option value="38">38</option>')
                                    .append('<option value="41">41</option>')
                                    .append('<option value="42">42</option>')
                                    .append('<option value="43">43</option>')
                                    .append('<option value="44">44</option>')
                                    .append('<option value="45">45</option>')
                                    .append('<option value="46">46</option>')
                                    .append('<option value="47">47</option>')
                                    .append('<option value="48">48</option>')   
                                    .append('<option value="51">51</option>')  
                                    .append('<option value="52">52</option>') 
                                    .append('<option value="53">53</option>') 
                                    .append('<option value="54">54</option>') 
                                    .append('<option value="55">55</option>')
                                    .append('<option value="61">61</option>')  
                                    .append('<option value="62">62</option>') 
                                    .append('<option value="63">63</option>') 
                                    .append('<option value="64">64</option>') 
                                    .append('<option value="65">65</option>')
                                    .append('<option value="71">71</option>')  
                                    .append('<option value="72">72</option>') 
                                    .append('<option value="73">73</option>') 
                                    .append('<option value="74">74</option>') 
                                    .append('<option value="75">75</option>')
                                    .append('<option value="81">81</option>')  
                                    .append('<option value="82">82</option>') 
                                    .append('<option value="83">83</option>') 
                                    .append('<option value="84">84</option>') 
                                    .append('<option value="85">85</option>')
                                )                               

                            )   

                            .append($('<div class="col-md-6 margin-bottom-15">')

                                .append('<label class="control-label">Công tác điều trị:</label>')

                                .append('<textarea required class="form-control" name="treatment_work[]" rows="3" placeholder="Công tác điều trị">'+listTreatmentWork[i].treatment_work+'</textarea>')             

                            )   

                        ); 

                        $(".tooth_numbers").select2({
                            placeholder: "Số răng",
                            allowClear: true      
                        }); 

                        if (listTreatmentWork[i].tooth_numbers) {   
                            var selectedValues = listTreatmentWork[i].tooth_numbers.split(','); 
                             $('#frm-save-medical-history select[name="tooth_numbers['+data_treatment+'][]"]').val(selectedValues).trigger("change");
                        }   

                    }else {

                        $('#containerTreatment').append($('<div data-treatment="'+data_treatment+'">')

                            .append($('<div class="col-md-6">')

                                .append('<label class="control-label">Số răng:</label>')

                                .append($('<select name="tooth_numbers['+data_treatment+'][]" class="form-control tooth_numbers" multiple style="width: 100%;padding:2px 12px;">') 
                                    .append('<option value="11">11</option>')               
                                    .append('<option value="12">12</option>')
                                    .append('<option value="13">13</option>')
                                    .append('<option value="14">14</option>')
                                    .append('<option value="15">15</option>')
                                    .append('<option value="16">16</option>')
                                    .append('<option value="17">17</option>')
                                    .append('<option value="18">18</option>')
                                    .append('<option value="21">21</option>')
                                    .append('<option value="22">22</option>')
                                    .append('<option value="23">23</option>')
                                    .append('<option value="24">24</option>')
                                    .append('<option value="25">25</option>')
                                    .append('<option value="26">26</option>')
                                    .append('<option value="27">27</option>')
                                    .append('<option value="28">28</option>')
                                    .append('<option value="31">31</option>')
                                    .append('<option value="32">32</option>')
                                    .append('<option value="33">33</option>')
                                    .append('<option value="34">34</option>')
                                    .append('<option value="35">35</option>')
                                    .append('<option value="36">36</option>')
                                    .append('<option value="37">37</option>')
                                    .append('<option value="38">38</option>')
                                    .append('<option value="41">41</option>')
                                    .append('<option value="42">42</option>')
                                    .append('<option value="43">43</option>')
                                    .append('<option value="44">44</option>')
                                    .append('<option value="45">45</option>')
                                    .append('<option value="46">46</option>')
                                    .append('<option value="47">47</option>')
                                    .append('<option value="48">48</option>')  
                                    .append('<option value="51">51</option>')  
                                    .append('<option value="52">52</option>') 
                                    .append('<option value="53">53</option>') 
                                    .append('<option value="54">54</option>') 
                                    .append('<option value="55">55</option>')
                                    .append('<option value="61">61</option>')  
                                    .append('<option value="62">62</option>') 
                                    .append('<option value="63">63</option>') 
                                    .append('<option value="64">64</option>') 
                                    .append('<option value="65">65</option>')
                                    .append('<option value="71">71</option>')  
                                    .append('<option value="72">72</option>') 
                                    .append('<option value="73">73</option>') 
                                    .append('<option value="74">74</option>') 
                                    .append('<option value="75">75</option>')
                                    .append('<option value="81">81</option>')  
                                    .append('<option value="82">82</option>') 
                                    .append('<option value="83">83</option>') 
                                    .append('<option value="84">84</option>') 
                                    .append('<option value="85">85</option>')  
                                )

                                .append($('<button onclick="removeTreatment('+data_treatment+');" class="btn sbtnAdd">')
                                    .append('<span class="glyphicon glyphicon-minus"></span>')
                                )

                            )   

                            .append($('<div class="col-md-6 margin-bottom-15">')

                                .append('<label class="control-label">Công tác điều trị:</label>')

                                .append('<textarea required class="form-control" name="treatment_work[]" rows="3" placeholder="Công tác điều trị">'+listTreatmentWork[i].treatment_work+'</textarea>')             

                            )   

                        ); 

                        $(".tooth_numbers").select2({
                            placeholder: "Số răng",
                            allowClear: true      
                        }); 

                        if (listTreatmentWork[i].tooth_numbers) {   
                            var selectedValues = listTreatmentWork[i].tooth_numbers.split(','); 
                            $('#frm-save-medical-history select[name="tooth_numbers['+data_treatment+'][]"]').val(selectedValues).trigger("change");
                        } 

                    }
                });                

                // $("#description").val(getData.description);                   
                // $("#length_time").val(getData.length_time); 
                $("#medicine_during_treatment").val(getData.medicine_during_treatment);
                // if (getData.reviewdate != '0000-00-00 00:00:00') {                                   
                //     $("#reviewdate").val(getData.reviewdate);    
                // }    
                if (getData.diagnose != null) {
                    $("#action-prescription").html('Xem toa thuốc');
                    $(".print").css('background-color','#94c63f');    
                }

                //***********thêm button xóa toa thuốc *************//
                if (getData.id_prescription != null) {
                    $("#cancelPrescription").html('<button type="button" class="btn btn-danger" onclick="deletePrescription('+getData.id_prescription+')">'+
                                                        'Xóa toa thuốc </button>');
                }else if(getData.id_prescription == null){
                    $("#cancelPrescription").html('');
                }
                //***********thêm button xóa labo *************//
                if (getData.id_labo != null) {
                    $("#cancelLaob").html('<button type="button" class="btn btn-danger" onclick="deleteLabo('+getData.id_labo+')">'+
                                                        'Xóa labo </button>');
                }else if(getData.id_labo == null){
                    $("#cancelLaob").html('');
                }

                if (getData.id_branch != null) { 
                    $("#action-lab").html('Xem lab'); 
                    $(".print_lab").css('background-color','#94c63f');
                    var sent_date     = getData.sent_date.substr(0,10); 
                    var received_date = getData.received_date.substr(0,10); 
                    $("#sent_date").val(sent_date);
                    $("#received_date").val(received_date);
                }         
                $("#diagnose").val(getData.diagnose);
                CKEDITOR.instances['advise'].setData(getData.advise);   
                $("#examination_after").val(getData.examination_after); 
                //List Drug And Usage
                if(getData.listDrugAndUsage != ''){  
                    var listDrugAndUsage = getData.listDrugAndUsage; 
                    var str = '';
                    var data_drug = 1;
                    $.each(listDrugAndUsage, function(i, item) {     
                        data_drug = data_drug + parseInt(i);                                                           
                        if (data_drug == 1) {
                            str = str+'<div data-drug="'+data_drug+'"><div class="input-group"><span class="input-group-addon spn-dots">'+data_drug+'.</span><input required type="text" class="form-control ipt-dots" name="drug_name[]" value="'+listDrugAndUsage[i].drug_name+'"></div><div class="input-group"><span class="input-group-addon dots spn-dots">Ngày</span><input required type="number" class="form-control ipt-dots" name="times[]" value="'+listDrugAndUsage[i].times+'"><span class="input-group-addon dots spn-dots">lần, mỗi lần:</span><input required type="text" class="form-control ipt-dots" name="dosage[]" value="'+listDrugAndUsage[i].dosage+'"></div></div>';
                        }else {
                            str = str+'<div data-drug="'+data_drug+'"><div class="input-group"><span class="input-group-addon spn-dots">'+data_drug+'.</span><input required type="text" class="form-control ipt-dots" name="drug_name[]" value="'+listDrugAndUsage[i].drug_name+'"></div><div class="input-group"><span class="input-group-addon dots spn-dots">Ngày</span><input required type="number" class="form-control ipt-dots" name="times[]" value="'+listDrugAndUsage[i].times+'"><span class="input-group-addon dots spn-dots">lần, mỗi lần:</span><input required type="text" class="form-control ipt-dots" name="dosage[]" value="'+listDrugAndUsage[i].dosage+'"><div class="input-group-addon dots spn-dots"><button onclick="minusDelete('+data_drug+');" class="btn sbtnAdd"><span class="glyphicon glyphicon-minus"></span></button></div></div></div>';
                        }
                    });
                    $('#dntd').html(str);
                }
                //End List Drug And Usage
                $("#id_br4nch").val(getData.id_branch);
                $("#id_d3ntist").val(getData.id_d3ntist);                
                $("#assign").val(getData.assign);
                CKEDITOR.instances['n0te'].setData(getData.note);  
                //thêm ngày tạo
                $("#createdate").val(getData.createdate_cs_medical_history); 
                $("#reviewdate").val(getData.reviewdate); 
                $("#description").val(getData.description); 
                                      
            }
        },
        error: function(data){ 
            alert("Error occured.Please try again!");
        },
    });
}


$('#frm-treatment').submit(function(e) {

    $('.cal-loading').fadeIn('fast');

    e.preventDefault();
    var formData = new FormData($("#frm-treatment")[0]);
    formData.append('id_customer',$('#id_customer').val());
    formData.append('id_mhg',$('#id_mhg').val());
    if (!formData.checkValidity || formData.checkValidity()) {
        jQuery.ajax({           
            type:"POST",
            url: baseUrl+'/itemsCustomers/Accounts/addNewMedicalHistory',   
            data:formData,
            datatype:'json',
            success:function(data){  
 
                e.stopPropagation(); 

                $('#medical_record').html(data);

                $('.cal-loading').fadeOut('slow');
         
            },
            error: function(data) {
                alert("Error occured. Please try again!");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    return false;
});

$('#edit_info').click(function (e) { 

    $('.cal-loading').fadeIn('fast');

    var id_customer = $('#id_customer').val();  
    var id_mhg = $('#id_mhg').val(); 

    $.ajax({
        type:'POST',
        url: baseUrl+'/itemsCustomers/Accounts/editMedicalHistory',    
        data: {"id_customer":id_customer,"id_mhg":id_mhg},   
        success:function(data){       

            $('#frm-treatment').html(data);

            $('.cal-loading').fadeOut('slow');
        },
        error: function(data){
        console.log("error");
        console.log(data);
        }
    });

});

function saveDentalStatusImage(){
    html2canvas($("#dental_status_image"), {       
        onrendered: function(canvas) {    

            var img = canvas.toDataURL("image/png");
            var output = encodeURIComponent(img);
            var id_mhg = $('#id_mhg').val(); 
            var Parameters = "image=" + output + "&code_number=" + <?php echo $model->code_number;?> + "&id_mhg=" + id_mhg;

            $.ajax({
                type: "POST",
                url: baseUrl+'/itemsCustomers/Accounts/saveDentalStatusImage',
                data: Parameters, 
                success : function(data)
                {
                    console.log("screenshot done");
                }
            });
            
        },
       
    });
}

$('#save').click(function (e) { 

    var dental_status_change = $('#dental_status_change').val();

    if (dental_status_change == 1) {

        $('.cal-loading').fadeIn('fast'); 

        $('.statsTabContent').animate({
            scrollTop: 457
        }, 0);     

        var id_customer    = $('#id_customer').val();   
        var id_mhg         = $('#id_mhg').val(); 
        var tooth_data     = [];
        var tooth_image    = [];
        var tooth_conclude = [];
        var tooth_note     = [];        
        var tooth_assign     = []; 

        $(".tooth").each(function() {  
            if($(this).attr("data-tooth")) { 
                var title=$(this).attr("title"); 
                var ret = title.split(" ");
                var number = ret[1]; 
                var response = {};
                response['tooth_number'] = number; 
                response['tooth_data'] = $(this).attr("data-tooth");        
                tooth_data.push(response);  
            }

            if($(this).attr("src").indexOf("/rangACTIVE/") !== -1) {                    
                var rang = $(this).attr("src").replace("/rangACTIVE/", "/rang/"); 
                $(this).attr("src", rang);
            }

        });
        
        $(".mat img").each(function() { 
            var tit=$(this).attr("id"); 
            var re = tit.split("-");        
            var num = re[2];   
            var res = {};
            res['tooth_number'] = num; 
            res['id_image']     = tit;        
            res['src_image']    = $(this).attr("src").replace(/^.*[\\\/]/, '');  
            res['type_image']   = re[0]; 
            res['style_image']  = $(this).attr("style");    
            tooth_image.push(res);
        });

        $(".ket i").each(function() {   
            if($(this).attr("id")) {       
                var id_i = $(this).attr("id"); 
                var r_i  = id_i.split("-"); 
                if (r_i[0] == "ketluan") {          
	                var rp_i = {};
	                rp_i['tooth_number'] = r_i[2];    
	                rp_i['id_i']         = id_i;     
	                rp_i['conclude']     = $(this).html();  
	                rp_i['id_user']      = $(this).attr("data-user");             
	                tooth_conclude.push(rp_i);  
	            }
            }          
        }); 

        $(".ghi").each(function() {      
        	if($(this).html()) {      
	            var id=$(this).attr("id"); 
	            var r = id.split("_"); 
	            var note = $(this).html();
	            if (note != "") {
	                var split_note = note.split(":");
	                note           = split_note[1]; 
	            }
	            var rp = {};
	            rp['tooth_number']  = r[2];       
	            rp['note']          = note;    
	            tooth_note.push(rp);     
	        }       
        });

        $(".chi").each(function() {  
        	if($(this).data("assign")) {       
	            var id_a=$(this).attr("id"); 
	            var s_a = id_a.split("_");    
	            var ta = {};
	            ta['tooth_number']  = s_a[2];       
	            ta['assign']          = $(this).data("assign");    
	            tooth_assign.push(ta);     
	        }       
        });

        saveDentalStatusImage();        
     
        $.ajax({
            type:'POST',
            url: baseUrl+'/itemsCustomers/Accounts/addDentalStatus',    
            data: {"id_customer":id_customer,"id_mhg":id_mhg,"tooth_data":JSON.stringify(tooth_data),"tooth_image":JSON.stringify(tooth_image),"tooth_conclude":JSON.stringify(tooth_conclude),"tooth_note":JSON.stringify(tooth_note),"tooth_assign":JSON.stringify(tooth_assign)},   
            success:function(data){                    
       
                $('#medical_record').html(data); 

                $('.cal-loading').fadeOut('slow');
                              
            },           
            error: function(data){
            console.log("error");
            console.log(data);
            }
        });

    }    

});

function checkExistUniversalKid(){ 
 
    var numbers = [51, 52, 53, 54, 55, 61, 62, 63, 64, 65, 71, 72, 73, 74, 75, 81, 82, 83, 84, 85];

    for (var i = 0; i < numbers.length; i++) {

        if (checkSick(numbers[i]) == 1 || checkStatus(numbers[i]) == 1) {

            showUniversalKid();
            
            break;
            
        }

    }       

}

checkExistUniversalKid();

$('#table_conclude').bind("DOMSubtreeModified",function(){
    var imageUrl='../../images/medical_record/more_icon/sale_3.png';

    $('#dental_status_change').val('1');
    $('#save').css('background-image', 'url(' + imageUrl + ')');
});

function checkExistImage(){ 
    var image_dental_status_change = $('#image_dental_status_change').val(); 
    if (image_dental_status_change == 1) {

        var imageUrl='../../images/medical_record/more_icon/draw_2.png';
        $('#draw').css('background-image', 'url(' + imageUrl + ')');

    }  
}
checkExistImage();

// $(function() {
//     $("#evaluate_state_of_tartar")
//         .mouseover(function() { 
//             $(".tooth").each(function() {  
//                 if($(this).attr("data-tooth")) { 
//                     $("#evaluate_state_of_tartar").removeAttr("readonly");
//                     return false;
//                 }
//             });
//         });        
// });


function updateEvaluateStateOfTartar(id){ 
    
    var id_customer = $('#id_customer').val(); 
    var evaluate_state_of_tartar=$('#evaluate_state_of_tartar').val();
   
    $.ajax({
        type:'POST',
        url: baseUrl+'/itemsCustomers/Accounts/updateEvaluateStateOfTartar', 
        data: {"id":id,"evaluate_state_of_tartar":evaluate_state_of_tartar},   
        success:function(data){ 
           
        },
        error: function(data){
        console.log("error");
        console.log(data);
        }
    });
}

function checkAddNewTreatment(){

    var id_mhg = $('#id_mhg').val();

    var check_add_new_treatment =  $('#check_add_new_treatment').html();

    if(id_mhg == 0 || check_add_new_treatment != 0){
        
        $('#add_new_treatment').removeClass('background-666'); 
        $('#add_new_treatment').addClass('background-9CC34D');              

    }else{

        $('#add_new_treatment').removeClass('background-9CC34D');
        $('#add_new_treatment').addClass('background-666');

    } 
}
checkAddNewTreatment();


$('#add_new_treatment').click(function (e) {     

    var id_mhg = $('#id_mhg').val();

    var check_add_new_treatment =  $('#check_add_new_treatment').html();

    if(id_mhg == 0 || check_add_new_treatment != 0){

        $('.cal-loading').fadeIn('fast');

        var id_customer = $('#id_customer').val();  

        $.ajax({
            type:'POST',
            url: baseUrl+'/itemsCustomers/Accounts/addNewTreatment',    
            data: {"id_customer":id_customer},   
            success:function(data){       

                $('#medical_record').html(data);

                $('.cal-loading').fadeOut('slow');

            },
            error: function(data){
            console.log("error");
            console.log(data);
            }
        });

    }else{
        return false;
    } 

});

$('#frm-save-medical-history').submit(function(e) {


        $('.cal-loading').fadeIn('fast');

        e.preventDefault();
        var formData = new FormData($("#frm-save-medical-history")[0]);  
        formData.append('id_customer',$('#id_customer').val());   
        formData.append('id_history_group',$('#id_mhg').val()); 
        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({           
                type:"POST",
                url: baseUrl+'/itemsCustomers/Accounts/saveMedicalHistory',   
                data:formData,
                datatype:'json',
                success:function(data){  

                    $('#frm-save-medical-history')[0].reset();
                    $(".tooth_numbers").val('').trigger('change');
                    $("#frm-prescription")[0].reset();
                    CKEDITOR.instances.advise.setData("");
                    $("#frm-lab")[0].reset();
                    CKEDITOR.instances.n0te.setData("");
                    $("#containerTreatment").replaceWith(containerTreatmentClone.clone()); 
                    $(".tooth_numbers").select2({
                        placeholder: "Số răng",
                        allowClear: true      
                    });
                    $("#action-prescription").replaceWith(aClone.clone());
                    $("#action-lab").replaceWith(aLabClone.clone());
                    $("#dntd").replaceWith(divClone.clone());             
                    $('#medical_history').html(data); 
                    templock = 1;
                    $($('#add-treatment-process-blur')[0]).fadeToggle(200,function(){
                        templock = 0;
                    });

                    e.stopPropagation();  
                    $('.cal-loading').fadeOut('slow');
                     
                },
                error: function(data) {
                    alert("Error occured. Please try again!");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        return false;


});

$('#upAdd').click(function (e) { 

    e.preventDefault();

    var lastDataDrug = $('#dntd > div').last().data('drug');
    var data_drug    = lastDataDrug + 1;

    $('#dntd').append($('<div data-drug="'+data_drug+'">')
                .append($('<div class="input-group">')
                    .append('<span class="input-group-addon spn-dots">'+data_drug+'.</span>')
                    .append('<input required type="text" class="form-control ipt-dots" name="drug_name[]">')
                )                
                .append($('<div class="input-group">')
                    .append('<span class="input-group-addon dots spn-dots">Ngày</span>')
                    .append('<input required type="number" class="form-control ipt-dots text-align-right" name="times[]">')
                    .append('<span class="input-group-addon dots spn-dots">lần, mỗi lần:</span>')
                    .append('<input required type="text" class="form-control ipt-dots" name="dosage[]">')
                    .append($('<div class="input-group-addon dots spn-dots">')
                        .append($('<button onclick="minusDelete('+data_drug+');" class="btn sbtnAdd">')
                            .append('<span class="glyphicon glyphicon-minus"></span>')
                            )
                        )
                )
                ); 

    e.stopPropagation();
});

$('#addTreatment').click(function (e) { 

    e.preventDefault();

    var lastDataTreatment = $('#containerTreatment > div').last().data('treatment');
    var data_treatment    = lastDataTreatment + 1;

    $('#containerTreatment').append($('<div data-treatment="'+data_treatment+'">')

        .append($('<div class="col-md-6">')

            .append('<label class="control-label">Số răng:</label>')

            .append($('<select name="tooth_numbers['+data_treatment+'][]" class="form-control tooth_numbers" multiple style="width: 100%;padding:2px 12px;">') 
                .append('<option value="11">11</option>')               
                .append('<option value="12">12</option>')
                .append('<option value="13">13</option>')
                .append('<option value="14">14</option>')
                .append('<option value="15">15</option>')
                .append('<option value="16">16</option>')
                .append('<option value="17">17</option>')
                .append('<option value="18">18</option>')
                .append('<option value="21">21</option>')
                .append('<option value="22">22</option>')
                .append('<option value="23">23</option>')
                .append('<option value="24">24</option>')
                .append('<option value="25">25</option>')
                .append('<option value="26">26</option>')
                .append('<option value="27">27</option>')
                .append('<option value="28">28</option>')
                .append('<option value="31">31</option>')
                .append('<option value="32">32</option>')
                .append('<option value="33">33</option>')
                .append('<option value="34">34</option>')
                .append('<option value="35">35</option>')
                .append('<option value="36">36</option>')
                .append('<option value="37">37</option>')
                .append('<option value="38">38</option>')
                .append('<option value="41">41</option>')
                .append('<option value="42">42</option>')
                .append('<option value="43">43</option>')
                .append('<option value="44">44</option>')
                .append('<option value="45">45</option>')
                .append('<option value="46">46</option>')
                .append('<option value="47">47</option>')
                .append('<option value="48">48</option>')  
                .append('<option value="51">51</option>')  
                .append('<option value="52">52</option>') 
                .append('<option value="53">53</option>') 
                .append('<option value="54">54</option>') 
                .append('<option value="55">55</option>')
                .append('<option value="61">61</option>')  
                .append('<option value="62">62</option>') 
                .append('<option value="63">63</option>') 
                .append('<option value="64">64</option>') 
                .append('<option value="65">65</option>')
                .append('<option value="71">71</option>')  
                .append('<option value="72">72</option>') 
                .append('<option value="73">73</option>') 
                .append('<option value="74">74</option>') 
                .append('<option value="75">75</option>')
                .append('<option value="81">81</option>')  
                .append('<option value="82">82</option>') 
                .append('<option value="83">83</option>') 
                .append('<option value="84">84</option>') 
                .append('<option value="85">85</option>')  
            )

            .append($('<button onclick="removeTreatment('+data_treatment+');" class="btn sbtnAdd">')
                .append('<span class="glyphicon glyphicon-minus"></span>')
            )

        )   

        .append($('<div class="col-md-6 margin-bottom-15">')

            .append('<label class="control-label">Công tác điều trị:</label>')

            .append('<textarea required class="form-control" name="treatment_work[]" rows="3" placeholder="Công tác điều trị"></textarea>')             

        )   

    ); 

    $(".tooth_numbers").select2({
        placeholder: "Số răng",
        allowClear: true      
    }); 

    e.stopPropagation();
});

function removeTreatment(data_treatment){
    
    var evt = window.event || arguments.callee.caller.arguments[0];

    evt.preventDefault();  

    $('div[data-treatment]').each(function(index, element) {         
      
        if ( $(this).attr('data-treatment') == data_treatment ) {    

          $(this).remove();

        }

    });

    evt.stopPropagation();
}

function minusDelete(data_drug){
    
    var evt = window.event || arguments.callee.caller.arguments[0];

    evt.preventDefault();  

    $('div[data-drug]').each(function(index, element) {         
      
        if ( $(this).attr('data-drug') == data_drug ) {    

          $(this).remove();

        }

    });

    evt.stopPropagation();
}

$('#frm-prescription').submit(function(e) {

    $('.cal-loading').fadeIn('fast');

    e.preventDefault();
    var formData = new FormData($("#frm-prescription")[0]);
    CKEDITOR.instances.advise.updateElement(); 
    formData.append('advise',document.getElementById( 'advise' ).value); 
    formData.append('id_history_group',$('#id_mhg').val()); 
    if (!formData.checkValidity || formData.checkValidity()) {
        jQuery.ajax({           
            type:"POST",
            url: baseUrl+'/itemsCustomers/Accounts/setSessionAddPrescription',   
            data:formData,
            datatype:'json',
            success:function(data){  
                e.stopPropagation(); 
                $('#prescriptionModal').modal('hide');  
                $('.cal-loading').fadeOut('slow');         
            },
            error: function(data) {
                alert("Error occured. Please try again!");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    return false;
});

$('#frm-lab').submit(function(e) {

    $('.cal-loading').fadeIn('fast');

    e.preventDefault();
    var formData = new FormData($("#frm-lab")[0]);
    CKEDITOR.instances.n0te.updateElement(); 
    formData.append('note',document.getElementById( 'n0te' ).value); 
    formData.append('id_history_group',$('#id_mhg').val()); 
    if (!formData.checkValidity || formData.checkValidity()) {
        jQuery.ajax({           
            type:"POST",
            url: baseUrl+'/itemsCustomers/Accounts/setSessionAddLab',   
            data:formData,
            datatype:'json',
            success:function(data){  
                e.stopPropagation(); 
                $('#labModal').modal('hide');  
                $('.cal-loading').fadeOut('slow');         
            },
            error: function(data) {
                alert("Error occured. Please try again!");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
    return false;
});

function deleteMedicalHistory(id){

    var evt = window.event || arguments.callee.caller.arguments[0];    
    evt.stopPropagation();

    if (confirm("Bạn có thật sự muốn xóa?")) { 

        $('.cal-loading').fadeIn('fast');

        var id_history_group = $('#id_mhg').val(); 

        $.ajax({
            type:'POST',
            url: baseUrl+'/itemsCustomers/Accounts/deleteMedicalHistory',     
            data: {"id":id,"id_history_group":id_history_group},   
            success:function(data){
                               
                $('#medical_history').html(data); 

                $('.cal-loading').fadeOut('slow');
                                
            },
            error: function(data){
            console.log("error");
            console.log(data);
            }
        });
    }      
}

$('#note').click(function(){ 
    var position = $( this ).position();  
    $('#notePopup').css({"top": position.top+25, "left": position.left+25});
    $('#notePopup').fadeToggle('fast');
});
$('#ic_close').click(function(){ 
    $('#notePopup').hide(); 
});
$(function() {   

    $(document).mouseup(function (e)
    {
        var container = $("#notePopup");

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $('#notePopup').hide();            
        }
               
    });
        
});

function showPopupMedicalHistory(){

var elem = $('#add-treatment-process-blur')[0];

$('body').on('click',function(e){
    if(templock == 0){
        if($(e.target).closest($('#addnewMedicalHistoryPopup')).length === 0 && $(e.target).closest($('#CalendarModal')).length === 0 && $(e.target).closest($('#prescriptionModal')).length === 0 && $(e.target).closest($('#labModal')).length === 0 && $(e.target).closest($('#ui-datepicker-div')).length === 0 && $(e.target).closest($('.daterangepicker')).length === 0){    
            if($(elem).is(':visible')){
         
                $('#frm-save-medical-history')[0].reset();
                $(".tooth_numbers").val('').trigger('change');     
                $("#frm-prescription")[0].reset();
                CKEDITOR.instances.advise.setData("");
                $("#frm-lab")[0].reset();
                CKEDITOR.instances.n0te.setData("");
                $("#containerTreatment").replaceWith(containerTreatmentClone.clone()); 
                $(".tooth_numbers").select2({
                    placeholder: "Số răng",
                    allowClear: true      
                });
                $("#action-prescription").replaceWith(aClone.clone());
                $("#action-lab").replaceWith(aLabClone.clone());   
                $("#dntd").replaceWith(divClone.clone());    
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

                $('#frm-save-medical-history')[0].reset();
                $(".tooth_numbers").val('').trigger('change');     
                $("#frm-prescription")[0].reset();
                CKEDITOR.instances.advise.setData("");
                 $("#frm-lab")[0].reset();
                CKEDITOR.instances.n0te.setData("");
                $("#containerTreatment").replaceWith(containerTreatmentClone.clone()); 
                $(".tooth_numbers").select2({
                    placeholder: "Số răng",
                    allowClear: true      
                });
                $("#action-prescription").replaceWith(aClone.clone());
                $("#action-lab").replaceWith(aLabClone.clone());
                $("#dntd").replaceWith(divClone.clone());  
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
showPopupMedicalHistory();

$(function() {    
    
    /*** reviewdate ***/
    // $('input[name="reviewdate"]').daterangepicker({
    //     singleDatePicker: true,
    //     showDropdowns: true,
    //     timePicker: true,
    //     autoApply: true,
    //     locale: {
    //         format: 'YYYY-MM-DD HH:mm:ss',
    //     },
    //     "drops": "up"
    // }, 
    // function(start, end, label) {
        
       
    // }); 
    // $('input[name="reviewdate"]').on('cancel.daterangepicker', function(ev, picker) {
    //     $(this).val('');
    // });
    // $( "#reviewdate" ).val('');
    /*** end reviewdate ***/
    $( "#sent_date" ).datepicker({
        changeMonth: true,
        changeYear: true,       
        dateFormat: 'yy-mm-dd'
    });
    $( "#received_date" ).datepicker({
        changeMonth: true,
        changeYear: true,       
        dateFormat: 'yy-mm-dd'
    });   
    $(".tooth_numbers").select2({
        placeholder: "Số răng",
        allowClear: true      
    }); 
});

$('.ket').on('click',function(e){   

    var id             = $(this).attr('id');
    var split_id       = id.split("_");
    var teeth          = split_id[2];
    var id_quotation = $('#id_quotation').val();
    var id_schedule  = $('#id_schedule').val();  
    window.GlobalTeeth = teeth; 

    if (id_schedule) {

        if(!id_quotation){
            $('#oAdds').click();
        }else{
            $('.oUpdates').click();
        } 

    }  

});
// modal báo giá
$( document ).ready(function() {  

    $('#oAdds').click(function (e) {    

        var id_customer = $('#id_customer').val();
        var id_mhg      = $('#id_mhg').val();  
        var id_schedule  = $('#id_schedule').val();   

        e.preventDefault(); 
        x = 1;
        $('.currentRow').nextAll('tr').remove();
        $('.sNote').show();
        $('#sAddNote').addClass('hidden');

        $.ajax({
            type:'POST',
            url: baseUrl+'/itemsSales/quotations/create',    
            data: {"id_customer":id_customer,"id_mhg":id_mhg,"teeth":GlobalTeeth,"id_schedule":id_schedule},   
            success:function(data){ 
                $('#quote_modal').html(data);
                if($('.sItem tr:last').find('.group').val()){
                    $('.newbtnAdd').removeClass('unbtn');
                }                     
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
    });  

    /*update quotations*/ 
    $('.oUpdates').on('click',function(e){     
            
        var id_quotation = $('#id_quotation').val();
        var id_schedule  = $('#id_schedule').val();
        
        if(!id_quotation)
            return;

        $.ajax({ 
            type:"POST",           
            url: baseUrl+'/itemsSales/quotations/updateQuotation',
            data: {
                id_quotation: id_quotation,
                teeth: GlobalTeeth, 
                id_schedule: id_schedule           
            },
            success:function(data){
                
                if(data){
                    $("#update_quote_modal").html(data);
                        dentistList();
                        productList();
                        serviceList();                        
                }
                $('.cal-loading').fadeOut('slow');
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
           
        });
    });

    $('.create_appt').click(function (e) { 
        $.ajax({ 
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsSchedule/calendar/createScheduleInCustomer')?>",
            data: {
                id_customer: '<?php echo $model->id; ?>',
                id_quotation: $('#id_quotation').val(),
            },
            success:function(data){
                $()
                if(data){
                    $("#CalendarModal").html(data);
                    $('#CalendarModal').modal('show');
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    });

});



function printTreatmentRecords(id_mhg){

    var evt         = window.event || arguments.callee.caller.arguments[0];       

    var id_customer = $("#id_customer").val();   

    if (id_customer && id_mhg) {
        var url="<?php echo CController::createUrl('Accounts/exportTreatmentRecords')?>?id_customer="+id_customer+"&id_medical_history_group="+id_mhg;
        window.open(url,'name') 
    };  

    evt.stopPropagation();

}

function printTreatmentRecordsOfCustomer(id_mhg){

    var evt         = window.event || arguments.callee.caller.arguments[0];       

    var id_customer = $("#id_customer").val();   

    if (id_customer && id_mhg) {
        var url="<?php echo CController::createUrl('Accounts/exportTreatmentRecordsOfCustomer')?>?id_customer="+id_customer+"&id_medical_history_group="+id_mhg;
        window.open(url,'name') 
    };  

    evt.stopPropagation();

}

$( document ).ready(function() {

    
    $('.print').on('click',function(e){

        var id_customer        = $("#id_customer").val();

        var id_medical_history = $("#id_medical_history").val();   

        if (id_medical_history && id_medical_history) {
            var url="<?php echo CController::createUrl('Accounts/exportPrescription')?>?id_customer="+id_customer+"&id_medical_history="+id_medical_history;
            window.open(url,'name') 
        };
                      
    });

    $('.print_lab').on('click',function(e){

        var id_customer        = $("#id_customer").val();

        var id_cs_m3dical_history = $("#id_cs_m3dical_history").val();   

        if (id_cs_m3dical_history) {
            var url="<?php echo CController::createUrl('Accounts/exportLab')?>?id_customer="+id_customer+"&id_medical_history="+id_cs_m3dical_history;
            window.open(url,'name') 
        };
                      
    });

});

/* bootstrap-fileinput-master */

$(function() {    
    var initialPreview       = [];
    var initialPreviewConfig = [];
    var uploadUrl = '<?php echo Yii::app()->params['upload_url'];?>';

    var code_number = "<?php echo $model->code_number;?>";
    var id_customer = $('#id_customer').val();
    var id_mhg      = $('#id_mhg').val();
    $.ajax({
        type:"POST",
        url: baseUrl+'/itemsCustomers/Accounts/view_medical_image',        
        data: {"id_customer":id_customer,"id_mhg":id_mhg}, 
        success: function (data) {
            var getData = $.parseJSON(data);   
            if(getData){    
                $.each(getData, function(i, item) {  
                    var response = {};           
                    initialPreview.push(uploadUrl+"/upload/customer/dental_status/"+code_number+"/"+getData[i].name); 
                    response['caption'] = getData[i].name; 
                    response['key']     = getData[i].id;   
                    response['extra']   = {id: getData[i].id, name: getData[i].name, code_number: "<?php echo $model->code_number;?>", id_customer: $('#id_customer').val(), id_mhg: $("#id_mhg").val()};
                    initialPreviewConfig.push(response);                  
                });     
            }
        }, 
        async: false
    });


    $("#input-700").fileinput({    
        uploadUrl: baseUrl+'/itemsCustomers/Accounts/upload', 
        deleteUrl: baseUrl+'/itemsCustomers/Accounts/fileDelete', 
        uploadAsync: false,   
        overwriteInitial: false,    
        initialPreview: initialPreview,
        initialPreviewAsData: true, // defaults markup
        initialPreviewFileType: 'image', // image is the default and can be overridden in config below
        initialPreviewConfig: initialPreviewConfig,
        uploadExtraData: {
            code_number: "<?php echo $model->code_number;?>",   
            id_customer: $('#id_customer').val(),
            id_mhg: $("#id_mhg").val()     
        }
    }).on('filesorted', function(e, params) {
        console.log('File sorted params', params);
    }).on('fileuploaded', function(e, params) {
        console.log('File uploaded params', params);
    });

    $('#input-700').on('filebatchuploadsuccess', function(event, data, previewId, index) {
        
        $("#webcamModal").removeClass("in");
        $(".modal-backdrop").remove();
        $('#bootstrapFileinputMasterModal').modal('hide');
        var form = data.form, files = data.files, extra = data.extra, 
        response = data.response, reader = data.reader;
        detailCustomer(response.id_customer);                

    });

    $("#input-700").on("filepredelete", function(jqXHR) {
        var abort = true;
        if (confirm("Are you sure you want to delete this image?")) {
            abort = false;
        }
        return abort; // you can also send any data/object that you can receive on `filecustomerror` event
    });

    $('#get_newest_schedule').click(function(e){
        e.preventDefault();

        $.ajax({
            type    : "POST",
            url     : baseUrl+'/itemsCustomers/Accounts/GetNewetSchedule',
            data    : {"id_customer": $("#id_customer").val()},
            dataType: 'json',
            success: function (data) {
                var string = "";
                if(data) {
                    $.each(data, function(k,v){
                        string += v + "\n";
                    });
                }
                console.log(string);
                $('#newest_schedule').val(string);
            }
        });
    })

});    

/* end bootstrap-fileinput-master */

// if (($(".status_3").length > 0)){ 
//     window.onbeforeunload = function() {
//         return 'Are you sure you want to navigate away from this page?';
//     };
// }else{
//     window.onbeforeunload = null;
// }

$(window).resize(function() {
    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    var tab_menu     = $("#tabcontent .menuTabDetail").height();
    var customer_action = $(".customersActionHolder").height();  
    var customer_search = $(".customerSearchHolder").height();

    $('#profileSideNav').height(windowHeight-header);

    $('.statsTabContent').height(windowHeight-header-tab_menu-45);     

    $('#customerList').css('max-height', windowHeight-header-customer_action-customer_search-80);

});

$( document ).ready(function() {

    var windowHeight =  $( window ).height();
    var header       = $("#headerMenu").height();
    var tab_menu     = $("#tabcontent .menuTabDetail").height();
    var customer_action = $(".customersActionHolder").height();    
    var customer_search = $(".customerSearchHolder").height();

    $('#profileSideNav').height(windowHeight-header);

    $('.statsTabContent').height(windowHeight-header-tab_menu-45);   

    $('#customerList').css('max-height', windowHeight-header-customer_action-customer_search-80);

});

$(function () {
   $('.createdate').datetimepicker({ 
      format: 'YYYY-MM-DD HH:mm:ss',
      defaultDate: moment().format('YYYY-MM-DD HH:mm:ss'),
    });

   $('#reviewdate').datetimepicker({ 
      format: 'YYYY-MM-DD HH:mm:ss',
    });
});

//*********** xóa toa thuốc *************//
function deletePrescription(id_prescription){
    var id_mhg      = '<?php echo $id_mhg; ?>';
    var id_customer = '<?php echo $model->id; ?>';
    if(confirm("Bạn có thực sự muốn xóa?")) {
        $.ajax({
            type    : "POST",
            url     : baseUrl+'/itemsCustomers/Accounts/deletePrescription',
            data    : {
                "id_prescription" : id_prescription,
                'id_mhg'          : id_mhg,
                'id_customer'     : id_customer,
            },
            success: function (data) {
                $(".modal-backdrop").remove(); 
                $('#medical_record').html(data);
            }
        });
    }
}
//*********** xóa laob *************//
function deleteLabo(id_labo){
    var id_mhg      = '<?php echo $id_mhg; ?>';
    var id_customer = '<?php echo $model->id; ?>';
    if(confirm("Bạn có thực sự muốn xóa?")) {
        $.ajax({
            type    : "POST",
            url     : baseUrl+'/itemsCustomers/Accounts/deleteLabo',
            data    : {
                "id_labo"         : id_labo,
                'id_mhg'          : id_mhg,
                'id_customer'     : id_customer,
            },
            success: function (data) {
                $(".modal-backdrop").remove(); 
                $('#medical_record').html(data);
            }
        });
    }
}

$(window).resize(function() {
    var header       = $("#headerMenu").height();
    var tab_menu     = $("#tabcontent .menuTabDetail").height();
    $('.save_medical').css('top',tab_menu+header+20);
});
$( document ).ready(function() {
    var header       = $("#headerMenu").height();
    var tab_menu     = $("#tabcontent .menuTabDetail").height();
    $('.save_medical').css('top',tab_menu+header+20);
});
</script>                           




