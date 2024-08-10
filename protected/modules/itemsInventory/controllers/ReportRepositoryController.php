<?php

class ReportRepositoryController extends Controller
{
	public $layout='/layouts/view';
	public $pageTitle = 'NhaKhoa2000 - Báo cáo';

	public function actionAdmin()
	{
		$this->render('admin');
	}

}