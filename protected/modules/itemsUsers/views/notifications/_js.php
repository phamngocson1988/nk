<script>
function loadNoti(page, type_time, startDate, endDate) {
    $('.cal-loading').fadeIn('fast');
    $.ajax({ 
        type    :"POST",
        url     :"<?php echo Yii::app()->createUrl('itemsUsers/Notifications/viewDetail')?>",
        dataType: 'html',
        data: {
            page        : page,
            type        : type_time,
            startDate   : startDate, 
            endDate     : endDate,
            code        : '<?php echo $code ?>',
        },
        success:function(data){
            if(data){
                $("#noty_List").html(data);
                $('.cal-loading').fadeOut('fast');
            }
        },
        error: function(data) {
            alert("Error occured.Please try again!");
        },
    });
}

$(function(){
    $('#noty_List').on('show.bs.collapse','.collapse', function () {
        $('.collapse.in').collapse('hide');
    });

    loadNoti(1,0,moment().format('YYYY-MM-DD'),moment().format('YYYY-MM-DD'));
    $(".datepicker").datetimepicker({
        format: "DD/MM/YYYY",
        defaultDate: moment(),
    });

    $('#noti_time').change(function(e){
        type = $('#noti_time').val();

        if (type != 0) {
            $('.chooseDate').hide();
        } else {
            $('.chooseDate').show();
        }

        startDate = moment($('#startDate').val(),'DD/MM/YYYY').format('YYYY-MM-DD');
        endDate = moment($('#endDate').val(),'DD/MM/YYYY').format('YYYY-MM-DD');

        loadNoti(1, type, startDate, endDate);
    })

    //chooseDate
    $('.chooseDate').on('dp.change',function(e){
        type = $('#noti_time').val();

        startDate = moment($('#startDate').val(),'DD/MM/YYYY').format('YYYY-MM-DD');
        endDate = moment($('#endDate').val(),'DD/MM/YYYY').format('YYYY-MM-DD');

        loadNoti(1, type, startDate, endDate);
    })
})
</script>