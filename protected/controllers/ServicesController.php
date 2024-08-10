<?php 
class ServicesController extends CController
{
	public $layout = '//layouts/home_col1';
	public $pageOgTitles	= '';
   	public $pageOgImg 		= '';
   	public $pageOgDes 		= '';

	public function convert_vi_to_en($str) {
	  $str = str_replace('.','',$str);
	  $str = str_replace(' ','-',$str);
	  $str = str_replace('?','',$str);
	  $str = str_replace('"','',$str);
	  $str = str_replace(',','',$str);
	  $str = str_replace("'",'',$str);
	  $str = str_replace('!','',$str);
	  $str = str_replace(':','',$str);
	  $str = str_replace('/','',$str);
	  $str = str_replace('@','',$str);
	  $str = str_replace('$','',$str);
	  $str = str_replace('%','',$str);
	  $str = str_replace('*','',$str);
	  $str = str_replace('(','',$str);
	  $str = str_replace(')','',$str);
	  $str = str_replace('[','',$str);
	  $str = str_replace(']','',$str);
	  $str = str_replace('<','',$str);
	  $str = str_replace('>','',$str);
	  $str = str_replace('_','',$str);
	  $str = str_replace('+','',$str);
	  $str = str_replace('=','',$str);
	  $str = str_replace('#','',$str);
	  $str = str_replace('^','',$str);
	  $str = str_replace('&','',$str);
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
	  $str = strtolower($str); 
	  return $str;
	}
	function findStart($limit)
	{
		if ((!isset($_GET['page'])) || ($_GET['page'] == "1"))
		{
			$start = 0;
			$_GET['page'] = 1;
		}
		else
		{
			$start = ($_GET['page']-1) * $limit;
		}
		
		return $start;
	}
	function findPages($count, $limit)
	{
		$pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;
		return $pages;
	}
	function pageList($curpage, $pages,$option="")
	{
		$page_list="";
			$vtdau=max($curpage-2,1);
			$vtcuoi=min($curpage+2,$pages);
			
				for($i=$vtdau;$i<=$vtcuoi;$i++)
				{
					if($i==$curpage)
					{
						$page_list.='<li class="active">'."<a>".$i."</a></li>";
					}
					else
					{
						$page_list.='<li>'."<a href ='?page=".$i."$option' title='Trang ".$i."'>".$i."</a></li>";
					}
				}
			return $page_list;
	}

	public function actionIndex()
	{
		$list_service 	= Service::model()->findAll();
 		$limit			= 10;
		$count 			= count($list_service);
		$pager 			= $this->findPages($count,$limit);
		$vt 			= $this->findStart($limit);
		$curpage 		= $_GET["page"];
		$lst 			= $this->pageList($curpage,$pager);
		$data_service   = Service::model()->findAllByAttributes(array('status'=>1),array('limit' => $limit,'offset' =>$vt,'order'=>'createdate DESC'));
		$view_more 		= ServiceType::model()->getListViewMore();
		$this->render('index', array('lst'=>$lst, 'data_service'=>$data_service,'view_more'=>$view_more));
	}

	public function actionServiceType($nameline,$id,$lang){
		$type = ServiceType::model()->findByPK($id);
		$list_service 	= Service::model()->findAllByAttributes(array('id_service_type'=>$id,'status'=>1));
		$limit			= 10;
		$count 			= count($list_service);
		$pager 			= $this->findPages($count,$limit);
		$vt 			= $this->findStart($limit);
		$curpage 		= $_GET["page"];
		$lst 			= $this->pageList($curpage,$pager);
		$data_service   = Service::model()->findAllByAttributes(array('id_service_type'=>$id,'status'=>1),array('limit' => $limit,'offset' =>$vt,'order'=>'stt ASC, createdate DESC'));
		$view_more 		= ServiceType::model()->getListViewMore();
		$this->render('service_type', array('lst'=>$lst, 'data_service'=>$data_service,'type'=>$type, 'view_more'=>$view_more));
	}

	public function actionDetail($name,$id,$lang){
		//share faceboook	
		$data_face = Service::model()->findByPK($id);
		$this->pageOgImg 		= Yii::app()->params['url_base_http']."/upload/post/service/lg/".$data_face->image;
		if($lang=='vi'){
			$this->pageOgTitles = $data_face->name;
			$this->pageOgDes 	= $data_face->description;
		}else{
			$this->pageOgTitles = $data_face->name_en;
			$this->pageOgDes 	= $data_face->description_en;
		}
		//end share faceboook
		if(isset(Yii::app()->session['page_service']) &&  Yii::app()->session['page_service'] = $id)
		{
			
		}else{
			Yii::app()->session['page_service'] = $id;
			$view  = Service::model()->findByPK($id);
			$total = $view['total_view'];
			$total++;
			Service::model()->updateByPK($id,array('total_view'=>$total));
		}
		$detail       = Service::model()->findByPK($id);
		$view_more 	  = ServiceType::model()->getListViewMore();
		$this->render('detail',array('detail'=>$detail,'view_more'=>$view_more));

	}


}