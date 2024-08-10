<?php

class ServiceController extends CController
{
	public $layout = '//layouts/home_col1';
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

	public function actionIndex()
	{
		$service = ServiceType::model()->findByPK(1); //Service
		if(!$service)
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		else{
			$this->render('index',array('service'=>$service));
		}
	}
	public function actionServiceLine($servicename,$id)
	{
		$service = Service::model()->findByPK($id);
		if($service)
		{
			$string = $this->convert_vi_to_en($service['name']);
			$return = substr_compare($string,$servicename,0);
		}
		if(!$service || $return == 1 || $return == -1)
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		else{
			$this->render('index',array('service'=>$service));
		}
	}
	public function actionPrice($price,$id)
	{
		$service = Prices::model()->findByPK($id);
		if($service)
		{
			$string = $this->convert_vi_to_en($service['name']);
			$return = substr_compare($string,$price,0);
		}
		if(!$service || $return == 1)
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		else{
			$this->render('index',array('service'=>$service));
		}
	}
	public function actionDetailservice()
	{
		$lang = $_POST['lang'];
		if(isset($_POST['id']) and $_POST['id']!=""){
		    $service = ServiceType::model()->findAll('id=:st',array(':st'=>$_POST['id'])); //Service
		}else{
		    $service = ServiceType::model()->findAll(' 1=1 LIMIT 1');
		}
		$this->renderPartial('detailservice',array('service'=>$service, 'lang'=>$lang),false, true);
	}



	public function actionDetailservice_type()
	{
		if(isset($_POST['id']) and $_POST['id']!=""){
		    $service = Service::model()->findAll('id=:st',array(':st'=>$_POST['id']));
		}else{
		    $service = Service::model()->findAll(' 1=1 LIMIT 1');
		}
		$this->renderPartial('detailservice',array('service'=>$service),false, true);
	}
	
	public function actionServiceDetail($nameline,$title,$id,$lang)
	{
		if(isset(Yii::app()->session['page_service']) &&  Yii::app()->session['page_service'] = $id)
		{
			
		}else{
			Yii::app()->session['page_service'] = $id;
			
			$view = Service::model()->findByPK($id);

			$total= $view['total_view'];
			$total++;
			Service::model()->updateByPK($id,array('total_view'=>$total));
		}
		
		$service_detail = Service::model()->service_details($id);
		$list_total_view = Service::model()->service_total_view();
		$this->render('servicedetail',array('service_detail'=>$service_detail,'list_total_view'=>$list_total_view));
	}

	public function actionSearchService()
	{
		if(isset($_POST['keyword']) && isset($_POST['curpage']))
		{
			$p = new Service;
			$keyword = $_POST['keyword'];
			$curpage = $_POST['curpage'];
			$limit=10;
			$t = new CDbCriteria(array('condition'=>'published="true"'));
			$n = new CDbCriteria();
			$n->addSearchCondition('name', $keyword, true);
			$t->mergeWith($n);
       		$count=$keyword==0?count($p->findAll($n)):count($p->findAll($n));
       		$pages=(($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;		   
       		$page_list="";	
       					
			$vtdau=max($curpage-3,1);
			$vtcuoi=min($curpage+3,$pages);				
			for($i=$vtdau;$i<=$vtcuoi;$i++)
			{
				if($i==$curpage)
				{
					$page_list.='<span style="background:rgba(115, 149, 158, 0.80);"  class="div_trang">'."<b style='color:#FFFFFF;'>".$i."</b></span>";
				}
				else
				{
					$page_list.='<span onclick="pagination('.$i.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#808285;' title='Trang ".$i."'>".$i."</a></span>";
				}
			}

	       	$lst=$page_list;

			$news_line = Service::model()->service_list_pagination($curpage,$keyword);

			//title cua danh sach
			$search = "Kết quả tìm kiếm";
			//danh sach tags hien thi
			$news_new = Service::model()->findAllByAttributes(array('status'=>1));
			$this->renderPartial('list_service',array('new'=>$news_new,'news_line'=>$news_line,'search'=>$search,'lst'=>$lst));
		}
	}
	public function actionSearchServiceEN()
	{
		if(isset($_POST['keyword']) && isset($_POST['curpage']))
		{
			$p = new Service;
			$keyword = $_POST['keyword'];
			$curpage = $_POST['curpage'];
			$limit=10;
			$t = new CDbCriteria(array('condition'=>'published="true"'));
			$n = new CDbCriteria();
			$n->addSearchCondition('name_en', $keyword, true);
			$t->mergeWith($n);
       		$count=$keyword==0?count($p->findAll($n)):count($p->findAll($n));
       		$pages=(($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;		   
       		$page_list="";	
       					
			$vtdau=max($curpage-3,1);
			$vtcuoi=min($curpage+3,$pages);				
			for($i=$vtdau;$i<=$vtcuoi;$i++)
			{
				if($i==$curpage)
				{
					$page_list.='<span style="background:rgba(115, 149, 158, 0.80);"  class="div_trang">'."<b style='color:#FFFFFF;'>".$i."</b></span>";
				}
				else
				{
					$page_list.='<span onclick="paginationEN('.$i.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#808285;' title='Trang ".$i."'>".$i."</a></span>";
				}
			}

	       	$lst=$page_list;

			$news_line = Service::model()->service_list_paginationEN($curpage,$keyword);

			//title cua danh sach
			$search = "SEARCH RESULTS";
			//danh sach tags hien thi
			$news_new = Service::model()->findAllByAttributes(array('status'=>1));
			$this->renderPartial('list_service_en',array('new'=>$news_new,'news_line'=>$news_line,'search'=>$search,'lst'=>$lst));
		}
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
			if(($curpage!=1)&&($curpage))
			{
				//$page_list.='<li>'."<a href =\"".$_SERVER['PHP_SELF']."?page=1$option\" title=\"Trang đầu\"><<</a></li>";
			}
			if(($curpage-1)>0)
			{
				//$page_list.='<li class="div_trang">'."<a href =\"".$_SERVER['PHP_SELF']."?page=".($curpage-1)."$option\" title=\"Về trang trước\"><</a></li>";
			}
			/*if($curpage>2)
				$page_list.="...";*/
			$vtdau=max($curpage-2,1);
			$vtcuoi=min($curpage+2,$pages);
			
				for($i=$vtdau;$i<=$vtcuoi;$i++)
				{
					if($i==$curpage)
					{
						$page_list.='<li class="div_trang">'."<a>".$i."</a></li>";
					}
					else
					{
						$page_list.='<li class="div_trang">'."<a href ='"."?page=".$i."$option' title='Trang ".$i."'>".$i."</a></li>";
					}
				}

			/*if(($curpage+2)<$pages)
				$page_list.="...";*/

			
			if(($curpage+1)<=$pages)
			{
				//$page_list.='<li>'."<a href =\"".$_SERVER['PHP_SELF']."?page=".($curpage+1)."$option\" title=\"Đến trang sau\">></a></li>";
				//$page_list.='<li>'."<a href =\"".$_SERVER['PHP_SELF']."?page=".$pages."$option\" title=\"Đến trang cuối\">>></a></li>";
			}
			return $page_list;
	}
}