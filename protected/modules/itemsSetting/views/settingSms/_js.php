<script>
    var baseUrl = $('#baseUrl').val() + '/itemsSetting/settingSms/';
</script>

<script>
    function detailSmsSetting(id) {
        if (id == null || id == '') {
            var id = $("#smsSettingList li:first-child").find('input').val();
        }

        $('.n').removeClass("active");
        $("#c" + id).addClass("active");

        $.ajax({
            type: 'POST',
            url: baseUrl + 'DetailSmsSetting',
            data: { "type": id },
            success: function(data) {
                $('#detailSmsSetting').html(data);
            },
            error: function(data) {
                console.log("error");
                console.log(data);
            }
        });

    }

    function err() {
        var status = true;
        if ($('#fullname').val() == '') {
            status = false;
            $('#fullname').addClass('invalid');
        } else {
            $('#fullname').removeClass('invalid');
        }

        if ($('#fullname').val() != '') {
            if (!isNaN($('#fullname').val())) {
                status = false;
                $('#fullname').addClass('invalid');
            } else {
                $('#fullname').removeClass('invalid');
            }
        }

        if ($('#email').val() != '') {
            if (!isValidEmailAddress($('#email').val())) {
                status = false;
                $('#email').addClass('invalid');
            } else {
                $('#email').removeClass('invalid');
            }
        } else {
            $('#email').removeClass('invalid');
        }

        if ($('#phone').val() != '') {
            if (!isValidPhoneNumber($('#phone').val())) {
                status = false;
                $('#phone').addClass('invalid');
            } else {
                $('#phone').removeClass('invalid');
            }
        } else {
            $('#phone').removeClass('invalid');
        }

        if ($('#identity_card_number').val() != '') {
            if (isNaN($('#identity_card_number').val())) {
                status = false;
                $('#identity_card_number').addClass('invalid');
            } else {
                $('#identity_card_number').removeClass('invalid');
            }
        } else {
            $('#identity_card_number').removeClass('invalid');
        }
        return status;
    }

    function err_insurrance() {
        var status = true;

        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var date = d.getFullYear() + '-' +
            (month < 10 ? '0' : '') + month + '-' +
            (day < 10 ? '0' : '') + day;

        if ($('#code_insurrance').val() == '') {
            status = false;
            $('#code_insurrance').addClass('invalid');
        } else {
            $('#code_insurrance').removeClass('invalid');
        }

        if ($('#type_insurrance').val() == '') {
            status = false;
            $('#type_insurrance').addClass('invalid');
        } else {
            $('#type_insurrance').removeClass('invalid');
        }





        return status;
    }

    function updateCustomerImage(id) {
        var formData = new FormData($("#imageUploader")[0]);
        formData.append('id', id);
        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({
                type: "POST",
                url: baseUrl + '/itemsCustomers/Accounts/updateCustomerImage',
                data: formData,
                datatype: 'json',
                success: function(data) {
                    $("#imageUploader").html(data);
                    searchSmsSetting(id);
                    $("#voice-box").removeClass("noDisplay").delay(1000).queue(function() {
                        $(this).addClass("noDisplay").dequeue();
                    });
                },
                error: function(data) {
                    alert("Error occured. Please try again!");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        return false;
    }

    function updateCustomer(id) {
        if (err()) {
            fullname = $('#fullname').val();
            email = $('#email').val();
            phone = $('#phone').val();
            gender = $('#gender').val();
            birthdate = $('#birthdate').val();
            identity_card_number = $('#identity_card_number').val();
            id_country = $('#id_country').val();
            id_job = $('#id_job').val();
            position = $('#position').val();
            organization = $('#organization').val();
            address = $('#address').val();
            $.ajax({
                type: 'POST',
                url: baseUrl + '/itemsCustomers/Accounts/updateCustomer',
                data: {
                    "id": id,
                    "fullname": fullname,
                    "email": email,
                    "phone": phone,
                    "gender": gender,
                    "birthdate": birthdate,
                    "identity_card_number": identity_card_number,
                    "id_country": id_country,
                    "id_job": id_job,
                    "position": position,
                    "organization": organization,
                    "address": address
                },
                success: function(data) {
                    searchSmsSetting(id);
                    $("#voice-box").removeClass("noDisplay").delay(1000).queue(function() {
                        $(this).addClass("noDisplay").dequeue();
                    });
                },
                error: function(data) {
                    console.log("error");
                    console.log(data);
                }
            });
        }
    }

    function insertUpdateCustomerInsurrance(id, id_customer) {
        if (id) {
            id = 0;
        }
        if (err_insurrance()) {
            code_insurrance = $('#code_insurrance').val();
            type_insurrance = $('#type_insurrance').val();
            startdate = $('#startdate').val();
            enddate = $('#enddate').val();
            $.ajax({
                type: 'POST',
                url: baseUrl + '/itemsCustomers/Accounts/insertUpdateCustomerInsurrance',
                data: {
                    "id": id,
                    "id_customer": id_customer,
                    "code_insurrance": code_insurrance,
                    "type_insurrance": type_insurrance,
                    "startdate": startdate,
                    "enddate": enddate
                },
                success: function(data) {
                    searchSmsSetting(id_customer);
                    $("#voice-box").removeClass("noDisplay").delay(1000).queue(function() {
                        $(this).addClass("noDisplay").dequeue();
                    });
                },
                error: function(data) {
                    console.log("error");
                    console.log(data);
                }
            });
        }
    }

    $('#newCustomer').click(function() {
        $('#addnewCustomerPopup').fadeToggle('fast');
    });

    $('#cancelNewCustomer').click(function() {
        $('#addnewCustomerPopup').hide();
    });

    $('#frm-add-customer').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($("#frm-add-customer")[0]);
        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({
                type: "POST",
                url: baseUrl + '/itemsSetting/Placement/NewChair',
                data: formData,
                datatype: 'json',
                success: function(data) {
                    if (data > 0) {
                        $('#addnewCustomerPopup').hide();
                        $('#frm-add-customer')[0].reset();
                        e.stopPropagation();
                        searchSmsSetting(data);
                    }
                },
                error: function(data) {
                    alert("Error occured. Please try again!");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        return false;
    });

</script>

<script type="text/javascript">
    $(window).resize(function() {
		var windowHeight = $(window).height();
		var header = $("#headerMenu").height();
		var tab_menu = $("#tabcontent .menuTabDetail").height();

		$('#profileSideNav').height(windowHeight - header);
		$('.customerListContainer').height(windowHeight - header);

		$('.statsTabContent').height(windowHeight - header - tab_menu - 45);
	});

	$(document).ready(function() {
		var windowHeight = $(window).height();
		var header = $("#headerMenu").height();
		var tab_menu = $("#tabcontent .menuTabDetail").height();

		$('#profileSideNav').height(windowHeight - header);
		$('.customerListContainer').height(windowHeight - header);

		$('.statsTabContent').height(windowHeight - header - tab_menu - 45);
	});

    $(document).ready(function() {
        detailSmsSetting();
    });

    function change_status(i, id_dentist, dow) {
        var $status = $('#slider_holder_' + i + ' input').val();
        jQuery.ajax({
            type: "POST",
            url: "<?php echo CController::createUrl('Staff/ChangeStatus') ?>",
            data: {
                'id_dentist': id_dentist,
                'dow': dow,
                'status': $status,
            },
            success: function(data) {
                alert("success !");
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    }

    function remove_relax(id) {
        var checkstr = confirm('are you sure you want to delete this?');
        if (checkstr == true) {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo CController::createUrl('Staff/RemoveTimeRelax') ?>",
                data: {
                    'id': id,
                },
                success: function(data) {
                    if (data) {
                        alert(data);
                    } else {
                        alert("Không xóa được");
                    }
                },
                error: function(data) {
                    alert("Error occured.Please try again!");
                },
            });
            $('#row_relax_' + id).remove();
        } else {
            return false;
        }

    }

    function showUpdateStaff(id) {
        var evt = window.event || arguments.callee.caller.arguments[0];
        evt.preventDefault();
        var position = $('#ltn' + id).position();
        $('#updateStaffPopup' + id).css({
            "top": position.top - 50,
            "left": position.left + 50
        });
        $('#updateStaffPopup' + id).fadeToggle('fast');
        evt.stopPropagation();
    }

    function updateCustomerName(id) {
        if ($('#staffName' + id).val() != "") {
            var formData = new FormData($('#frm-update-staff-' + id)[0]);
            formData.append('id_staff', id);
            if (!formData.checkValidity || formData.checkValidity()) {
                jQuery.ajax({
                    type: 'POST',
                    url: baseUrl + '/itemsUsers/Staff/updateStaffName',
                    data: formData,
                    datatype: 'json',
                    success: function(data) {
                        if (data == 1) {
                            searchSmsSetting(id);
                        }
                    },
                    error: function(data) {
                        console.log("error");
                        console.log(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        }
    }
</script>