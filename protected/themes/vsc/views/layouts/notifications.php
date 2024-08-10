<script>
    function getCrmNotification(timestamp)
    {
        var queryString = {'timestamp' : timestamp};
        $.ajax(
            {
                type: 'GET',
                url: '/ws_nhakhoa2000/Site/Notifications',
                data: queryString,
                success: function(dataString){
                    
                    //console.log(dataString);
                    // put result data into "obj"
                    if(dataString == 0){
                        return false;
                    }

                    var obj = jQuery.parseJSON(dataString);

                    if(obj.status == 1){

                        //console.log(obj.data);
                        var objnewdata = jQuery.parseJSON(obj.data);

                        console.log(objnewdata);
                        
                        var StartDateSchdule = new Date(objnewdata.start_time);
                        var sd_date          = StartDateSchdule.getDate();
                        var sd_month         = StartDateSchdule.getMonth() + 1; //Months are zero based
                        var sd_year          = StartDateSchdule.getFullYear();
                        var sd_hours         = StartDateSchdule.getHours();
                        var sd_minutes       = StartDateSchdule.getMinutes();
                        
                        
                        var EndDateSchdule = new Date(objnewdata.end_time);
                        var ed_hours = EndDateSchdule.getHours();
                        var ed_minutes = EndDateSchdule.getMinutes();
                        
                        var agoStartEnd = timeDifference(new Date(), new Date(objnewdata.create_date));
                        var str_sch_status = "";

                        if(objnewdata.status_active == '-2'){
                            str_sch_status = '<span class = "label label_bookoke label_sch_xoa">xoa</span>';
                        }else{
                            if(objnewdata.status == -2){
                                str_sch_status = '<span class = "label label_bookoke label_sch_bohen">Bỏ hẹn</span>';
                            }

                            if(objnewdata.status == -1){
                                str_sch_status = '<span class = "label label_bookoke label_sch_henlai">Hẹn lại</span>';
                            }

                            if(objnewdata.status == 0){
                                str_sch_status = '<span class = "label label_bookoke label_notworking">Không làm việc</span>';
                                objnewdata.fullname = 'Không làm việc';
                            }

                            if(objnewdata.status == 1){
                                str_sch_status = '<span class = "label label_bookoke label_sch_moi">Lịch mới</span>';
                            }

                            if(objnewdata.status == 2){
                                str_sch_status = '<span class = "label label_bookoke label_sch_dangcho">Đang chờ</span>';
                            }

                            if(objnewdata.status == 3){
                                str_sch_status = '<span class = "label label_bookoke label_sch_dieutri">Điều trị</span>';
                            }

                            if(objnewdata.status == 4){
                                str_sch_status = '<span class = "label label_bookoke label_sch_hoantat">Hoàn tất</span>';
                            }

                            if(objnewdata.status == 5){
                                str_sch_status = '<span class = "label label_bookoke label_sch_bove">Bỏ về</span>';
                            }

                            if(objnewdata.status == 6){
                                str_sch_status = '<span class = "label label_bookoke label_sch_vaokham">Vào khám</span>';
                            }

                            if(objnewdata.status == 7){
                                str_sch_status = '<span class = "label label_bookoke label_sch_xacnhan">Xác nhận</span>';
                            }
                        }
                       
                        
                        
                        var htmlNoti = '<li>'+
                            '<div id="activity_notification_list_holder">'+ 
                                '<div style=" float: left;width:100%; color: #333;">'+
                                    '<div style="margin-bottom: 2px;">'+
                                        '<span style="font-size: 14px;">'+objnewdata.fullname+'</span>'+
                                        '<span style="text-align: right;float: right;font-size: 11px;">'+
                                        '<input type="hidden" class="createDataNoti" value="'+objnewdata.create_date+'" />'+
                                         '<em>'+agoStartEnd+'</em>'+
                                        '<input type="hidden" class="createdate_noti" value="'+obj.createdate+'" />'+
                                        '</span>'+
                                    '</div>'+
                                    '<p style="font-size: 12px;margin:0px;line-height: 19px;">'+
                                        '<span><strong>Bác Sĩ:</strong>'+objnewdata.name_dentist+'</span><br>'+
                                        '<span>'+sd_year+'/'+sd_month+'/'+sd_date+'</span>'+
                                        '<span> '+sd_hours+':'+sd_minutes+'-'+ed_hours+':'+ed_minutes+'</span>'+
                                        ''+str_sch_status+''+
                                    '</p>'+
                                '</div>'+
                                '<div class="clearfix"></div>'+
                            '</div>'+
                        '<li/>';
                        $( "#activity_notification_list" ).prepend(htmlNoti);
                        

                        var lay_out = $("#LayoutCalendar").val();
                        
                        if(lay_out == 1){
                            getNewSch(obj.data);
                        }
                        getsumNotifications();
                    }

                    else if(obj.status == 4){
                        var lay_out = $("#LayoutCalendar").val();
                        
                        if(lay_out == 1){
                            getNewSch(obj.data);
                        }
                    }

                    // put the data_from_file into #response
                    //$('#response').html(obj.data_from_file);
                    // call the function again, this time with the timestamp we just got from server.php
                    getCrmNotification(obj.timestamp);
                },
            }
        );
    }

    function updateUserNotifications(id_notification){
        $.ajax({
            type    : "post",
            dataType: 'json',
            url     : '<?php echo Yii::app()->createUrl('itemsUsers/Users/UpdateNotification')?>',
            data    : {
                    id_notification: id_notification,
            },
            success: function(data){
                if(data){
                    var sumNoti = $("#sumNotification").val();
                    console.log("Before:"+sumNoti);
                    sumNoti = parseInt(sumNoti);
                    sumNoti = sumNoti-1;
                    console.log("After:"+sumNoti);

                    $("#sumNotification").val(sumNoti);
                    $("#sumBoxNotification").html(sumNoti);
                    $("#notification_sch"+id_notification).addClass('watched');

                }
                
            },
        });
    }

    function showNotifications(id_notification,id_sch){
        showNotificationsSchudle(id_sch);
        updateUserNotifications(id_notification);
    }


    function showNotificationsSchudle(id_sch){
            $.ajax({ 
                type    :"POST",
                url     :"<?php echo Yii::app()->createUrl('itemsSchedule/calendar/updateEventAllLayout')?>",
                dataType:'html',
                data    : {id_schedule:id_sch},
                success :function(data){
                  $('.updateEventAllLayout').html(data);
                  $('#update_sch_modal_all').modal('show');
                  
                },
                error: function(data) {
                    alert("Error occured.Please try again!");
                },
            });
    }

    function showListNotiLayout(){
            $.ajax({ 
                type    :"POST",
                url     :"<?php echo Yii::app()->createUrl('itemsUsers/Notifications/ListViewLayoutNoti')?>",
                dataType:'html',
                success :function(data){

                    var dataArr = $.parseJSON(data);

                    dataArr.forEach( function (dataItem)
                    {
                        var dataSch =  $.parseJSON(dataItem.data);

                        var watchedUser = '';

                        if(dataItem.id_user){
                            watchedUser = 'watched';
                        }

                        var titleCus = '';

                        if(dataSch.status == '0'){
                            titleCus = 'Không làm việc';
                        }else{
                            titleCus = dataSch.fullname;
                        }

                        
                        if(dataSch.start_time){

                            var dateSch = new Date(dataSch.start_time);

                            var yearSch     = dateSch.getFullYear();
                            var monthSch    = dateSch.getMonth();
                            var daySch      = dateSch.getDate();

                            var hoursSch    = dateSch.getHours();
                            var mimutesSch  = dateSch.getMinutes();

                            var createDateSch = daySch + "/" + monthSch + "/" + yearSch;
                       
                            var startTimeSch = hoursSch + ":" + mimutesSch;


                            var dateEndSch = new Date(dataSch.end_time);
                            var hoursEndSch     = dateEndSch.getHours();
                            var mimutesEndSch   = dateEndSch.getMinutes();
                            var endTimeSch      = hoursEndSch + ":" + (mimutesEndSch);

                        }

                        var strLabelSch = '';

                        if(dataSch.status == '-2'){
                            strLabelSch = '<span class = "label label_bookoke label_sch_bohen">Bỏ hẹn</span>';
                        }

                        if(dataSch.status == '-1'){
                            strLabelSch = '<span class = "label label_bookoke label_sch_henlai">Hẹn lại</span>';
                        }

                        if(dataSch.status == 0){
                            strLabelSch = '<span class = "label label_bookoke label_notworking">Không làm việc</span>';
                        }

                        if(dataSch.status == 1){
                            strLabelSch = '<span class = "label label_bookoke label_sch_moi">Lịch mới</span>';
                        }

                        if(dataSch.status == 2){
                            strLabelSch = '<span class = "label label_bookoke label_sch_dangcho">Đang chờ</span>';
                        }

                        if(dataSch.status == 3){
                            strLabelSch = '<span class = "label label_bookoke label_sch_vaokham">Vào khám</span>';
                        }

                        if(dataSch.status == 4){
                            strLabelSch = '<span class = "label label_bookoke label_sch_hoantat">Hoàn tất</span>';
                        }

                        if(dataSch.status == 5){
                            strLabelSch = '<span class = "label label_bookoke label_sch_bove">Bỏ về</span>';
                        }

                        if(dataSch.status == 6){
                            strLabelSch = '<span class = "label label_bookoke label_sch_dieutri">Điều trị</span>';
                        }

                        if(dataSch.status == 7){
                            strLabelSch = '<span class = "label label_bookoke label_sch_xacnhan">Xác nhận</span>';
                        }

                        var LiNoti = '<li id="notification_sch'+dataItem.id+'" class="'+watchedUser+'" >'+
                                            '<div id="activity_notification_list_holder" onclick="showNotifications('+dataItem.id+','+dataSch.id+');">'+
                                                '<div style=" float: left;width:100%; color: #333;">'+
                                                    '<div style="margin-bottom: 2px;">'+
                                                        '<span style="font-size: 14px;">'+titleCus+'</span>'+
                                                        '<span style="text-align: right;float: right;font-size: 11px;">'+
                                                        '<input type="hidden" class="createdate_noti" value="'+dataItem.createdate+'"><em></em>'+
                                                        '<span>'+
                                                    '</div>'+
                                                    '<p style="font-size: 12px;margin:0px;line-height: 19px;">'+
                                                        '<span><strong>Bác Sĩ:</strong>'+dataSch.name_dentist+'</span><br>'+
                                                        '<span>'+createDateSch+'</span><span> '+startTimeSch+' - '+endTimeSch+'</span>'+
                                                        strLabelSch+
                                                    '</p>'+
                                                '</div>'+
                                                '<div class="clearfix"></div>'+
                                            '</div>'+ 
                                     '</li>';

                        $("#activity_notification_list").append(LiNoti);   
                        

                    });

                    setInterval(updateTime, 3000);

                    getSumNotiLayout();

                },
                error: function(data) {
                    console.log("Error occured.Please try again!");
                },
            });
    }


    function getSumNotiLayout(){
        $.ajax({ 
            type    :"POST",
            url     :"<?php echo Yii::app()->createUrl('itemsUsers/Notifications/getSumNotiLayout')?>",
            dataType:'html',
            success :function(data){
                      $("#sumBoxNoti").html('<span id="sumBoxNotification" >'+data+'</span>');
                      $("#sumNotification").val(data);
            },
            error: function(data) {
                console.log("Error occured.Please try again!");
            },
        });
    }

    function getsumNotifications(){
        var sumNoti = $("#sumNotification").val();

        sumNoti = parseInt(sumNoti);
        sumNoti = parseInt(sumNoti+1);

        $("#sumNotification").val(sumNoti);
        $("#sumBoxNotification").html(sumNoti);
      
    }

    function timeDifference(current, previous) {

            var msPerMinute = 60 * 1000;
            var msPerHour = msPerMinute * 60;
            var msPerDay = msPerHour * 24;
            var msPerMonth = msPerDay * 30;
            var msPerYear = msPerDay * 365;

            var elapsed = current - previous;

            if (elapsed < msPerMinute) {
                 return Math.round(elapsed/1000) + ' giây trước';   
            }

            else if (elapsed < msPerHour) {
                 return Math.round(elapsed/msPerMinute) + ' phút trước';   
            }

            else if (elapsed < msPerDay ) {
                 return Math.round(elapsed/msPerHour ) + ' giờ trước';   
            }

            else if (elapsed < msPerMonth) {
                return 'approximately ' + Math.round(elapsed/msPerDay) + ' ngày trước';   
            }

            else if (elapsed < msPerYear) {
                return 'approximately ' + Math.round(elapsed/msPerMonth) + ' tháng trước';   
            }

            else {
                return 'approximately ' + Math.round(elapsed/msPerYear ) + ' năm trước';   
            }
    }

    function relative_time(date_str) {
        return  moment(date_str).fromNow(); 
    }

 
  window.onload = function()
    {
     
        var timerNoti;
        var timerNotiList;
        var timeDueNoti; 

        function endAndStartTimerNoti() {
           window.clearTimeout(timerNoti);
           //var millisecBeforeRedirect = 10000; 
           timerNoti = window.setTimeout(function(){
               getCrmNotification();

            },10000); 
        }

        function endAndStartTimerNotiList() {
           window.clearTimeout(timerNotiList);
           //var millisecBeforeRedirect = 10000; 
           timerNotiList = window.setTimeout(function(){
               showListNotiLayout();
            },4000); 
        }


        function updateTime() {
           window.clearTimeout(timeDueNoti);
           //var millisecBeforeRedirect = 10000; 
           timeDueNoti = window.setTimeout(function(){
               setInterval(updateTime, 6000);
            },6000); 
        }


        endAndStartTimerNotiList();

        endAndStartTimerNoti();
    };

    function updateTime(){
  
        $( "#activity_notification_list li" ).each(function( index ) {

            var cur = $(this).find('.createdate_noti').val();
           
            var agoStartEnd = relative_time(cur);

            $(this).find('em').html(agoStartEnd);
    
        });

    }
  
</script>

