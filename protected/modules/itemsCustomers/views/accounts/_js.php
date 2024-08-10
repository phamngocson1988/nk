<script>
    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    };

    function isValidPhoneNumber(phoneNumber) {
        var pattern = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        return pattern.test(phoneNumber);
    }

    var baseUrl = $('#baseUrl').val();
    var is_ajax = false; // Biến dùng kiểm tra nếu đang gửi ajax thì ko thực hiện gửi thêm
    var is_busy = false; // Biến dùng kiểm tra nếu đang gửi ajax thì ko thực hiện gửi thêm
    var page = 1; // Biến lưu trữ trang hiện tại
    var stopped = false; // Biến lưu trữ rạng thái phân trang

    var search_page = 1;
    var search_stop = false;

    function searchCustomers(id) {
        // Nếu đang gửi ajax thì ngưng
        if (is_ajax == true) {
            return false;
        }
        // Thiết lập đang gửi ajax
        is_ajax = true;

        var value = $('#searchNameCustomer').val();
        var email = $('#iptSearchEmail').val();

        var country = $('#iptSearchCountry').val();
        var identity_card_number = $('#iptSearchIdentityCardNumber').val();
        var source = $('#iptSearchSource').val();
        var segment = $('#iptSearchSegment').val();
        var type = $("#searchSortCustomer").val();

        //$('.cal-loading').fadeOut('slow');
        //$('.cal-loading').fadeIn('fast');

        $.ajax({
            type: 'POST',
            url: baseUrl + '/itemsCustomers/Accounts/searchCustomers',
            data: {
                "value": value,
                "email": email,
                "country": country,
                "identity_card_number": identity_card_number,
                "source": source,
                "segment": segment,
                "type": type
            },
            success: function(data) {
                page = 1;
                stopped = false;
                $('#customerList').html(data);
                detailCustomer(id);
                is_ajax = false;
                $("#searchCustomerPopup").hide();
            },
            error: function(data) {
                console.log("error");
                console.log(data);
            }
        });
        //$('.cal-loading').fadeOut('slow');
    }

    function detailCustomer(id) {
        var dental_status_change = $('#dental_status_change').val();
        if (dental_status_change == 1) {
            if (confirm("Bạn có muốn lưu tình trạng răng của khách hàng này không?")) {
                $('#save').click();
                return;
            }
        }

        $('.cal-loading').fadeIn('fast');
        if (id == null || id == '') {
            var id = $("#customerList li:first-child").find('input').val();
        }

        $('.n').removeClass("active");
        $("#c" + id).addClass("active");
        $("#c" + id).find('code').removeClass("hide");

        $.ajax({
            type: 'POST',
            url: baseUrl + '/itemsCustomers/Accounts/detailCustomer',
            data: {
                "id": id
            },
            success: function(data) {
                $('#detailCustomer').html(data);
                $('.cal-loading').fadeOut('fast');
            },
            error: function(data) {
                console.log("error-detailCustomer");
                console.log(data);
            }
        });
        //formOldBalance(id);
    }

    //** jQuery Ajax scrolling pagination **//

    $(document).ready(function() {
        // Khi kéo scroll thì xử lý

        $('#customerList').on('scroll', function() {
            // Nếu màn hình đang ở dưới cuối thẻ thì thực hiện ajax
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                // Nếu đang gửi ajax thì ngưng
                if (is_busy == true) {
                    return false;
                }
                // Nếu hết dữ liệu thì ngưng
                if (stopped == true) {
                    return false;
                }
                // Thiết lập đang gửi ajax
                is_busy = true;
                // Tăng số trang lên 1
                page++;
                // Hiển thị loadding
                $('#loadding').removeClass('hidden');
                // Gửi Ajax
                var value = $('#searchNameCustomer').val();
                var email = $('#iptSearchEmail').val();


                var country = $('#iptSearchCountry').val();
                var identity_card_number = $('#iptSearchIdentityCardNumber').val();
                var source = $('#iptSearchSource').val();
                var segment = $('#iptSearchSegment').val();
                var type = $("#searchSortCustomer").val();
                $.ajax({
                        type: 'POST',
                        url: baseUrl + '/itemsCustomers/Accounts/searchCustomers',
                        data: {
                            "value": value,
                            "email": email,
                            "country": country,
                            "identity_card_number": identity_card_number,
                            "source": source,
                            "segment": segment,
                            "type": type,
                            "cur_page": page
                        },
                        success: function(result) {

                            $('#customerList').append(result);
                        }
                    })
                    .always(function() {
                        // Sau khi thực hiện xong ajax thì ẩn hidden và cho trạng thái gửi ajax = false
                        $('#loadding').addClass('hidden');
                        is_busy = false;
                    });
                return false;
            }
        });

        $('#searchCustomerResult').on("scroll", function() {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                if (search_stop == true) {
                    return false;
                }
                if ($('#txtSearchCustomer').val() != '' || $('#iptSearchEmail').val() != '' || $('#iptSearchCountry').val() != '' || $('#iptSearchIdentityCardNumber').val() != '' || $('#iptSearchSource').val() != '' || $('#iptSearchSegment').val() != '') {
                    search_page++;
                    $.ajax({
                        type: 'POST',
                        url: baseUrl + '/itemsCustomers/Accounts/getCustomerList',
                        data: {
                            "q": $('#txtSearchCustomer').val(),
                            "page": search_page,
                            "type": $("input[name='sort']:checked"). val(),
                            "email": $('#iptSearchEmail').val(),
                            "country": $('#iptSearchCountry').val(),
                            "identity_card_number": $('#iptSearchIdentityCardNumber').val(),
                            "source": $('#iptSearchSource').val(),
                            "segment": $('#iptSearchSegment').val()
                        },
                        success: function(resp) {
                            var result = JSON.parse(resp);
                            if (result.length > 0) {
                                var result_html = "";
                                for (var i = 0; i < result.length; i++) {
                                    result_html += '<li class="row"><a href="#" onclick="showCustomer('+result[i]['id']+')"><div class="col-md-2">' + result[i]['code_number'] + '</div>';
                                    result_html += '<div class="col-md-3">' + result[i]['text'] + '</div>';
                                    result_html += '<div class="col-md-2">' + result[i]['birthdate'] + '</div>';
                                    result_html += '<div class="col-md-2">' + result[i]['phone'] + '</div>';
                                    result_html += '<div class="col-md-3">' + result[i]['address'] + '</div>' + '</a></li>';
                                }   
                                $('#searchCustomerResult ul').append(result_html);
                            }
                            if (result.length < 20) {
                                search_stop = true;
                            }
                        }
                    })
                    .always(function() {
                        $('#searchProcess').addClass('hidden');
                        is_busy = false;
                    });
                }
            }
        });

        $('#searchCustomerModal').on('hidden.bs.modal', function () {
            $('#txtSearchCustomer').val('');
            $('#searchCustomerResult').html('');
            search_page = 1;
            search_stop = false;
        });
    });

    //** end jQuery Ajax scrolling pagination **//

    function runScript_search(e) {

        if (e.keyCode == 13) {
            e.preventDefault();
            searchCustomers();
        }
    }

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    $('#txtSearchCustomer').keypress(function(){
        $('#searchProcess').removeClass('hidden');
        $('#searchProcess').text('đang tìm kiếm');
        $('#searchCustomerResult').html('');
    })

    $('#txtSearchCustomer').keyup(delay(function(e){
        search_stop = false;
        search_page = 1;
        if ($(this).val() != '') {
            $.ajax({
                type: 'POST',
                url: baseUrl + '/itemsCustomers/Accounts/getCustomerList',
                data: {
                    "q": $(this).val(),
                    "page": 1,
                },
                success: function(resp) {
                    var result = JSON.parse(resp);
                    console.log(result.length);
                    if (result.length > 0) {
                        var result_html = "<ul class='table table-condensed'>";
                        for (var i = 0; i < result.length; i++) {
                            result_html += '<li class="row"><a href="#" onclick="showCustomer('+result[i]['id']+')"><div class="col-md-2">' + result[i]['code_number'] + '</div>';
                            result_html += '<div class="col-md-3">' + result[i]['text'] + '</div>';
                            result_html += '<div class="col-md-2">' + result[i]['birthdate'] + '</div>';
                            result_html += '<div class="col-md-2">' + result[i]['phone'] + '</div>';
                            result_html += '<div class="col-md-3">' + result[i]['address'] + '</div>' + '</a></li>';
                        }
                        result_html += '</ul>';    
                    } else {
                        var result_html = 'Không có dữ liệu';
                    }
                    $('#searchCustomerResult').html(result_html);
                }
            })
            .always(function() {
                $('#searchProcess').addClass('hidden');
                is_busy = false;
            });
        }
    }, 1000));

    function showCustomer(id) {
        $('#searchCustomerModal').modal('toggle');
        detailCustomer(id);
    }

    function advanceSearch() {
        var sort_by = $("input[name='sort']:checked"). val();
        var email = $('#iptSearchEmail').val();
        var country = $('#iptSearchCountry').val();
        var id_card = $('#iptSearchIdentityCardNumber').val();
        var source = $('#iptSearchSource').val();
        var segment = $('#iptSearchSegment').val();
        $.ajax({
            type: 'POST',
            url: baseUrl + '/itemsCustomers/Accounts/getCustomerList',
            data: {
                "q": "",
                "page": 1,
                "type": sort_by,
                "email": email,
                "country": country,
                "identity_card_number": id_card,
                "source": source,
                "segment": segment
            },
            success: function(resp) {
                var result = JSON.parse(resp);
                console.log(result.length);
                if (result.length > 0) {
                    var result_html = "<ul class='table table-condensed'>";
                    for (var i = 0; i < result.length; i++) {
                        result_html += '<li class="row"><a href="#" onclick="showCustomer('+result[i]['id']+')"><div class="col-md-3">' + result[i]['text'] + '</div>';
                        result_html += '<div class="col-md-2">' + result[i]['birthdate'] + '</div>';
                        result_html += '<div class="col-md-2">' + result[i]['phone'] + '</div>';
                        result_html += '<div class="col-md-5">' + result[i]['address'] + '</div>' + '</a></li>';
                    }
                    result_html += '</ul>';    
                } else {
                    var result_html = 'Không có dữ liệu';
                }
                $('#searchCustomerResult').html(result_html);
                $('#searchCustomerModal').modal('show');
            }
        })
        .always(function() {
            $('#searchProcess').addClass('hidden');
            is_busy = false;
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

        // if($('#code_insurrance').val() == ''){
        //        status = false;
        //        $('#code_insurrance').addClass('invalid');
        //    }
        //    else{
        //    	$('#code_insurrance').removeClass('invalid');
        //    }

        if ($('#type_insurrance').val() == '') {
            status = false;
            $('#type_insurrance').addClass('invalid');
        } else {
            $('#type_insurrance').removeClass('invalid');
        }

        if ($('#startdate').val() == '') {
            status = false;
            $('#startdate').addClass('invalid');
        } else {
            $('#startdate').removeClass('invalid');
        }

        if ($('#enddate').val() == '') {
            status = false;
            $('#enddate').addClass('invalid');
        } else {
            $('#enddate').removeClass('invalid');
        }

        if ($('#startdate').val() != '' && $('#enddate').val() != '') {
            if ($('#enddate').val() < $('#startdate').val()) {
                status = false;
                $('#startdate').addClass('invalid');
                $('#enddate').addClass('invalid');
            } else {
                $('#enddate').removeClass('invalid');
                $('#startdate').removeClass('invalid');
            }
        }

        // if($('#startdate').val() != ''){
        //     if($('#startdate').val() < date){
        //         status = false;
        //         $('#startdate').addClass('invalid');
        //     }
        //     else{
        //         $('#startdate').removeClass('invalid');
        //     }
        // }

        return status;
    }

    function updateCustomerImage(id) {

        $("#webcamModal").removeClass("in");
        $(".modal-backdrop").remove();
        $('#webcamModal').modal('hide');

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
                    searchCustomers(id);
                    Webcam.reset();
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

    function updateCustomerImageDefault(id) {

        $("#webcamModal").removeClass("in");
        $(".modal-backdrop").remove();
        $('#webcamModal').modal('hide');

        $.ajax({
            type: 'POST',
            url: baseUrl + '/itemsCustomers/Accounts/updateCustomerImageDefault',
            data: {
                "id": id
            },
            success: function(data) {
                $("#imageUploader").html(data);
                searchCustomers(id);
                Webcam.reset();
            },
            error: function(data) {
                console.log("error");
                console.log(data);
            }
        });

    }

    function change_flag(id) {
        $("#on_flag").toggleClass("On");
        $("#off_flag").toggleClass("Off");
        $('#switch_flag').toggleClass("Switch");

        if ($('#hidden_flag').val() == 0) {
            $('#hidden_flag').val(1);
        } else {
            $('#hidden_flag').val(0);
        }
        updateCustomer(id);
    }

    //#region --- UPDATE CUSTOMER REMAIN SCHEDULE
    function change_remindSchedule(id) {
        var $id = "#slideRemind";

        $($id + " .slider_on").toggleClass("On");
        $($id + " .slider_off").toggleClass("Off");
        $($id + " .slider_switch").toggleClass("Switch");

        if ($('#remind-isRemindSchedule').val() == 0) {
            $('#remind-isRemindSchedule').val(1);
            $('li.remindSchedule').show();
        } else {
            $('#remind-isRemindSchedule').val(0);
            $('li.remindSchedule').hide();
        }

        updateScheduleRemind(id);
    }

    function updateScheduleRemind(id) {
        $.ajax({
            type: 'POST',
            url: baseUrl + '/itemsCustomers/Accounts/updateScheduleRemind',
            dataType: 'json',
            data: {
                id_customer: id,
                isRemindSchedule: $('#remind-isRemindSchedule').val(),
                durations: $("#remind-durations").val(),
                durations_type: $('#remind-durations_type').val(),
                date_remind: moment($('#remind-date_remind').val(), 'DD/MM/YYYY').format("YYYY-MM-DD")
            },
            success: function(data) {
                console.log(data);
                if (data.status == 1) {
                    $('#alert-success').append('<div class = "alert alert-success" id="success-alert"><a href = "#" class = "close" data-dismiss = "alert" style="font-size: 22px; color:#333;">&times;</a><strong>Thành Công!</strong> Đã cập nhật...</div>');
                    var element = $('.alert-success');
                    for (var i = element.length; i >= 0; i--) {
                        $(element[i]).fadeTo(2000, 500).slideUp(500, function() {
                            $(this).remove();
                        });
                    }
                    $('#remind-date_remind').val(moment(data.data.date_remind, 'YYYY-MM-DD').format('DD/MM/YYYY'));
                } else if (data.status == 0) {
                    var error = data['error-message'];

                    if (typeof error == 'string') {
                        $('#alert-success').append('<div class = "alert alert-danger"><a href = "#" class = "close" data-dismiss = "alert" style="font-size: 22px; color:#333;">&times;</a><strong>Thất bại!</strong> <br>'+error+' </div>');

                        var element = $('.alert-danger');
                        for (var i = element.length; i >= 0; i--) {
                            $(element[i]).fadeTo(2000, 500).slideUp(500, function() {
                                $(this).remove();
                            });
                        }
                    } else if (Object.keys(error).length > 0) {
                        Object.keys(error).forEach(ms => {
                            $('#alert-success').append('<div class = "alert alert-danger"><a href = "#" class = "close" data-dismiss = "alert" style="font-size: 22px; color:#333;">&times;</a><strong>Thất bại!</strong> <br>'+error[ms][0]+' </div>');

                            var element = $('.alert-danger');
                            for (var i = element.length; i >= 0; i--) {
                                $(element[i]).fadeTo(2000, 500).slideUp(500, function() {
                                    $(this).remove();
                                });
                            }
                        });
                    }
                }
            },
            error: function(data) {
                console.log("error");
                console.log(data);
            }
        });
    }
    //#endregion

    function updateCustomer(id) {
        if (err()) {
            code_number = $('#code_number').val();
            fullname = $('#fullname').val();
            membership_card = ('#membership_card');
            email = $('#email').val();
            phone = $('#phone').val();
            phone_sms = $('#phone_sms').val();
            gender = $('#gender').val();
            birthdate = $('#birthdate').val();
            identity_card_number = $('#identity_card_number').val();
            id_country = $('#id_country').val();
            id_source = $('#id_source').val();
            id_job = $('#id_job').val();
            position = $('#position').val();
            address = $('#address').val();

            flag = $('#hidden_flag').val();
            last_day = $('#last_day').val();
            note = $('#note_customer').val();
            nickname = $('#nickname').val();
            phone2 = $('#phone2').val();
            city = $('#city').val();
            county = $('#county').val();
            branch = $('#branch').val();

            $.ajax({
                type: 'POST',
                url: baseUrl + '/itemsCustomers/Accounts/updateCustomer',
                data: {
                    "id": id,
                    'membership_card': membership_card,
                    "code_number": code_number,
                    "fullname": fullname,
                    "email": email,
                    "phone": phone,
                    "phone_sms": phone_sms,
                    "gender": gender,
                    "birthdate": birthdate,
                    "identity_card_number": identity_card_number,
                    "id_country": id_country,
                    "id_source": id_source,
                    "id_job": id_job,
                    "position": position,
                    "address": address,
                    "flag": flag,
                    "last_day": last_day,
                    "note": note,
                    "nickname": nickname,
                    "phone2": phone2,
                    "city": city,
                    "county": county,
                    "branch": branch
                },
                success: function(data) {
                    if (data == '-1') {
                        alert('Số điện thoại không được quá 10 ký tự');
                        return false;
                    }
                    if (data == '-4') {
                        alert('Đầu số điện thoại không đúng');
                        return false;
                    }
                    if (data == '-2') {
                        alert('Email này đã tồn tại, vui lòng chọn email khác');
                        return false;
                    } else {
                        if (data) {
                            $('#alert-success').append(data);
                            var element = $('.alert-success');
                            // var count = element.length;
                            for (var i = element.length; i >= 0; i--) {
                                $(element[i]).fadeTo(2000, 500).slideUp(500, function() {
                                    $(this).remove();
                                });
                            }
                        }
                        // sendEmail(email,fullname);
                        // searchCustomers(id);
                        // $("#voice-box").removeClass("noDisplay").delay(1000).queue(function(){
                        //     $(this).addClass("noDisplay").dequeue();
                        // });
                    }

                },
                error: function(data) {
                    console.log("error");
                    console.log(data);
                }
            });
        }
    }

    function updateCodeMember(id) {
        membership_card = $('#membership_card').val();
        $.ajax({
            type: 'POST',
            url: baseUrl + '/itemsCustomers/Accounts/UpdateCodeMember',
            data: {
                "id": id,
                'membership_card': membership_card
            },
            success: function(data) {
                // sendEmail(email,fullname);
                searchCustomers(id);
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

    function randomString(length, chars) {
        var result = '';
        for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
        return result;
    }

    function sendEmail(id) {
        var fullname = $('#fullname').val();
        var email = $('#email').val();
        var pass = randomString(6, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        var resufl_confirm = confirm("Bạn muốn gửi mail xác nhận tới địa chỉ này không ? ");
        if (resufl_confirm) {
            $.ajax({
                type: 'POST',
                url: baseUrl + '/itemsCustomers/Accounts/SendMailCreateUser',
                data: {
                    'email': email,
                    'fullname': fullname,
                    'pass': pass,
                    'id': id
                },
                success: function(data) {
                    alert(data);
                    $('#username').val(email);
                    $('#password').val(pass);
                },
                error: function(data) {
                    console.log("error");
                    console.log(data);
                }
            });
        }
    }

    function updateCustomerSegment(id) {

        var id_segment = $('#id_segment').val();

        $.ajax({
            type: 'POST',
            url: baseUrl + '/itemsCustomers/Accounts/updateCustomerSegment',
            data: {
                "id": id,
                "id_segment": id_segment
            },
            success: function(data) {
                if (data) {
                    $('#alert-success').append(data);
                    var element = $('.alert-success');
                    // var count = element.length;
                    for (var i = element.length; i >= 0; i--) {
                        $(element[i]).fadeTo(2000, 500).slideUp(500, function() {
                            $(this).remove();
                        });
                    }
                }
                // searchCustomers(id);
            },
            error: function(data) {
                console.log("error");
                console.log(data);
            }
        });

    }

    function updateStatusSchedule(id, id_customer, id_dentist) {
        var id_quotation = $("#id_quotation").val();
        var status_schedule = $("#status_schedule_" + id).val();

        $.ajax({
            type: 'POST',
            url: baseUrl + '/itemsCustomers/Accounts/updateStatusSchedule',
            data: {
                "id": id,
                "id_quotation": id_quotation,
                "id_customer": id_customer,
                "status_schedule": status_schedule
            },
            dataType: "json",
            success: function(data) {
                if (data == 0) {
                    alert("Cập nhật thất bại! Có lịch hẹn đang ở trạng thái đang chờ hoặc chưa hoàn tất");
                } else if (data) {
                    getNoti(id, "update", <?php echo Yii::app()->user->getState('user_id'); ?>, id_dentist);

                    if (status_schedule == 3) {

                        $("li#c" + id_customer + " code").replaceWith('<code class=\"delete_btn status_3\">Điều trị</code>');

                    } else if (status_schedule == 6) {

                        $("li#c" + id_customer + " code").replaceWith('<code class=\"delete_btn status_6\">Vào khám</code>');

                    } else {

                        $("li#c" + id_customer + " code").remove();

                    }

                    detailCustomer(id_customer);

                }

            },
            error: function(data) {
                console.log("error");
                console.log(data);
            }
        });
    }

    function updateToExamination(id_customer) {

        $.ajax({
            type: 'POST',
            url: baseUrl + '/itemsCustomers/Accounts/updateToExamination',
            data: {
                "id_customer": id_customer
            },
            success: function(data) {
                var getData = $.parseJSON(data);

                if (getData) {

                    var time = 500;

                    $.each(getData, function(i, item) {
                        setTimeout(function() {
                            getNoti(getData[i].id, "update", <?php echo Yii::app()->user->getState('user_id'); ?>)
                        }, time);
                        time += 500;
                    });

                }
                searchCustomers(id_customer);
            },
            error: function(data) {
                console.log("error");
                console.log(data);
            }
        });

    }

    function changeBlackList(id_customer) {
        if (err_insurrance()) {
            var insurrance_status = $('#insurrance_status').val();
            $.ajax({
                type: 'POST',
                url: baseUrl + '/itemsCustomers/Accounts/UpdateStatusInsurrance',
                data: {
                    "id_customer": id_customer,
                    "insurrance_status": insurrance_status
                },
                success: function(data) {
                    searchCustomers(id_customer);
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

    function insertUpdateCustomerInsurrance(id_customer) {
        // alert(id_customer);
        // return false;
        if (err_insurrance()) {

            code_insurrance = $('#code_insurrance').val();
            type_insurrance = $('#type_insurrance').val();
            startdate = $('#startdate').val();
            enddate = $('#enddate').val();
            $.ajax({
                type: 'POST',
                url: baseUrl + '/itemsCustomers/Accounts/insertUpdateCustomerInsurrance',
                data: {
                    "id_customer": id_customer,
                    "code_insurrance": code_insurrance,
                    "type_insurrance": type_insurrance,
                    "startdate": startdate,
                    "enddate": enddate
                },
                success: function(data) {
                    searchCustomers(id_customer);
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

    function click_to_call(phone) {

        jQuery.ajax({
            type: "POST",
            url: baseUrl + '/itemsCustomers/Accounts/ClickToCall',
            data: {
                "phone": phone
            },
            success: function(data) {
                if (data != '1') {
                    alert('Failed to call. Please try again!')
                }
            }
        });
    }

    function getNoti(id_schedule, action, author, id_dentist) {
        $.ajax({
            url: baseUrl + '/itemsSchedule/calendar/getNoti',
            type: "post",
            dataType: 'json',
            data: {
                id_schedule: id_schedule,
                action: action,
                id_author: author,
                id_dentist: id_dentist,
            },
            success: function(data) {
                console.log(data);
            }
        })
    }

    function formOldBalance(id) {
        $.ajax({
            url: baseUrl + '/itemsCustomers/Accounts/formOldBalance',
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $('#addOldBalance').html(data);
            },
            error: function(data) {
                formOldBalance(id);
            },
        })
    }

    $(document).ready(function() {});

    $('#newCustomer').click(function() {
        console.log(1);
        $('#addnewCustomerPopup').fadeToggle('fast');
    });
    $('#cancelNewCustomer').click(function() {
        $('#parsley').html('');
        $('#addnewCustomerPopup').hide();
    });
    $('#frm-add-customer').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($("#frm-add-customer")[0]);
        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({
                type: "POST",
                url: baseUrl + '/itemsCustomers/Accounts/add',
                data: formData,
                datatype: 'json',
                success: function(data) {
                    console.log(data);
                    if (data == -4) {
                        $('#parsley').html('Bạn chưa nhập mã khách hàng.');
                    } else if (data == -1) {
                        $('#parsley').html('Bạn chưa nhập họ và tên.');
                    } else if (data == -2) {
                        $('#parsley').html('Bạn chưa nhập số điện thoại.');
                    } else if (data == -5) {
                        $('#parsley').html('Mã khách hàng đã tồn tại.');
                    } else if (data == -6) {
                        $('#parsley').html('Mã khách hàng phải là số.');
                    } else if (data == -7) {
                        $('#parsley').html('Mã khách hàng phải là 10 số.');
                    } else if (data == -8) {
                        $('#parsley').html('Số điện thoại không đúng đầu số.');
                    } else {
                        $('#frm-add-customer')[0].reset();
                        $('#addnewCustomerPopup').hide();
                        // $('#searchNameCustomer').val(data);
                        detailCustomer(data);
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

    $('#sortLabel').click(function() {
        var position = $(this).position();
        $('#searchCustomerPopup').css({
            "top": position.top + 105,
            "left": position.left - 175
        }).fadeToggle('fast');
    });

    $(document).mouseup(function(e) {
        var container = $("#searchCustomerPopup");
        if (!container.is(e.target) &&
            container.has(e.target).length === 0 && $(e.target).closest($('#ui-datepicker-div')).length === 0) {
            container.hide();
        }
    });

    $('.SortBy').click(function() {
        $("#searchSortCustomer").val($(this).val());
    });

    var timeout;
    $('#searchNameCustomer').on('onchange', function() {
        //if you already have a timout, clear it
        if (timeout) {
            clearTimeout(timeout);
        }

        //start new time, to perform ajax stuff in 500ms
        timeout = setTimeout(function() {
            searchCustomers();
            //your ajax stuff
        }, 500);
    })

    //console.log($('#getFormOldBalance').length);

    /*** edit_cam ***/

    function showUpdateCustomer(id) {
        var evt = window.event || arguments.callee.caller.arguments[0];
        evt.preventDefault();
        var position = $('#ltn' + id).position();
        $('#updateCustomerPopup' + id).css({
            "top": position.top - 50,
            "left": position.left + 50
        });
        $('#updateCustomerPopup' + id).fadeToggle('fast');
        evt.stopPropagation();
    }

    $(document).mouseup(function(e) {
        var container = $(".popover.bottom.customer");
        if (!container.is(e.target) &&
            container.has(e.target).length === 0) {
            container.hide();
        }
    });

    function deleteCustomer(id) {
        if (confirm("Bạn có thật sự muốn xóa?")) {
            $.ajax({
                type: 'POST',
                url: baseUrl + '/itemsCustomers/Accounts/deleteCustomer',
                data: {
                    "id": id
                },
                success: function(data) {
                    if (data == 1) {
                        searchCustomers();
                    }
                },
                error: function(data) {
                    console.log("error");
                    console.log(data);
                }
            });
        }
    }

    function updateCustomerName(id) {
        if ($('#customerName' + id).val() != "") {
            var formData = new FormData($('#frm-update-customer-' + id)[0]);
            formData.append('id_customer', id);
            if (!formData.checkValidity || formData.checkValidity()) {
                jQuery.ajax({
                    type: 'POST',
                    url: baseUrl + '/itemsCustomers/Accounts/updateCustomerName',
                    data: formData,
                    datatype: 'json',
                    success: function(data) {
                        if (data == 1) {
                            searchCustomers(id);
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

    /*** end edit_cam ***/

    function showCounty(id, county = "0") {
        if (county == "0") {
            updateCustomer(id);
        }
        var city = $("#city").val();
        jQuery.ajax({
            type: 'POST',
            url: baseUrl + '/itemsCustomers/Accounts/LoadCounty',
            data: {
                "id": id,
                "city": city,
                "county": county
            },
            success: function(data) {
                $("#Localtiondistrict").html(data);
            },
            error: function(data) {
                console.log("error");
                console.log(data);
            },
        });
    }
</script>