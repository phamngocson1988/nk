<?php $baseUrl = Yii::app()->baseUrl; ?>

<div class="customerDetailsContainer">
	<div id="tabcontent" class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_information" data-toggle="tab">Thiết lập</a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="tab_information">
				<?php include("detail_setting.php"); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(window).resize(function() {
		var windowHeight = $(window).height();
		var header = $("#headerMenu").height();
		var tab_menu = $("#tabcontent .nav-tabs").height();

		$('#content_tab_agenda').height(windowHeight - header - tab_menu - 36);
		$('#content_tab_information').height(windowHeight - header - tab_menu - 36);
	});

	$(document).ready(function() {
		var windowHeight = $(window).height();
		var header = $("#headerMenu").height();
		var tab_menu = $("#tabcontent .nav-tabs").height();

		$('#content_tab_agenda').height(windowHeight - header - tab_menu - 36);
		$('#content_tab_information').height(windowHeight - header - tab_menu - 36);
		$('#content_tab_doctor_salary').height(windowHeight - header - tab_menu - 66);

	});
</script>