<script>
//#region --- VARIABLE
    var searchData = {}, timer;
    var numberOptions = {aSep: '.', aDec: ',', mDec: 3, aPad: false};
//#endregion

//#region --- LIST DEPOSIT
    function loadCustomerDeposit(searchParams) {
        searchData.id_customer = $('.deposit-id_customer').val();

        $('.cal-loading').fadeIn('fast');
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('itemsAccounting/deposit/LoadTabList') ?>",
            dataType: 'html',
            data: searchParams,
            success: function(data) {
                $('.cal-loading').fadeOut('fast');
                if (data) {
                    $("#deposit-list").html(data);
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
function depositPaging(page) {
    searchData['page'] = page;
    loadCustomerDeposit(searchData);
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
        loadCustomerDeposit(searchData);

    //#region --- LOC DU LIEU
        $('#deposit-time').change(function(e) {
            e.preventDefault();
            searchData['time'] = $(this).val();
            searchData['page'] = 1;

            if ($(this).val() == 5) {
                $('.search_date').show();
            } else {
                $('.search_date').hide();
                loadCustomerDeposit(searchData);
            }
        });

        $('.frm-datepicker').on('dp.change', function(e) {
            var start = $('#deposit-start').val();
            var end = $('#deposit-end').val();

            if (end < start) {
                $('#deposit-end').val(start);
            }

            searchData['page'] = 1;
            searchData['start'] = moment(start, 'DD/MM/YYYY').format('YYYY-MM-DD');
            searchData['end'] = moment(end, 'DD/MM/YYYY').format('YYYY-MM-DD');

            loadCustomerDeposit(searchData);
        });

        $('#deposit-code_invoice').on('input', function(e) {
            if (timer) {
                clearTimeout(timer);
            }

            timer = setTimeout(function() {
                searchData['page'] = 1;
                searchData['code_invoice'] = $('#deposit-code_invoice').val();

                loadCustomerDeposit(searchData);
            }, 500);
        });
    //#endregion

    //#region --- CAP NHAT - LAYOUT
        $('.deposit-update_layout').click(function(e) {
            var id_customer = $(".deposit-id_customer").val();
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('itemsAccounting/deposit/updateLayout') ?>",
                data: { id_customer: id_customer},
                success: function(data) {
                    $('.cal-loading').fadeOut('fast');
                    if (data) {
                        $('#deposit-modal').html(data);
                        $('#deposit-modal').modal('show');
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