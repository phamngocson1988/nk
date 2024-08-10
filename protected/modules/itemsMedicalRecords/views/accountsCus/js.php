<script>
	/*****************************/
	var baseUrl 	= '<?php echo Yii::app()->baseUrl;?>';
	var id_customer = "<?php echo $model['id']; ?>";
	var aClone   = $("#action-prescription").clone();
	var aLabClone   = $("#action-lab").clone();
	var divClone = $("#dntd").clone();
	var containerTreatmentClone = $("#containerTreatment").clone();
	var GlobalTeeth;

	$(document).click(function(e) {
		var toggle_dental = $("#toggle-dental");
		if (!toggle_dental.is(e.target) && toggle_dental.has(e.target).length === 0) {
			closeNav();
		}
	});
	function closeNav(){
		$('#toggle-dental').fadeOut('slow');
	}
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	})
	/*************Chiều cao tự động của textarea *************/
	function autoTextarea(){
		var textarea = document.querySelectorAll('.textarea');
		for (var i = 0; i < textarea.length; i++) {
			var self = textarea[i];
			self.addEventListener('keydown', autosize);
		}
	}
	function autosize(){
		var el = this;
		setTimeout(function(){
			el.style.cssText = 'height:auto; padding:10px';
			el.style.cssText = 'height:' + el.scrollHeight + 'px';
		},0);
	}
	/*************upload image film*************/
	$(function() {
		var initialPreview       = [];
		var initialPreviewConfig = [];
		var uploadUrl = '<?php echo Yii::app()->params['upload_url'];?>';
		var code_number = "<?php echo $model->code_number;?>";
		var id_customer = $('#id_customer').val();
		var id_mhg      = $('#id_mhg').val();
		$.ajax({
			type:"POST",
			url: baseUrl+'/itemsMedicalRecords/AccountsCus/view_medical_image',
			data: {"id_customer":id_customer,"id_mhg":id_mhg},
			success: function (data) {
				var getData = $.parseJSON(data);
				if(getData){
					$.each(getData, function(i, item) {
						var response = {};
						initialPreview.push(uploadUrl+"/upload/customer/dental_status/"+code_number+"/"+getData[i].name);
						response['caption'] = getData[i].name;
						response['key']     = getData[i].id;
						response['extra']   = {id: getData[i].id, name: getData[i].name, code_number: "<?php echo $model->code_number;?>", id_customer: $('#id_customer').val(), id_mhg: $("#id_mhg").val()};
						initialPreviewConfig.push(response);
					});

				}

			},
			async: false
		});


		$("#upload-film").fileinput({
			uploadUrl: baseUrl+'/itemsMedicalRecords/AccountsCus/upload',
			deleteUrl: baseUrl+'/itemsMedicalRecords/AccountsCus/fileDelete',
			uploadAsync: false,
			overwriteInitial: false,
			initialPreview: initialPreview,
	        initialPreviewAsData: true, // defaults markup
	        initialPreviewFileType: 'image', // image is the default and can be overridden in config below
	        initialPreviewConfig: initialPreviewConfig,
	        uploadExtraData: {
	        	code_number: "<?php echo $model->code_number;?>",
	        	id_customer: $('#id_customer').val(),
	        	id_mhg: $("#id_mhg").val()
	        }
	    }).on('filesorted', function(e, params) {
	    	console.log('File sorted params', params);
	    }).on('fileuploaded', function(e, params) {
	    	console.log('File uploaded params', params);
	    });

	    $('#upload-film').on('filebatchuploadsuccess', function(event, data, previewId, index) {
	    	$('#bootstrapFileinputMasterModal').modal('hide');
	    	var form = data.form, files = data.files, extra = data.extra,
	    	response = data.response, reader = data.reader;
	    	loadMedicalRecords(response.id_customer, '');

	    });

	    $("#upload-film").on("filepredelete", function(jqXHR) {
	    	var abort = true;
	    	if (confirm("Are you sure you want to delete this image?")) {
	    		abort = false;
	    	}
	    	return abort;
	    });
	});
	/*************ghi chú bảng màu*************/
	$(document).ready(function() {
		$(".note-tooth .img").hover(function(){
			$('.note-tooth .img').attr('src', '<?php echo Yii::app()->request->baseUrl ?>/images/medical_record/more_icon/note_act.png');
		},function(){
			$('.note-tooth .img').attr('src', '<?php echo Yii::app()->request->baseUrl ?>/images/medical_record/more_icon/note_def.png');
		});
		autoTextarea();
		$('.note-tooth .img').click(function(){
			$('#noteToothPopup').fadeToggle('fast');
		});
		$('#noteToothPopup #ic_close').click(function(){
			$('#noteToothPopup').hide();
		});
	});
	/*************Quá trình điều trị*************/
	$('#table_treatment').click(function(){
		$('#triangle').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top');
		$('.treatment').fadeToggle('fast');
	});
	$(".uT").click(function(e) {
		e.stopPropagation();
	})
	function detailTreatment(id){
		$('.cal-loading').fadeIn('fast');
		var id_customer = $('#id_customer').val();
		$.ajax({
			type:'POST',
			url: baseUrl+'/itemsMedicalRecords/AccountsCus/detailTreatment',
			data: {
				"id":id,
				"id_customer":id_customer
			},
			success:function(data){
				$('#tab_medical_records').html(data);
				$('.cal-loading').fadeOut('slow');
			},
			error: function(data){
				console.log("error");
				console.log(data);
			}
		});

	}
	function updateTreatment(id) {
		var check_change_status_process = $('#check_change_status_process').val();
		//if (check_change_status_process != 0) {
			$('.cal-loading').fadeIn('fast');

			var evt = window.event || arguments.callee.caller.arguments[0];
			evt.stopPropagation();

			var id_customer = $('#id_customer').val();

			$.ajax({
				type: 'POST',
				url: baseUrl + '/itemsMedicalRecords/AccountsCus/updateTreatment',
				data: {
					"id": id,
					"id_customer": id_customer
				},
				success: function (data) {

					$('#tab_medical_records').html(data);

					$('.cal-loading').fadeOut('slow');
				},
				error: function (data) {
					console.log("error");
					console.log(data);
				}
			});

		// } else {
		// 	var evt = window.event || arguments.callee.caller.arguments[0];
		// 	evt.stopPropagation();
		// 	return false;
		// }
	}
	function checkAddNewTreatment(){
		var id_mhg = $('#id_mhg').val();
		var check_add_new_treatment =  $('#check_add_new_treatment').val();
		if(id_mhg == 0 || check_add_new_treatment != 0){
			$("#add_new_treatment").attr("disabled", false);
		}else{
			$("#add_new_treatment").attr("disabled", true);
		}
	}
	$('#add_new_treatment').click(function (e) {
		var id_mhg = $('#id_mhg').val();
		var check_add_new_treatment =  $('#check_add_new_treatment').val();
		if(id_mhg == 0 || check_add_new_treatment != 0){
			$('.cal-loading').fadeIn('fast');
			var id_customer = $('#id_customer').val();
			$.ajax({
				type:'POST',
				url: baseUrl+'/itemsMedicalRecords/AccountsCus/addNewTreatment',
				data: {"id_customer":id_customer},
				success:function(data){
					$('#tab_medical_records').html(data);
					$('.cal-loading').fadeOut('slow');
				},
				error: function(data){
					console.log("error");
					console.log(data);
				}
			});

		}else{
			return false;
		}

	});
	function printTreatmentRecords(id_mhg){
		var evt         = window.event || arguments.callee.caller.arguments[0];
		var id_customer = $("#id_customer").val();
		if (id_customer && id_mhg) {
			var url="<?php echo CController::createUrl('AccountsCus/exportTreatmentRecords')?>?id_customer="+id_customer+"&id_medical_history_group="+id_mhg;
			window.open(url,'name')
		};
		evt.stopPropagation();

	}
	/*************Load thông tin bộ răng*************/
	$(document).ready(function(){
		$(".tooth").each(function() {
			if($(this).attr("data-tooth")) {

				if($(this).attr("data-tooth")=='1') {
					var src = $(this).attr("src").replace("rang", "rangbenh");
					$(this).attr("src", src);
				}
				else if($(this).attr("data-tooth")=='101') {
					var src = $(this).attr("src").replace("rang", "rangmat");
					$(this).attr("src", src);
				}
				else if($(this).attr("data-tooth")=='102') {
					var src = $(this).attr("src").replace("rang", "rangtramA");
					$(this).attr("src", src);
				}
				else if($(this).attr("data-tooth")=='103') {
					var src = $(this).attr("src").replace("rang", "ranggiacodinh");
					$(this).attr("src", src);
				}
				else if($(this).attr("data-tooth")=='104') {
					var src = $(this).attr("src").replace("rang", "vitricauranggia");
					$(this).attr("src", src);
				}
				else if($(this).attr("data-tooth")=='105') {
					var src = $(this).attr("src").replace("rang", "rangbenh");
					$(this).attr("src", src);
				}
				else if($(this).attr("data-tooth")=='106') {
					var src = $(this).attr("src").replace("rang", "rangphuchoiIMPLANT");
					$(this).attr("src", src);
				}
				else if($(this).attr("data-tooth")=='107') {
					var src = $(this).attr("src").replace("rang", "rangyeu");
					$(this).attr("src", src);
				}

			}
		});
	});
	/*************Chọn bộ răng*************/
	$(function(){
		$(".dropdown-menu li a").click(function(){
			var typeTooth = $('#typeTooth').val();
			$('#typeTooth').text($(this).text());
			$('#typeTooth').val($(this).text());

			if ($(this).text() == "RĂNG TRẺ EM" && typeTooth == "RĂNG NGƯỜI LỚN") {

				$('#universal_kid').removeClass('hide');

			}else if ($(this).text() == "RĂNG NGƯỜI LỚN" && typeTooth == "RĂNG TRẺ EM") {

				$('#universal_kid').addClass('hide');

			}

		});
	});
	/*************Kiểm tra răng trẻ em*************/
	function showUniversalKid() {
		$('#typeTooth').text('RĂNG TRẺ EM');
		$('#typeTooth').val('RĂNG TRẺ EM');
		$('#universal_kid').removeClass('hide');
	}
	function checkExistUniversalKid(){
		var numbers = [51, 52, 53, 54, 55, 61, 62, 63, 64, 65, 71, 72, 73, 74, 75, 81, 82, 83, 84, 85];
		for (var i = 0; i < numbers.length; i++) {
			if (checkSick(numbers[i]) == 1 || checkStatus(numbers[i]) == 1) {
				showUniversalKid();
				break;
			}
		}
	}
	$(document).ready(function() {
		checkExistUniversalKid();
		checkAddNewTreatment();
	});
	/*************Các hàm kiểm tra*************/
	function checkElementExist(number){
		var string = $('#hidden_string_number').val();
		var data_array = JSON.parse("[" + string + "]");

		for (var i = 0; i < data_array.length; i++) {

			if (data_array[i] == number){
				return false;
			}
		}

		return true;
	}

	function checkSick(number){
		var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];
		var types =    [6, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35];

		for (var i = 0; i < faces.length; i++) {
			for (var j = 0; j < types.length; j++) {
				if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){
					return 1;
				}
			}
		}

		return 0;

	}

	function checkStatus(number){
		var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];
		var types =    [101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117];

		for (var i = 0; i < faces.length; i++) {
			for (var j = 0; j < types.length; j++) {
				if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){
					return 1;
				}
			}
		}

		return 0;

	}

	function checkDecay(number){
		var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];
		var types = [8, 9, 10, 11, 12, 13, 14, 15, 16];

		for (var i = 0; i < faces.length; i++) {
			for (var j = 0; j < types.length; j++) {
				if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){
					return 1;
				}
			}
		}

		return 0;

	}

	function checkFractured(number){

		var faces = ['matnhai', 'matngoai', 'mattrong'];
		var types = [21, 22, 23];

		for (var i = 0; i < faces.length; i++) {
			for (var j = 0; j < types.length; j++) {
				if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){
					return 1;
				}
			}
		}

		return 0;

	}

	function checkResidualCrownRoot(type,number){

		if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){

			if ($("#matngoai-"+type+"-"+number).attr('src').indexOf('residualcrownroot') != -1 && $("#mattrong-"+type+"-"+number).attr('src').indexOf('residualcrownroot') != -1){

				return 1;
			}

			return 0;
		}

		return 0;
	}

	function checkResidualCrown(number){

		var faces = ['matngoai', 'mattrong', 'matgan', 'matxa'];
		var type  = 6;

		for (var i = 0; i < faces.length; i++) {
			if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){
				return 1;
			}
		}

		return 0;

	}

	function checkCrown(number){

		var face = 'matnhai';
		var type = 21;

		if ($("#"+face+"-"+type+"-"+number).length > 0){
			return 1;
		}

		return 0;

	}

	function checkCrownStatus(number){

		var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];
		var type  = 103;

		for (var i = 0; i < faces.length; i++) {
			if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){
				return 1;
			}
		}

		return 0;

	}

	function checkPonticStatus(number){

		var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];
		var type  = 104;

		for (var i = 0; i < faces.length; i++) {
			if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){
				return 1;
			}
		}

		return 0;

	}

	function checkResidualRootStatus(number){

		var faces = ['matngoai', 'mattrong', 'matgan', 'matxa'];
		var type  = 105;

		for (var i = 0; i < faces.length; i++) {
			if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){
				return 1;
			}
		}

		return 0;

	}

	function checkMissingStatus(number){

		var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];
		var type  = 101;

		for (var i = 0; i < faces.length; i++) {
			if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){
				return 1;
			}
		}

		return 0;

	}

	function checkImplantStatus(number){

		var faces = ['matngoai', 'mattrong', 'matgan', 'matxa'];
		var type  = 106;

		for (var i = 0; i < faces.length; i++) {
			if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){
				return 1;
			}
		}

		return 0;

	}

	function checkRoot(number){

		var faces = ['matngoai', 'mattrong'];
		var type = 22;

		for (var i = 0; i < faces.length; i++) {
			if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){
				return 1;
			}
		}

		return 0;

	}

	function checkCalculus(number){

		var faces = ['matngoai', 'mattrong', 'matgan', 'matxa'];
		var types = [24, 25, 26, 27];

		for (var i = 0; i < faces.length; i++) {
			for (var j = 0; j < types.length; j++) {
				if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){
					return 1;
				}
			}
		}

		return 0;

	}

	function checkToothache(number){

		var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];
		var types = [17, 18, 19, 20];

		for (var i = 0; i < faces.length; i++) {
			for (var j = 0; j < types.length; j++) {
				if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){
					return 1;
				}
			}
		}

		return 0;

	}

	function checkCrownRoot(number){

		var faces = ['matngoai', 'mattrong'];
		var type = 23;

		for (var i = 0; i < faces.length; i++) {
			if ($("#"+faces[i]+"-"+type+"-"+number).length > 0){
				return 1;
			}
		}

		return 0;

	}

	function checkRestorationStatus(number){

		var faces = ['matnhai', 'matngoai', 'mattrong', 'matgan', 'matxa'];
		var types = [107, 108, 109, 110, 111, 112, 113, 114, 115];

		for (var i = 0; i < faces.length; i++) {
			for (var j = 0; j < types.length; j++) {
				if ($("#"+faces[i]+"-"+types[j]+"-"+number).length > 0){
					return 1;
				}
			}
		}

		return 0;

	}

	function checkRangMocLechStatus(number){

		var face = 'matnhai';
		var type = 116;


		if ($("#"+face+"-"+type+"-"+number).length > 0){
			return 1;
		}


		return 0;

	}

	function checkRangMocNgamStatus(number){

		var face = 'matnhai';
		var type = 117;


		if ($("#"+face+"-"+type+"-"+number).length > 0){
			return 1;
		}


		return 0;

	}

	function getLastRestorationStatus(number){


		var types = [107, 108, 109, 110, 111, 112, 113, 114, 115];
		var last  = 0;
		for (var i = 0; i < types.length; i++) {
			if ($("#ketluan-"+types[i]+"-"+number).length > 0){
				last = types[i];
			}
		}

		return last;

	}

	function getLastDecay(number){

		var types = [8, 9, 10, 11, 12, 13, 14, 15, 16];
		var last  = 0;
		for (var i = 0; i < types.length; i++) {
			if ($("#ketluan-"+types[i]+"-"+number).length > 0){
				last = types[i];
			}
		}

		return last;

	}

	function getLastToothache(number){

		var types = [17, 18, 19, 20];
		var last  = 0;
		for (var i = 0; i < types.length; i++) {
			if ($("#ketluan-"+types[i]+"-"+number).length > 0){
				last = types[i];
			}
		}

		return last;

	}

	function getLastFractured(number){

		var types = [21, 22, 23];
		var last  = 0;
		for (var i = 0; i < types.length; i++) {
			if ($("#ketluan-"+types[i]+"-"+number).length > 0){
				last = types[i];
			}
		}

		return last;

	}

	function getLastCalculus(number){

		var types = [24, 25, 26, 27,38];
		var last  = 0;
		for (var i = 0; i < types.length; i++) {
			if ($("#ketluan-"+types[i]+"-"+number).length > 0){
				last = types[i];
			}
		}

		return last;

	}

	function getLastMobility(number){

		var types = [28, 29, 30];
		var last  = 0;
		for (var i = 0; i < types.length; i++) {
			if ($("#ketluan-"+types[i]+"-"+number).length > 0){
				last = types[i];
			}
		}

		return last;

	}

	function getLastPeriodontal(number){

		var types = [31, 32, 33, 34, 35];
		var last  = 0;
		for (var i = 0; i < types.length; i++) {
			if ($("#ketluan-"+types[i]+"-"+number).length > 0){
				last = types[i];
			}
		}

		return last;

	}
	function onOpacityZero() {
		$('#mat-nhai').addClass('opacity-0');
		$('#mat-ngoai').addClass('opacity-0');
		$('#mat-trong').addClass('opacity-0');
		$('#mat-gan').addClass('opacity-0');
		$('#mat-xa').addClass('opacity-0');
	}
	function offOpacityZero() {
		$('#mat-nhai').removeClass('opacity-0');
		$('#mat-ngoai').removeClass('opacity-0');
		$('#mat-trong').removeClass('opacity-0');
		$('#mat-gan').removeClass('opacity-0');
		$('#mat-xa').removeClass('opacity-0');
	}
	function onOpacityZeroType1() {
		$('#mat-ngoai').addClass('opacity-0');
		$('#mat-trong').addClass('opacity-0');
		$('#mat-gan').addClass('opacity-0');
		$('#mat-xa').addClass('opacity-0');
	}

	function unlockAll() {

		$(".restoration").each(function() {
			$(this).attr('onclick',$(this).attr("onclick")).unbind('click');
		});
		$(".decay").each(function() {
			$(this).attr('onclick',$(this).attr("onclick")).unbind('click');
		});
		$(".toothache").each(function() {
			$(this).attr('onclick',$(this).attr("onclick")).unbind('click');
		});
		$(".fractured").each(function() {
			$(this).attr('onclick',$(this).attr("onclick")).unbind('click');
		});
		$(".calculus").each(function() {
			$(this).attr('onclick',$(this).attr("onclick")).unbind('click');
		});
		$(".mobility").each(function() {
			$(this).attr('onclick',$(this).attr("onclick")).unbind('click');
		});
		$(".periodontal").each(function() {
			$(this).attr('onclick',$(this).attr("onclick")).unbind('click');
		});
		$(".rang_moc_lech").each(function() {
			$(this).attr('onclick',$(this).attr("onclick")).unbind('click');
		});
		$(".rang_moc_ngam").each(function() {
			$(this).attr('onclick',$(this).attr("onclick")).unbind('click');
		});

		$('#missing').attr('onclick',$('#missing').attr("onclick")).unbind('click');
		$('#residual_crown').attr('onclick',$('#residual_crown').attr("onclick")).unbind('click');
		$('#crown').attr('onclick',$('#crown').attr("onclick")).unbind('click');
		$('#pontic').attr('onclick',$('#pontic').attr("onclick")).unbind('click');
		$('#residual_root').attr('onclick',$('#residual_root').attr("onclick")).unbind('click');
		$('#implant').attr('onclick',$('#implant').attr("onclick")).unbind('click');
	}
	function lockOfCrown() {
		$('#missing').prop('onclick',null).off('click');
		$('#residual_crown').prop('onclick',null).off('click');
		$('.restoration').prop('onclick',null).off('click');
		$('#pontic').prop('onclick',null).off('click');
		$('#residual_root').prop('onclick',null).off('click');
		$('#implant').prop('onclick',null).off('click');
	}
	function lockOfPontic() {
		$('#missing').prop('onclick',null).off('click');
		$('#crown').prop('onclick',null).off('click');
		$('#residual_root').prop('onclick',null).off('click');
		$('#implant').prop('onclick',null).off('click');
		$('#residual_crown').prop('onclick',null).off('click');
		$('.restoration').prop('onclick',null).off('click');
		$('.decay').prop('onclick',null).off('click');
		$('.toothache').prop('onclick',null).off('click');
		$(".fractured:nth-child(2)").prop('onclick',null).off('click');
		$(".fractured:nth-child(3)").prop('onclick',null).off('click');
		$('.calculus').prop('onclick',null).off('click');
	}
	function lockOfResidualCrown() {
		$('#missing').prop('onclick',null).off('click');
		$('#crown').prop('onclick',null).off('click');
		$('#pontic').prop('onclick',null).off('click');
		$('#implant').prop('onclick',null).off('click');
		$('#residual_root').prop('onclick',null).off('click');

		$('.restoration').prop('onclick',null).off('click');
		$('.decay').prop('onclick',null).off('click');
		$(".fractured:nth-child(1)").prop('onclick',null).off('click');
		$(".fractured:nth-child(3)").prop('onclick',null).off('click');
	}
	function lockOfResidualRoot() {
		$('#missing').prop('onclick',null).off('click');
		$('#crown').prop('onclick',null).off('click');
		$('#pontic').prop('onclick',null).off('click');
		$('#implant').prop('onclick',null).off('click');
		$('#residual_crown').prop('onclick',null).off('click');

		$('.restoration').prop('onclick',null).off('click');
		$('.decay').prop('onclick',null).off('click');
		$('.fractured').prop('onclick',null).off('click');
	}
	function lockOfMissing() {
		$('.restoration').prop('onclick',null).off('click');
		$('.decay').prop('onclick',null).off('click');
		$('.toothache').prop('onclick',null).off('click');
		$('.fractured').prop('onclick',null).off('click');
		$('.calculus').prop('onclick',null).off('click');
		$('.mobility').prop('onclick',null).off('click');
		$('.periodontal').prop('onclick',null).off('click');
		$('#residual_crown').prop('onclick',null).off('click');
		$('.restoration').prop('onclick',null).off('click');
		$('#crown').prop('onclick',null).off('click');
		$('#pontic').prop('onclick',null).off('click');
		$('#residual_root').prop('onclick',null).off('click');
		$('#implant').prop('onclick',null).off('click');
	}
	function lockOfImplant() {

		$('#missing').prop('onclick',null).off('click');
		$('#crown').prop('onclick',null).off('click');
		$('#pontic').prop('onclick',null).off('click');
		$('#residual_root').prop('onclick',null).off('click');
		$('#residual_crown').prop('onclick',null).off('click');

		$('.restoration').prop('onclick',null).off('click');
		$('.decay').prop('onclick',null).off('click');
		$('.toothache').prop('onclick',null).off('click');
		$(".fractured:nth-child(2)").prop('onclick',null).off('click');
		$(".fractured:nth-child(3)").prop('onclick',null).off('click');
		$('.calculus').prop('onclick',null).off('click');
	}
	function lockOfRangMocLech() {
		$('#missing').prop('onclick',null).off('click');
		$('.restoration').prop('onclick',null).off('click');
		$('#crown').prop('onclick',null).off('click');
		$('#pontic').prop('onclick',null).off('click');
		$('#residual_root').prop('onclick',null).off('click');
		$('#implant').prop('onclick',null).off('click');
		$('.rang_moc_ngam').prop('onclick',null).off('click');
	}
	function lockOfRangMocNgam() {
		$('#missing').prop('onclick',null).off('click');
		$('.restoration').prop('onclick',null).off('click');
		$('#crown').prop('onclick',null).off('click');
		$('#pontic').prop('onclick',null).off('click');
		$('#residual_root').prop('onclick',null).off('click');
		$('#implant').prop('onclick',null).off('click');
		$('.rang_moc_lech').prop('onclick',null).off('click');
	}
	/*************click vào răng*************/
	$('.tooth').click(function (e) {
		$('#detail_tooth').removeClass('opacity-0');
		var title 	= $( this ).attr("title");
		var ret 	= title.split(" ");
		var number	 	= ret[1];
		var str_number =  $('#hidden_string_number').val();

		var rangACTIVE = $(this).attr("src").replace("/rang/", "/rangACTIVE/");
		console.log("click");
		if(e.shiftKey) {
			if(str_number){
				if(checkElementExist(number)){
					$('#hidden_string_number').val(str_number+','+number);
					$(this).attr("src", rangACTIVE);
				}
			}else{
				$('#hidden_string_number').val(str_number+number);
				$(this).attr("src", rangACTIVE);
			}
		}else{
			$('#hidden_string_number').val(number);
			$(".tooth").each(function() {
				if($(this).attr("src").indexOf("/rangACTIVE/") !== -1) {
					var rang = $(this).attr("src").replace("/rangACTIVE/", "/rang/");
					$(this).attr("src", rang);
				}
			});
			$(this).attr("src", rangACTIVE);
		}

		var src1 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai-"+number+".png";
		var src2 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matngoai-"+number+".png";
		var src3 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mattrong-"+number+".png";
		var src4 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matgan-"+number+".png";
		var src5 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matxa-"+number+".png";
		$('#tooth_title').html("- "+title+" -");
		var string = $('#hidden_string_number').val();
		$('.title_sidenav').html(string);
		var data_array = JSON.parse("[" + string + "]");

		for (var i = 0; i < data_array.length; i++) {

			var number_array = data_array[i];

			if (($("#mat_nhai_"+number_array).length > 0) && ($("#mat_ngoai_"+number_array).length > 0) && ($("#mat_trong_"+number_array).length > 0) && ($("#mat_gan_"+number_array).length > 0) && ($("#mat_xa_"+number_array).length > 0)){

			}else{
				$('#nhai').append('<div id="mat_nhai_'+number_array+'" class="mat"></div>');
				$('#ngoai').append('<div id="mat_ngoai_'+number_array+'" class="mat"></div>');
				$('#trong').append('<div id="mat_trong_'+number_array+'" class="mat"></div>');
				$('#gan').append('<div id="mat_gan_'+number_array+'" class="mat"></div>');
				$('#xa').append('<div id="mat_xa_'+number_array+'" class="mat"></div>');
			}

		}

		$('#hidden_number').val(number);
		$('#mat-nhai').attr("src", src1);
		$('#mat-ngoai').attr("src", src2);
		$('#mat-trong').attr("src", src3);
		$('#mat-gan').attr("src", src4);
		$('#mat-xa').attr("src", src5);
		$('.mat').addClass("hidden");
		$('#mat_nhai_'+number).removeClass("hidden");
		$('#mat_ngoai_'+number).removeClass("hidden");
		$('#mat_trong_'+number).removeClass("hidden");
		$('#mat_gan_'+number).removeClass("hidden");
		$('#mat_xa_'+number).removeClass("hidden");
	});

	$('.tooth').contextmenu(function(e) {
		e.preventDefault();
		$('#detail_tooth').removeClass('opacity-0');
		var title 	= $( this ).attr("title");
		var ret 	= title.split(" ");
		var number 	= ret[1];
		var str_number =  $('#hidden_string_number').val();
		var rangACTIVE = $(this).attr("src").replace("/rang/", "/rangACTIVE/");
		console.log("contextmenu");
		if(e.shiftKey) {
			if(str_number){
				if(checkElementExist(number)){
					$('#hidden_string_number').val(str_number+','+number);
					$(this).attr("src", rangACTIVE);
				}
			}else{
				$('#hidden_string_number').val(str_number+number);
				$(this).attr("src", rangACTIVE);
			}
		}else{
			$('#hidden_string_number').val(number);
			$(".tooth").each(function() {
				if($(this).attr("src").indexOf("/rangACTIVE/") !== -1) {
					var rang = $(this).attr("src").replace("/rangACTIVE/", "/rang/");
					$(this).attr("src", rang);
				}
			});
			$(this).attr("src", rangACTIVE);
		}

		var src1 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai-"+number+".png";
		var src2 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matngoai-"+number+".png";
		var src3 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mattrong-"+number+".png";
		var src4 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matgan-"+number+".png";
		var src5 = "<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matxa-"+number+".png";
		$('#tooth_title').html("- "+title+" -");
		$('#tooth_number').html("- "+title+" -");
		var string = $('#hidden_string_number').val();
		$('.title_sidenav').html(string);
		var data_array = JSON.parse("[" + string + "]");
		var number_array = string.replace(/,/g,"_");

		if (($("#mat_nhai_"+number_array).length > 0) && ($("#mat_ngoai_"+number_array).length > 0) && ($("#mat_trong_"+number_array).length > 0) && ($("#mat_gan_"+number_array).length > 0) && ($("#mat_xa_"+number_array).length > 0)){

		}else{
			$('#nhai').append('<div id="mat_nhai_'+number_array+'" class="mat"></div>');
			$('#ngoai').append('<div id="mat_ngoai_'+number_array+'" class="mat"></div>');
			$('#trong').append('<div id="mat_trong_'+number_array+'" class="mat"></div>');
			$('#gan').append('<div id="mat_gan_'+number_array+'" class="mat"></div>');
			$('#xa').append('<div id="mat_xa_'+number_array+'" class="mat"></div>');
		}
		if (($("#ket_luan_"+number_array).length > 0)  && ($("#chi_dinh_"+number_array).length > 0)){

		}else{
			$('#table_conclude').prepend('<tr>'+
				'<td  id="so_rang_'+number_array+'"  class="sorang  th1"></td>'+
				'<td  id="ket_luan_'+number_array+'" class="ketluan th2 text-left"></td> '+
				'<td  id="chi_dinh_'+number_array+'" class="chidinh th3 text-left"></td>'+
				'<td></td>'+
				'</tr>'
				);
		}


		$('#hidden_number').val(number);
		$('#mat-nhai').attr("src", src1);
		$('#mat-ngoai').attr("src", src2);
		$('#mat-trong').attr("src", src3);
		$('#mat-gan').attr("src", src4);
		$('#mat-xa').attr("src", src5);
		$('.mat').addClass("hidden");
		$('#mat_nhai_'+number).removeClass("hidden");
		$('#mat_ngoai_'+number).removeClass("hidden");
		$('#mat_trong_'+number).removeClass("hidden");
		$('#mat_gan_'+number).removeClass("hidden");
		$('#mat_xa_'+number).removeClass("hidden");
		$('#toggle-dental').fadeToggle('fast');
		unlockAll();
		offOpacityZero();
		if (checkMissingStatus(number) == 1) {
			onOpacityZero();
			lockOfMissing();
		}else if (checkCrownStatus(number) == 1) {
			lockOfCrown();
		}else if (checkPonticStatus(number) == 1) {
			onOpacityZero();
			lockOfPontic();
		}else if (checkResidualRootStatus(number) == 1) {
			onOpacityZeroType1();
			lockOfResidualRoot();
		}else if (checkImplantStatus(number) == 1) {
			onOpacityZeroType1();
			lockOfImplant();
		}else if (checkResidualCrown(number) == 1) {
			onOpacityZeroType1();
			lockOfResidualCrown();
		}else if (checkRangMocLechStatus(number) == 1) {
			lockOfRangMocLech();
		}else if (checkRangMocNgamStatus(number) == 1) {
			lockOfRangMocNgam();
		}

		if (checkCrown(number) == 1) {
			$('#mat-nhai').addClass('opacity-0');
		}else if (checkRoot(number) == 1) {
			$('#mat-ngoai').addClass('opacity-0');
			$('#mat-trong').addClass('opacity-0');
		}else if (checkCrownRoot(number) == 1) {
			$('#mat-ngoai').addClass('opacity-0');
			$('#mat-trong').addClass('opacity-0');
		}
		e.stopPropagation();
	});

$('#table_conclude').bind("DOMSubtreeModified",function(){
	$('#dental_status_change').val('1');
	$("#save").attr("disabled", false);
	$('#save').css('background', '#10b1dd');
});

$('#table_conclude textarea').click(function() {
	$('#dental_status_change').val('1');
	$("#save").attr("disabled", false);
	$('#save').css('background', '#10b1dd');
});

/*************Mặt nhai (X)*************/
function incisalUsal(status){
	var id_user = $('#id_user').val();
	var string 	= $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			if(status==1){
				var type 	= 107;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">Phục hồi miếng trám mặt nhai (X)</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt nhai (X)</span>');
					}
				}
			}else if(status ==2){
				var type 	= 8;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt nhai (X)</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt nhai (X)</span>');
					}
				}
			}
		}

	}else{
		if(status==1){
			var number = string.replace(/,/g,"_");
			var type=107;
			var flag=102;

			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
				var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){

				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangtramAval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangtramA/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth",flag).attr("src", rangtramAval);
					})

				}

				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Nhập chỉ định"></textarea>');
				autoTextarea();
			}

			if (($("#matnhai-"+type+"-"+number).length > 0)){
				$("#matnhai-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();

			}else{
				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai'+number+'-trongtrai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastRestorationStatus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt nhai (X)</span>');
				}else {
					var last = getLastRestorationStatus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt nhai (X)</span>');
				}

			}
			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#ket_luan_'+number).empty();
				$("#so_rang_"+number).empty();
				$("#chi_dinh_"+number).empty();
			}
		}else if(status==2){
			var number = string.replace(/,/g,"_");
			var type    = 8;
			var flag 	= 1;
			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}
			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if($("#matnhai-"+type+"-"+number).length > 0){
				$("#matnhai-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matnhai'+number+'-trongtrai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt nhai (X)</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt nhai (X)</span>');
				}
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}
		}
	}
}
/*************Mặt nhai G *************/
function incisalSal(status){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			if(status==1){
				var type 	= 108;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt nhai (G)</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt nhai (G)</span>');
					}
				}
			}else if(status ==2){
				var type 	= 9;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt nhai</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt nhai</span>');
					}
				}
			}
		}
	}else{
		if(status==1){

			var number = string.replace(/,/g,"_");

			var type=108;
			var flag=102;

			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
				var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangtramAval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangtramA/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth",flag).attr("src", rangtramAval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Nhập chỉ định"></textarea>');
				autoTextarea();
			}

			if (($("#matnhai-"+type+"-"+number+"").length > 0)){
				$("#matnhai-"+type+"-"+number+"").remove();
				$("#ketluan-"+type+"-"+number+"").remove();
			}
			else{
				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai'+number+'-trongtrai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				if (getLastRestorationStatus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">Phục hồi miếng trám mặt nhai (G)</span>');
				}else {
					var last = getLastRestorationStatus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">Phục hồi miếng trám mặt nhai (G)</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#ket_luan_'+number).empty();
				$("#so_rang_"+number).empty();
				$("#chi_dinh_"+number).empty();
			}
		}else if(status==2){
			var data_array = JSON.parse("[" + string + "]");
			var number = string.replace(/,/g,"_");

			var type=9;
			var flag=1;
			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}
			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					});

				}

				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matnhai-"+type+"-"+number).length > 0){
				$("#matnhai-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matnhai'+number+'-trongphai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">Sâu răng mặt nhai</span>');
				}else {
					var last = getLastDecay(number);
		            $("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">Sâu răng mặt nhai</span>');     //(G)
		        }

		    }

		    if (checkSick(number) == 0 && checkStatus(number) == 0){
		    	$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
		    	$('#so_rang_'+number).empty();
		    	$('#ket_luan_'+number).empty();
		    	$('#chi_dinh_'+number).empty();
		    }
		}
	}
}
/*************Mặt bên X *************/
function proximalD(status){

	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			if(status==1){
				var type 	= 111;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">Phục hồi miếng trám mặt bên xa</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt bên xa</span>');
					}
				}
			}else if(status ==2){
				var type 	= 12;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">Sâu răng mặt bên (X)</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt bên (X)</span>');
					}
				}
			}
		}
	}else{

		if(status==1){

			var number = string.replace(/,/g,"_");

			var type=111;
			var flag=102;

			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
				var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangtramAval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangtramA/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth",flag).attr("src", rangtramAval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Nhập chỉ định"></textarea>');
				autoTextarea();
			}

			if (($("#matngoai-"+type+"-"+number+"").length > 0) && ($("#mattrong-"+type+"-"+number+"").length > 0)){
				$("#matngoai-"+type+"-"+number+"").remove();
				$("#mattrong-"+type+"-"+number+"").remove();
				$("#ketluan-"+type+"-"+number+"").remove();
			}
			else{

				$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matngoai'+number+'-trai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mattrong'+number+'-phai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastRestorationStatus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt bên xa</span>');
				}else {
					var last = getLastRestorationStatus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt bên xa</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#ket_luan_'+number).empty();
				$("#so_rang_"+number).empty();
				$("#chi_dinh_"+number).empty();
			}

		}else if(status==2){
			var data_array = JSON.parse("[" + string + "]");
			var number = string.replace(/,/g,"_");

			var type=12;
			var flag=12;
			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}
			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{
					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})
				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){
				$("#matngoai-"+type+"-"+number).remove();
				$("#mattrong-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();

			}else{
				$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matngoai'+number+'-trai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-mattrong'+number+'-phai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt bên (X)</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt bên (X)</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}
		}
	}
}
/*************Mặt bên G*************/
function proximalM(status){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			if(status==1){
				var type 	= 112;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">Phục hồi miếng trám mặt bên gần</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt bên gần</span>');
					}
				}
			}else if(status ==2){
				var type 	= 13;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt bên (G)</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt bên (G)</span>');
					}
				}
			}
		}
	}else{
		if(status==1){
			var number = string.replace(/,/g,"_");

			var type=112;
			var flag=102;

			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
				var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangtramAval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangtramA/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth",flag).attr("src", rangtramAval);
					})

				}

				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Nhập chỉ định"></textarea>');
				autoTextarea();
			}

			if (($("#matngoai-"+type+"-"+number+"").length > 0) && ($("#mattrong-"+type+"-"+number+"").length > 0)){
				$("#matngoai-"+type+"-"+number+"").remove();
				$("#mattrong-"+type+"-"+number+"").remove();
				$("#ketluan-"+type+"-"+number+"").remove();
			}
			else{

				$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matngoai'+number+'-phai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mattrong'+number+'-trai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastRestorationStatus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt bên gần</span>');
				}else {
					var last = getLastRestorationStatus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt bên gần</span>');
				}
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#ket_luan_'+number).empty();
				$("#so_rang_"+number).empty();
				$("#chi_dinh_"+number).empty();
			}
		}
		else if(status==2){
			var number = string.replace(/,/g,"_");
			var type=13;
			var flag=1;
			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}
			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{
					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})
				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){
				$("#matngoai-"+type+"-"+number).remove();
				$("#mattrong-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();

			}else{
				$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matngoai'+number+'-phai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-mattrong'+number+'-trai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt bên (G)</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt bên (G)</span>');
				}
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}
		}
	}
}
/*************Cổ răng*************/
function abfractionV(status){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			if(status==1){
				var type 	= 113;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám cổ răng</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám cổ răng</span>');
					}
				}
			}else if(status ==2){
				var type 	= 14;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng cổ răng</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng cổ răng</span>');
					}
				}
			}
		}
	}else{
		if(status==1){
			var number = string.replace(/,/g,"_");
			var type=113;
			var flag=102;

			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
				var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangtramAval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangtramA/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth",flag).attr("src", rangtramAval);
					})

				}

				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Nhập chỉ định"></textarea>');
				autoTextarea();
			}

			if (($("#matngoai-"+type+"-"+number+"").length > 0) && ($("#mattrong-"+type+"-"+number+"").length > 0)){

				$("#matngoai-"+type+"-"+number+"").remove();
				$("#mattrong-"+type+"-"+number+"").remove();
				$("#ketluan-"+type+"-"+number+"").remove();
			}
			else{

				$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matngoai'+number+'-giua.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mattrong'+number+'-giua.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastRestorationStatus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám cổ răng</span>');
				}else {
					var last = getLastRestorationStatus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám cổ răng</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#ket_luan_'+number).empty();
				$("#so_rang_"+number).empty();
				$("#chi_dinh_"+number).empty();
			}
		}
		else if(status==2){
			var data_array = JSON.parse("[" + string + "]");
			var number = string.replace(/,/g,"_");

			var type=14;
			var flag=1;
			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
				var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");
			}
			if (checkSick(number) == 0 && checkStatus(number) == 0){

				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);
				}else{
					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth",flag).attr("src", rangbenhval);
					})
				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){
				$("#matngoai-"+type+"-"+number).remove();
				$("#mattrong-"+type+"-"+number).remove();
				$("#matgan-"+type+"-"+number).remove();
				$("#matxa-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();


			}else{
				$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matngoai'+number+'-giua.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-mattrong'+number+'-giua.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matgan'+number+'-giua.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matxa'+number+'-giua.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng cổ răng</span>');

				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng cổ răng</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}
		}
	}
}
/*************Mặt ngoài*************/
function facialBuccal(status){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			if(status==1){
				var type 	= 114;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt ngoài</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt ngoài</span>');
					}
				}
			}else if(status ==2){
				var type 	= 15;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt ngoài</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt ngoài</span>');
					}
				}
			}
			else if(status ==3){
				var type 	= 33;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt ngoài</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt ngoài</span>');
					}
				}
			}
		}
	}else{
		if(status==1){
			var number = string.replace(/,/g,"_");
			var type=114;
			var flag=102;
			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
				var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangtramAval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangtramA/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth",flag).attr("src", rangtramAval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Nhập chỉ định"></textarea>');
				autoTextarea();
			}

			if (($("#matnhai-"+type+"-"+number+"").length > 0)){
				$("#matnhai-"+type+"-"+number+"").remove();
				$("#ketluan-"+type+"-"+number+"").remove();
			}
			else{

				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai'+number+'-duoi.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastRestorationStatus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt ngoài </span>');
				}else {
					var last = getLastRestorationStatus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt ngoài </span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#ket_luan_'+number).empty();
				$("#so_rang_"+number).empty();
				$("#chi_dinh_"+number).empty();
			}
		}else if(status==2){

			var data_array = JSON.parse("[" + string + "]");
			var number = string.replace(/,/g,"_");
			var type=15;
			var flag=1;

			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){


				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{
					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenh);
					})
				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matnhai-"+type+"-"+number).length > 0){
				$("#matnhai-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();

			}else{
				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matnhai'+number+'-duoi.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt ngoài </span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt ngoài</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}



		}else if(status==3){

			var data_array = JSON.parse("[" + string + "]");
			var number = string.replace(/,/g,"_");
			var type=33;
			var flag=7;

			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{
					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenh);
					})
				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matngoai-"+type+"-"+number).length > 0){
				$("#matngoai-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();

			}else{
				$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/periodontal--'+number+'---matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');


				if (getLastPeriodontal(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt ngoài</span>');

				}else {
					var last = getLastPeriodontal(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt ngoài</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}

		}

	}
}

/*************Mặt trong*************/
function palateLingual(status){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			if(status==1){
				var type 	= 115;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt trong</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt trong</span>');
					}
				}
			}else if(status ==2){
				var type 	= 16;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt trong</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt trong</span>');
					}
				}
			}else if(status ==3){
				var type 	= 34;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt trong</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt trong</span>');
					}
				}
			}
		}
	}else{
		if(status==1){
			var number = string.replace(/,/g,"_");
			var type=115;
			var flag=102;

			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
				var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangtramAval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangtramA/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth",flag).attr("src", rangtramAval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g,","));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Nhập chỉ định"></textarea>');
				autoTextarea();
			}

			if (($("#matnhai-"+type+"-"+number+"").length > 0)){
				$("#matnhai-"+type+"-"+number+"").remove();
				$("#ketluan-"+type+"-"+number+"").remove();
			}
			else{

				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai'+number+'-tren.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastRestorationStatus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt trong</span>');
				}else {
					var last = getLastRestorationStatus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt trong</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#ket_luan_'+number).empty();
				$("#so_rang_"+number).empty();
				$("#chi_dinh_"+number).empty();
			}
		}else if(status==2){
			var number = string.replace(/,/g,"_");
			var type=16;
			var flag=1;
			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}
			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matnhai-"+type+"-"+number).length > 0){
				$("#matnhai-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matnhai'+number+'-tren.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt trong</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt trong</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}

		}else if(status==3){

			var number = string.replace(/,/g,"_");
			var type=34;
			var flag=7;
			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}
			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#mattrong-"+type+"-"+number).length > 0){
				$("#mattrong-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();

			}else{
				$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/periodontal--'+number+'---mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastPeriodontal(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt trong</span>');
				}else {
					var last = getLastPeriodontal(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt trong</span>');
				}
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}

		}

	}
}
/*************Đau răng nhạy cảm*************/
function sensitive(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 17;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng nhạy cảm</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng nhạy cảm</span>');
				}
			}

		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=17;
		var flag=2;
		if (number.indexOf("_")==-1) {
			var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
			var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
		}
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
			}else{
				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
				})

			}
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matnhai-"+type+"-"+number).length > 0){
			$("#matnhai-"+type+"-"+number).remove();
			$("#ketluan-"+type+"-"+number).remove();
		}else{
			$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/sensitive-tooth.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');


			if (getLastToothache(number) == 0) {
				$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng nhảy cảm</span>');
			}else {
				var last = getLastToothache(number);
				$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">Đau răng nhạy cảm</span>');
			}

		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#so_rang_'+number).empty();
			$('#ket_luan_'+number).empty();
			$('#chi_dinh_'+number).empty();
		}
	}

}
/*************Đau răng viêm tủy*************/
function pulpitis(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 18;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng viêm tuỷ</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng viêm tuỷ</span>');
				}
			}

		}
	}else{

		var number = string.replace(/,/g,"_");
		var type=18;
		var flag=2;
		if (number.indexOf("_")==-1) {
			var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
			var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
		}
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
			}else{
				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
				})

			}
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){
			$("#matngoai-"+type+"-"+number).remove();
			$("#mattrong-"+type+"-"+number).remove();
			$("#matgan-"+type+"-"+number).remove();
			$("#matxa-"+type+"-"+number).remove();
			$("#ketluan-"+type+"-"+number).remove();

		}else{
			$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pulpitis'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pulpitis'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pulpitis'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pulpitis'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

			if (getLastToothache(number) == 0) {
				$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng viêm tủy</span>');
			}else {
				var last = getLastToothache(number);
				$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng viêm tủy</span>');
			}

		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#so_rang_'+number).empty();
			$('#ket_luan_'+number).empty();
			$('#chi_dinh_'+number).empty();
		}

	}
}
/*************Viêm quanh chóp cấp*************/
function acutePeriapical(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 19;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng viêm quanh chóp cấp </span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng viêm quanh chóp cấp</span>');
				}
			}
		}
	}else{
		var data_array = JSON.parse("[" + string + "]");
		var number = string.replace(/,/g,"_");
		var type=19;
		var flag=2;

		if (number.indexOf("_")==-1) {
			var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
			var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
			}else{
				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
				})
			}
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){
			$("#matngoai-"+type+"-"+number).remove();
			$("#mattrong-"+type+"-"+number).remove();
			$("#matgan-"+type+"-"+number).remove();
			$("#matxa-"+type+"-"+number).remove();
			$("#ketluan-"+type+"-"+number).remove();
		}else{
			$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/acute'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/acute'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/acute'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/acute'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

			if (getLastToothache(number) == 0) {
				$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng viêm quanh chóp cấp</span>');
			}else {
				var last = getLastToothache(number);
				$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng viêm quanh chóp cấp</span>');
			}

		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#so_rang_'+number).empty();
			$('#ket_luan_'+number).empty();
			$('#chi_dinh_'+number).empty();
		}

	}
}

/*************Viêm quanh chóp mãn*************/
function chronicPeriapical(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 20;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng viêm quanh chóp mãn</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">Đau răng viêm quanh chóp mãn </span>');
				}
			}

		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=20;
		var flag=2;
		if (number.indexOf("_")==-1) {
			var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
			var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
		}
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
			}else{

				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
				})

			}
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Nhập chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){
			$("#matngoai-"+type+"-"+number).remove();
			$("#mattrong-"+type+"-"+number).remove();
			$("#matgan-"+type+"-"+number).remove();
			$("#matxa-"+type+"-"+number).remove();
			$("#ketluan-"+type+"-"+number).remove();
		}else{
			$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/chroni'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/chroni'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/chroni'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/chroni'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

			if (getLastToothache(number) == 0) {
				$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng viêm quanh chóp mãn</span>');
			}else {
				var last = getLastToothache(number);
				$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Đau răng viêm quanh chóp mãn</span>');
			}

		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#ket_luan_'+number).empty();
			$("#so_rang_"+number).empty();
			$("#chi_dinh_"+number).empty();
		}

	}
}
/*************Nứt thân răng*************/
function crown(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 21;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nứt thân răng</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nứt thân răng </span>');
				}
			}

		}
	}else{

		var number = string.replace(/,/g,"_");
		var type=21;
		var flag=3;
		if (number.indexOf("_")==-1) {
			var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
			var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
			}else{

				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
				})

			}
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Nhập chỉ định"></textarea>');
			autoTextarea();
		}

		if (($("#matnhai-"+type+"-"+number).length > 0)){
			$("#matnhai-"+type+"-"+number).remove();
			$('#mat-nhai').removeClass('opacity-0');

			if($("#matnhai-104-"+number).length > 0){
				var srcIf = $("#matnhai-104-"+number).attr("src").replace("crown", "pontic");
				$("#matnhai-104-"+number).attr("src", srcIf);
			}

			$("#ketluan-"+type+"-"+number).remove();
		}else{
			$("#matngoai-22-"+number).remove();
			$("#mattrong-22-"+number).remove();
			$("#matngoai-23-"+number).remove();
			$("#mattrong-23-"+number).remove();
			$('#mat-ngoai').removeClass('opacity-0');
			$('#mat-trong').removeClass('opacity-0');
			$('#mat-nhai').addClass('opacity-0');

			if($("#matnhai-104-"+number).length > 0){
				$('#mat-ngoai').addClass('opacity-0');
				$('#mat-trong').addClass('opacity-0');
				var srcElse = $("#matnhai-104-"+number).attr("src").replace("pontic", "crown");
				$("#matnhai-104-"+number).attr("src", srcElse);
			}
			else if($("#matngoai-106-"+number).length > 0 && $("#mattrong-106-"+number).length > 0){
				$('#mat-ngoai').addClass('opacity-0');
				$('#mat-trong').addClass('opacity-0');
			}

			$('#mat_nhai_'+number).prepend('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

			if (getLastFractured(number) == 0) {
				$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nứt thân răng</span>');
			}else {
				var last = getLastFractured(number);
				$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nứt thân răng</sapn>');
			}

			$("#ketluan-22-"+number+"").remove();
			$("#ketluan-23-"+number+"").remove();

		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#ket_luan_'+number).empty();
			$("#so_rang_"+number).empty();
			$("#chi_dinh_"+number).empty();
		}

	}
}
/*************Nứt chân răng*************/
function root(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 22;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nứt chân răng</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nứt chân răng </span>');
				}
			}

		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=22;
		var flag=3;
		if (number.indexOf("_")==-1) {
			var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
			var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
			}else{

				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
				})

			}
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Nhập chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){
			$('#mat-ngoai').removeClass('opacity-0');
			$('#mat-trong').removeClass('opacity-0');

			if ($("#matngoai-"+type+"-"+number).attr('src').indexOf('residualcrownroot') != -1 && $("#mattrong-"+type+"-"+number).attr('src').indexOf('residualcrownroot') != -1){
				$('#mat-ngoai').addClass('opacity-0');
				$('#mat-trong').addClass('opacity-0');
				$('#mat_ngoai_'+number).prepend('<img id="matngoai-6-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).prepend('<img id="mattrong-6-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			}

			$("#matngoai-"+type+"-"+number).remove();
			$("#mattrong-"+type+"-"+number).remove();
			$("#ketluan-"+type+"-"+number).remove();

		}else if(checkResidualCrownRoot(6,number) == 1){
			$("#matngoai-6-"+number).remove();
			$("#mattrong-6-"+number).remove();
			$('#mat_ngoai_'+number).prepend('<img id="matngoai-6-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_trong_'+number).prepend('<img id="mattrong-6-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$("#ketluan-"+type+"-"+number).remove();
		}else{
			$("#matnhai-21-"+number).remove();
			$("#matngoai-23-"+number).remove();
			$("#mattrong-23-"+number).remove();
			$('#mat-nhai').removeClass('opacity-0');
			$('#mat-ngoai').addClass('opacity-0');
			$('#mat-trong').addClass('opacity-0');

			if(($("#matngoai-6-"+number+"").length > 0) && ($("#mattrong-6-"+number+"").length > 0)){
				$("#matngoai-6-"+number).remove();
				$("#mattrong-6-"+number).remove();
				$('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrownroot'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrownroot'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			}else{
				$('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/root'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/root'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			}

			if (getLastFractured(number) == 0) {
				$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nứt chân răng</span>');
			}else {
				var last = getLastFractured(number);
				$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nứt chân răng</span>');
			}

			$("#ketluan-21-"+number).remove();
			$("#ketluan-23-"+number).remove();
		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#ket_luan_'+number).empty();
			$("#so_rang_"+number).empty();
			$("#chi_dinh_"+number).empty();
		}

	}
}
/*************Nứt thân- chân răng*************/
function crownRoot(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 23;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nứt thân- chân răng</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nứt thân- chân răng </span>');
				}
			}

		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=23;
		var flag=3;
		if (number.indexOf("_")==-1) {
			var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
			var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
		}


		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
			}else{

				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
				})

			}
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Nhập chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){
			$("#matngoai-"+type+"-"+number).remove();
			$("#mattrong-"+type+"-"+number).remove();
			$('#mat-ngoai').removeClass('opacity-0');
			$('#mat-trong').removeClass('opacity-0');
			$("#ketluan-"+type+"-"+number).remove();

		}else{
			$("#matnhai-21-"+number).remove();
			$("#matngoai-22-"+number).remove();
			$("#mattrong-22-"+number).remove();
			$('#mat-ngoai').addClass('opacity-0');
			$('#mat-trong').addClass('opacity-0');
			$('#mat-nhai').removeClass('opacity-0');
			$('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crownroot'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crownroot'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

			if (getLastFractured(number) == 0) {
				$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nứt thân- chân răng</span>');
			}else {
				var last = getLastFractured(number);
				$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nứt thân- chân răng</span>');
			}

			$("#ketluan-21-"+number).remove();
			$("#ketluan-22-"+number).remove();

		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#ket_luan_'+number).empty();
			$("#so_rang_"+number).empty();
			$("#chi_dinh_"+number).empty();
		}

	}
}
/*************Vôi răng, lung lay độ 1*************/
function gradeI(status){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			if(status==1){
				var type 	= 24;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 1</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 1</span>');
					}
				}
			}else if(status ==2){
				var type 	= 28;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Lung lay độ 1</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Lung lay độ 1</span>');
					}
				}
			}
		}
	}else{
		if(status==2){
			var number = string.replace(/,/g,"_");
			var type=28;
			var flag=5;
			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matnhai-"+type+"-"+number).length > 0){
				$("#matnhai-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				$("#matnhai-29-"+number).remove();
				$("#matnhai-30-"+number).remove();

				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mobility-img-grade1.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastMobility(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Lung lay độ 1</span>');
				}else {
					var last = getLastMobility(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Lung lay độ 1</span>');
				}

				$("#ketluan-29-"+number).remove();
				$("#ketluan-30-"+number).remove();

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}
		}else if(status==1){
			var number = string.replace(/,/g,"_");

			var type=24;
			var flag=4;
			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}
			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})

				}

				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){
				$("#matngoai-"+type+"-"+number).remove();
				$("#mattrong-"+type+"-"+number).remove();
				$("#matgan-"+type+"-"+number).remove();
				$("#matxa-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();

			}else{
				$("#matngoai-25-"+number).remove();
				$("#mattrong-25-"+number).remove();
				$("#matgan-25-"+number).remove();
				$("#matxa-25-"+number).remove();
				$("#matngoai-26-"+number).remove();
				$("#mattrong-26-"+number).remove();
				$("#matgan-26-"+number).remove();
				$("#matxa-26-"+number).remove();

				$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade1-'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade1-'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade1-'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade1-'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastCalculus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 1</span>');
				}else {
					var last = getLastCalculus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 1</span>');
				}

				$("#ketluan-25-"+number).remove();
				$("#ketluan-26-"+number).remove();

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}

		}
	}

}

/*************Vôi răng, lung lay độ 2*************/
function gradeII(status){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			if(status==1){
				var type 	= 25;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 2</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 2</span>');
					}
				}
			}else if(status ==2){
				var type 	= 29;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Lung lay độ 2</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Lung lay độ 2</span>');
					}
				}
			}
		}
	}else{
		var data_array = JSON.parse("[" + string + "]");
		if(status==2){
			var number = string.replace(/,/g,"_");
			var type=29;
			var flag=5;
			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}
			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matnhai-"+type+"-"+number).length > 0){
				$("#matnhai-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				$("#matnhai-28-"+number).remove();
				$("#matnhai-30-"+number).remove();

				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mobility-img-grade2.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastMobility(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Lung lay độ 2</span>');
				}else {
					var last = getLastMobility(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'">, Lung lay độ 2</span>');
				}

				$("#ketluan-28-"+number).remove();
				$("#ketluan-30-"+number).remove();

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}
		}else if(status==1){
			var number = string.replace(/,/g,"_");
			var type=25;
			var flag=4;

			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){

				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})

				}

				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number+"").length > 0 && $("#matgan-"+type+"-"+number+"").length > 0 && $("#matxa-"+type+"-"+number+"").length > 0){
				$("#matngoai-"+type+"-"+number).remove();
				$("#mattrong-"+type+"-"+number).remove();
				$("#matgan-"+type+"-"+number).remove();
				$("#matxa-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				$("#matngoai-24-"+number).remove();
				$("#mattrong-24-"+number).remove();
				$("#matgan-24-"+number).remove();
				$("#matxa-24-"+number).remove();
				$("#matngoai-26-"+number).remove();
				$("#mattrong-26-"+number).remove();
				$("#matgan-26-"+number).remove();
				$("#matxa-26-"+number).remove();

				$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade2-'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade2-'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade2-'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade2-'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastCalculus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 2</span>');
				}else {
					var last = getLastCalculus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 2</span>');
				}

				$("#ketluan-24-"+number).remove();
				$("#ketluan-26-"+number).remove();

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty(); ;
			}
		}
	}
}
/*************Vôi răng, lung lay độ 3*************/
function gradeIII(status){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			if(status==1){
				var type 	= 26;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 3</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 3</span>');
					}
				}
			}else if(status ==2){
				var type 	= 30;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Lung lay độ 3</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Lung lay độ 3</span>');
					}
				}
			}
		}
	}else{
		if(status==2){
			var number = string.replace(/,/g,"_");
			var type=30;
			var flag=5;
			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matnhai-"+type+"-"+number).length > 0){
				$("#matnhai-"+type+"-"+number).remove();

				$("#ketluan-"+type+"-"+number).remove();

				if (getLastMobility(number) == 0) {
					$("#muc-"+flag+"-"+number).remove();
				}

			}else{
				$("#matnhai-28-"+number).remove();
				$("#matnhai-29-"+number).remove();

				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/mobility-img-grade3.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastMobility(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Lung lay độ 3</span>');
				}else {
					var last = getLastMobility(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Lung lay độ 3</span>');
				}

				$("#ketluan-28-"+number).remove();
				$("#ketluan-29-"+number).remove();

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}
		}
		else if(status==1){

			var number = string.replace(/,/g,"_");
			var type=26;
			var flag=4;


			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g,","));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}

			if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){
				$("#matngoai-"+type+"-"+number).remove();
				$("#mattrong-"+type+"-"+number).remove();
				$("#matgan-"+type+"-"+number).remove();
				$("#matxa-"+type+"-"+number).remove();

				$("#ketluan-"+type+"-"+number).remove();

				if (getLastCalculus(number) == 0) {
					$("#muc-"+flag+"-"+number).remove();
				}

			}else{
				$("#matngoai-24-"+number).remove();
				$("#mattrong-24-"+number).remove();
				$("#matgan-24-"+number).remove();
				$("#matxa-24-"+number).remove();
				$("#matngoai-25-"+number).remove();
				$("#mattrong-25-"+number).remove();
				$("#matgan-25-"+number).remove();
				$("#matxa-25-"+number).remove();

				$('#mat_ngoai_'+number).append('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade3-'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).append('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade3-'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade3-'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/calculus-grade3-'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastCalculus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 3</span>');
				}else {
					var last = getLastCalculus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 3</span>');
				}

				$("#ketluan-24-"+number).remove();
				$("#ketluan-25-"+number).remove();

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}
		}
	}
}

/*************Răng bể*************/
function residualCrown(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}

			var type 	= 6;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Răng bể</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Răng bể</span>');
				}
			}

		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=6;
		if (number.indexOf("_")==-1) {
			var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
			var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
		}

		if (checkRestorationStatus(number) == 1 || checkDecay(number) == 1 || checkCrown(number) == 1 || checkCrownRoot(number) == 1){
			return false;
		}


		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
			}else{

				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
				})

			}
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0){
			unlockAll();
			offOpacityZero();
			if (checkResidualCrownRoot(type,number)){
				$('#mat-ngoai').addClass('opacity-0');
				$('#mat-trong').addClass('opacity-0');
				$('#mat_ngoai_'+number).prepend('<img id="matngoai-22-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/root'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).prepend('<img id="mattrong-22-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/root'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			}

			$("#matngoai-"+type+"-"+number).remove();
			$("#mattrong-"+type+"-"+number).remove();
			$("#matgan-"+type+"-"+number).remove();
			$("#matxa-"+type+"-"+number).remove();
			$("#ketluan-"+type+"-"+number).remove();

			if (checkResidualCrown(number) == 0) {
				$("#muc-"+flag+"-"+number).remove();
			}

		}
		else if(checkResidualCrownRoot(22,number) == 1){
			$("#matngoai-22-"+number).remove();
			$("#mattrong-22-"+number).remove();
			$("#matgan-"+type+"-"+number).remove();
			$("#matxa-"+type+"-"+number).remove();
			$('#mat-gan').removeClass('opacity-0');
			$('#mat-xa').removeClass('opacity-0');
			$('#mat_ngoai_'+number).prepend('<img id="matngoai-22-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/root'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_trong_'+number).prepend('<img id="mattrong-22-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/root'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$("#ketluan-"+type+"-"+number).remove();



		}
		else{

			if (checkRoot(number) == 1){
				$("#matngoai-22-"+number).remove();
				$("#mattrong-22-"+number).remove();
				$('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrownroot'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrownroot'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			}
			else{
				$('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
				$('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			}
			$('#mat_gan_'+number).prepend('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_xa_'+number).prepend('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualcrown'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Răng bể</spa,>');
			lockOfResidualCrown();
			onOpacityZeroType1();
		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#so_rang_'+number).empty();
			$('#ket_luan_'+number).empty();
			$('#chi_dinh_'+number).empty();
		}
	}
}
/*************Mặt gần*************/
function mesial(status){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			if(status==1){
				var type 	= 110;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt gần</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt gần</span>');
					}
				}
			}else if(status ==2){
				var type 	= 11;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt gần</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt gần</span>');
					}
				}
			}else if(status ==3){
				var type 	= 31;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt gần</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt gần</span>');
					}
				}
			}
		}
	}else{
		if(status==1){
			var number = string.replace(/,/g,"_");
			var type=110;
			var flag=102;

			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
				var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangtramAval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangtramA/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth",flag).attr("src", rangtramAval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if (($("#matnhai-"+type+"-"+number+"").length > 0)){

				$("#matnhai-"+type+"-"+number+"").remove();

				$("#ketluan-"+type+"-"+number+"").remove();

				if (getLastRestorationStatus(number) == 0) {
					$("#muc-"+flag+"-"+number).remove();
				}

			}
			else{

				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai'+number+'-phai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastRestorationStatus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt gần</span>');
				}else {
					var last = getLastRestorationStatus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt gần</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}
		}else if(status==3){

			var number = string.replace(/,/g,"_");
			var type=11;
			var flag=1;
			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}
			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matnhai-"+type+"-"+number).length > 0){
				$("#matnhai-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();

				if (getLastDecay(number) == 0) {
					$("#muc-"+flag+"-"+number).remove();
				}

			}else{
				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matnhai'+number+'-phai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt gần</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt gần</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}

		}else if(status==2){

			for (var i = 0; i < data_array.length; i++) {
				var number = data_array[i];
				var type=31;
				var flag=7;
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

				if (checkSick(number) == 0 && checkStatus(number) == 0){
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
					if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
					if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
					if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
					$('#so_rang_'+number).append(number);
					$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
					autoTextarea();
				}

				if ($("#matgan-"+type+"-"+number).length > 0){
					$("#matgan-"+type+"-"+number).remove();
					$("#ketluan-"+type+"-"+number).remove();

					if (getLastPeriodontal(number) == 0) {
						$("#muc-"+flag+"-"+number).remove();
					}

				}else{
					$('#mat_gan_'+number).append('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/periodontal--'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');


					if (getLastPeriodontal(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt gần</span>');
					}else {
						var last = getLastPeriodontal(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt gần</span>');
					}

				}

				if (checkSick(number) == 0 && checkStatus(number) == 0){
					$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
					$('#so_rang_'+number).empty();
					$('#ket_luan_'+number).empty();
					$('#chi_dinh_'+number).empty();
				}

			}
		}
	}
}

/*************Mặt xa*************/
function distal(status){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			if(status==1){
				var type 	= 109;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt xa</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt xa</span>');
					}
				}
			}else if(status ==2){
				var type 	= 10;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt xa</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Sâu răng mặt xa</span>');
					}
				}
			}else if(status ==3){
				var type 	= 7;
				if ($("#ketluan-"+type+"-"+number).length > 0){
					$("#ketluan-"+type+"-"+number).remove();
				}else{
					if (getLastDecay(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt xa</span>');
					}else {
						var last = getLastDecay(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt xa</span>');
					}
				}
			}
		}
	}else{
		if(status==1){
			var number = string.replace(/,/g,"_");
			var type=109;
			var flag=102;

			if (number.indexOf("_")==-1) {
				var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangtramA/", "/rangACTIVE/");
				var rangtramA = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangtramA/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth",flag).attr("src", rangtramA);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangtramAval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangtramA/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth",flag).attr("src", rangtramAval);
					})

				}

				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();

				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));

				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if (($("#matnhai-"+type+"-"+number+"").length > 0)){

				$("#matnhai-"+type+"-"+number+"").remove();

				$("#ketluan-"+type+"-"+number+"").remove();

				if (getLastRestorationStatus(number) == 0) {
					$("#muc-"+flag+"-"+number).remove();
				}

			}
			else{

				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/matnhai'+number+'-trai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastRestorationStatus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt xa</span>');
				}else {
					var last = getLastRestorationStatus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Phục hồi miếng trám mặt xa</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}
		}else if(status==3){

			var number = string.replace(/,/g,"_");
			var type=10;
			var flag=1;
			if (number.indexOf("_")==-1) {
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				if (number.indexOf("_")==-1) {
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
				}else{

					var arrayNumber = number.split("_");
					$.each(arrayNumber,function(i,val){
						console.log(val);
						var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
						$('#rang-nguoi-lon-'+val).attr("data-tooth","1").attr("src", rangbenhval);
					})

				}
				if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
				if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
				if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
				$('#so_rang_'+number).append(number.replace(/_/g," "));
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
				autoTextarea();
			}

			if ($("#matnhai-"+type+"-"+number).length > 0){
				$("#matnhai-"+type+"-"+number).remove();
				$("#ketluan-"+type+"-"+number).remove();

				if (getLastDecay(number) == 0) {
					$("#muc-"+flag+"-"+number).remove();
				}

			}else{
				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/decay-matnhai'+number+'-trai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt xa</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt xa</span>');
				}

			}

			if (checkSick(number) == 0 && checkStatus(number) == 0){
				$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
				$('#so_rang_'+number).empty();
				$('#ket_luan_'+number).empty();
				$('#chi_dinh_'+number).empty();
			}

		}else if(status==2){

			for (var i = 0; i < data_array.length; i++) {
				var number = data_array[i];
				var flag=7;
				var type=32;
				var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");

				if (checkSick(number) == 0 && checkStatus(number) == 0){
					$('#rang-nguoi-lon-'+number).attr("data-tooth","1").attr("src", rangbenh);
					if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
					if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
					if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
					$('#so_rang_'+number).append(number);
					$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
					autoTextarea();
				}

				if ($("#matxa-"+type+"-"+number).length > 0){
					$("#matxa-"+type+"-"+number).remove();
					$("#ketluan-"+type+"-"+number).remove();

					if (getLastPeriodontal(number) == 0) {
						$("#muc-"+flag+"-"+number).remove();
					}

				}else{
					$('#mat_xa_'+number).append('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/periodontal-'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');


					if (getLastPeriodontal(number) == 0) {
						$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt xa</span>');
					}else {
						var last = getLastPeriodontal(number);
						$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Túi nha chu mặt xa</span>');
					}

				}

				if (checkSick(number) == 0 && checkStatus(number) == 0){
					$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
					$('#so_rang_'+number).empty();
					$('#ket_luan_'+number).empty();
					$('#chi_dinh_'+number).empty();
				}

			}

		}
	}
}
/*************Răng mất*************/
function missingStatus(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 101;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Răng mất</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Răng mất</span>');
				}
			}
		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=101;
		if (number.indexOf("_")==-1) {
			var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangmat/", "/rangACTIVE/");
			var rangmat  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangmat/");
		}

		if (checkSick(number) == 1 || checkRestorationStatus(number) == 1){
			return false;
		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth",type).attr("src", rangmat);
			}else{

				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangmatval  = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangmat/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth",type).attr("src", rangmatval);
				})

			}
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Răng mất</span>');
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matnhai-"+type+"-"+number).length > 0 && $("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){
			unlockAll();
			offOpacityZero();
			$("#matnhai-"+type+"-"+number).remove();
			$("#matngoai-"+type+"-"+number).remove();
			$("#mattrong-"+type+"-"+number).remove();
			$("#matgan-"+type+"-"+number).remove();
			$("#matxa-"+type+"-"+number).remove();

		}else{
			lockOfMissing();
			onOpacityZero();
			$('#mat_nhai_'+number).prepend('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/missing'+number+'-matnhai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/missing'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/missing'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_gan_'+number).prepend('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/missing'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_xa_'+number).prepend('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/missing'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#so_rang_'+number).empty();
			$('#ket_luan_'+number).empty();
			$('#chi_dinh_'+number).empty();
		}

	}
}
/*************Mão*************/
function crownStatus(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 103;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Mão</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Mão</span>');
				}
			}

		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=103;

		if (number.indexOf("_")==-1) {
			var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/ranggiacodinh/", "/rangACTIVE/");
			var ranggiacodinh  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/ranggiacodinh/");
		}
		if (checkRestorationStatus(number) == 1){
			return false;
		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth",type).attr("src", ranggiacodinh);
			}else{

				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangmatval  = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangmat/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth",type).attr("src", rangmatval);
					var ranggiacodinhval  = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/ranggiacodinh/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth",type).attr("src", ranggiacodinhval);
				})

			}

			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matnhai-"+type+"-"+number).length > 0 && $("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){
			unlockAll();

			$("#matnhai-"+type+"-"+number).remove();
			$("#matngoai-"+type+"-"+number).remove();
			$("#mattrong-"+type+"-"+number).remove();
			$("#matgan-"+type+"-"+number).remove();
			$("#matxa-"+type+"-"+number).remove();

			$("#ketluan-"+type+"-"+number).remove();

		}else{
			lockOfCrown();

			if(checkCrown(number) == 1){
				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-matnhai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			}
			else{
				$('#mat_nhai_'+number).prepend('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-matnhai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			}

			$('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_gan_'+number).prepend('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_xa_'+number).prepend('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

			$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Mão</span>');
		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#so_rang_'+number).empty();
			$('#ket_luan_'+number).empty();
			$('#chi_dinh_'+number).empty();
		}
	}
}
/*************Nhịp cầu*************/
function ponticStatus(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 104;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nhịp cầu</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nhịp cầu</span>');
				}
			}

		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=104;
		if (number.indexOf("_")==-1) {
			var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/vitricauranggia/", "/rangACTIVE/");
			var vitricauranggia  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/vitricauranggia/");
		}

		if (checkRestorationStatus(number) == 1 || checkDecay(number) == 1 || checkToothache(number) == 1 || checkRoot(number) == 1 || checkCrownRoot(number) == 1 || checkCalculus(number) == 1){
			return false;
		}


		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth",type).attr("src", vitricauranggia);
			}else{

				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var vitricauranggiaval  = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/vitricauranggia/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth",type).attr("src", vitricauranggiaval);
				})

			}
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matnhai-"+type+"-"+number).length > 0 && $("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){
			unlockAll();
			offOpacityZero();

			if(checkCrown(number) == 1){
				$('#mat-nhai').addClass('opacity-0');
			}

			$("#matnhai-"+type+"-"+number).remove();
			$("#matngoai-"+type+"-"+number).remove();
			$("#mattrong-"+type+"-"+number).remove();
			$("#matgan-"+type+"-"+number).remove();
			$("#matxa-"+type+"-"+number).remove();

			$("#ketluan-"+type+"-"+number).remove();

		}else{
			lockOfPontic();
			onOpacityZero();

			if(checkCrown(number) == 1){
				$('#mat_nhai_'+number).append('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/crown'+number+'-matnhai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			}
			else{
				$('#mat_nhai_'+number).prepend('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pontic'+number+'-matnhai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			}
			$('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pontic'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pontic'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_gan_'+number).prepend('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pontic'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_xa_'+number).prepend('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/pontic'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

			$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Nhịp cầu</span>');
		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#so_rang_'+number).empty();
			$('#ket_luan_'+number).empty();
			$('#chi_dinh_'+number).empty();
		}

	}
}
/*************Còn chân răng *************/
function residualRootStatus(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 105;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Còn chân răng</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Còn chân răng</span>');
				}
			}
		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=105;
		if (number.indexOf("_")==-1) {
			var rangACTIVE     = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangbenh/", "/rangACTIVE/");
			var rangbenh = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangbenh/");
		}

		if (checkRestorationStatus(number) == 1 || checkDecay(number) == 1 || checkFractured(number) == 1){
			return false;
		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth",type).attr("src", rangbenh);
			}else{

				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangbenhval = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangbenh/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth",type).attr("src", rangbenhval);
				})

			}
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){
			unlockAll();
			offOpacityZero();


			$("#matngoai-"+type+"-"+number).remove();
			$("#mattrong-"+type+"-"+number).remove();
			$("#matgan-"+type+"-"+number).remove();
			$("#matxa-"+type+"-"+number).remove();

			$("#ketluan-"+type+"-"+number).remove();

		}else{
			lockOfResidualRoot();
			onOpacityZeroType1();

			$('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualroot'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualroot'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_gan_'+number).prepend('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualroot'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_xa_'+number).prepend('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/residualroot'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

			$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Còn chân răng</span>');

		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#so_rang_'+number).empty();
			$('#ket_luan_'+number).empty();
			$('#chi_dinh_'+number).empty();
		}
	}
}
/*************Implant*************/
function implantStatus(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 106;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Implant</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Implant</span>');
				}
			}
		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=106;
		if (number.indexOf("_")==-1) {
			var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangphuchoiIMPLANT/", "/rangACTIVE/");
			var rangphuchoiIMPLANT  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangphuchoiIMPLANT/");
		}

		if (checkRestorationStatus(number) == 1 || checkDecay(number) == 1 || checkToothache(number) == 1 || checkRoot(number) == 1 || checkCrownRoot(number) == 1 || checkCalculus(number) == 1 || number == 18 || number == 28 || number == 38 || number == 48){
			return false;
		}


		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth",type).attr("src", rangphuchoiIMPLANT);
			}else{

				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangphuchoiIMPLANT  = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangphuchoiIMPLANT/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth",type).attr("src", rangphuchoiIMPLANT);
				})

			}
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matngoai-"+type+"-"+number).length > 0 && $("#mattrong-"+type+"-"+number).length > 0 && $("#matgan-"+type+"-"+number).length > 0 && $("#matxa-"+type+"-"+number).length > 0){
			unlockAll();
			offOpacityZero();


			if (checkCrown(number) == 1){
				$('#mat-nhai').addClass('opacity-0');
			}


			$("#matngoai-"+type+"-"+number).remove();
			$("#mattrong-"+type+"-"+number).remove();
			$("#matgan-"+type+"-"+number).remove();
			$("#matxa-"+type+"-"+number).remove();

			$("#ketluan-"+type+"-"+number).remove();

		}else{
			lockOfImplant();
			onOpacityZeroType1();


			if (checkCrown(number) == 1){
				$('#mat-nhai').addClass('opacity-0');
			}

			$('#mat_ngoai_'+number).prepend('<img id="matngoai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/implant'+number+'-matngoai.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_trong_'+number).prepend('<img id="mattrong-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/implant'+number+'-mattrong.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_gan_'+number).prepend('<img id="matgan-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/implant'+number+'-matgan.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');
			$('#mat_xa_'+number).prepend('<img id="matxa-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/implant'+number+'-matxa.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

			$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Implant</span>');

		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#so_rang_'+number).empty();
			$('#ket_luan_'+number).empty();
			$('#chi_dinh_'+number).empty();
		}
	}
}
/*************răng mọc lệch*************/
function rangMocLech(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 106;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Răng mọc lệch</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Răng mọc lệch</span>');
				}
			}

		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=116;
		if (number.indexOf("_")==-1) {
			var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangyeu/", "/rangACTIVE/");
			var rangyeu  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangyeu/");
		}
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth",107).attr("src", rangyeu);
			}else{

				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangyeu  = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangyeu/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth",107).attr("src", rangyeu);
				})

			}

			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matnhai-"+type+"-"+number).length > 0){
			unlockAll();

			$("#matnhai-"+type+"-"+number).remove();

			$("#ketluan-"+type+"-"+number).remove();

		}else{
			lockOfRangMocLech();

			$('#mat_nhai_'+number).prepend('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/transparent.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

			$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Răng mọc lệch</span>');

		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#so_rang_'+number).empty();
			$('#ket_luan_'+number).empty();
			$('#chi_dinh_'+number).empty();
		}
	}
}
/*************răng mọc ngầm*************/
function rangMocNgam(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}
			var type 	= 117;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastDecay(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Răng mọc ngầm</span>');
				}else {
					var last = getLastDecay(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Răng mọc ngầm</span>');
				}
			}

		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=117;
		if (number.indexOf("_")==-1) {
			var rangACTIVE = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangyeu/", "/rangACTIVE/");
			var rangyeu  = $('#rang-nguoi-lon-'+number).attr("src").replace("/rangACTIVE/", "/rangyeu/");
		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if (number.indexOf("_")==-1) {
				$('#rang-nguoi-lon-'+number).attr("data-tooth",107).attr("src", rangyeu);
			}else{

				var arrayNumber = number.split("_");
				$.each(arrayNumber,function(i,val){
					console.log(val);
					var rangyeu  = $('#rang-nguoi-lon-'+val).attr("src").replace("/rangACTIVE/", "/rangyeu/");
					$('#rang-nguoi-lon-'+val).attr("data-tooth",107).attr("src", rangyeu);
				})

			}

			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			autoTextarea();
		}

		if ($("#matnhai-"+type+"-"+number).length > 0){
			unlockAll();

			$("#matnhai-"+type+"-"+number).remove();

			$("#ketluan-"+type+"-"+number).remove();

		}else{
			lockOfRangMocNgam();

			$('#mat_nhai_'+number).prepend('<img id="matnhai-'+type+'-'+number+'" src="<?php echo Yii::app()->params['image_url']; ?>/images/medical_record/images/rang-nguoi-lon/transparent.png" style="position: absolute;top: 0;left: 0;width:100%;height: auto;">');

			$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Răng mọc ngầm</span>');

		}

		if (checkSick(number) == 0 && checkStatus(number) == 0){

			$('#rang-nguoi-lon-'+number).removeAttr("data-tooth").attr("src", rangACTIVE);
			$('#so_rang_'+number).empty();
			$('#ket_luan_'+number).empty();
			$('#chi_dinh_'+number).empty();
		}
	}
}
/*************Bệnh, tình trạng khác*************/
function toothOther(){
	$('#otherModal').modal('show');
	$("#toggle-dental").hide();
}

function saveToothOther(){
	$('#otherModal').modal('hide');
	autoTextarea();
	var type= 1;
	var ketluan 	= $('#sick_other').val();
	var chidinh 	= $('#assign_other').val();
	var id_user 	= $('#id_user').val();
	var string 		= $('#hidden_string_number').val();

	var number = string.replace(/,/g,"_");

	if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
	$('#so_rang_'+number).append(number.replace(/_/g," "));
	$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> '+ketluan+'</span>');
	if ($("#chi_dinh_"+number + ' textarea').length > 0){
		$('#chi_dinh_'+number+ ' textarea').append(' '+chidinh);
	}else{
		$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"> '+ chidinh+'</textarea>');
	}

	$('#sick_other').val("");
	$('#assign_other').val("");
}
/*************Bệnh, tình trạng khác 2*************/
// $('#frm-other-btt').submit(function(e) {
// 	e.preventDefault();
// 	var id_user 	= $('#id_user').val();
// 	var sorang 		= $('#frm-other-btt').find('input[name="tooth_number"]').val();
// 	var ketluan 	= $('#frm-other-btt').find('input[name="sick_other"]').val();
// 	var chidinh 	= $('#frm-other-btt').find('textarea[name="assign_other"]').val();
// 	var type 		= 1;
// 	if (($("#ket_luan_"+sorang).length > 0)  && ($("#chi_dinh_"+sorang).length > 0)){
// 	}else{
// 		$('#table_conclude').prepend('<tr>'+
// 			'<td id="so_rang_'+sorang+'"  class="th1 sorang"></td>'+
// 			'<td id="ket_luan_'+sorang+'" class="th2 ketluan text-left"></td> '+
// 			'<td id="chi_dinh_'+sorang+'" class="th3 chidinh text-left"></td>'+
// 			'</tr>'
// 			);
// 	}
// 	if(!$("#so_rang_"+sorang).is(':empty')) $("#so_rang_"+sorang).empty();
// 	$('#so_rang_'+sorang).append(sorang);
// 	$('#ket_luan_'+sorang).append('<span id="ketluan-'+type+'-'+sorang+'" data-user="'+id_user+'"> '+ketluan+'</span>');
// 	if ($("#chi_dinh_"+sorang + ' textarea').length > 0){
// 		$('#chi_dinh_'+sorang+ ' textarea').append(' '+chidinh);
// 		autoTextarea();
// 	}else{
// 		$('#chi_dinh_'+sorang).append('<textarea rows="1" placeholder="Thêm chỉ định"> '+ chidinh+'</textarea>');
// 		autoTextarea();
// 	}
// 	$('#otherModal2').modal('hide');
// });
$('#frm-other-btt').submit(function(e) {
	e.preventDefault();

	var id_user 	= $('#id_user').val();
	var sorang 		= $('#frm-other-btt').find('input[name="tooth_number"]').val().replace(/,/g,"_");
	var ketluan 	= $('#frm-other-btt').find('input[name="sick_other"]').val();
	var chidinh 	= $('#frm-other-btt').find('textarea[name="assign_other"]').val();
	var type 		= 1;

	if (($("#ket_luan_"+sorang).length > 0)  && ($("#chi_dinh_"+sorang).length > 0)){
	}else{
		$('#table_conclude').prepend('<tr>'+
			'<td id="so_rang_'+sorang+'"  class="th1 sorang"></td>'+
			'<td id="ket_luan_'+sorang+'" class="th2 ketluan text-left"></td> '+
			'<td id="chi_dinh_'+sorang+'" class="th3 chidinh text-left"></td>'+
			'<td></td>'+
			'</tr>'
			);
	}

	if(!$("#so_rang_"+sorang).is(':empty')) $("#so_rang_"+sorang).empty();
	$('#so_rang_'+sorang).append(sorang.replace(/_/g," "));
	$('#ket_luan_'+sorang).append('<span id="ketluan-'+type+'-'+sorang+'" data-user="'+id_user+'"> '+ketluan+'</span>');
	if ($("#chi_dinh_"+sorang + ' textarea').length > 0){
		$('#chi_dinh_'+sorang+ ' textarea').append(' '+chidinh);
		autoTextarea();
	}else{
		$('#chi_dinh_'+sorang).append('<textarea rows="1" placeholder="Thêm chỉ định"> '+ chidinh+'</textarea>');
		autoTextarea();
	}
	$('#otherModal2').modal('hide');
});
$('#otherModal2').on('hidden.bs.modal', function () {
	$('#frm-other-btt')[0].reset();
})
/*************Nhập lại*************/
function retype() {
	var number = $('#hidden_number').val();
	offOpacityZero();

	if(($("#mat_nhai_"+number).length > 0)){
		$("#mat_nhai_"+number).empty();
	}
	if(($("#mat_ngoai_"+number).length > 0)){
		$("#mat_ngoai_"+number).empty();
	}
	if(($("#mat_trong_"+number).length > 0)){
		$("#mat_trong_"+number).empty();
	}
	if(($("#mat_gan_"+number).length > 0)){
		$("#mat_gan_"+number).empty();
	}
	if(($("#mat_xa_"+number).length > 0)){
		$("#mat_xa_"+number).empty();
	}
	if(($("#so_rang_"+number).length > 0)){
		$("#so_rang_"+number).empty();
	}
	if(($("#ket_luan_"+number).length > 0)){
		$("#ket_luan_"+number).empty();
	}

	if(($("#chi_dinh_"+number).length > 0)){
		$('#chi_dinh_'+number).data("assign","").empty();
	}

	$(".tooth").each(function() {
		if(this.title == "RĂNG "+number+"") {

			if($(this).attr("data-tooth")=='1') {
				var src = $(this).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				$(this).attr("src", src);
			}
			else if($(this).attr("data-tooth")=='101') {
				var src = $(this).attr("src").replace("/rangmat/", "/rangACTIVE/");
				$(this).attr("src", src);
			}
			else if($(this).attr("data-tooth")=='102') {
				var src = $(this).attr("src").replace("/rangtramA/", "/rangACTIVE/");
				$(this).attr("src", src);
			}
			else if($(this).attr("data-tooth")=='103') {
				var src = $(this).attr("src").replace("/ranggiacodinh/", "/rangACTIVE/");
				$(this).attr("src", src);
			}
			else if($(this).attr("data-tooth")=='104') {
				var src = $(this).attr("src").replace("/vitricauranggia/", "/rangACTIVE/");
				$(this).attr("src", src);
			}
			else if($(this).attr("data-tooth")=='105') {
				var src = $(this).attr("src").replace("/rangbenh/", "/rangACTIVE/");
				$(this).attr("src", src);
			}
			else if($(this).attr("data-tooth")=='106') {
				var src = $(this).attr("src").replace("/rangphuchoiIMPLANT/", "/rangACTIVE/");
				$(this).attr("src", src);
			}
			else if($(this).attr("data-tooth")=='107') {
				var src = $(this).attr("src").replace("/rangyeu/", "/rangACTIVE/");
				$(this).attr("src", src);
			}

			$(this).removeAttr("data-tooth");

		}
	});

	$("#toggle-dental").hide();

}
/*************Button 2 hàm*************/
$('#tooth_2h').contextmenu(function(e) {
	e.preventDefault();
	$('#toggle-dental').fadeToggle('fast');
	$('#hidden_string_number').val('2H');
	$('#hidden_number').val('2H');
	$('#tooth_number').html('2H');
	var number_array = '2H';
	if (($("#ket_luan_"+number_array).length > 0)  && ($("#chi_dinh_"+number_array).length > 0)){
	}else{
		$('#table_conclude').prepend('<tr>'+
			'<td id="so_rang_'+number_array+'"  class="th1 sorang"></td>'+
			'<td id="ket_luan_'+number_array+'" class="th2 ketluan text-left"></td> '+
			'<td id="chi_dinh_'+number_array+'" class="th3 chidinh text-left"></td>'+
			'<td></td>'+
			'</tr>'
			);
	}
})
/*************Vôi răng cấp 4 type=38 *************/
function gradeIV(){
	var id_user = $('#id_user').val();
	var string = $('#hidden_string_number').val();
	if(string == '2H'){
		var number =  string ;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			$('#so_rang_'+number).append(number);
			if ($("#chi_dinh_"+number + " textarea").length > 0){
			}else{
				$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			}

			var type 	= 38;
			if ($("#ketluan-"+type+"-"+number).length > 0){
				$("#ketluan-"+type+"-"+number).remove();
			}else{
				if (getLastCalculus(number) == 0) {
					$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 4</span>');
				}else {
					var last = getLastCalculus(number);
					$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 4</span>');
				}
			}
		}
	}else{
		var number = string.replace(/,/g,"_");
		var type=38;
		if (checkSick(number) == 0 && checkStatus(number) == 0){
			if(!$("#so_rang_"+number).is(':empty')) $("#so_rang_"+number).empty();
			if(!$("#ket_luan_"+number).is(':empty')) $("#ket_luan_"+number).empty();
			if(!$("#chi_dinh_"+number).is(':empty')) $("#chi_dinh_"+number).empty();
			$('#so_rang_'+number).append(number.replace(/_/g," "));
			$('#chi_dinh_'+number).append('<textarea rows="1" placeholder="Thêm chỉ định"></textarea>');
			autoTextarea();
		}
		if ($("#ketluan-"+type+"-"+number).length > 0){
			$("#ketluan-"+type+"-"+number).remove();
		}else{
			$("#matngoai-25-"+number).remove();
			$("#mattrong-25-"+number).remove();
			$("#matgan-25-"+number).remove();
			$("#matxa-25-"+number).remove();
			$("#matngoai-26-"+number).remove();
			$("#mattrong-26-"+number).remove();
			$("#matgan-26-"+number).remove();
			$("#matxa-26-"+number).remove();

			if (getLastCalculus(number) == 0) {
				$('#ket_luan_'+number).append('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 4</span>');
			}else {
				var last = getLastCalculus(number);
				$("#ketluan-"+last+"-"+number).after('<span id="ketluan-'+type+'-'+number+'" data-user="'+id_user+'"> Vôi răng độ 4</span>');
			}

			$("#ketluan-25-"+number).remove();
			$("#ketluan-26-"+number).remove();
		}

	}
}


/*************Chụp hình bộ răng*************/
function saveDentalStatusImage(){
	html2canvas($("#dental_status_img"), {
		onrendered: function(canvas) {
			var img 		= canvas.toDataURL("image/png");
			var output 		= encodeURIComponent(img);
			var id_mhg 		= $('#id_mhg').val();
			var code_number = '<?php echo $model->code_number;?>';
			var Parameters 	= "image=" + output + "&code_number=" +code_number+ "&id_mhg=" + id_mhg;

			$.ajax({
				type: "POST",
				url: baseUrl+'/itemsMedicalRecords/AccountsCus/saveDentalStatusImage',
				data: Parameters,
				success : function(data)
				{
					console.log("screenshot done");
				}
			});

		},

	});
}
/*************Lưu bệnh trên răng*************/
$('#save').click(function (e) {
	var dental_status_change = $('#dental_status_change').val();

	if (dental_status_change == 1) {
		$('.cal-loading').fadeIn('fast');

		var id_customer    		= $('#id_customer').val();
		var id_mhg         		= $('#id_mhg').val();
		var tooth_data     		= [];
		var tooth_image    		= [];
		var tooth_conclude 		= [];
		var assign_tooth 	= [];
		var cd ='';
		var dg ='';

		$(".tooth").each(function() {
			if($(this).attr("data-tooth")) {
				var title  = $(this).attr("title");
				var ret    = title.split(" ");
				var number = ret[1];
				var response = {};
				response['tooth_number'] = number;
				response['tooth_data'] = $(this).attr("data-tooth");
				tooth_data.push(response);
			}

			if($(this).attr("src").indexOf("/rangACTIVE/") !== -1) {
				var rang = $(this).attr("src").replace("/rangACTIVE/", "/rang/");
				$(this).attr("src", rang);
			}
		});

		$(".mat img").each(function() {
			var tit=$(this).attr("id");
			var re = tit.split("-");
			var num = re[2];
			var res = {};
			res['tooth_number'] = num;
			res['id_image']     = tit;
			res['src_image']    = $(this).attr("src").replace(/^.*[\\\/]/, '');
			res['type_image']   = re[0];
			res['style_image']  = $(this).attr("style");
			tooth_image.push(res);
		});

		$(".ketluan span").each(function() {
			if($(this).attr("id")) {
				var id_i = $(this).attr("id");
				var r_i = id_i.split("-");
					
				if (r_i[0] == "ketluan") {
					var rp_i = {};
					rp_i['tooth_number'] = r_i[2];
					rp_i['id_i'] = id_i;
					rp_i['conclude'] = $(this).html();
					rp_i['id_user'] = $(this).attr("data-user");
					tooth_conclude.push(rp_i);
				}
			}
		});

		

		$(".chidinh").each(function() {
			if($(this).attr("id")) {
				var id 		= $(this).attr("id");
				var r 		= id.substring(9,id.length);
				var cd 		= $("#chi_dinh_"+r).find("textarea").val();
				if(cd != undefined){
					var arr_new 			= {};
					arr_new['tooth_number'] = r;
					arr_new['assign']  	= cd;
					assign_tooth.push(arr_new);
				}
			}

		});
		
		// console.log(tooth_image," tooth_image");
		// console.log(tooth_conclude," tooth_conclude");
		// console.log(assign_tooth," assign_tooth");
	
		saveDentalStatusImage();
		$.ajax({
			type:'POST',
			url: baseUrl+'/itemsMedicalRecords/AccountsCus/addDentalStatus',
			data: {
				"id_customer" 			:id_customer,
				"id_mhg" 				:id_mhg,
				"tooth_data" 			:JSON.stringify(tooth_data),
				"tooth_image"   		:JSON.stringify(tooth_image),
				"tooth_conclude" 		:JSON.stringify(tooth_conclude),
				"assign_tooth"			:JSON.stringify(assign_tooth),
			},
			success:function(data){
				// console.log(data);
				// return;
				$('.cal-loading').fadeOut('slow');
				$('#tab_medical_records').html(data);
			},
			error: function(data){
				console.log("error");
				console.log(data);
			}
		});

	}

});
/*************Báo giá*************/
$( document ).ready(function() {
	$('.create_appt').click(function (e) {
		$.ajax({
			type:"POST",
			url:"<?php echo Yii::app()->createUrl('itemsSchedule/calendar/createScheduleInCustomer')?>",
			data: {
				id_customer: '<?php echo $model->id; ?>',
				id_quotation: $('#id_quotation').val(),
			},
			success:function(data){
				$()
				if(data){
					$("#CalendarModal").html(data);
					$('#CalendarModal').modal('show');
				}
			},
			error: function(data) {
				alert("Error occured.Please try again!");
			},
		});
	});

});
/*************load điều trị và hóa đơn *************/
function getListInvoiceAndTreatment(id_mhg, id_customer, search_tooth,search_code_service){
	$.ajax({
		type:'POST',
		url: baseUrl+'/itemsMedicalRecords/AccountsCus/getListInvoiceAndTreatment',
		data: {
			"id_customer" 			:id_customer,
			"id_mhg" 				:id_mhg,
			"search_tooth" 			:search_tooth,
			"search_code_service"   :search_code_service
		},
		success:function(data){
			if(data == -1){
				$('#InvoiceAndTreatment').html('<tr><td colspan="6">Không có dữ liệu!</td></tr>');
			}else{
				$('#see_hidden').addClass('hidden');
				$('#see_all').removeClass('hidden');
				$('#ds_dieutri').html(data);

				showPopupChooseActionCancel();
			}
		},
		error: function(data){
			console.log("error");
			console.log(data);
		}
	});
}

$(document).ready(function() {
	var id_customer = $('#id_customer').val();
	var id_mhg      = $('#id_mhg').val();
	getListInvoiceAndTreatment(id_mhg,id_customer,'','');
	$('#search_tooth').keypress(function(event) {
		if (event.keyCode == 13) {
			var search_tooth = $('#search_tooth').val();
			var search_code_service = $('#search_code_service').val();
			getListInvoiceAndTreatment(id_mhg,id_customer,search_tooth,search_code_service);
		}
	});
	$('#search_code_service').keypress(function(event) {
		if (event.keyCode == 13) {
			var search_code_service = $('#search_code_service').val();
			var search_tooth = $('#search_tooth').val();
			getListInvoiceAndTreatment(id_mhg,id_customer,search_tooth,search_code_service);
		}
	});
})

/*************Công tác điều trị *************/
/*1.Thêm trên răng, 2. Thêm button, 3. chỉnh sửa*/
function viewTreatment(type,id_medical_history){
	var id_customer = $('#id_customer').val();
	var data_tooth 	= '';
	if(type == 1){
		var data_tooth = $('#hidden_string_number').val();
	}
	$.ajax({
		type:'POST',
		url: baseUrl+'/itemsMedicalRecords/AccountsCus/loadViewTreatment',
		data: {
			"type"							: type,
			"id_medical_history" 			: id_medical_history,
			"data_tooth" 					: data_tooth,
			'id_customer'					: id_customer,
		},
		success:function(data){
			$('#toggle-dental').fadeOut('slow');
			$('#add-treatment-process-modal').html(data);
			$('.cal-loading').fadeOut('fast');
		},
		error: function(data){
			console.log("error");
			console.log(data);
		}
	});

	viewPrescription();
	viewLabo();
}
/*************xem tất cả và ẩn bớt điều trị *************/
$('#see_all').click(function () {
	var id_customer 		= $('#id_customer').val();
	var id_mhg      		= $('#id_mhg_dt').val();
	var search_tooth 		= $('#search_tooth').val();
	var search_code_service = $('#search_code_service').val();
	$.ajax({
		type:'POST',
		url: baseUrl+'/itemsMedicalRecords/AccountsCus/getListInvoiceAndTreatmentAll',
		data: {
			"id_customer" 			:id_customer,
			"id_mhg" 				:id_mhg,
			"search_tooth" 			:search_tooth,
			"search_code_service"   :search_code_service
		},
		success:function(data){
			$('#see_all').addClass('hidden');
			$('#see_hidden').removeClass('hidden');
			$('#ds_dieutri').html(data);

			showPopupChooseActionCancel();
		},
		error: function(data){
			console.log("error");
			console.log(data);
		}
	});
});
$('#see_hidden').click(function () {
	var id_customer 		= $('#id_customer').val();
	var id_mhg      		= $('#id_mhg').val();
	var search_tooth 		= $('#search_tooth').val();
	var search_code_service = $('#search_code_service').val();
	getListInvoiceAndTreatment(id_mhg,id_customer,search_tooth,search_code_service);
});
/*************Xóa quá trình điều trị *************/
function deleteMedicalHistory(id){
	var evt = window.event || arguments.callee.caller.arguments[0];
	evt.stopPropagation();
	if (confirm("Bạn có thật sự muốn xóa?")) {
		$('.cal-loading').fadeIn('fast');
		var id_history_group 	= $('#id_mhg').val();
		var id_customer 		= $('#id_customer').val();
		$.ajax({
			type:'POST',
			url: baseUrl+'/itemsMedicalRecords/AccountsCus/deleteMedicalHistory',
			data: {
				"id" 				: id,
				"id_history_group" 	: id_history_group,
				"id_customer" 		: id_customer
			},
			success:function(data){
				$('#tab_medical_records').html(data);
				$('.cal-loading').fadeOut('slow');
			},
			error: function(data){
				console.log("error");
				console.log(data);
			}
		});
	}
}
/*************Load view labo *************/
function viewLabo(id_labo, id_medical_history){
	var id_customer 		= $('#id_customer').val();
	$.ajax({
		type:'POST',
		url: baseUrl+'/itemsMedicalRecords/AccountsCus/loadViewLabo',
		data: {
			"id_labo" 		: id_labo,
			"id_customer" 	: id_customer,
			"id_medical_history" :id_medical_history,
		},
		success:function(data){
			$('#labModal').html(data);
			$('.cal-loading').fadeOut('slow');
		},
		error: function(data){
			console.log("error");
			console.log(data);
		}
	});
}
/*************Load view toa thuốc *************/
function viewPrescription(id_prescription, id_medical_history){
	var id_customer 		= $('#id_customer').val();
	$.ajax({
		type:'POST',
		url: baseUrl+'/itemsMedicalRecords/AccountsCus/loadViewPrescription',
		data: {
			"id_prescription" 		: id_prescription,
			"id_customer" 			: id_customer,
			"id_medical_history" 	:id_medical_history,
		},
		success:function(data){

			$('#prescriptionModal').html(data);
			$('.cal-loading').fadeOut('slow');
		},
		error: function(data){
			console.log("error");
			console.log(data);
		}
	});
}

/************* bấm đợt điều trị **************/
// $('.btn_ddt').click(function (e) {
// 	$('.btn_ddt').removeClass('btn-green');
// 	$(this).addClass('btn-green');
// 	var id_mhg = $(this).data('key');
// 	$('#id_mhg_dt').val(id_mhg);
// 	var id_customer = $('#id_customer').val();
// 	getListInvoiceAndTreatment(id_mhg,id_customer,'','');
// })
$('.btn_ddt').click(function (e) {
	var id_customer = $('#id_customer').val();
	var id_mhg = $(this).data('key');
	$('.cal-loading').fadeIn('fast');
	$.ajax({
		type:'POST',
		url: baseUrl+'/itemsMedicalRecords/AccountsCus/DetailTreatment',
		data: {
			"id_customer":id_customer,
			"id":id_mhg,
		},
		success:function(data){
			$('.cal-loading').fadeOut('slow');
			$('#tab_medical_records').html(data);
		},
		error: function(data){
			console.log("error");
			console.log(data);
		}
	});
})
/*************Xóa bệnh trên răng*************/
$('#right_medical_records').on('click','#deletetooth',function (e) {
	e.preventDefault();

	var id = $(this).attr("data-tooth");
	var id_customer = $('#id_customer').val();
	var id_mhg = $('#id_mhg').val();

	$('#smsRs').modal();

	$('.calcf').click(function (e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: baseUrl + '/itemsMedicalRecords/AccountsCus/Deletetooth',
			data: {
				id: id,
				id_customer: id_customer,
				id_mhg: id_mhg,
			},
			success: function(data) {
				$.jAlert({
					'title': "Thông báo",
					'content': data,
				});

				$('#deleteFile').modal("hide");

				setTimeout(function(){
					location.reload();
				}, 1500);
			},
			error: function(xhr, ajaxOptions, thrownError){
				alert(xhr.status);
				alert(thrownError);
			},
		});
	});
});
</script>