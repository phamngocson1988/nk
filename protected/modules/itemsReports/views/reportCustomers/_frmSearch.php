<style>
    .changeW {
        margin-left: -250px;
        border-top: 1px solid rgb(102, 175, 233) !important;
        width: 800px !important;
    }
</style>

<?php
$group_id =  Yii::app()->user->getState('group_id');
$type_search = 2;
$disable = "";
if ($group_id == 3) {
    $disable = "disabled";
    $type_search = 5;
}
$user_id = Yii::app()->user->getState('user_id');
?>

<form class="form-inline">
    <div id="oSrchRight" class="pull-left col-xs-10">
        <div class="row">
            <div class="col-xs-3">
                <div class="row">
                    <label class="col-xs-3">Loại: </label>
                    <div class="col-xs-9" style="padding: 0">
                        <?php
                        $listdata = array();

                        if (Yii::app()->user->getState('group_id') != 19) {
                            $listdata['2'] = "Khách hàng mới";
                            $listdata['3'] = "Sinh nhật khách hàng";
                            $listdata['4'] = "Tổng doanh thu khách hàng";
                            $listdata['5'] = "Khách hàng theo dịch vụ";
                            $listdata['6'] = "Ghi chú khách hàng";
                            $listdata['7'] = "Nguồn khách hàng";
                            $listdata['8'] = "Khách hàng còn công nợ";
                            $listdata['9'] = "Ngày điều trị cuối cùng";
                            $listdata['10'] = "Khách hàng gọi sau điều trị";
                            $listdata['11'] = "Khách hàng không điều trị";
                            $listdata['12'] = "Ngày nhắc hẹn";
                            $listdata['13'] = "Theo khu vực";
                        } else {
                            $listdata['3'] = "Sinh nhật khách hàng";
                            $listdata['9'] = "Ngày điều trị cuối cùng";
                        }

                        // $listdata['1'] = "Tổng lượt điều trị khách hàng";

                        echo CHtml::dropDownList('frm_search_type', $type_search, $listdata, array('onChange' => "search_cus()", 'class' => 'form-control', 'disabled' => $disable));
                        ?>
                    </div>
                </div>
            </div>

			<!-- report-customer report-new report-birthdate report-revenue report-service report-note report-source report-debt report-lasttreatmentdate report-aftertreatment report-donttreatment -->

            <div class="col-xs-3 report-customer report-new report-birthdate report-revenue report-service report-note report-source report-debt report-aftertreatment report-donttreatment report-remind" id="branch">
                <div class="row">
                    <label class="col-xs-4">Văn phòng: </label>
                    <div class="col-xs-8" style="padding: 0">
                        <?php
                        $listdata     = array();
                        $listdata[""] = "Tất cả";
                        $branch       = Branch::model()->findAll();
                        foreach ($branch as $temp) {
                            $listdata[$temp['id']] =  $temp['name'];
                        }
                        echo CHtml::dropDownList('frm_search_branch', '', $listdata, array('class' => 'form-control', 'onChange' => 'changeBranch()', 'disabled' => $disable));
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-xs-3 report-customer report-new report-birthdate report-revenue report-service report-note report-source report-debt report-lasttreatmentdate report-remind report-area">
                <div class="row">
                    <label class="col-xs-4">Thời gian: </label>
                    <div class="col-xs-8" style="padding: 0">
                        <?php
                        $listdata        = array();
                        $listdata['5']   = "Chọn thời gian";
                        $listdata['1']   = "Hôm nay";
                        $listdata['2']   = "Tuần này";
                        $listdata['3']   = "Tháng này";
                        $listdata['4']   = "Tháng trước";
                        echo CHtml::dropDownList('frm_search_date', 1, $listdata, array('class' => 'form-control'));
                        ?>
                    </div>
                </div>
			</div>

			<div class="col-xs-3 report-customer report-aftertreatment report-donttreatment" style="display: none;">
                <div class="row">
                    <label class="col-xs-4">Thời gian: </label>
                    <div class="col-xs-8" style="padding: 0">
						<input type="text" class="form-control datepicker" id="datetime" autocomplete="off">
                    </div>
                </div>
			</div>

            <div class="col-xs-3 report-customer report-new report-birthdate report-revenue report-service report-note report-source report-debt" id="staff">
                <div class="row">
                    <label class="col-xs-4">Nhân viên: </label>
                    <div id="lstStaff" class="col-xs-8">
                        <div class="row">
                            <?php
                            $listdata     = array();
                            $listdata[""] = "Tất cả";
                            $User         = GpUsers::model()->findAllByAttributes(array('block' => 0, 'group_id' => 3));
                            foreach ($User as $temp) {
                                $listdata[$temp['id']] =  $temp['name'];
                            }
                            echo CHtml::dropDownList('frm_search_user', $user_id, $listdata, array('class' => 'form-control', 'disabled' => $disable));
                            ?>
                        </div>
                    </div>
                </div>
			</div>

            <div class="col-xs-3 report-area" style="display: none;">
                <div class="row">
                    <label class="col-xs-3" style="padding: 0">Quốc gia:</label>
                    <div class="col-xs-9" style="padding: 0">
                        <?php
                        $listdata        = array();
                        $Localtionprovince = Customer::model()->getListCountry();
                        foreach ($Localtionprovince as $temp) {
                            $listdata[$temp['code']] =  $temp['country'];
                        }
                        echo CHtml::dropDownList('frm_search_country', '', $listdata, array('empty' => 'Tất cả', 'class' => 'form-control'));
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-xs-3 report-area" style="display: none;">
                <div class="row">
                    <label class="col-xs-3" style="padding: 0">Tỉnh thành:</label>
                    <div class="col-xs-9" style="padding: 0">
                        <?php
                        $listdata        = array();
                        $Localtionprovince = LocaltionProvince::model()->findAll();
                        foreach ($Localtionprovince as $temp) {
                            $listdata[$temp['provinceID']] =  $temp['provinceDescriptionVn'];
                        }
                        echo CHtml::dropDownList('frm_search_city', '', $listdata, array('empty' => 'Tất cả', 'onChange' => "showCounty(this.value, 0);", 'class' => 'form-control'));
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-xs-3 report-area" style="display: none;">
                <div class="row">
                    <label class="col-xs-3" style="padding: 0">Quận/huyện:</label>
                    <div class="col-xs-9" style="padding: 0">
                        <?php
                        $listdata        = array();
                        echo CHtml::dropDownList('frm_search_district', '', $listdata, array('empty' => '', 'onChange' => "", 'class' => 'form-control'));
                        ?>
                    </div>
                </div>
            </div>

			<!-- <div class="clearfix" style="padding-bottom: 5px;"></div> -->

			<div class="col-xs-3 report-customer report-source" id="souce" style="display: none;">
                <div class="row">
					<label class="col-xs-3">Nguồn: </label>
					<div class="col-xs-9" style="padding: 0">
						<?php
							$listdata     = array();
							$User         = Customer::model()->getListSource();
							foreach ($User as $temp) {
								$listdata[$temp['id']] =  $temp['name'];
							}
							echo CHtml::dropDownList('frm_search_source', 1, $listdata, array('class' => 'form-control'));
						?>
					</div>
				</div>
			</div>

			<div class="col-xs-3 report-customer report-service" style="display: none;">
                <div class="row">
                    <label class="col-xs-3" style="padding: 0">Nhóm DV:</label>
                    <div class="col-xs-9" style="padding: 0">
						<?php
                        $listdata        = array();
                        $User         = CsServiceType::model()->findAllByAttributes(array('status' => 1));
                        foreach ($User as $temp) {
                            $listdata[$temp['id']] =  $temp['name'];
                        }
                        echo CHtml::dropDownList('frm_search_nhom_dich_vu', '', $listdata, array('empty' => '', 'onChange' => "search_service(this.value);", 'class' => 'Service form-control'));
                        ?>
                    </div>
                </div>
			</div>

			<div class="col-xs-3 report-customer report-service" style="display: none;">
                <div class="row">
                    <label class="col-xs-4">Chọn dịch vụ:</label>
                    <div class="col-xs-8" style="padding: 0">
						<span id="service">
							<select id="frm_search_dich_vu" class=" form-control select2">
                                <option value="">Chọn dịch vụ</option>
                            </select>
                        </span>
                    </div>
                </div>
			</div>

			<div class="col-xs-3 report-customer report-service" style="display: none;">
                <div class="row">
                    <label class="col-xs-4">Khách hàng:</label>
                    <div class="col-xs-8" style="padding: 0">
						<select name="" class="form-control" id="frm_search_customer"></select>
                    </div>
                </div>
			</div>

			<!-- <div class="clearfix" style="padding-bottom: 5px;"></div> -->

            <div id="time" class="hidden col-xs-6" style="padding: 0">
                <div class="col-xs-6">
                    <div class="row">
                        <label class="col-xs-3">Từ ngày: </label>
                        <div class="col-xs-9" style="padding: 0">
                            <input type="text" id="fromtime" class="form-control" value="" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="row">
                        <label class="col-xs-4">Đến ngày: </label>
                        <div class="col-xs-8" style="padding: 0">
                            <input type="text" id="totime" class="form-control" value=""  autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="oSrchLeft" class="pull-right col-xs-2" style="text-align: right;">
        <div class="btn-group">
            <button type="button" class="btn btn_bookoke" onclick="search_cus()"><i class="fa fa-search-plus"></i>&nbsp;Xem</button>
            <button type="button" class="btn btn_bookoke dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>

            <ul class="dropdown-menu menu-export">
                <li><a href="#" class="print"><i class="fa fa-print"></i>&nbsp;In</a></li>
                <li><a href="#" class="btn_excel"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</a></li>
                <li><a href="#" class="word"><i class="fa fa-file-word-o"></i>&nbsp;Word</a></li>
                <li><a href="#" class="pdf"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</a></li>
                <li><a href="#" class="csv"><i class="fa fa-file-o"></i>&nbsp;CSV</a></li>
            </ul>
        </div>
    </div>

    <div class="clearfix"></div>
</form>

<script type="text/javascript">
    //#region --- PARAMS TYPE
        const NEW = 2; const BIRTHDATE = 3; const REVENUE = 4; const SERVICE = 5; const NOTE = 6; const SOURCE = 7; const DEBT = 8; const LASTTREATMENTDATE = 9;
		const AFTERTREATMENT = 10; const DONTTREATMENT = 11;const REMIND = 12;const AREA = 13;
		const REPORT_TYPE = {
			2: "new",
			3: "birthdate",
			4: 'revenue',
			5: 'service',
			6: 'note',
			7: 'source',
			8: 'debt',
			9: 'lasttreatmentdate',
			10: 'aftertreatment',
			11: 'donttreatment',
            12: 'remind',
            13: 'area'
		};
    //#endregion

    function changeBranch() {
        var dataBranch = $("#frm_search_branch").val();
        jQuery.ajax({
            type: "POST",
            url: "<?php echo CController::createUrl('reportingAppointment/ChangeBranch') ?>",
            data: {
                'dataBranch': dataBranch,
            },
            success: function(string) {
                if (string !== "") {
                    $('#lstStaff').html(string);
                }
            }
        });
    }

    function search_cus() {
        var search_type = $("#frm_search_type").val();
        var search_branch = $("#frm_search_branch").val();
        var search_time = $("#frm_search_date").val();
        var search_user = $("#frm_search_user").val();

        var fromtime = $('#fromtime').val();
        var totime = $('#totime').val();
        var datetime = $('#datetime').val();

        var group_service = $('#frm_search_nhom_dich_vu').val();
        var service = $('#frm_search_dich_vu').val();
        var source = $('#frm_search_source').val();
        var customer = $('#frm_search_customer').val();

        var country = $('#frm_search_country').val();
        var city = $('#frm_search_city').val();
        var district = $('#frm_search_district').val();

        $('.cal-loading').fadeIn('fast');

        jQuery.ajax({
            type: "POST",
            url: "<?php echo CController::createUrl('reportCustomers/typeReport') ?>",
            data: {
                'search_branch': search_branch,
                'search_type': search_type,
                'search_user': search_user,
                'search_time': search_time,
                'fromtime': fromtime,
                'totime': totime,
                'datetime': datetime,
                'group_service': group_service,
                'service': service,
                'source': source,
                'customer': customer,
                'country': country,
                'city': city,
                'district': district,
            },
            success: function(data) {
				$('.cal-loading').fadeOut('fast');

                if (data == '-1') {
                    alert('Data not found');
                } else if (data != '') {
                    $("#return_content").fadeIn("slow");
                    $("#return_content").html(data);
                } else {
                    alert('Data not found', 'Notice');
                }
            }
        });
    }

    function search_service(id) {
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('ReportCustomers/GetService') ?>",
            data: {
                id: id
            },
            success: function(data) {
                $('#service').html(data);
                $(".Service").select2({
                    placeholder: "--Chọn--",
                    allowClear: true
                });
            },
            error: function(data) {
                console.log("error");
                console.log(data);
            }
        });
    }

    function formatState(data) {
        if (!data.id) {
            return data.text;
        }

        datas = '<div class="col-xs-4">' + data.text + '</div>';
        if (moment(data.birthdate).isValid()) {
            datas = datas + '<div class="col-xs-2">' + moment(data.birthdate).format("DD/MM/YYYY") + '</div>';
        } else {
            datas += '<div class="col-xs-2"> &nbsp </div>';
        }

        datas += '<div class="col-xs-2">' + data.phone + '</div>';
        datas += '<div class="col-xs-4" style="font-size:12px; padding-right: 0;">' + data.adr + '</div>';
        datas += '<div class="clearfix"></div>';
        var $data = $(datas);
        return $data;
    };

    function customer(code_number) {
        $('.select2-search__field').val(code_number);
        $('#frm_search_customer').select2({
            language: 'vi',
            placeholder: 'Khách hàng',
            templateResult: formatState,
            width: '150px',
            dropdownCssClass: "changeW",
            allowClear: true,
            ajax: {
                dataType: "json",
                url: '<?php echo CController::createUrl('ReportCustomers/getCustomerList'); ?>',
                type: "post",
                delay: 50,
                data: function(params) {
                    if (code_number && params.term == '')
                        q = code_number;
                    else
                        q = params.term;

                    return {
                        q: q, // search term
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data,
                        pagination: {
                            more: true
                        }
                    };
                },
                cache: true,
            },
        });
    }

    $(document).ready(function() {
        $('#frm_search_type').change(function() {
			var type = $(this).val();

			$('.report-customer').hide();
			$('.report-' + REPORT_TYPE[type]).show();
        });

        $('#frm_search_date').change(function() {
            if ($(this).val() == 5) {
                $('#time').removeClass('hidden');
            } else {
                $('#time').addClass('hidden');
            }
        });

        $('.datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

        $('.datepicker').val(moment().format('YYYY-MM-DD'));

        $('#fromtime').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

        $('#totime').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

        $('#time').change(function(e) {
            fromtime = $('#fromtime').datepicker("getDate");
            totime = $('#totime').datepicker("getDate");
            if (fromtime > totime)
                $('#totime').datepicker("setDate", fromtime);
        })

        $('#oSrchBar').on('click', '.print', function(e) {
            var search_branch = $("#frm_search_branch").val();
            var search_type = $("#frm_search_type").val();
            var search_user = $("#frm_search_user").val();
            var search_time = $("#frm_search_date").val();
            var fromtime = $('#fromtime').val();
            var totime = $('#totime').val();
            var group_service = $('#frm_search_nhom_dich_vu').val();
            var service = $('#frm_search_dich_vu').val();
            var source = $('#frm_search_source').val();
            var customer = $('#frm_search_customer').val();

            var url = "<?php echo CController::createUrl('ReportCustomers/typePrint') ?>?type=" + search_type + "&branch=" + search_branch + "&lstUser=" + search_user + "&time=" + search_time + "&fromtime=" + fromtime + "&totime=" + totime + "&source=" + source + "&service=" + service + "&customer=" + customer;
            window.open(url, 'name');
        });
    });

    function showCounty(city, id, county = "0") {
        jQuery.ajax({
            type: 'POST',
            url: '/itemsCustomers/Accounts/LoadCounty',
            data: {
                "id": id,
                "city": city,
                "county": county
            },
            success: function(data) {
                $("#frm_search_district").html(data);
            },
            error: function(data) {
                console.log("error");
                console.log(data);
            },
        });
    }
</script>