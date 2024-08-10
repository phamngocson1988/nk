<?php
if(Yii::app()->user->getState('registered')) {

    if(Yii::app()->user->getState('queue_login') == '1') {


        $break_url = Yii::app()->createUrl('itemsCall/Call/breakagent');
        $unbreak_url = Yii::app()->createUrl('itemsCall/Call/Unbreakagent');

        $id_register = Yii::app()->user->getState('id_register');
        $timeout1 = Yii::app()->params['keepAlive'];
        $timeout2 = Yii::app()->params['incommingCall'];
        $url1 = Yii::app()->params['url_keepAlive']."&id_register=".$id_register;
        $url2 = Yii::app()->params['url_getIncommingCall']."&id_register=".$id_register;
        $url3 = Yii::app()->createUrl('admin/logout');
        $url4 = Yii::app()->params['url_getIncommingCall'];

?>
<script>
    var baseUrl = $('#baseUrl').val();

    $(document).ready(function (){

        <?php if(Yii::app()->params['keepAlive_status'] == 'online') echo "keepAlive();"; ?>
        //getIncommingCall();
        getContent('');
        

   });

    function getContent(timestamp)
    {
        return; // for test ipcc
        var id_register = '<?php echo $id_register?>';
        var queryString = {"timestamp" : timestamp, "id_register" : id_register};
    	if(id_register == 0 || id_register == ''){
    		return false;
    	}
        
        jQuery.ajax({
            type: 'GET',
            url: '<?php echo $url4; ?>',
            data: queryString,
            success: function(returndata){
                
                // put result data into "obj"
                var obj = jQuery.parseJSON(returndata);
                if(obj.newdata > 0){

                    popupCallNotification(obj.phone);
                    // get lead info and show on screen
      /*              jQuery.ajax({ type:"GET",
                            url:" <?php echo CController::createUrl('lead/get_lead_info')?>&phone="+obj.phone,
                            success:function(resdata){
                                var html = '';
                                var obj1 = jQuery.parseJSON(resdata);
                                if(obj1.exist == 0){
                                    html = html + '<p><a href=\"#\" onclick=\"new_account(' + obj.phone + ')\">New phone:</a> ' + obj.phone;
                                    jAlert(html);
                                }else if(obj1.exist == 1){
                                    html = html + '<p><a href=\"#\" onclick=\"search_account(' + obj1.phone + ')\">Customer phone:</a> ' + obj1.phone + '';
                                    html = html + '<br/><a href=\"#\" onclick=\"search_account(' + obj1.phone + ')\">Fullname = ' + obj1.firstname + ' ' +  obj1.lastname + '</a></p>';
                                    jAlert(html);
                                }else if(obj1.exist == '2'){
                                    html = html + '<p><a href=\"#\" onclick=\"search_lead(' + obj1.phone + ')\">Lead phone:</a> ' + obj1.phone + '';
                                    html = html + '<br/><a href=\"#\" onclick=\"search_lead(' + obj1.phone + ')\">Fullname = ' + obj1.firstname + ' ' +  obj1.lastname + '</a></p>';
                                    jAlert(html);
                                }
                                $('#popup_overlay').remove();
                            }
                        });*/
                }
                //alert(object.phone);    // -2: missing id_register, -3: timeout
                // call the function again, this time with the timestamp we just got from server.php
                getContent(obj.timestamp);
            }
        });
    }

    function keepAlive() {
        return; // for test ipcc
        var url =  '<?php echo $url1; ?>';
        var id = '<?php echo $id_register; ?>';
        var req = $.ajax({ url: url, data: {id: id}, dataType: "jsonp", jsonp : "callback", jsonpCallback: "onKeepAliveComplete"});

        setInterval(
            function() {
                req.abort();
                req = $.ajax({ url: url, data: {id: id}, dataType: "jsonp", jsonp : "callback", jsonpCallback: "onKeepAliveComplete"});
            },<?php echo $timeout1; ?>);
    }

    function onKeepAliveComplete(rtndata) {
        var data = rtndata.message;
        console.log(data);

        if(data.indexOf('Access Denied') > -1 || data.indexOf('204') > -1 || data.indexOf('408') > -1) {
            var url3 = '<?php echo $url3; ?>';
            $(location).attr('href', url3);
        }
    }

    function getIncommingCall() {
        return; // for test ipcc
        var url =  '<?php echo $url2; ?>';
        var id = '<?php echo $id_register; ?>';
        var req = $.ajax({ url: url, data: {id: id}, dataType: "jsonp", jsonp : "callback", jsonpCallback: "onGetIncommingCallComplete"});

        setInterval(
            function() {
                req.abort();
                req = $.ajax({ url: url, data: {id: id}, dataType: "jsonp", jsonp : "callback", jsonpCallback: "onGetIncommingCallComplete"});
            },<?php echo $timeout2; ?>);
    }

    function onGetIncommingCallComplete(phone) {
        
        if(isNaN(phone)) {
            console.log(phone);
            return;
        }
        jQuery.ajax({ type:"GET",
                        url:" <?php echo CController::createUrl('lead/get_lead_info')?>&phone="+phone,
                        success:function(data){
                            return jQuery.parseJSON(data);
                        }
                    });
    }

    function showBreakAgentPopup() {
        var url = '<?php echo $break_url; ?>';

        jQuery.get(url, function(data) {
            //console.log(data);
            jAlert(data, 'Break Agent Dialog');
            $('#popup_content').css('background-image', 'url()');
            $('#popup_ok').hide();
        });
    }

    function breakAgent() {
        var url = '<?php echo $break_url; ?>';
        var dataString = '&id_break=' + $('#break').val();
        
        jQuery.ajax({url: url,
                      data: dataString,
                      beforeSend: function ( request ) {
                        $('#popup_message').html('<img alt="Waiting....." src="<?php echo Yii::app()->params['image_url']; ?>/images/waitingmain.gif">');
                      },
                      success: function(data) {
                          console.log(data);
                          if(data == 'Success'){
                            var unbreak = '<?php
                            echo CHtml::label('&nbsp;', false, array('class' => ''));
                            echo CHtml::Button('Unbreak', array('class' => 'button_izi', 'id'=>'unbreak', 'onclick'=>'unbreakAgent();')); ?>'
                            $('#popup_message').html(unbreak);
                           }
                           else {
                               jAlert('Failed');
                           }
                      }
        });
    }

    function unbreakAgent() {
        var url = '<?php echo $unbreak_url; ?>';
        $('#popup_message').html('<img alt="Waiting....." src="<?php echo Yii::app()->params['image_url']; ?>/images/waitingmain.gif">');
        $.get(url, function(data){
            if(data == 'Success') {
                $('#popup_ok').click();
            }
        });
    }

    function cancelBreakAgent() {
        $('#popup_ok').click();
    };

    function search_account(phone) {
        var url='<?php echo CController::createUrl('pinless/searchcustomer'); ?>&phone_new='+phone;

        location.href=url;
        $('#popup_ok').remove();
    }

    function search_lead(phone) {
        var url='<?php echo CController::createUrl('lead/searchlead'); ?>&search_phone='+phone;

        location.href=url;
        $('#popup_ok').remove();
    }

    function new_account(phone) {
        //$('#sb_newaccount').click();
        var link='<?php echo CController::createUrl('pinless/newaccount'); ?>&edit_lead_phone='+phone;

        changecolor('newaccount');
        jQuery.ajax({ type:'POST',url:link,
                    success:function(data){
                         jQuery('#content_body').html(data);
                         jQuery('#idwaiting_main').html('');
                         format_phone('new_account_phone');
                         autocheck_localaccess();
                    }
        });
        $('#popup_ok').click();
    }

    function popupCallNotification(phone)
    {
        $.ajax({
            type:'POST',
            url:'<?php echo Yii::app()->params['url_base_http'] ?>/itemsCustomers/Accounts/SearchCustomersCall',
            data:{
                'phone' : phone,
            },
            success: function(dataString){
                if (dataString) {
                    getcallcoming(dataString,phone);
                }
            },
         });
    }

    function getcallcoming(id_cus,phone_cus)
    {
        if (id_cus==0) {
            var html ='<div data-toggle="popover" id="call-animation" class="call-animation" style="position: fixed;bottom: 30px;right: 50px;z-index: 999"><a href="<?php echo Yii::app()->request->baseUrl; ?>/itemsCustomers/Potential/admin"><img  class="img-circle" src="<?php echo Yii::app()->params['image_url']; ?>/images/phone.jpg" alt=""/></a></div>';
        }
        else {
            var html ='<div data-toggle="popover" onclick="detailCustomer('+id_cus+');" id="call-animation" class="call-animation" style="position: fixed;bottom: 30px;right: 50px;z-index: 999"><img  class="img-circle" src="<?php echo Yii::app()->params['image_url']; ?>/images/phone.jpg" alt=""/></div>';
        }
        
        $('#ring-call').fadeIn(5000).append(html);

        var audio = document.createElement('audio');
          audio.style.display = "none";
          audio.src = "<?php echo Yii::app()->params['image_url']; ?>/images/84586-telephone-bell.mp3";
          audio.autoplay = true;
          audio.loop = true;
        document.body.appendChild(audio);
        $('[data-toggle="popover"]').popover({
            title :'Cuộc gọi mới',
            content :"số điện thoại: "+phone_cus,
            trigger: 'hover',
            placement:'left'
         }); 
    }

    function clickToCall(phone)
    {
        
        $.ajax({
            type:'POST',
            url:baseUrl+'/itemsCall/Call/ClickToCall',
            data:{
                'phone' : phone,
            },
            success: function(dataString){
                if (dataString) {
                   console.log(dataString);
                }
            },
        });
    }

</script>
<?php
    }
}

?>