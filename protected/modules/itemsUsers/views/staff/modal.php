
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
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 390px;">

    <!-- Modal content-->
    <div class="modal-content" style="margin-top: 25%;border-radius: 0px;">

      <div class="modal-header sHeader">
          <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h3 id="modalTitle" class="modal-title">Thêm Thời Gian Nghỉ Phép</h3>
      </div>

      <div class="modal-body">
      <p id="msg-error" style="color: green"></p>

      <div class="form-horizontal">
        <div class="form-group">
          <label class="col-xs-4 control-label" for="datetimepicker4">Ngày bắt đầu</label>
          <div class="col-xs-7">
              <input type='text' class="form-control datetimepicker" id='datetimepicker4' />
          </div>
        </div>

        <div class="form-group">
          <label class="col-xs-4 control-label" for="datetimepicker5">Ngày kết thúc</label>
          <div class="col-xs-7">
              <input type='text' class="form-control datetimepicker" id='datetimepicker5' />
          </div>
        </div>

        <div class="form-group">
          <label class="col-xs-4 control-label" for="note_time_off">Ghi chú</label>
          <div class="col-xs-7">
              <textarea name="" id="note_time_off" class="form-control"></textarea>
          </div>
        </div>
      </div>

      <div class="form-group timeOff-summary-li" style="margin-bottom: 0;">
        <label class="timeoff-summary-content" id="newtimeoff-summary">Từ ngày <span id="start">01/05/2017</span> đến ngày <span id="end">01/05/2017</span></label>
      </div>

      </div>
      <div class="modal-footer">
        <div class="col-xs-12">
          <a style="margin: auto;" class="staff-timeoff-popup-details-save-btn  new-timeoff-savebtn" onclick="add_time_off(<?php echo $id_dentist; ?>)" id="saveTimeoff">
          Lưu Lại
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

        $("#datetimepicker4").on("dp.change", function (e) {
            $('#datetimepicker5').data("DateTimePicker").minDate(e.date);
            start = $('#datetimepicker4').val();
            $('#start').text(moment(start,'YYYY-MM-DD').format('DD/MM/YYYY'));
        });
        $("#datetimepicker5").on("dp.change", function (e) {
            $('#datetimepicker4').data("DateTimePicker").maxDate(e.date);
            end = $('#datetimepicker5').val();
            $('#end').text(moment(end,'YYYY-MM-DD').format('DD/MM/YYYY'));
        });
    });
</script>
<script type="text/javascript">

    function add_time_off(id_dentist)
    {
      var $start_date    =  $('#datetimepicker4').val();
      var $end_date      =  $('#datetimepicker5').val();
      var $note_time_off =  $('#note_time_off').val();
      var $id_dentist    =  id_dentist;
      var $group_id       =  $('#group_user').val();
      
      if($start_date == "" || $end_date == "") {
        alert('Vui lòng nhập ngày tháng đầy đủ');
      }
      else 
      {
        jQuery.ajax({
            type: "POST",
            url : "<?php echo CController::createUrl('Staff/AddTimeOff')?>",
            data:{
                'start_date'   : moment($start_date,'YYYY-MM-DD').format('YYYY-MM-DD') +' '+ '00:01:00',
                'end_date'     : moment($end_date,'YYYY-MM-DD').format('YYYY-MM-DD') +' '+ '23:59:00',
                'note_time_off': $note_time_off,
                'id_dentist'   : $id_dentist,
                'group_id'     : $group_id,
            },
            success:function(data)
            { 
                if(data == 0){
                  alert( "Bác sỹ có lịch hẹn!");
              }
              else if(data == -1) {
                  alert("Có lỗi xảy ra! Vui lòng thử lại sau!"); 
              }
              else if(data) {
                  $('#add_time_off').css({'display':'none'});
                  $('#list_time_off').append(data);
                  $("#myModal").modal("hide");
                  alert("Success !");
                  $('#datetimepicker4').val(moment().format('YYYY-MM-DD'));
                  $('#datetimepicker5').val(moment().format('YYYY-MM-DD'));
                  $('#note_time_off').val("");
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
    }
</script>