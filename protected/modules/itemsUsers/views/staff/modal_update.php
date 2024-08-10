<style type="text/css">
  
  .staff-timeoff-details-daytime {
    border: 1px solid #d9d9d9;
    border-radius: 5px;
    color: #686868;
    display: block;
    line-height: 35px;
    padding-left: 10px;
    padding-right: 10px;
    width: 228px;
}
.staff-timeoff-popup-details-save-btn {
    background: none repeat scroll 0 0 #27c3bb;
    border-radius: 4px;
    color: #fff !important;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    line-height: 40px;
    text-align: center;
    text-decoration: none !important;
    width: 150px;
}
.timeOff-summary-li {
    border: solid 1px #E9EDAB;
    background: #FDFFE5;
    text-align: center;
}
.timeoff-summary-content {
    color: #1C1C1C;
    display: inline-block;
    font-size: 13px;
    line-height: 35px;
    cursor: auto;
    padding: 0px 13px;
}
</style>
<div id="myModal_update_time_off" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 390px;">

    <!-- Modal content-->
    <div class="modal-content" style="margin-top: 25%;border-radius: 0px;">

      <div class="modal-header sHeader">
          <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h3 id="modalTitle" class="modal-title">Thêm Thời Gian Nghỉ Phép</h3>
      </div>

      <div class="modal-body">
      <p id="msg-error" style="color: green"></p>
       <input type="hidden" id="time_off_Id" value=""/>

      <div class="form-horizontal">
        <div class="form-group">
          <label class="col-xs-4 control-label" for="datetimepicker6">Ngày bắt đầu</label>
          <div class="col-xs-7">
              <input type='text' class="form-control datetimepicker" id='datetimepicker6' />
          </div>
        </div>

        <div class="form-group">
          <label class="col-xs-4 control-label" for="datetimepicker7">Ngày kết thúc</label>
          <div class="col-xs-7">
              <input type='text' class="form-control datetimepicker" id='datetimepicker7' />
          </div>
        </div>

        <div class="form-group">
          <label class="col-xs-4 control-label" for="up_note_time_off">Ghi chú</label>
          <div class="col-xs-7">
              <textarea name="" id="up_note_time_off" class="form-control"></textarea>
          </div>
        </div>
      </div>

      <div class="form-group timeOff-summary-li" style="margin-bottom: 0;">
          <label class="timeoff-summary-content" id="newtimeoff-summary">Từ ngày <span id="up_start"></span> đến ngày <span id="up_end"></span></label>
      </div>

      </div>
      <div class="modal-footer" style="text-align: center;">
        <div>
          <a class="staff-timeoff-popup-details-save-btn  new-timeoff-savebtn" onclick="delete_time_off_active(<?php echo $id_dentist; ?>)" id="deleteTimeoff">
          Xóa
          </a>
          <a class="staff-timeoff-popup-details-save-btn new-timeoff-savebtn" onclick="update_time_off_active(<?php echo $id_dentist; ?>)" id="saveTimeoff">
          Lưu
          </a> 
        </div>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.datetimepicker').datetimepicker({ 
          format: 'YYYY-MM-DD',
          minDate: moment().format('YYYY-MM-DD'),
          defaultDate: moment().format('YYYY-MM-DD'),
        });

        $('.datetimepicker').on('dp.show dp.update', function () {
            var datepicker = $(this).siblings('.bootstrap-datetimepicker-widget');
            datepicker.height(250);

            $(".datepicker-years .picker-switch").removeAttr('title')
            .css('cursor', 'default')
            .css('background', 'inherit')
            .on('click', function (e) {
                e.stopPropagation();
            });
        });

        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);

            start = $('#datetimepicker6').val();
            $('#up_start').text(moment(start,'YYYY-MM-DD').format('DD/MM/YYYY'));
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);

            end = $('#datetimepicker7').val();
            $('#up_end').text(moment(end,'YYYY-MM-DD').format('DD/MM/YYYY'));
        });
    });

   function update_time_off_active(id_dentist)
   {
      var time_off_Id    = $('#time_off_Id').val();
      var time_off_Start = $('#datetimepicker6').val() +' 00:01:00';
      var time_off_End   = $('#datetimepicker7').val() +' 23:59:00';
      var time_off_Note =  $('#up_note_time_off').val();
      var $group_id       =  $('#group_user').val();

      $.ajax({
         type: "POST",
         url : "<?php echo CController::createUrl('Staff/UpdateTimeOff')?>",
         data:{
            id           : time_off_Id,
            start_date   : time_off_Start,
            end_date     : time_off_End,
            note_time_off: time_off_Note,
            id_dentist   : id_dentist,
            'group_id'     : $group_id,
         },
         success:function(data) { 
                if(data == 0){
                  alert( "Bác sỹ có lịch hẹn!");
              }
              else if(data == -1) {
                  alert("Có lỗi xảy ra! Vui lòng thử lại sau!"); 
              }
              else if(data) {
                  $('#add_time_off').css({'display':'none'});
                  $('#list_time_off').append(data);
                  $("#myModal_update_time_off").modal("hide");
                  alert("Success !");
                  $('#time_off_'+time_off_Id).remove();
               }
               else {
                 alert("Error !");
               }
            },
            error: function (data) {
                alert("Error occured.Please try again!");
            },
        });
   }

   function delete_time_off_active(id_dentist)
   {
      var time_off_Id = $('#time_off_Id').val();
      var checkstr =  confirm('Bạn có muốn xóa lịch nghỉ phép này không?');
      if(checkstr == true)
      {
         jQuery.ajax({
            type: "POST",
            url : "<?php echo CController::createUrl('Staff/DeleteTimeOff')?>",
            data:{
              'id' : time_off_Id,
              'group_id'     : $('#group_user').val(),
              id_dentist   : id_dentist,
            },
            success:function(data)
            {
               if(data)
               {
                  alert(data);
                  $("#myModal_update_time_off").modal("hide");
                  $('#time_off_'+time_off_Id).remove();
               }
               else{
                  alert("Không xóa được");
               }
            },
            error: function (data) {
               alert("Error occured.Please try again!");
            },
         });
      }else{
         return false;
      }
   }
</script>