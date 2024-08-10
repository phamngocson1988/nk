<style>
input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance:textfield;
}
#frm-up-sch .form-group {margin-bottom: 10px;}
</style>

<?php $baseUrl = Yii::app()->getBaseUrl(); ?>

<div id="update_sch_modal" class="modal calendarModal">
<div class="modal-dialog">
   <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">close</span></button>
         <h3 id="modalTitle" class="modal-title">CẬP NHẬT LỊCH HẸN</h3>
      </div>

      <div id="modalBody" class="modal-body">
         <div class="row">
            <ul class="nav nav-tabs nav-1">
               <li id="nav-sch" class="active"><a data-toggle="tab" href="#up-schedule">Lịch Hẹn</a></li>
               <li class="upCusShow"><a data-toggle="tab" href="#up-cus">Khách Hàng</a></li>
            </ul>

            <div class="tab-content">

               <!-- Lich hen -->
               <div id="up-schedule" class="tab-pane tab-ct fade in active">
                  <form enctype="multipart/form-data" class="form-horizontal" id="frm-up-sch" action="/nhakhoa2000/itemsSchedule/calendar/" method="post">
                     <div class="form-group">
                        <div class="col-xs-6 col-xs-offset-1">
                           <h4>Trạng thái lịch hẹn</h4>
                        </div>
                        <div class="col-xs-4">
                           <?php echo CHtml::dropDownList('CsSchedule[status]', '', $status_sch, array('class'=>'form-control','id'=>'CsSchedule_up_status')); ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <div class="col-xs-6 col-xs-offset-1">
                           <h4>Trạng thái hồ sơ</h4>
                        </div>
                        <div class="col-xs-4">
                           <?php echo CHtml::dropDownList('CsSchedule[status_customer]', '',array('0' => 'Chưa sẵn sàng', '1'=>'Đã sẵn sàng'), array('class'=>'form-control','id'=>'CsSchedule_up_status_customer')); ?>
                        </div>
                     </div>

                     <input name="CsSchedule[type]" class="Csh_type" type="hidden" />
                     <input name="CsSchedule[id]" id="CsSchedule_up_id" type="hidden" />
                     <input name="CsSchedule[id_customer]" id="CsSchedule_up_id_customer" type="hidden" />
                     <input name="CsSchedule[id_author]" id="CsSchedule_up_id_author" type="hidden" />
                     <input name="CsSchedule[code_number]" id="CsSchedule_up_code_number" type="hidden" />
                     <input class="chair" name="CsSchedule[id_chair]" id="CsSchedule_up_id_chair" type="hidden" value="" />
                     <input class="branch" name="CsSchedule[id_branch]" id="CsSchedule_up_id_branch" type="hidden" value="" />
                     <input class="end_time" name="CsSchedule[end_time]" id="CsSchedule_up_end_time" type="hidden" />
                     <input class="chkT" id="create_up_chkT" type="hidden" value="1" name="checkT" />
                     <input class="Customer_up_code_number" name="Customer[code_number]" type="hidden" />
                     <input type="hidden" class="acceptChange" id="update_acceptChange" value="0" />

                     <div class="clearfix"></div>

                     <div class="form-group">
                        <label class="col-xs-4 control-label" for="CsSchedule_up_id_dentist">Nha sỹ</label>
                        <div class="col-xs-6">
                           <select placeholder="" class="sch_dentist form-control" name="CsSchedule[id_dentist]" id="CsSchedule_up_id_dentist"></select>
                        </div>
                        <div class="col-xs-1 load-up-at load-at load-dt padding-left-0">
                           <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-xs-4 control-label" for="CsSchedule_up_id_service">Dịch vụ</label>
                        <div class="col-xs-6">
                           <select placeholder="" class="sch_service form-control" name="CsSchedule[id_service]" id="CsSchedule_up_id_service"></select>
                        </div>
                        <div class="col-xs-1 load-up-at load-at  padding-left-0" id="load-sv">
                           <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-xs-4 control-label" for="CsSchedule_up_lenght">Thời gian</label>
                        <div class="col-xs-6">
                           <div class="input-group">
                              <input type="number" class="len times form-control" name="CsSchedule[lenght]" id="CsSchedule_up_lenght" min="0" max="300" step="5">

                              <span class="input-group-addon">phút</span>
                           </div>
                        </div>
                        <div class="col-xs-1 load-up-at load-at  padding-left-0" id="load-ti">
                           <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-xs-4 control-label" for="CsSchedule_up_start_time">Ngày giờ</label>
                        <div class="col-xs-6 times">
                           <input required="required" placeholder="" class="group_time datetimepicker form-control" name="CsSchedule[start_time]" id="CsSchedule_up_start_time" type="text" />
                        </div>
                        <div class="col-xs-1 load-up-at load-at padding-left-0" id="load-da">
                           <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-xs-4 control-label" for="CsSchedule_up_note">Ghi chú</label>
                        <div class="col-xs-6">
                           <textarea class="form-control" placeholder="Note" name="CsSchedule[note]" id="CsSchedule_up_note"></textarea>
                        </div>
                        <div class="col-xs-1 load-up-at load-at  padding-left-0" id="load-no">
                           <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        </div>
                     </div>

                     <div class="form-group">
                        <div class="col-xs-6 col-xs-offset-4">
                           <?php if ($delSch == 1): ?>
                              <button type="button" class="btn btn_cancel pull-left del-sch">Xóa lịch</button>
                           <?php endif ?>
                           <?php if ($upSch == 1): ?>
                              <button type="button" class="btn btn_book pull-right up-sch up_sch_cus" style="color: white;">Cập nhật</button>
                           <?php endif ?>
                        </div>
                     </div>
                     </form>
               </div>

               <!-- Khach hang -->
               <div id="up-cus" class="tab-pane fade upCusShow">
                  <div id="show-cus">
                     <ul class="nav nav-tabs nav-2 nav-justified">
                        <li class="active"><a data-toggle="tab" href="#up-info">Thông tin</a></li>
                        <li><a data-toggle="tab" href="#up-med">Bệnh sử</a></li>
                     </ul>

                     <div class="tab-content">
                        <!-- Lich hen -->
                        <div id="up-info" class="tab-pane tab-ct fade in active">
                           <div class="col-xs-12 form-horizontal">
                              <div class="form-group">
                                 <label class="col-xs-4 control-label required" for="Customer_up_fullname" style="margin-top: -10px">
                                    <img style="width: 40px;" src="<?php echo Yii::app()->getBaseUrl(); ?>/upload/customer/no_avatar.png" id="img_cus" />
                                 </label>
                                 <div class="col-xs-6 padding-left-0">
                                    <input placeholder="Họ và tên" value="" class="ckError read form-control" name="Customer[fullname]" id="Customer_up_fullname" type="text" />
                                    <div class="help-block error" id="Customer_up_fullname_em_" style="display:none"></div>
                                 </div>
                                 <div class="col-xs-1 load-up-cus padding-left-0">
                                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                 </div>
                              </div>

                              <div class="form-group">
                                 <label class="col-xs-4 control-label required" for="Customer_up_code_number">
                                   Mã khách hàng
                                 </label>
                                 <div class="col-xs-6 padding-left-0">
                                    <div class="Customer_up_code_number_remain" data-toggle="tooltip" data-placement="right" title="" data-original-title="">
                                       <input placeholder="Mã khách hàng" value="" class="ckError read form-control Customer_up_code_number" type="text" />
                                    </div>
                                    <div class="help-block error" id="Customer_up_code_number_em_" style="display:none"></div>
                                 </div>
                                 <div class="col-xs-1 load-up-cus padding-left-0">
                                    <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                 </div>
                              </div>

                                 <input class="" name="Customer[id]" id="Customer_up_id" type="hidden" />

                                 <div class="form-group">
                                    <label class="col-xs-4 control-label required" for="Customer_up_phone">Số điện thoại <span class="required">*</span></label>
                                    <div class="col-xs-6 padding-left-0">
                                       <input placeholder="Số điện thoại" value="" class="ckError read form-control" name="Customer[phone]" id="Customer_up_phone" type="text" maxlength="20" />
                                       <div class="help-block error" id="Customer_up_phone_em_" style="display:none"></div>
                                    </div>
                                    <div class="col-xs-1 load-up-cus padding-left-0">
                                       <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                    <label class="col-xs-4 control-label" for="Customer_up_email">Email</label>
                                    <div class="col-xs-6 padding-left-0">
                                       <input placeholder="Email" value="" class="read form-control" name="Customer[email]" id="Customer_up_email" type="text" maxlength="255" />
                                       <div class="help-block error" id="Customer_up_email_em_" style="display:none"></div>
                                    </div>
                                    <div class="col-xs-1 load-up-cus padding-left-0">
                                       <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                    <label class="col-xs-4 control-label" for="Customer_up_gender">Giới tính</label>
                                    <div class="col-xs-6 padding-left-0">
                                       <select value="" class="read form-control" name="Customer[gender]" id="Customer_up_gender">
                                          <option value="0" selected="selected">Nam</option>
                                          <option value="1">Nữ</option>
                                       </select>
                                       <div class="help-block error" id="Customer_up_gender_em_" style="display:none"></div>
                                    </div>
                                    <div class="col-xs-1 load-up-cus padding-left-0">
                                       <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                    <label class="col-xs-4 control-label" for="Customer_up_birthdate">Ngày sinh</label>
                                    <div class="col-xs-6 padding-left-0">
                                       <input placeholder="Ngày sinh" value="" class="read form-control" name="Customer[birthdate]" id="Customer_up_birthdate" type="text" />
                                       <div class="help-block error" id="Customer_up_birthdate_em_" style="display:none"></div>
                                    </div>
                                    <div class="col-xs-1 load-up-cus padding-left-0">
                                       <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                    </div>
                                 </div>

                                 <!-- <div class="form-group">
                                    <label class="col-xs-4 control-label" for="Customer_up_identity_card_number">CMND</label>
                                    <div class="col-xs-6 padding-left-0">
                                       <input placeholder="CMND" value="" class="read form-control" name="Customer[identity_card_number]" id="Customer_up_identity_card_number" type="text" maxlength="20" />
                                       <div class="help-block error" id="Customer_up_identity_card_number_em_" style="display:none"></div>
                                    </div>
                                    <div class="col-xs-1 load-up-cus padding-left-0">
                                       <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                    </div>
                                 </div> -->

                                 <div class="form-group">
                                    <label class="col-xs-4 control-label">Nguồn KH</label>
                                    <div class="col-xs-6 padding-left-0">
                                      <?php echo CHtml::dropDownList('Customer[id_source]','',$source, array('class'=>'form-control read', 'id' => 'Customer_up_id_source', 'empty' => 'Chọn nguồn KH')); ?>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                    <label class="col-xs-4 control-label" for="Customer_up_id_country">Quốc tịch</label>
                                    <div class="col-xs-6 padding-left-0">
                                       <input placeholder="Quốc tịch" value="" class="read form-control" name="Customer[id_country]" id="Customer_up_id_country" type="text" maxlength="255" />
                                       <div class="help-block error" id="Customer_up_id_country_em_" style="display:none"></div>
                                    </div>
                                    <div class="col-xs-1 load-up-cus padding-left-0">
                                       <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                    <div class="col-xs-11 btn_cus text-right">
                                       <!-- <button type="button" class="btn btn_book up_sch_cus" style="color: white;">Cập nhật</button> -->
                                    </div>
                                 </div>

                           </div>
                        </div>

                        <!-- Benh su -->
                        <div id="up-med" class="tab-pane fade">
                           <form enctype="multipart/form-data" class="form-horizontal" id="frm-up-med_alert" action="" method="post">

                           <h5 class="text-center">Bệnh sử y khoa</h5>
                           <div id="medi">
                              <div class="col-xs-10 col-xs-offset-1">
                               <input type="hidden" id="cusForMed" name="CsMedicalHistoryAlert[id_customer]">
                                 <?php
                                    $t = 0;
                                    $alert      =  MedicineAlert::model()->findAllByAttributes(array('status'=>1));
                                    $alert      =  CHtml::listData($alert,'id','name');


                                    foreach ($alert as $key => $value):
                                 ?>


                                 <div class="checkbox">
                                    <label>
                                       <input id="ytCsMedicalHistoryAlert_id_medicine_alert_<?php echo $key; ?>" type="hidden" value="0" name="CsMedicalHistoryAlert[id_medicine_alert][<?php echo $key; ?>]">

                                       <input class="me_ck" name="CsMedicalHistoryAlert[id_medicine_alert][<?php echo $key; ?>]" id="CsMedicalHistoryAlert_up_id_medicine_alert_<?php echo $key; ?>" value="1" type="checkbox">
                                       <?php echo $value; ?>
                                    </label>
                                    <input style="display: none;" type="text" name="CsMedicalHistoryAlert[note][<?php echo $key; ?>]" id="CsMedicalHistoryAlert_up_note_<?php echo $key; ?>" class="form-control me_inp">
                                 </div>
                                 <?php endforeach ?>
                              </div>

                              <div class="form-group">
                                 <div class="col-xs-11 text-right" style="margin: 10px 0;">
                                     <button type="submit" class="btn btn_book" id="updateMedHis" style="color: white;">Cập nhật</button>
                                  </div>
                              </div>
                           </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>

<script>
   //#region --- LAY THONG TIN NHOM KHACH HANG
   function getCustomerSegment(id_customer) {
      return $.ajax({
         type: "POST",
         url: "<?php echo CController::createUrl('calendar/getCustomerSegment'); ?>",
         data: {
            id_customer: id_customer,
         },
      });
   }
   //#endregion

/*********** Load schedule info update ***********/
   function getInfoUp(id) {
      return $.ajax({
         type     :"POST",
         url      :"<?php echo CController::createUrl('calendar/updateEvent'); ?>",
         dataType    :'json',
         data     : {
            id_schedule: id,
         }
     })
   }
/*********** Show info Schedule ***********/
   function infoUpSch(sch, den, stus,isAcceptChange) {

      if($.isEmptyObject(sch)){ return -1; }

      if (!isAcceptChange) {isAcceptChange = 0 ;}
      //console.log(isAcceptChange);
      $('#update_acceptChange').val(isAcceptChange);

      $date = $('#calendar').fullCalendar('getDate');

      date = $date.format('YYYY-MM-DD');
      st = [];
      st_arr = [];
      if(moment($date).isSame(moment(),'day')){
         if(sch.chair_type == 2){
               // lich moi
               if(sch.status == 1 || stus == 1)
                  st = <?php echo json_encode($this->st1); ?>;
               // xac nhan
               else if(sch.status == 7)
                  st = <?php echo json_encode($this->st7); ?>;
               else if(sch.status == 2)
                  st = <?php echo json_encode($this->st2); ?>;
               else if(sch.status == 3)
                  st = <?php echo json_encode($this->st3); ?>;
               else if(sch.status == -2)
                  st = <?php echo json_encode($this->st0); ?>;
               else if(sch.status == 5)
                  st = <?php echo json_encode($this->st5); ?>;
               else
                  st = <?php echo json_encode($this->status_arr); ?>;
            }
            else if(sch.chair_type == 1){
               if(sch.status == 1 || stus == 1)
                  st = <?php echo json_encode($this->stE1); ?>;
               // xac nhan
               else if(sch.status == 7)
                  st = <?php echo json_encode($this->stE7); ?>;
               else if(sch.status == 6)
                  st = <?php echo json_encode($this->stE2); ?>;
               else if(sch.status == -2)
                  st = <?php echo json_encode($this->stE0); ?>;
               else if(sch.status == 5)
                  st = <?php echo json_encode($this->stE5); ?>;
               else
                  st = <?php echo json_encode($this->status_arr); ?>;
            }
      }
      else {
         if(sch.chair_type == 2){
               st = <?php echo json_encode($this->st1); ?>;
            }
            else if(sch.chair_type == 1){
               st = <?php echo json_encode($this->stE1); ?>;
            }
      }

      stOp = '';
      if(st) {
         $.each(st, function (k, v) {
            stOp +=  '<option value="'+k+'">'+v+'</option>';
         })
      }
      if(stOp == '') {
         $.each(st_arr, function (k, v) {
            if(k == sch.status)
               stOp +=  '<option value="'+k+'">'+v+'</option>';
         })
      }

     $('#CsSchedule_up_status').html(stOp);

      // dentist
      if(den != 1)
         $('#CsSchedule_up_id_dentist').html('<option value="'+sch.id_dentist+'">'+sch.name_dentist+'</option>');

      if(sch.id_service == 0) {
         sv = 'Không làm việc';
      }
      else
         sv = sch.name_service;

      servicesList(sch.id_dentist, sch.id_service, 1 , 1, sch.id_service);

      // services
      $('#CsSchedule_up_id_service').html('<option value="'+sch.id_service+'">'+sv+'</option>');

      $.each(sch, function (k, v) {
         $('#CsSchedule_up_'+k).val(v);
      })

      $('#CsSchedule_up_status_customer').val(sch.status_sch_customer);
      $('.load-up-at, .load-at').fadeOut('fast');
   }
/*********** Show info customer ***********/
   function infoUpCus(cus,codeNumberRemain,codeNumberExp) {
      if($.isEmptyObject(cus))
         return -1;

      $.each(cus, function (k, v) {
         $('#Customer_up_'+k).val(v);
      })

      $('#CsSchedule_up_id_customer').val(cus.id);
      $('#CsSchedule_up_code_number').val(cus.code_number);
      $('.Customer_up_code_number').val(cus.code_number);
      $('#Customer_up_birthdate').val(moment(cus.birthdate).format('DD/MM/YYYY'));
      $('.Customer_up_code_number_remain').attr('title', codeNumberRemain);
      $('.Customer_up_code_number_remain').attr('data-original-title', codeNumberRemain);
      $('#updateCodeNumber').val(codeNumberExp);
      // updateCodeNumberRe
      $('#updateCodeNumberRe').val(codeNumberExp);

      $('#cusForMed').val(cus['id']);

      $('.read').attr('readonly',true);

      $('.load-up-cus').fadeOut('fast');
   }
/*********** Show info Medical Alert ***********/
   function infoUpAl(als) {
      $('.me_inp').val('');
      $('.me_ck').prop('checked',false);
      if($.isEmptyObject(als))
         return -1;
      $.each(als, function (k,v) {
         $('#CsMedicalHistoryAlert_up_id_medicine_alert_'+k).prop('checked',true);
         $('#CsMedicalHistoryAlert_up_note_'+k).val(v);
         $('#CsMedicalHistoryAlert_up_note_'+k).show();
      })
   }
/*********** Action update Schedule + Customer ***********/
   function updateSchCus(formData) {

      return  jQuery.ajax({
            type     :  "POST",
            url      :  "<?php echo CController::createUrl('calendar/updateEvent')?>",
            data     :  formData,
            dataType :  'json',
            cache    : false,
            contentType: false,
            processData: false
         });
   }
/*********** Check Schedule ***********/
   function checkSchUp(id_dentist, id_services, len) {
      ck = true;
      // check dentist
      if(!id_dentist) {
         $($('#CsSchedule_up_id_dentist').data('select2').$container).addClass('errors');
         ck = false;
      }
      else {
         $($('#CsSchedule_up_id_dentist').data('select2').$container).removeClass('errors');
      }

      // check services
      if(!id_services) {
         $($('#CsSchedule_up_id_service').data('select2').$container).addClass('errors');
         ck = false;
      }
      else {
         $($('#CsSchedule_up_id_service').data('select2').$container).removeClass('errors');
      }

      // check len
      if(len == 0) {
         $('.len').addClass('errors');
         ck = false;
      }
      else {
         $('.len').removeClass('errors');
      }

      return ck;
   }
/*********** Check Time ***********/
   function chkTimeUp(id_dentist, id_services, start, len, id_schedule,status_sch) {
      $chk = 1;

      chkSch = checkSchUp(id_dentist, id_services, len);

      if(!chkSch) {
         $chk = 0;
         $('#create_up_chkT').val(0);
         return;
      }

      if(!moment(start).isValid()) {
         $('#CsSchedule_up_start_time').addClass('errors');
         $chk = 0;
      }

      startT = moment(start).format("YYYY-MM-DD HH:mm:ss");
      end    = moment(start).add(len,'m').format("YYYY-MM-DD HH:mm:ss");

      $('#CsSchedule_up_end_time').val(end);

      if($chk == 0) {
         $('#create_up_chkT').val(0);
         $('.up_sch').addClass('unbtn');
         return ;
      }

      id_customer = $('#CsSchedule_up_id_customer').val();
      update_acceptChange = $('#update_acceptChange').val();

      if(status_sch == 5 || status_sch == -1 || status_sch == -2) {
            $('#step-1').removeClass('unbtn');
            $('.up-sch').removeClass('unbtn');
      } else {
         $('.up-sch').addClass('unbtn');
         $.when(checkTimeAjax(id_dentist, startT, end, id_schedule,status_sch,id_customer)).done(function (data) {
            checkTime(data,update_acceptChange)
         });
      }
   }
/*********** Update medical alert ***********/
   function upMedAlert() {
     var searchIDs = $('#up-med input[type="checkBox"]:checked').map(function(){
         return $(this).val();
       }).get(); // <----
   }

</script>

<script>
$(window).load(function (e) {
   id_dentist = $('#CsSchedule_up_id_dentist').val();
   servicesList(id_dentist, 2, '', 1);
// change status customer
   $('#CsSchedule_up_status_customer').change(function(e){
      id_dentist  = $('#CsSchedule_up_id_dentist').val();
      id_services = $('#CsSchedule_up_id_service').val();
      start       = moment($('#CsSchedule_up_start_time').val());
      len         = $('#CsSchedule_up_lenght').val();
      id_schedule = $('#CsSchedule_up_id').val();
      status = $('#CsSchedule_up_status').val();

      chkTimeUp(id_dentist, id_services, start, len, id_schedule,status);
   })
// change dentist
   $('#CsSchedule_up_id_dentist').change(function(){
      var id_dentist = $('#CsSchedule_up_id_dentist').val();

      $('#CsSchedule_up_id_service').html('');
      $('#CsSchedule_up_lenght').val(0);

      servicesList(id_dentist, 2, '', 1);

      $($('#CsSchedule_up_id_service').data('select2').$container).addClass('errors');

   });
// change services
   $('#CsSchedule_up_id_service').change(function(e){
      var id_services = $('#CsSchedule_up_id_service').val();

      if(!id_services) {
         $($('#CsSchedule_up_id_service').data('select2').$container).addClass('errors');
         $('#CsSchedule_up_lenght').val(0);
         $('#CsSchedule_up_lenght').addClass('errors');
      }
      else {
         $($('#CsSchedule_up_id_service').data('select2').$container).removeClass('errors');

         data  = $('#CsSchedule_up_id_service').select2('data');
         len   = data[0].len;

         if(typeof len === 'undefined')
            len = 45;

         id_dentist  = $('#CsSchedule_up_id_dentist').val();
         start       = moment($('#CsSchedule_up_start_time').val());
         id_schedule = $('#CsSchedule_up_id').val();
         status = $('#CsSchedule_up_status').val();

         chkTimeUp(id_dentist, id_services, start, len, id_schedule, status);

         $('#CsSchedule_up_lenght').val(len);
         $('#CsSchedule_up_lenght').removeClass('errors');
      }
   })
// change length services
   $('#CsSchedule_up_lenght').on('input',function(e){
      id_dentist  = $('#CsSchedule_up_id_dentist').val();
      id_services = $('#CsSchedule_up_id_service').val();
      start       = moment($('#CsSchedule_up_start_time').val());
      len         = $('#CsSchedule_up_lenght').val();
      id_schedule = $('#CsSchedule_up_id').val();
      status = $('#CsSchedule_up_status').val();

      chkTimeUp(id_dentist, id_services, start, len, id_schedule, status);
   })
// change start_time
   $('#CsSchedule_up_start_time').on('dp.change',function(){
      id_dentist  = $('#CsSchedule_up_id_dentist').val();
      id_services = $('#CsSchedule_up_id_service').val();
      len      = $('#CsSchedule_up_lenght').val();
      start       = moment($('#CsSchedule_up_start_time').val());
      id_schedule = $('#CsSchedule_up_id').val();
      status = $('#CsSchedule_up_status').val();

      chkTimeUp(id_dentist, id_services, start, len, id_schedule,status);
   })
// change status
   $('#CsSchedule_up_status').on('change',function(){
      id_dentist  = $('#CsSchedule_up_id_dentist').val();
      id_services = $('#CsSchedule_up_id_service').val();
      len      = $('#CsSchedule_up_lenght').val();
      start       = moment($('#CsSchedule_up_start_time').val());
      id_schedule = $('#CsSchedule_up_id').val();
      status = $('#CsSchedule_up_status').val();

      chkTimeUp(id_dentist, id_services, start, len, id_schedule,status);
   })

   // update note
   $('#CsSchedule_up_note').on('input',function(e){
      $('.up-sch').removeClass("unbtn");
   })
// kiem tra ma khach hang
   $('.btnUpCode').click(function(e){
      code_number = $('#updateCodeNumber').val();

      if(!code_number || code_number.length != 10){
         $('#upCode .error').text("Mã khách hàng trống hoặc không đúng định dạng!");
         return;
      }

      $('#CsSchedule_up_code_number').val("");
      $('.Customer_up_code_number').val("");

      customer_info_id = $('#Customer_info_id').val();

      if(!customer_info_id){     // kiem tra ma khach hang
         $.ajax({
            url: '<?php echo CController::createUrl('calendar/checkCodeNumber')?>',
            type: 'POST',
            dataType: 'json',
            data: {code_number: code_number},
            success: function(data){
               if(data == 1){
                  $('.Customer_up_code_number').val(code_number);
                  $('#upCode').modal("hide");
                  $('#upCode .error').text("");
                  $('.up-sch').click();
                  $('#Customer_info_id').val("");
                  $('.Customer_info').hide();
               } else {
                  $('.Customer_info').show();
                  $('#upCode .error').text("Mã khách hàng đã tồn tại!");
                  $('#Customer_info_id').val(data[0]['id']);
                  $('#Customer_info_code_number').text(data[0]['code_number']);
                  $('#Customer_info_fullname').text(data[0]['fullname']);
                  $('#Customer_info_phone').text(data[0]['phone']);
                  $('#Customer_info_birthdate').text(moment(data[0]['birthdate']).format('DD/MM/YYYY'));
                  $('#Customer_info_address').text(data[0]['address']);
               }
            }
         });
      } else {             // cap nhat ma khach hang vao lich
         $('.Customer_up_code_number').val(code_number);
         $('#CsSchedule_up_code_number').val(code_number);
         $('#CsSchedule_up_id_customer').val(customer_info_id);
         $('#upCode').modal("hide");
         $('#upCode .error').text("");
         $('.up-sch').click();
         $('#Customer_info_id').val("");
         $('.Customer_info').hide();
      }
   })
// update schedule
   $('.up-sch').click(function (e) {
      e.preventDefault();

      if($('.up-sch').hasClass('unbtn')) {
         return;
      }

      status = $('#CsSchedule_up_status').val();
      code_number = $('.Customer_up_code_number').val();

      if(status == 6 || status == 2 || status == 4 || status == 3) {
         if(code_number.length != 10){
            code_number_re = $("#updateCodeNumber").val();
            $('.Customer_up_code_number').val(code_number_re);
            $('#upCode .error').text("");
            $('#Customer_info_id').val("");
            $('.Customer_info').hide();
            $('#upCode').modal("show");
            return;
         }
      }

      if ($('#CsSchedule_up_id_chair').val() == '' || $('#CsSchedule_up_id_chair').val() == 0 ||
         $('#CsSchedule_up_id_branch').val() == '' || $('#CsSchedule_up_id_branch').val() == 0) {
         alert("Có lỗi xảy ra. Xin vui lòng thử lại sau!");
         return;
      }

      var formData   = new FormData($("#frm-up-sch")[0]);

      if (!formData.checkValidity || formData.checkValidity()) {
         if($('.up-sch').hasClass('up_sch_cus')) {

            $.when(updateSchCus(formData)).done(function (data) {
            	if(data == -3){
            		$('#upCode').modal("show");
            		$('#upCode .error').text("Tồn tại mã khách hàng!");
            	}
            	else {
            		$('#calendar').fullCalendar( 'removeEvents', data.id );
	               $('#calendar').fullCalendar( 'renderEvent', data, true );
	               $('#update_sch_modal').modal('hide');
	               getNoti(data.id,'update',<?php echo Yii::app()->user->getState('user_id'); ?>, data.id_dentist);
            	}

            });
         }
         else if($('.up-sch').hasClass('up_next')) {
            $.when(addSchCus(formData)).done(function (data) {
               $('#frm-create-sch')[0].reset();
               $('.read').attr('readonly',false);
               $('.cal-loading').fadeOut('fast');

               if(data.status == 1){
                  $('.help-block').hide();
                  $('.ckError').removeClass('errors');

                  $('#calendar').fullCalendar('renderEvent',data.data,true);
                  $('#update_sch_modal').modal('hide');
               }
            })
         }
      }
   });
// delete schedule
   $('.del-sch').click(function (e) {
      e.preventDefault();
      id       = $('#CsSchedule_up_id').val();
      id_quote = $('#CsSchedule_up_id_quotation').val();
      st       = $('#CsSchedule_up_status').val();
      id_dentist  = $('#CsSchedule_up_id_dentist').val();

      if(id_quote || st == 4) {
         $('#info_content').html('Lịch hẹn đã hoàn tất hay có báo giá.<br/> Bạn không thể xóa lịch hẹn này!');
         $("#info").modal();
      }
      else {
         delEv(id);
      }
   })
// check medical alert (benh su y khoa)
   $('.me_ck').change(function (e) {
      idCk = $(this).attr('id');
      ck   = $(this).is(':checked');
      idNote = idCk.replace('id_medicine_alert','note');
      if(ck == true) {
         $('#'+idNote).show();
      }
      else {
         $('#'+idNote).val('');
         $('#'+idNote).hide();
      }
   })

$('#frm-up-med_alert').submit(function(e) {
   e.preventDefault();

   var formData   = new FormData($("#frm-up-med_alert")[0]);

   $.ajax({
      type     :  "POST",
      url      :  "<?php echo CController::createUrl('calendar/updateMediAlert')?>",
      data     :  formData,
      dataType :  'json',
      success: function (data) {
         if(data == 1)
            $('#update_sch_modal').modal('hide');
      },
      cache    : false,
      contentType: false,
      processData: false
   });
});
})
</script>