
<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->baseUrl?>"/>
<div style='text-align:right'>
	<button type="button" class="btn btn-info" onclick='showModalAdd();'>
	<span class="glyphicon glyphicon-plus"></span>
	Thêm
	</button>
</div>
<div id="content_tab_doctor_salary" style="margin: 30px 0px;width: 100%;overflow: auto;padding-left: 15px;">
	
  <table class="table">

    <thead>

      <tr>
        <th>Nhóm</th>
        <th>Khách hàng</th>
        <th>Dịch vụ</th>
        <th>Phí</th>
        <th>Bác sĩ</th>
        <th>Mã hóa đơn</th>
        <th>Ngày lập</th>
        <th>Ngày trả</th>
        
        <th>Tình trạng</th>
        <!-- <th>Loại giao dịch</th> -->

        <th></th>
      </tr>

    </thead>

    <tbody id="tbody_doctor_salary">

      <?php include("tbody_doctor_salary.php");?> 
      
    </tbody>

  </table>


    <div class="modal fade" id="updateTransactionInvoiceModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

      <div class="modal-dialog" role="document">

        <div class="modal-content">   

          <div class="modal-header sHeader">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h3 class="modal-title">Chỉnh sửa</h3>
          </div>

          <div class="modal-body">

            <form id="formUpdateTransactionInvoice">       

                <input type="hidden" name="id">        

                <div class="form-group">

                  <label class="form-control-label">Khách hàng:</label>  

                  <select required name="id_customer" class="form-control"></select>                   

                </div>

                <div class="form-group">

                  <label class="form-control-label">Dịch vụ:</label>  

                  <select required name="id_service" class="form-control"></select>                   

                </div>

                <div class="form-group">

                  <label class="form-control-label">Phí:</label>  

                  <input type="text" required class="form-control autoNum" name="amount">

                </div>

                <div class="form-group">

                  <label class="form-control-label">Phần trăm:</label>  

                  <input type="number" min="0" max="100" required class="form-control" name="percent">                  

                </div>


                <div class="form-group">

                  <label class="form-control-label">Ngày lập:</label>  

                  <input type="text" required class="form-control" name="create_date">                  

                </div>

                <div class="form-group">

                  <label class="form-control-label">Ngày trả:</label>  

                  <input type="text" class="form-control" name="pay_date" onchange="changePayDate(this);">                  

                </div>

                <div class="form-group">

                  <label class="form-control-label">Tình trạng:</label>                   

                  <select required class="form-control" name="debt" onchange="changeDebt(this);">
                    <option value="0">Đã thanh toán</option>
                    <option value="1">Nợ</option>
                  </select>                

                </div>

               <div class="modal-footer" style="border: 0px;">                  

                <button type="submit" class="btn btn-primary">Cập nhật</button>

              </div>
              
            </form>

          </div>
         
        </div>

      </div>

    </div>

</div>
<div class="modal fade" id="myModalAdd" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header sHeader">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title">Thêm</h3>
			</div>
			<form id="formAddTransactionInvoice">
			<input type='hidden' id='add_id_user' name='add_id_user' value='<?php echo $model->id;?>'/>
			<input type='hidden' id='add_id_author' name='add_id_author' value='<?php echo Yii::app()->user->getState('user_id');?>'/>
			<div class="modal-body contentModalAdd"> 
				<div class="form-group">
					<label class="form-control-label">Hóa đơn:</label>  
              <select class="form-control" id='add_id_invoice' name='add_id_invoice'> 
					</select>					
				</div>
				<div class="form-group">
					<label class="form-control-label">Dịch vụ:</label>  
					<input type='hidden' id='add_id_service1' name="add_id_service"/>
                    <select class="form-control" id='add_id_service' onchange='show_gia_serivice();'> 
					    <option value='0'>--Chọn Dịch Vụ--</option>
					    <?php $CsService = CsService::model()->findAll();
					    foreach($CsService as $gt){
							$CsServiceTk = CsServiceTk::model()->findAll('st=:st and id_cs_service=:dd',array(':st'=>1,':dd'=>$gt['id']));
							$CsServiceTk1 = $CsServiceTk && count($CsServiceTk)>0?$CsServiceTk[0]['id_service_type_tk']:0;
							$CsPercentTk = CsPercentTk::model()->findAll('st=:st and id_service_type_tk=:dd',array(':st'=>1,':dd'=>$CsServiceTk1));
							$percent = $CsPercentTk && count($CsPercentTk)>0?$CsPercentTk[0]['percent']:0;
							?>
						<option value='<?php echo $gt['id'].'|'.$gt['price'].'|'.$CsServiceTk1.'|'.$percent;?>'><?php echo $gt['name'];?></option>
						<?php }?>
					</select>					
				</div>
				<div class="form-group">
					<label class="form-control-label">Phí:</label>  
					<input type="text" class="form-control" id='add_amount' name="add_amount"/>                  
				</div>
				<div class="form-group">
					<label class="form-control-label">Khách hàng:</label> 
					<select class="form-control" id='add_id_customer' name="add_id_customer">
					</select>					                  
				</div>
				<div class="form-group">
					<label class="form-control-label">Nhóm:</label>  
					<input type='hidden' id='add_id_service_type_tk1' name="add_id_service_type_tk"/>
					<select class="form-control" id='add_id_service_type_tk' onchange='change_percent();'> 
					    <option value='0'>--Nhóm--</option>
						<?php $CsServiceTypeTk = CsServiceTypeTk::model()->findAll('st=:st',array(':st'=>1));
						foreach($CsServiceTypeTk as $gt){
							$CsPercentTk = CsPercentTk::model()->findAll('st=:st and id_service_type_tk=:dd',array(':st'=>1,':dd'=>$gt['id']));
							$percent = $CsPercentTk && count($CsPercentTk)>0?$CsPercentTk[0]['percent']:0;
							?>
						<option value='<?php echo $gt['id'].'|'.$percent;?>'><?php echo $gt['name'];?></option>
						<?php }?>
					</select>               
				</div>
				<div class="form-group">
					<label class="form-control-label">Phần trăm:</label>  
					<input type="text" class="form-control" id='add_percent' name="add_percent"/>
				</div>
				<div class="form-group">
					<label class="form-control-label">Ngày trả:</label>  
					<input type="text" class="form-control" onchange='pad_date_show();' id='add_pay_date' name="add_pay_date"/>
				</div>
				<div class="form-group">
					<label class="form-control-label">Tình trạng:</label>                   
					<select class="form-control" onchange='debt_show();' id='add_debt' name="add_debt">
						<option value="0">Đã thanh toán</option>
						<option value="1">Nợ</option>
					</select>                
                </div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Xác nhận</button>
				<button type="button" class="btn btn-default close_add" data-dismiss="modal" >Hủy</button>
			</div>
			</form>
		</div>
      
    </div>
</div>

<script type="text/javascript">
//function show_dateww(){
	//alert($('#add_pay_date').val());
//}
$('#add_id_invoice').select2({
	placeholder: 'Mã Khách Hàng',
	width: '100%',
});
$('#add_id_service').select2({
	placeholder: 'Dịch Vụ',
	width: '100%',
});
$('#add_id_service_type_tk').select2({
	placeholder: 'Nhóm',
	width: '100%',
});
$('#add_pay_date').datepicker({
	changeMonth: true,
	changeYear: true,       
	dateFormat: 'dd/mm/yy',
	yearRange: '2000:+0'
});
$('#add_id_customer').select2({
      placeholder: 'Khách hàng',
      width: '100%',
      language: "vi",
      ajax: {
          dataType : "json",          
          url      : baseUrl+'/itemsSales/quotations/getCustomerList',
          type     : "post",
          delay    : 1000,
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
$('#add_id_invoice').select2({
      placeholder: 'Mã hóa đơn',
      width: '100%',
      language: "vi",
      ajax: {
          dataType : "json",          
          url      : baseUrl+'/itemsSales/quotations/getInvoiceList',
          type     : "post",
          delay    : 1000,
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
var baseUrl = $('#baseUrl').val();
function showModalAdd(){
	$("#myModalAdd").modal();
}
function show_gia_serivice(){
	var add_id_service = $("#add_id_service").val();
	var arr = add_id_service.split("|");
	if(add_id_service != 0){
		$("#add_amount").val(arr[1]);
		$("#add_id_service1").val(arr[0]);
		$("#add_id_service_type_tk").val(arr[2]+'|'+arr[3]).trigger('change');
	}else{
		$("#add_amount").val('');
		$("#add_id_service1").val('');
		$("#add_id_service_type_tk").val(0).trigger('change');
	}
}
function change_percent(){
	var add_id_service_type_tk = $("#add_id_service_type_tk").val();
	if(add_id_service_type_tk != 0){
		var arr = add_id_service_type_tk.split("|");
		$("#add_percent").val(arr[1]);
		$("#add_id_service_type_tk1").val(arr[0]);
	}else{
		$("#add_percent").val('');
		$("#add_id_service_type_tk1").val('');
	}
}
function pad_date_show(){
	var add_pay_date = $("#add_pay_date").val();
	if(add_pay_date != ''){
		$("#add_debt").val(0);
	}else{
		$("#add_debt").val(1);
	}
}
function debt_show(){
	var add_debt = $("#add_debt").val();
	if(add_debt != 0){
		$("#add_pay_date").val('');
	}else{
		$('#add_pay_date').datepicker("setDate", new Date());
	}
}
function loadDoctorSalary() {

  $.ajax({
      type:'POST',
      url: '<?php echo CController::createUrl('staff/loadDoctorSalary'); ?>',
      data: {"id_user":<?php echo $model->id;?>},   
      success:function(data){

          $('#tbody_doctor_salary').html(data);          

      },
      error: function(data){
      console.log("error");
      console.log(data);
      }
  });

}  

$('#formUpdateTransactionInvoice').submit(function(e) { 
    
    var formData = new FormData($("#formUpdateTransactionInvoice")[0]);         

    if (!formData.checkValidity || formData.checkValidity()) {

        jQuery.ajax({           
            type:"POST",
            url: '<?php echo CController::createUrl('staff/updateTransactionInvoice'); ?>', 
            data:formData,
            datatype:'json',
            success:function(data){  

              var getData = JSON.parse(data);  

              if (getData['status'] == 'successful') {

                loadDoctorSalary();           

                $("#updateTransactionInvoiceModal").removeClass("in");
                $(".modal-backdrop").remove();
                $("#updateTransactionInvoiceModal").hide();

              } else {

                  alert(getData['error-message']);

              }
                
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

$('#formAddTransactionInvoice').submit(function(e) { 
    
    var formData = new FormData($("#formAddTransactionInvoice")[0]);         
    if($("#add_id_invoice").val() == 0){
		alert('Xin chọn mã hóa đơn !!!');
		return false;
	}
	if($("#add_id_service").val() == 0){
		alert('Xin chọn dịch vụ !!!');
		return false;
	}
	if($("#add_id_customer").val() == ""){
		alert('Xin chọn khách hàng !!!');
		return false;
	}
	if($("#add_id_service_type_tk").val() == 0){
		alert('Xin chọn nhóm !!!');
		return false;
	}
	if($("#add_percent").val() == ""){
		alert('Xin nhập phần trăm !!!');
		return false;
	}
    if (!formData.checkValidity || formData.checkValidity()) {

        jQuery.ajax({           
            type:"POST",
            url: '<?php echo CController::createUrl('staff/addTransactionInvoice'); ?>', 
            data:formData,
            datatype:'json',
            success:function(data){   
				if(data == 1) { 
				    loadDoctorSalary();	
                    $("#add_id_invoice").val(0).trigger('change');
					$("#add_id_service").val(0).trigger('change');
					$("#add_id_customer").val('').trigger('change');
					$("#add_id_service_type_tk").val(0).trigger('change');
					$("#add_percent").val('');
					$("#add_pay_date").val('');
					$("#add_amount").val('');
					$("#add_id_service1").val('');
                    //$("#add_id_invoice").select2("val", 0);	
                    //$("#add_id_service").select2("val", 0);			  
                    //$("#add_id_customer").select2("val", '');	
					//$("#add_id_service_type_tk").select2("val", 0);					
                    $('.close_add').click();		
				}else{
				    alert('Error!!!');
				}
                
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

function deleteTransactionInvoice(id) {

  if (confirm("Bạn có thật sự muốn xóa?")) { 
      
    $.ajax({
        type:'POST',
        url: '<?php echo CController::createUrl('staff/deleteTransactionInvoice'); ?>',
        data: {"id":id},   
        success:function(data){

            var getData = JSON.parse(data);  

            if (getData['status'] == 'successful') {

              loadDoctorSalary();

            } else {

                alert(getData['error-message']);

            }    

        },
        error: function(data){
        console.log("error");
        console.log(data);
        }
    });

  }      

}

function setTransactionInvoiceModal(id,id_customer,name_customer,id_service,name_service,amount,percent,create_date,pay_date,debt) {

  $('#formUpdateTransactionInvoice input[name="id"]').val(id);  

  $('#formUpdateTransactionInvoice select[name="id_customer"]').empty().append('<option value="'+id_customer+'">'+name_customer+'</option>').val(id_customer).trigger('change');

  $('#formUpdateTransactionInvoice select[name="id_service"]').empty().append('<option value="'+id_service+'">'+name_service+'</option>').val(id_service).trigger('change');  

  $('#formUpdateTransactionInvoice input[name="amount"]').val(amount);  

  $('#formUpdateTransactionInvoice input[name="percent"]').val(percent);  

  $('#formUpdateTransactionInvoice input[name="create_date"]').val(create_date);

  $('#formUpdateTransactionInvoice input[name="pay_date"]').val(pay_date);

  $('#formUpdateTransactionInvoice select[name="debt"]').val(debt);  

}

$('#updateTransactionInvoiceModal').on('hidden.bs.modal', function (e) {

  $('#formUpdateTransactionInvoice input[type=hidden]').val('');

  $("#formUpdateTransactionInvoice")[0].reset();

});

function changePayDate(selectObject) {

  var value = selectObject.value; 

  if (value) {

    $('#formUpdateTransactionInvoice select[name="debt"]').val(0);  

  } else {

    $('#formUpdateTransactionInvoice select[name="debt"]').val(1);  

  }

}

function changeDebt(selectObject) {

  var value = selectObject.value; 

  if (value == 1) {     

    $('#formUpdateTransactionInvoice input[name="pay_date"]').val('');

  } else {

    $('#formUpdateTransactionInvoice input[name="pay_date"]').datepicker("setDate", new Date());

  }

}

$(function(){
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
    $('.autoNum').autoNumeric('init',numberOptions);
});

function customerList() {

  $('#formUpdateTransactionInvoice select[name="id_customer"]').select2({
      placeholder: 'Khách hàng',
      width: '100%',
      language: "vi",
      ajax: {
          dataType : "json",          
          url      : baseUrl+'/itemsSales/quotations/getCustomerList',
          type     : "post",
          delay    : 1000,
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

function serviceList() {
  
  $('#formUpdateTransactionInvoice select[name="id_service"]').select2({
      placeholder: 'Dịch vụ',
      width: '100%',
      ajax: {
          dataType : "json",  
          url      : baseUrl+'/itemsSales/quotations/getServicesList',
          type     : "post",
          delay    : 1000,
          data : function (params) {
        return {
          q     : params.term, // search term
          page  : params.page || 1,
  
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
      },
  });
  
}


function create_date() {
  
  $('#formUpdateTransactionInvoice input[name="create_date"]').datepicker({
      changeMonth: true,
      changeYear: true,       
      dateFormat: 'dd/mm/yy',
      yearRange: '2000:+0'
  });
  
}

function pay_date() {
  
  $('#formUpdateTransactionInvoice input[name="pay_date"]').datepicker({
      changeMonth: true,
      changeYear: true,       
      dateFormat: 'dd/mm/yy',
      yearRange: '2000:+0'
  });
  
}

function loadTransactionInvoiceModal() {

  customerList();

  serviceList();

  create_date();

  pay_date();


}

$(document).ready(function() {

  loadDoctorSalary();  

  loadTransactionInvoiceModal();

}); 

</script>


