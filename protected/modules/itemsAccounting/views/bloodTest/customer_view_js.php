<script>
//#region --- VARIABLE
    var searchData = {}, timer;
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
//#endregion

//#region --- LIST DEPOSIT
    function loadCustomerBloodTest(searchParams) {
        searchData.id_customer = $('.blood_test-id_customer').val();

        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('itemsAccounting/bloodTest/LoadTabList') ?>",
            dataType: 'html',
            data: searchParams,
            success: function(data) {
                $('.cal-loading').fadeOut('fast');
                if (data) {
                    $("#blood_test-list").html(data);
                }
            },
            error: function(data) {
                $('.cal-loading').fadeOut('fast');
                alert("Error occured.Please try again!");
            },
        });
    }
//#endregion

//#region --- PHAN TRANG
function bloodTestPaging(page) {
    searchData['page'] = page;
    loadCustomerBloodTest(searchData);
}
//#endregion

    $(document).ready(function() {
    //#region --- INIT
        $.fn.select2.defaults.set("theme", "bootstrap");

        $('.frm-datepicker').datetimepicker({
            defaultDate: moment(),
            format: 'DD/MM/YYYY'
        });
    //#endregion

        searchData.page = 1;
        loadCustomerBloodTest(searchData);

    //#region --- LOC DU LIEU
        $('#blood_test-time').change(function(e) {
            e.preventDefault();
            searchData['time'] = $(this).val();
            searchData['page'] = 1;

            if ($(this).val() == 5) {
                $('.search_date').show();
            } else {
                $('.search_date').hide();
                loadCustomerBloodTest(searchData);
            }
        });

        $('.frm-datepicker').on('dp.change', function(e) {
            var start = $('#blood_test-start').val();
            var end = $('#blood_test-end').val();

            if (end < start) {
                $('#blood_test-end').val(start);
            }

            searchData['page'] = 1;
            searchData['start'] = moment(start, 'DD/MM/YYYY').format('YYYY-MM-DD');
            searchData['end'] = moment(end, 'DD/MM/YYYY').format('YYYY-MM-DD');

            loadCustomerBloodTest(searchData);
        });

        $('#blood_test-code_invoice').on('input', function(e) {
            if (timer) {
                clearTimeout(timer);
            }

            timer = setTimeout(function() {
                searchData['page'] = 1;
                searchData['code_invoice'] = $('#blood_test-code_invoice').val();

                loadCustomerBloodTest(searchData);
            }, 500);
        });
    //#endregion

    //#region --- CAP NHAT - LAYOUT
        $('.blood_test-update_layout').click(function(e) {
            var id_customer = $(".blood_test-id_customer").val();
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('itemsAccounting/bloodTest/updateLayout') ?>",
                data: { id_customer: id_customer},
                success: function(data) {
                    $('.cal-loading').fadeOut('fast');
                    if (data) {
                        $('#blood_test-modal').html(data);
                        $('#blood_test-modal').modal('show');
                        $('.autoNum').autoNumeric('init', numberOptions);
                    }
                },
                error: function(data) {
                    alert("Error occured.Please try again!");
                },
            });
        });
    //#endregion
    });
</script>