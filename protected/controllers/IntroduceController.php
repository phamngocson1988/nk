<?php

class IntroduceController extends CController
{
	public $layout = '//layouts/home_col1';
	public function behaviors()
    {
        return array(
            'seo' => array('class' => 'ext.seo.components.SeoControllerBehavior'),
        );
    }

    public function filters()
    {
        return array(
            array('ext.seo.components.SeoFilter + view'), // apply the filter to the view-action
        );
    }
	public function actionIndex()
	{
		$introduce =  PInfrastructure::model()->findAll();
		$data_seo = SeoData::model()->findAllByAttributes(array('name'=>'introduce'));
		$list_doctor = GpUsers::model()->getListDentists();
		$list_doctor_ct = GpUsers::model()->getListDentists_ct();
		$this->render('index',array('list_doctor'=>$list_doctor,'data_seo'=>$data_seo,'list_doctor_ct' =>$list_doctor_ct, 'introduce'=>$introduce));
	}
	public function actionDetailHoatDongNhaKhoa($lang)
	{
		$data = PImages::model()->findAllByAttributes(array('id_type'=>4));
		$this->render('hoat_dong_nha_khoa',array('img'=>$data,'lang'=>$lang));
	}
	public function actionDetailHoatDongNgoaiKhoa($lang)
	{
		$data = PImages::model()->findAllByAttributes(array('id_type'=>5));
		$this->render('hoat_dong_ngoai_khoa',array('img'=>$data,'lang'=>$lang));
	}
	public function actionDetailAboutUs()
	{
		$this->render('detail_about_us');
	}
	public function actionDetailBacSi($id)
	{
		
		$data = GpUsers::model()->findByPK($id);
		
		$this->render('detail_bac_si',array('detail_data'=>$data));
	}
	public function actionDetailCoSoVatChat($lang)
	{
		$data = PInfrastructure::model()->findAllByAttributes(array('id_type'=>2));
		$this->render('detail_co_so_vat_chat',array('data'=>$data,'lang'=>$lang));
	}
	public function actionDetailCoSoVatChat2($lang)
	{
		$data = PInfrastructure::model()->findAllByAttributes(array('id_type'=>3));
		$this->render('detail_co_so_vat_chat_2',array('data'=>$data,'lang'=>$lang));
	}
	public function actionDetailNhaKhoaNhi($lang)
	{
		$data = PInfrastructure::model()->findAllByAttributes(array('id_type'=>4));
		$this->render('detail_nha_khoa_nhi',array('data'=>$data,'lang'=>$lang));
	}
	public function actionClipChuyenDe($lang)
	{
		$data = PImages::model()->findAllByAttributes(array('id_type'=>6));
		$this->render('list_video',array('clips'=>$data, 'lang'=>$lang));
	}
	
	function stripVN($str) {
	    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
	    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
	    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
	    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
	    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
	    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
	    $str = preg_replace("/(đ)/", 'd', $str);

	    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
	    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
	    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
	    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
	    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
	    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
	    $str = preg_replace("/(Đ)/", 'D', $str);
	    return $str;
	}

	
}