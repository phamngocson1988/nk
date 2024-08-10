<!-- tao lich hen moi -->
<style>
   #CalendarModal .modal-dialog {width: 410px; padding-top: 50px;}
   #CalendarModal .modal-content {border-radius: 0;}
   #CalendarModal .modal-header {background: #0eb1dc; color: white; padding: 7px 25px; }
   #CalendarModal .modal-header h3 {font-size: 20px; line-height: 1.7em;; font-weight: normal;}
   #CalendarModal .modal-header .close {font-size: 36px; color: white; opacity: 1; font-weight: lighter;} 
   #CalendarModal .modal-body {padding: 10px 15px;}
   #CalendarModal .modal-body h4 {font-size: 16px; font-weight: normal;}

   #start_date {
      -webkit-border-top-right-radius: 0;
      -moz-border-top-right-radius: 0;
      border-top-right-radius: 0;

      -webkit-border-bottom-right-radius: 0;
      -moz-border-bottom-right-radius: 0;
      border-bottom-right-radius: 0;
   }

   #start_time {
      -webkit-border-top-left-radius: 0;
      -moz-border-top-left-radius: 0;
      border-top-left-radius: 0;

      -webkit-border-bottom-left-radius: 0;
      -moz-border-bottom-left-radius: 0;
      border-bottom-left-radius: 0;
   }
   #schErr {color: red; font-style: italic; text-align: center;}
</style>
<?php $group_no = Yii::app()->user->getState('group_no'); ?>

<!-- modal -->
<div class="modal-dialog">
   <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">close</span></button>
         <h3 id="modalTitle" class="modal-title">TẠO LỊCH HẸN</h3>
      </div>

      <div id="modalBody" class="modal-body">
      <form enctype="multipart/form-data" class="form-horizontal" id="frm-next-sch" action="/nhakhoa2000/itemsSchedule/calendar/index" method="post">  
  
            <!-- Lich hen -->
            <div id="tab-schedule" class="tab-pane">
                  <div class="form-group">
                     <label class="col-xs-7 control-label" for="CsSchedule_status">Trạng thái lịch hẹn</label>
                     <div class="col-xs-4">
                      <?php echo CHtml::dropDownList('CsSchedule[status]', '', $sch->st1, array('class'=>'form-control','id'=>'CsSchedule_status')); ?>
                   </div>
                  </div>

                <div class="clearfix"></div>

            <input name="CsSchedule[id_customer]" id="CsSchedule_id_customer" type="hidden">
                  <input name="CsSchedule[id_author]" id="CsSchedule_id_author" type="hidden" value="<?php echo Yii::app()->user->getState('user_id'); ?>">
                  <input name="CsSchedule[id_chair]" class="chair" id="CsSchedule_id_chair" type="hidden" value="0">
                  <input name="CsSchedule[id_branch]" class="branch" id="CsSchedule_id_branch" type="hidden" value="<?php echo Yii::app()->user->getState('user_branch'); ?>">
                  <input name="CsSchedule[end_time]" class="end_time" id="CsSchedule_end_time" type="hidden">

                  <div class="form-group">
                    <label class="col-xs-4 control-label" for="CsSchedule_id_dentist">Nha sỹ</label>
                    <div class="col-xs-7">
                       <?php if ($group_no == Yii::app()->params['id_group_dentist']): ?>
                           <select class="form-control" name="CsSchedule[id_dentist]" id="CsSchedule_id_dentist">
                              <option value="<?php echo Yii::app()->user->getState('user_id'); ?>"><?php echo Yii::app()->user->getState('user_name'); ?></option>
                           </select>
                       <?php else: ?>
                           <?php 
                           $dent = GpUsers::model()->findAllByAttributes(array('id_branch'=>Yii::app()->user->getState('user_branch'),'group_id'=>Yii::app()->params['id_group_dentist']));
                           $listDent = CHtml::listData($dent,'id','name');
                           echo CHtml::dropDownList('CsSchedule[id_dentist]', '', $listDent, array('class'=>'form-control','id'=>'CsSchedule_id_dentist')); ?>
                       <?php endif ?>
                    </div>
                    <!-- <div class="col-xs-1 load-at padding-left-0">
                       <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                    </div> -->
                </div>

                <div class="form-group">
                    <label class="col-xs-4 control-label" for="CsSchedule_id_service">Dịch vụ</label>
                    <div class="col-xs-7">
                        <select placeholder="" class="sch_service form-control" name="CsSchedule[id_service]" id="CsSchedule_id_service"></select>
                    </div>
                    <!-- <div class="col-xs-1 load-at padding-left-0" id="load-sv">
                       <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                    </div> -->
                </div>

                <div class="form-group">
                    <label class="col-xs-4 control-label" for="CsSchedule_lenght">Thời gian</label>
                    <div class="col-xs-7">
                        <div class="input-group">
                           <input type="number" class="len times form-control" name="CsSchedule[lenght]" id="CsSchedule_lenght" min="0" max="200" step="5">
                           <span class="input-group-addon">phút</span>
                        </div>
                    </div>
                    <!-- <div class="col-xs-1 load-at padding-left-0" id="load-ti">
                       <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                    </div> -->
                </div>

                <div class="form-group">
                    <label class="col-xs-4 control-label" for="CsSchedule_start_time">Ngày giờ</label>
                    <div class="col-xs-7 times">
                        <div class="col-xs-7">
                           <div class="row">
                              <input class="group_time form-control" id="start_date" type="text" />
                           </div>
                        </div>

                        <div class="col-xs-5">
                           <div class="row">
                              <!-- <input class="group_time form-control col-xs-5" id="start_time" type="text" /> -->
                              <select name="" class="form-control" id="start_time">
                                 <option value="0">00:00</option>
                              </select>
                           </div>
                        </div>

                       <input name="CsSchedule[start_time]" id="CsSchedule_start_time" type="hidden" />
                    </div>
                    <!-- <div class="col-xs-1 load-at padding-left-0" id="load-da">
                       <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                    </div> -->
                </div>

                <div class="form-group">
                  <label class="col-xs-4 control-label" for="CsSchedule_note">Ghi chú</label>
                  <div class="col-xs-7">
                     <textarea class="form-control" placeholder="Note" name="CsSchedule[note]" id="CsSchedule_note"></textarea>
                     <div class="help-block error" id="CsSchedule_note_em_" style="display:none"></div>
                  </div>
                </div>

                <div class="help-block" id="schErr"></div>

                <div class="form-group">
                    <div class="col-xs-11">
                        <button type="submit" class="btn btn_book pull-right" style="color: white;">Đặt lịch</button>
                    </div>  
                </div>
            </div>
        </form>
      </div>
</div>
<script>

// lay danh sch dich vu
function getServiceForCus(id_quote) {
   $.ajax({ 
       type     :"POST",
       url      :"<?php echo Yii::app()->createUrl('itemsSchedule/calendar/getServiceForCus'); ?>",
       dataType :'json',
       data: {
          id_quotation: id_quote,
       },
       success: function (data) {
            sv = $('#CsSchedule_id_service');
            op = '';

            $.each(data, function (k, v) {
               op = op + '<option value="'+v.id+'" data-len = "'+v.len+'">'+v.name+'</option>';
            });

            sv.html(op);

            len = data[0].len;

            $('#CsSchedule_lenght').val(data[0].len);

         id_den   = $('#CsSchedule_id_dentist').val();
         id_ser   = data[0].id;
         time  = $('#start_date').val();

         getTimeForDent(id_den, id_ser, time, len);
       },
    });
}

// lay thoi gian trong
function getTimeForDent(id_den, id_ser, time, len) {
   $.ajax({ 
         type     :"POST",
         url      :"<?php echo Yii::app()->createUrl('itemsSchedule/calendar/getTimeForDent'); ?>",
         dataType :'json',
         data: {
            id_den   :  id_den,
            id_ser   :  id_ser,
            time  :  time,
            len   :  len,
         },
         success: function (data) {
            if(data != 0)
               showTime(data[0]);
            else 
               $('#start_time').html('<option value="00:00:00" data-chr="0">00:00:00</option>')
         },
    });
}

// show thoi gian trong
function showTime(data) {
   ti    =  $('#start_time');
   opt = '';
   fchr = '';

   time = data.time;
   date = moment(data.day);
   
   $.each(time, function (k, v) {
      str   =  v.split(".");
      chair   =   str[2].split("-");


      if(date.isSame(moment(),'day')){
         if(moment(str[0],'HH:mm:ss') < moment()){
            return true;
         }
      }

      if(fchr == '')
         fchr = chair[1];

      opt   = opt + '<option value="'+str[0]+'" data-chr="'+chair[1]+'">'+str[0]+'</option>';
   })

   $('#CsSchedule_id_chair').val(fchr);

   ti.html(opt);
}
/*********** Thong bao ***********/
   function getNoti(id_schedule, action, author, id_dentist) {
       $.ajax({
         url     : '<?php echo Yii::app()->createUrl('itemsSchedule/calendar/getNoti')?>',
         type    : "post",
         dataType: 'json',
         data    : {
            id_schedule: id_schedule,
            action     : action,
            id_author  : author,
            id_dentist :id_dentist,
         }
       })
   }
</script>

<script>
today    =  moment();

$('#start_date').datetimepicker({
   minDate  : today,
   format      : 'YYYY-MM-DD',
});
// change dentist
$('#CsSchedule_id_dentist').change(function(e){

   id_den   = $('#CsSchedule_id_dentist').val();
   id_ser   = $('#CsSchedule_id_service').val();
   time  = $('#start_date').val();

   $('#CsSchedule_id_chair').val($(this).find(':selected').data('chair'));

   getTimeForDent(id_den, id_ser, time, len);
})

// change service
$('#CsSchedule_id_service').change(function(e){
   len = $(this).find(':selected').data('len');
   $('#CsSchedule_lenght').val(len);

   id_den   = $('#CsSchedule_id_dentist').val();
   id_ser   = $('#CsSchedule_id_service').val();
   time  = $('#start_date').val();

   $('#CsSchedule_id_chair').val($(this).find(':selected').data('chair'));

   getTimeForDent(id_den, id_ser, time, len);
})

// change length services
$('#CsSchedule_lenght').change(function(e){
   id_den   = $('#CsSchedule_id_dentist').val();
   id_ser   = $('#CsSchedule_id_service').val();
   time  = $('#start_date').val();
   len     = $('#CsSchedule_lenght').val();

   getTimeForDent(id_den, id_ser, time, len);
})

// change start_date
$('#start_date').on('dp.change',function(){
   id_den   = $('#CsSchedule_id_dentist').val();
   id_ser   = $('#CsSchedule_id_service').val();
   time  = $('#start_date').val();
   len     = $('#CsSchedule_lenght').val();
  
   getTimeForDent(id_den, id_ser, time, len);
})

// change start_time
$('#start_time').change(function(){
   chair = $(this).find(':selected').data('chr');
   $('#CsSchedule_id_chair').val(chair);
})

/*calendarModal*/
$('#createAppt').click(function (e) {
   e.preventDefault();

   id_quote = $('#id_quotation').val();

    $('#CalendarModal').modal('show');
    getServiceForCus(id_quote);
});

// submit schedule
$('#frm-next-sch').submit(function (e) {
   e.preventDefault();

   date = $('#start_date').val();
   time = $('#start_time').val();
   len  = $('#CsSchedule_lenght').val();

   start_date  = moment(date, 'YYYY-MM-DD').format('YYYY-MM-DD');
   start_time  = moment(time, 'HH:mm:ss').format('HH:mm:ss');
   start       = start_date + ' ' + start_time;
   end      = moment(start).add(len,'m').format('YYYY-MM-DD HH:mm:ss');

   $('#CsSchedule_id_customer').val($('#id_customer').val());
   $('#CsSchedule_start_time').val(start);
   $('#CsSchedule_end_time').val(end);

   var formData   = new FormData($("#frm-next-sch")[0]);
  
    if (!formData.checkValidity || formData.checkValidity()) {
        //$('.cal-loading').fadeIn('fast');
            jQuery.ajax({ 
               type     :  "POST",
                  url   :  "<?php echo Yii::app()->createUrl('itemsSchedule/calendar/addNextSch')?>",
                  data    :  formData,
                  dataType:  'json',

                  success  :function(data){
                  $('#schErr').text("");
                     if(data.status == 1){
                        $('#CalendarModal').modal('hide');
                        getNoti(data['success']['id'], "add", data['success']['id_author'], data['success']['id_dentist']);
                     }

                  else {
                     $('#schErr').text(data["error-message"]);
                  }

                  },
                  error: function(data) {
                   alert("Error occured.Pleaxasxase try again!");
                  },
                  cache: false,
                  contentType: false,
                  processData: false
           });
       }
   
    return false;
})
</script>