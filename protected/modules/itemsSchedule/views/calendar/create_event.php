<style>
input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance:textfield;
}
#frm-create-sch .form-group {margin-bottom: 10px;}
</style>
<?php $baseUrl = Yii::app()->getBaseUrl(); ?>

<div id="create_sch_modal" class="modal calendarModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">close</span></button>
            <h3 id="modalTitle" class="modal-title">TẠO LỊCH HẸN</h3>
         </div>

         <div id="modalBody" class="modal-body">
         <div class="row">
         <?php /** @var TbActiveForm $form */
         $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
                 'id'               =>    'frm-create-sch',
                 'type'                =>    'horizontal',
                 'enableAjaxValidation'   => true,
                 'clientOptions'       => array(
                     'validateOnSubmit'      => true,
                     'validateOnChange'      => true,
                     'validateOnType'     => true,
                 ),
                 'htmlOptions'         => array(
                     'enctype'            =>    'multipart/form-data'
                 ),
             )
      ); ?>

            <ul class="nav nav-tabs nav-1">
               <li id="nav-sch" class="active"><a data-toggle="tab" href="#tab-schedule">Lịch Hẹn</a></li>
               <li id="nav-cus"><a data-toggle="tab" href="#customer">Khách Hàng</a></li>
            </ul>

            <div class="tab-content">
               <!-- Lich hen -->
               <div id="tab-schedule" class="tab-pane tab-ct fade in active">
               <div class="col-xs-6 col-xs-offset-1">
                     <h4>Trạng thái lịch hẹn</h4>
               </div>
               <div class="col-xs-4">
                  <?php
                     echo $form->dropDownListGroup($sch, "status",array(
                        'wrapperHtmlOptions' => array('class' => 'col-xs-12',),
                        'widgetOptions'=>array(
                           'htmlOptions'=>array('required'=>false,'placeholder'=>'','class'=>'')),
                           'labelOptions' => array("label" => false)
                     ));
                  ?>
               </div>
               <div class="clearfix"></div>

               <div class="col-xs-6 col-xs-offset-1">
                     <h4>Trạng thái hồ sơ</h4>
               </div>
               <div class="col-xs-4">
                  <?php
                     echo $form->dropDownListGroup($sch, "status_customer",array(
                        'wrapperHtmlOptions' => array('class' => 'col-xs-12',),
                        'widgetOptions'=>array(
                           'data'   => array('0' => 'Chưa sẵn sàng', '1'=>'Đã sẵn sàng'),
                           'htmlOptions'=>array('required'=>false,'placeholder'=>'','class'=>'')),
                           'labelOptions' => array("label" => false)
                     ));
                  ?>
               </div>

                   <?php
                     echo $form->hiddenField($sch,'id_author',array('value'=>Yii::app()->user->getState("user_id")));
                     echo $form->hiddenField($sch,'id_chair',array('class'=>'chair'));
                     echo $form->hiddenField($sch,'id_branch',array('class'=>'branch'));
                     echo $form->hiddenField($sch,'end_time',array('class'=>'end_time'));
                     echo CHtml::hiddenField('checkT',0,array('class'=>'chkT','id'=>'create_chkT'));
                     echo CHtml::hiddenField('acceptChange',0,array('class'=>'acceptChange','id'=>'create_acceptChange')); ?>

                     <input name="CsSchedule[type]" class="Csh_type" type="hidden" />
                     <div class="form-group">
                        <label class="col-xs-4 control-label" for="CsSchedule_id_dentist">Nha sỹ</label>
                        <div class="col-xs-6">
                           <select placeholder="" class="sch_dentist form-control" name="CsSchedule[id_dentist]" id="CsSchedule_id_dentist"></select>
                        </div>
                        <div class="col-xs-1 load-at load-dt padding-left-0">
                           <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-xs-4 control-label" for="CsSchedule_id_service">Dịch vụ</label>
                        <div class="col-xs-6">
                           <select placeholder="" class="sch_service form-control" name="CsSchedule[id_service]" id="CsSchedule_id_service"></select>
                        </div>
                        <div class="col-xs-1 load-at padding-left-0" id="load-sv">
                           <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-xs-4 control-label" for="CsSchedule_lenght">Thời gian</label>
                        <div class="col-xs-6">
                           <div class="input-group">
                             <input type="number" class="len times form-control" name="CsSchedule[lenght]" id="CsSchedule_lenght" min="0" max="300" step="5">
                              <span class="input-group-addon">phút</span>
                           </div>
                        </div>
                        <div class="col-xs-1 load-at padding-left-0" id="load-ti">
                           <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-xs-4 control-label" for="CsSchedule_start_time">Ngày giờ</label>
                        <div class="col-xs-6 times">
                           <input required="required" placeholder="" class="group_time datetimepicker form-control" name="CsSchedule[start_time]" id="CsSchedule_start_time" type="text" />
                        </div>
                        <div class="col-xs-1 load-at padding-left-0" id="load-da">
                           <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        </div>
                     </div>

                  <?php // thoi gian thuc hien

                  echo $form->textAreaGroup($sch,'note',array(
                     'wrapperHtmlOptions' => array('class' => 'col-xs-6',),
                     'widgetOptions'=>array(
                        'htmlOptions'=>array()),
                        'labelOptions' => array("label" => 'Ghi chú','class' => 'col-xs-4')
                  ));
                  ?>
                  <div class="form-group">
                     <div class="col-xs-10">
                        <button type="button" class="btn btn_book pull-right col-xs-4" id="step-1" style="color: white;">Tiếp tục</button>
                     </div>
                  </div>
               </div>

               <!-- Khach hang -->
               <div id="customer" class="tab-pane fade">
                     <div id="srch-cus" class="col-xs-12 tab-ct">
                        <?php
                           echo $form->dropDownListGroup($sch, 'id_customer',array(
                              'wrapperHtmlOptions' => array('class' => 'col-xs-8 col-xs-offset-2',),
                              'widgetOptions' => array(
                                 'htmlOptions'=>array('class'=>'customer','required'=>false)),
                                 'labelOptions' => array("label" => false)
                           ));
                         ?>
                         <div class="col-xs-12 text-center" id="t-cus" style="margin-bottom: 20px;">
                            <button type="button" class="btn btn_book" id="new-cus">Khách mới</button>
                         </div>
                     </div>

                     <div class="clearfix"></div>
                     <div id="show-cus" style="display: none;">
                        <ul class="nav nav-tabs nav-2 nav-justified">
                           <li class="active"><a data-toggle="tab" href="#tab-info">Thông tin</a></li>
                           <li><a data-toggle="tab" href="#medical">Bệnh sử</a></li>
                        </ul>

                        <div class="tab-content">
                           <!-- Lich hen -->
                           <div id="tab-info" class="tab-pane tab-ct fade in active">
                              <div class="col-xs-12">
                              <?php
                                 $img  =  '<img src="'.$baseUrl.'/upload/customer/no_avatar.png" id="img_cus" />';
                                 echo $form->textFieldGroup($cus, "fullname",array(
                                    'wrapperHtmlOptions' => array('class' => 'col-xs-7 padding-left-0',),
                                    'widgetOptions'=>array(
                                       'htmlOptions'=>array('required'=>false,'placeholder'=>'Họ và tên','value'=>'', 'class'=>'ckError read')),
                                       'labelOptions' => array("label" => $img,'class' => 'col-xs-4')
                                 ));

                                 echo '<div id="Customer_code_number_remain" data-toggle="tooltip" data-placement="right" title="" data-original-title="">';
                                 echo $form->textFieldGroup($cus, "code_number",array(
                                    'wrapperHtmlOptions' => array('class' => 'col-xs-7 padding-left-0',),
                                    'widgetOptions'=>array(
                                       'htmlOptions'=>array('required'=>'','placeholder'=>'Mã khách hàng','value'=>'', 'class'=>'ckError read')),
                                       'labelOptions' => array("label" => 'Mã khách hàng','class' => 'col-xs-4')
                                 ));
                                 echo "</div>";

                                 echo $form->hiddenField($cus,'id',array('class'=>''));

                                 echo $form->textFieldGroup($cus, "phone",array(
                                    'wrapperHtmlOptions' => array('class' => 'col-xs-7 padding-left-0',),
                                    'widgetOptions'=>array(
                                       'htmlOptions'=>array('placeholder'=>'Số điện thoại','value'=>'', 'class'=>'ckError read')),
                                       'labelOptions' => array("label" => 'Số điện thoại','class' => 'col-xs-4')
                                 ));

                                 echo $form->textFieldGroup($cus, "email",array(
                                    'wrapperHtmlOptions' => array('class' => 'col-xs-7 padding-left-0',),
                                    'widgetOptions'=>array(
                                       'htmlOptions'=>array('required'=>'','placeholder'=>'Email','value'=>'', 'class'=>'read')),
                                       'labelOptions' => array("label" => 'Email','class' => 'col-xs-4')
                                 )); ?>

                              <div class="form-group">
                                 <label class="col-xs-4 control-label" for="Customer_gender">Giới tính</label>
                                 <div class="col-xs-6 padding-left-0">
                                    <select class="read form-control" name="Customer[gender]" id="Customer_gender">
                                       <option value="0">Nam</option>
                                       <option value="1">Nữ</option>
                                    </select>
                                    <div class="help-block error" id="Customer_gender_em_" style="display:none"></div>
                                 </div>
                              </div>

                              <?php
                                 echo $form->textFieldGroup($cus, "birthdate",array(
                                    'wrapperHtmlOptions' => array('class' => 'col-xs-6 padding-left-0',),
                                    'widgetOptions'=>array(
                                       'htmlOptions'=>array('required'=>'','placeholder'=>'Ngày sinh','value'=>'', 'class'=>'read')),
                                       'labelOptions' => array("label" => 'Ngày sinh','class' => 'col-xs-4')
                              ));?>

                              <?php
                                 // echo $form->textFieldGroup($cus, "identity_card_number",array(
                                 //    'wrapperHtmlOptions' => array('class' => 'col-xs-7 padding-left-0',),
                                 //    'widgetOptions'=>array(
                                 //       'htmlOptions'=>array('required'=>'','placeholder'=>'CMND','value'=>'', 'class'=>'read')),
                                 //       'labelOptions' => array("label" => 'CMND','class' => 'col-xs-4')
                                 // ));
                              ?>

                                 <div class="form-group">
                                    <label class="col-xs-4 control-label">Nguồn KH</label>
                                    <div class="col-xs-6 padding-left-0">
                                      <?php echo CHtml::dropDownList('Customer[id_source]','',$source, array('class'=>'form-control read', 'empty' => 'Chọn nguồn KH')); ?>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                    <label class="col-xs-4 control-label" for="Customer_cus_seg">Quốc tịch</label>
                                    <div class="col-xs-6 padding-left-0">
                                      <?php echo CHtml::dropDownList('Customer[id_country]','VN',$country, array('class'=>'form-control read')); ?>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                    <div class="col-xs-11 btn_cus text-right">
                                       <button type="button" class="btn btn_book" id="step-pre" style="color: white;">Quay lại</button>
                                       <button type="button" class="btn btn_book" id="step-2" style="color: white;">Tiếp tục</button>
                                    </div>
                                 </div>
                              <?php
                                 $this->endWidget();
                                 unset($form);
                              ?>
                              </div>
                           </div>

                           <!-- Benh su -->
                           <div id="medical" class="tab-pane fade">
                              <h5 class="text-center">Bệnh sử y khoa</h5>
                              <div id="medi">
                              <div class="col-xs-10 col-xs-offset-1">
                              <?php
                                 $t = 0;
                                 $alert =  MedicineAlert::model()->findAllByAttributes(array('status'=>1));
                                 $alert =  CHtml::listData($alert,'id','name');

                                 foreach ($alert as $key => $value):
                                    $checked = '';
                                    $dis = 'style="display: none;"';
                                    if(isset($als[$t]) && $key == $als[$t]) {
                                       $checked = 'checked';
                                       $dis = '';
                                       $t++;

                                    }
                              ?>

                              <div class="checkbox">
                                 <label>
                                    <input id="ytCsMedicalHistoryAlert_id_medicine_alert_<?php echo $key; ?>" type="hidden" value="0" name="CsMedicalHistoryAlert[id_medicine_alert][<?php echo $key; ?>]">

                                    <input class="alCk" <?php echo $checked; ?> name="CsMedicalHistoryAlert[id_medicine_alert][<?php echo $key; ?>]" id="CsMedicalHistoryAlert_id_medicine_alert_<?php echo $key; ?>" value="1" type="checkbox">
                                    <?php echo $value; ?>
                                 </label>
                                 <input <?php echo $dis; ?> type="text" name="CsMedicalHistoryAlert[note][<?php echo $key; ?>]" id="CsMedicalHistoryAlert_note_<?php echo $key; ?>" value="" placeholder="" class="form-control">
                              </div>
                              <?php endforeach ?>
                           </div>

                           <div class="form-group">
                              <div class="col-xs-11 text-right" style="margin: 10px 0;">
                              <?php if ($upSch == 1): ?>
                                 <button type="submit" class="btn btn_book" id="step-4" style="color: white;">Đặt lịch</button>
                              <?php endif ?>
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
      </div>
   </div>
</div>

<script>
/*********** Check Schedule ***********/
   function checkSch(id_dentist, id_services, len) {
      ck = true;
      if(len == 0) {
         $('.len').addClass('errors');
         ck = false;
      }
      else { $('.len').removeClass('errors'); }

      return ck;
   }
/*********** Check Time ***********/
   function chkTime(id_dentist, id_services, start, len, chk, status) {
      $chk = 1;

      $('#step-1').attr('class','btn btn_book pull-right col-xs-4');
      if(id_services == 0) {
         $('#step-1').addClass('brTime');
      }

      chkSch = checkSch(id_dentist, id_services, len);

      if(!chkSch) {
         $chk = 0;
         $('#create_chkT').val(0);
         return;
      }

      if(!moment(start).isValid()) {
         $('#CsSchedule_start_time').addClass('errors');
         $chk = 0;
      }

      startT      = moment(start).format("YYYY-MM-DD HH:mm:ss");
      end         = moment(start).add(len,'m').format("YYYY-MM-DD HH:mm:ss");
      $('#CsSchedule_end_time').val(end);

      if($chk == 0) {
         $('#create_chkT').val(0);
         $('#step-1').addClass('unbtn');
         return ;
      }

      id_customer = $('#CsSchedule_id_customer').val();
      acceptChange = $('#create_acceptChange').val();
      $('#step-1').addClass('unbtn');
      ck = $.when(checkTimeAjax(id_dentist, startT, end, 0, status, id_customer)).done(function (data) {
      	checkTime(data, acceptChange);
      })
   }
/*********** Customer ***********/
   function Customer(id_customer,data) {
      if(id_customer) {
         $('#Customer_fullname').val(data[0].text);
         $('#Customer_phone').val(data[0].phone);
         $('#Customer_code_number').val(data[0].code_number);
         $('#Customer_email').val(data[0].email);
         $('#Customer_gender').val(data[0].gender);
         $('#Customer_id_source').val(data[0].id_source);
         $('#Customer_birthdate').val(moment(data[0].birthdate).format('DD/MM/YYYY'));
         $('#Customer_identity_card_number').val(data[0].identity_card_number);
         $('#Customer_id_country').val(data[0].id_country);
         $('.read').attr('readonly',true);

      } else {
         $('#Customer_fullname').val('');
         $('#Customer_phone').val('');
         $('#Customer_code_number').val('<?php echo $codeNumberExp; ?>');
         $('#Customer_email').val('');
         $('#Customer_gender').val(0);
         $('#Customer_birthdate').val('');
         $('#Customer_identity_card_number').val('');
         $('#Customer_id_country').val('VN');
         $('.read').attr('readonly',false);
      }
   }

   function checkCustomerSchedule(id_customer) {
      $.ajax({
         url     : '<?php echo CController::createUrl('calendar/checkCustomerSchedule'); ?>',
         type    : 'POST',
         dataType: 'json',
         data    : {id_customer: id_customer},
         success:function (data) {
            if(data == 1){
               $('#info_head').text('THÔNG BÁO!');
               $('#info_content').text('Khách hàng có lịch hẹn chưa hoàn tất!');
               $("#info").modal();
            }
            else if(data == 2){
               $('#info_head').text('THÔNG BÁO!');
               $('#info_content').text('Khách hàng có lịch hẹn đang chờ hoặc chưa hoàn tất!');
               $("#info").modal();
               $('#step-2').addClass('unbtn');
            }
         }
      });
   }

   function checkCus(id_customer, fullname, phone) {
      if(id_customer) {
         $('#Customer_fullname').removeClass('errors');
         // $('#Customer_phone').removeClass('errors');
         $('#Customer_id').val(id_customer);
         $('.read').attr('readonly',true);
         $('#step-2').removeClass('unbtn');
         return true;
      }
      else {
         $('#Customer_id').val('');
         $('.read').attr('readonly',false);
         // && phone.match(/^\d+$/)
         if(fullname) {
            $('#Customer_fullname').removeClass('errors');
            // $('#Customer_phone').removeClass('errors');
            $('#step-2').removeClass('unbtn');
            return true;
         }
         else {
            $('#Customer_fullname').addClass('errors');
            // $('#Customer_phone').addClass('errors');
            return false;
         }
      }
      return false;
   }
/*********** Action benh su y khoa ***********/
   function getMedicalAlert(id_customer) {

      $.ajax({
         type     :"POST",
         url      :"<?php echo CController::createUrl('calendar/medicalAlert'); ?>",
         dataType :'json',
         data: {
            id_customer: id_customer,
         },
         success: function (data) {
            $.each(data, function (k,v) {
               $('#CsMedicalHistoryAlert_id_medicine_alert_'+v).prop('checked',true);
            })
         },
      });
   }

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


/*********** Action create new Schedule + Customer ***********/
   function addSchCus(formData) {

      return  jQuery.ajax({
            type     :  "POST",
            url      :  "<?php echo CController::createUrl('calendar/addEvent')?>",
            data     :  formData,
            dataType :  'json',
            cache    : false,
            contentType: false,
            processData: false
         });
   }
/*********** Add break time ***********/
   function addBreak(formData) {
      return  $.ajax({
            type       :  "POST",
            url        :  "<?php echo CController::createUrl('calendar/addBreak')?>",
            data       :  formData,
            dataType   :  'json',
            cache      : false,
            contentType: false,
            processData: false
         });
   }
/*********** Check code number in create new customer ***********/
   function checkCodeNumberInCreateNew() {
      code_number = $('#Customer_code_number').val();

      $.ajax({
         url: '<?php echo CController::createUrl('calendar/checkCodeNumber')?>',
         type: 'POST',
         dataType: 'json',
         data: {code_number: 'code_number'},
         success: function(data){
            if(data == 1){
               $('#Customer_code_number').val(code_number);
               $('#Customer_code_number').removeClass('errors');
            }
            else{
               $('#Customer_code_number').val("");
               $('#Customer_code_number').addClass('errors');
            }
         }
      });
   }
   function formatState (data) {
     if (!data.id) { return data.text; }

     datas = '<div class="col-xs-4">' + data.text + '</div>';
     if(moment(data.birthdate).isValid())
      datas = datas + '<div class="col-xs-2">' + moment(data.birthdate).format("DD/MM/YYYY") + '</div>';
     else
      datas += '<div class="col-xs-2"> &nbsp </div>';

      datas +=  '<div class="col-xs-2">' + data.phone + '</div>';

      datas += '<div class="col-xs-4" style="font-size:12px; padding-right: 0;">' + data.address + '</div>';
     datas += '<div class="clearfix"></div>';
     var $data = $(datas);
     return $data;
   };
</script>

<script>
//$(document).ready(function () {
   $('input[type=number]').on('blur', function (e) {
      $(this).off('mousewheel.disableScroll')
   })
   // preview customer
   $('#step-pre').click(function (e) {
      $('#CsSchedule_id_customer').val(-1).trigger('change');
      $('#srch-cus').show();
      $('#show-cus').hide();
   });

   // change dentist
   $('#CsSchedule_id_dentist').change(function(){
      var id_dentist = $('#CsSchedule_id_dentist').val();
      if(!id_dentist) {
         $($('#CsSchedule_id_dentist').data('select2').$container).addClass('errors');
      }
      else {
         $($('#CsSchedule_id_dentist').data('select2').$container).removeClass('errors');
      }

      $('#CsSchedule_id_service').html('');

      servicesList(id_dentist, chair_type);
      $($('#CsSchedule_id_service').data('select2').$container).addClass('errors');
      $('#CsSchedule_lenght').val(0);
   });

   $('#CsSchedule_id_customer').select2({
         language: 'vi',
         minimumInputLength: 2,
          placeholder: {
            id: -1,
            text: 'Khách hàng'
          },
          width: '100%',
          templateResult: formatState,
          allowClear: true,
          dropdownCssClass: "changeW",
          ajax: {
              dataType : "json",
              url      : '<?php echo CController::createUrl('calendar/getCustomersList'); ?>',
              type     : "post",
              delay    : 500,
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

   // change services
   $('#CsSchedule_id_service').change(function(e){
      var id_services = $('#CsSchedule_id_service').val();

      if(!id_services) {
         $($('#CsSchedule_id_service').data('select2').$container).addClass('errors');
         $('#CsSchedule_lenght').val(0);
         $('#CsSchedule_lenght').addClass('errors');
      }
      else {
         $($('#CsSchedule_id_service').data('select2').$container).removeClass('errors');

         data  = $('#CsSchedule_id_service').select2('data');
         len   = data[0].len;

         id_dentist  = $('#CsSchedule_id_dentist').val();
         start       = moment($('#CsSchedule_start_time').val());
         status  = $('#CsSchedule_status').val();

         chkTime(id_dentist, id_services, start, len, status);

         $('#CsSchedule_lenght').val(len);
         $('#CsSchedule_lenght').removeClass('errors');
      }
   })

   // change length services
   $('#CsSchedule_lenght').on('input', function(e){

      id_dentist  = $('#CsSchedule_id_dentist').val();
      id_services = $('#CsSchedule_id_service').val();
      start       = moment($('#CsSchedule_start_time').val());
      len         = $('#CsSchedule_lenght').val();
      status  = $('#CsSchedule_status').val();

      chkTime(id_dentist, id_services, start, len, status);
   })

   // change start_time
   $('#CsSchedule_start_time').on('dp.change',function(){
      id_dentist  = $('#CsSchedule_id_dentist').val();
      id_services = $('#CsSchedule_id_service').val();
      len      = $('#CsSchedule_lenght').val();
      start       = moment($('#CsSchedule_start_time').val());
      status  = $('#CsSchedule_status').val();

      chkTime(id_dentist, id_services, start, len,status);
   })

   // change tab customer
   $('.nav-tabs a[href="#customer"]').on("click", function(e) {
      e.preventDefault();

      id_dentist     = $('#CsSchedule_id_dentist').val();
      id_services    = $('#CsSchedule_id_service').val();
      len            = $('#CsSchedule_lenght').val();
      start          = moment($('#CsSchedule_start_time').val());
      status  = $('#CsSchedule_status').val();

      ck = chkTime(id_dentist, id_services, start, len, status);

      var ckT = '';
      $.when(ck).done(function(){
         ckT = $('#create_chkT').val();
      });

      if(ckT == 0)
         return false;

      $('.nav-tabs a[href="#tab-info"]').tab('show');
      id_customer = $('#CsSchedule_id_customer').val();

      if(!id_customer) {
         $('#srch-cus').show();
         $('#show-cus').hide();
         $('#step-2').addClass('unbtn');
      }

      $('#step-2').removeClass('unbtn');
   });

   // btn click next step customer
   $('#step-1').click(function(e){
      e.preventDefault();
      if($('#step-1').hasClass('unbtn')) {
         return;
      }

      if($('#step-1').hasClass('brTime')) {
         var formData   = new FormData($("#frm-create-sch")[0]);

         $.when(addBreak(formData)).done(function (data) {
            $('#calendar').fullCalendar('renderEvent',data,true);
            $('#create_sch_modal').modal('hide');
         })
         return;
      }

      id_dentist  = $('#CsSchedule_id_dentist').val();
      id_services = $('#CsSchedule_id_service').val();
      len         = $('#CsSchedule_lenght').val();
      start       = moment($('#CsSchedule_start_time').val());
      ckT         = '';
      status  = $('#CsSchedule_status').val();

      ck = chkTime(id_dentist, id_services, start, len, status);

      $.when(ck).done(function(){
         ckT      = $('#create_chkT').val();
      });

      if(ckT == 1) {
         $('.nav-tabs a[href="#customer"]').tab('show');
         $('.nav-tabs a[href="#tab-info"]').tab('show');

         id_customer = $('#CsSchedule_id_customer').val();

         if(!id_customer) {
            $('#srch-cus').show();
            $('#show-cus').hide();
            $('#step-2').addClass('unbtn');
         }

         $('#step-2').removeClass('unbtn');
      }
   })

   // new customer
   $('#new-cus').click(function (e) {

      $('#srch-cus').hide();
      $('#show-cus').show();
      $('#CsSchedule_id_customer').html('');
      $('#step-2').addClass('unbtn');
      Customer();
   })

   // search customer
   $('#CsSchedule_id_customer').change(function(){

      id_customer    = $('#CsSchedule_id_customer').val();
      data           =  $('#CsSchedule_id_customer').select2('data');

      if(id_customer) {
         $('#srch-cus').hide();
         $('#show-cus').show();
         status = $('#CsSchedule_status').val();
         if(status == 3 || status == 6)
            checkCustomerSchedule(id_customer);
      }

      checkCus(id_customer);
      Customer(id_customer,data);

   });

   $('#Customer_fullname, #Customer_phone').on('keyup',function (e) {
      e.preventDefault();

      fullname = $('#Customer_fullname').val();
      phone =  $('#Customer_phone').val();

      checkCus('', fullname, phone);

      if(customer && phone.match(/^\d+$/)) {
         $('#step-2').removeClass('unbtn');
      }
   })

   $('#Customer_birthdate').datetimepicker({
      maxDate: moment().format('YYYY-MM-DD'),
      format: 'DD/MM/YYYY',
   });

   // change tab medical - chon tab benh su
   $('.nav-tabs a[href="#medical"]').on("click", function(e) {
      e.preventDefault();

      id_customer = $('#CsSchedule_id_customer').val();
      status = $('#CsSchedule_status').val();
      code_number = $('#Customer_code_number').val();

      ckCode = 1;
      if(status == 6 || status == 2){
      	if(!code_number || code_number.length != 10){
      		ckCode = 0;
      	}
      }

      if(id_customer && ckCode) {
         $('.nav-tabs a[href="#medical"]').tab('show');
         getMedicalAlert(id_customer);
      }
      else {
         fullname = $('#Customer_fullname').val();
         phone = $('#Customer_phone').val();

         ckCus = checkCus('', fullname, phone);

         if(ckCus && ckCode) {
            $('.nav-tabs a[href="#medical"]').tab('show');
         }
         if(!ckCode){
         	$('#Customer_code_number').addClass('errors');
         }
         else {
         	$('#Customer_code_number').removeClass('errors');
         }
      }

      return false;
   });

   // check medical alert (benh su y khoa)
   $('.alCk').change(function (e) {
      e.preventDefault();
      idCk = $(this).attr('id');
      ck = $(this).is(':checked');
      idNote = idCk.replace('id_medicine_alert','note');
      if(ck == true) {
         $('#'+idNote).show();
      }
      else {
         $('#'+idNote).val('');
         $('#'+idNote).hide();
      }
   })

   // btn click next step medical
   // $('#step-2').click(function(e){
   //    e.preventDefault();
   //    if($('#step-2').hasClass('unbtn')) {
   //       return;
   //    }

   //    id_customer = $('#CsSchedule_id_customer').val();

   //    status = $('#CsSchedule_status').val();
   //    code_number = $('#Customer_code_number').val();

   //    ckCode = 1;

   //    if(status == 6 || status == 2){
   //    	if(!code_number || code_number.length != 10){
   //    		ckCode = 0;
   //    	}
   //    }

   //    if(id_customer && ckCode) {
   //       $('.nav-tabs a[href="#medical"]').tab('show');
   //       getMedicalAlert(id_customer)
   //    }
   //    else {
   //       fullname = $('#Customer_fullname').val();
   //       phone = $('#Customer_phone').val();

   //       ckCus = checkCus('', fullname, phone);

   //       if(ckCus && ckCode) {
   //          $('.nav-tabs a[href="#medical"]').tab('show');
   //       }
   //       if(!ckCode){
   //       	$('#Customer_code_number').addClass('errors');
   //       }
   //       else {
   //       	$('#Customer_code_number').removeClass('errors');
   //       }
   //    }
   // })
   // btn click next step medical
   $('#step-2').click(function(e){
      e.preventDefault();
      phone = $('#Customer_phone').val();
      jQuery.ajax({          
         type:"POST",
         url: '<?php echo CController::createUrl('calendar/CheckPhone'); ?>',
         data:{
            "phone":phone
         },
         success:function(data){
            console.log(data);
            if (data == "false") {
               console.log("if");
               $('#Customer_phone').addClass('errors');
               return;
            }else{
               console.log("else");
               $('#Customer_phone').removeClass('errors');
            }
            if($('#step-2').hasClass('unbtn')) {
               return;
            }

            id_customer = $('#CsSchedule_id_customer').val();

            status = $('#CsSchedule_status').val();
            code_number = $('#Customer_code_number').val();

            ckCode = 1;

            if(status == 6 || status == 2){
               if(!code_number || code_number.length != 10){
                  ckCode = 0;
               }
            }

            if(id_customer && ckCode) {
               $('.nav-tabs a[href="#medical"]').tab('show');
               getMedicalAlert(id_customer)
            }
            else {
               fullname = $('#Customer_fullname').val();


               ckCus = checkCus('', fullname, phone);

               if(ckCus && ckCode) {
                  $('.nav-tabs a[href="#medical"]').tab('show');
               }
               if(!ckCode){
                  $('#Customer_code_number').addClass('errors');
               }
               else {
                  $('#Customer_code_number').removeClass('errors');
               }

            }
         },
         error: function(data) {
            alert("Error occured. Please try again!");
         },
      });
   })
   // btn dat lich
   $('#step-4').click(function (e) {
      e.preventDefault();

      fullname       = $('#Customer_fullname').val();
      phone          = $('#Customer_phone').val();
      id_customer    = $('#CsSchedule_id_customer').val();

      ckCus       = checkCus(id_customer, fullname, phone);

      if(!ckCus)
         return;
      status  = $('#CsSchedule_status').val();

      //ck = chkTime(id_dentist, id_services, start, len,status);

      var ckT = '';
      //$.when(ck).done(function(){
         ckT = $('#create_chkT').val();

         bd = $('#Customer_birthdate').val();
         $('#Customer_birthdate').val(moment(bd).format('YYYY-MM-DD'));

         var formData   = new FormData($("#frm-create-sch")[0]);

         if(ckT == 1){
            if (!formData.checkValidity || formData.checkValidity()) {
               $('.cal-loading').fadeIn('fast');
               $.when(addSchCus(formData)).done(function (data) {
                  $('.cal-loading').fadeOut('fast');

                  if (data == 0) {
                     if(!alert('Có lỗi xảy ra. Xin vui lòng thử lại sau!')){window.location.reload();}
                     return;
                  }

                  if(data == -5){
                     $('.nav-tabs a[href="#customer"]').tab('show');
                     $('.nav-tabs a[href="#tab-info"]').tab('show');
                     $('#Customer_code_number_em_').text("Mã khách hàng đã tồn tại!");
                     $('#Customer_code_number_em_').show();
                     $('#Customer_code_number').addClass('errors');
                     return;
                  }
                  if(data.status == 0) {
                     $.each(data.error, function (k, v) {
                        $('#Customer_' + k +'_em_').text(v);
                        $('#Customer_' + k +'_em_').show();
                        $('#Customer_' + k).addClass('errors');
                     });
                     $('.nav-tabs a[href="#customer"]').tab('show');
                     $('.nav-tabs a[href="#tab-info"]').tab('show');
                     return;
                  }
                  $('#frm-create-sch')[0].reset();
                  $('.read').attr('readonly',false);

                  if(data.status == 1){
                     $('.help-block').hide();
                     $('.ckError').removeClass('errors');

                     $('#calendar').fullCalendar('renderEvent',data.data,true);
                     $('#create_sch_modal').modal('hide');

                     var userLog   = $('#idUserLog').val();
                     getNoti(data.data.id,'add',userLog, id_dentist);
                  }
               });
            }
         }
      });
   //})
//})


$('#id_branch').on('change',function(){
   $('#CsSchedule_id_branch').val($(this).val());
});
</script>