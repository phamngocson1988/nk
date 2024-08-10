<?php

class SettingSmsController extends Controller {
	public $layout = '/layouts/main_sup';

	#region --- INDEX
	public function actionIndex() {
		$this->render('index');
	}
	#endregion

	#region --- DETAIL
	public function actionDetailSmsSetting() {
		$type = isset($_POST['type']) ? $_POST['type'] : false;

		if (!$type) { exit; }

		if (!in_array($type, SettingSms::$_TYPE)) {
			exit;
		}

		$smsSetting = SettingSms::model()->find(array(
			'select' => '*',
			'condition' => "type = $type"
		));

		if (!$smsSetting) {
			$smsSetting = new SettingSms();
			$smsSetting->type = $type;
		}

		$this->renderPartial('detail', array(
			'smsSetting' => $smsSetting
		));
	}
	#endregion

	#region --- UPDATE
	public function actionUpdate() {
		$setting = SettingSms::model()->upsert($_POST);
		echo CJSON::encode($setting);
	}
	#endregion
}
