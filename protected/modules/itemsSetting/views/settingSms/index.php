<?php $baseUrl = Yii::app()->baseUrl; ?>

<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/jqtransform.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/setting.css" />
<link id="settingCss" rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/customers_new.css" />

<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->baseUrl ?>" />

<style type="text/css">
	#profileSideNav ul li a i {
		font-size: 2em;
	}

	#tabcontent {
		padding: 30px 30px 10px 30px;
	}

	.Off {
		left: 1px;
	}

	.On {
		left: -57px;
	}

	.Switch {
		left: 1px;
	}

	.slider_holder {
		font-family: helveticaneuelight;
	}
</style>

<div id="alert-success" style="position: fixed; top: 50px; right: 0px;"></div>

<div id="smsSetting" class="tab-pane full-height active">
	<div class="row-fluid full-height">
		<div id="customerContent" class="content">
			<div class="row">
				<div class="customerListContainer col-sm-3 col-md-3">
					<div style="margin:0px 2em;">
						<div class="customersActionHolder">
							<h3>Danh sách</h3>
							<div class="clearfix"></div>
						</div>

						<div id="customerListHolder" class="customerListHolder">
							<ul id="smsSettingList">
								<?php foreach (SettingSms::$_TYPE as $key => $value) : ?>
									<li id="c<?php echo $value; ?>" onclick="detailSmsSetting(<?php echo $value; ?>);" class="n">
										<input type="hidden" class="smsSettingType" value="<?php echo $value; ?>">
										<label class="fl"><?php echo SettingSms::$_TYPE_NAME[$value]; ?> </label>
										<div class="clearfix"></div>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>

				<div id="detailSmsSetting" class="col-sm-9 col-md-9"></div>
			</div>

			<div class="clearfix"></div>
		</div>
	</div>
</div>

<?php include('_js.php'); ?>