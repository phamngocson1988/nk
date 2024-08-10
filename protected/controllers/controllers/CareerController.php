<?php

class CareerController extends HController
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
	public function actionIndex()
	{
		$doc = Recruitment::model()->findAll();
		$limit=6;
		$count=count($doc)-1;
		$pages=$this->findPages($count,$limit);
		$vt=$this->findStart($limit);
		$curpage=$_GET["page"];
		$lst=$this->pageList($curpage,$pages);
		
		$show_km=Recruitment::model()->doc_recruitment($vt,$limit);
		$this->render('index',array('show_km'=>$show_km,'lst'=>$lst));
	}
	public function actionDetailCareer($title,$id, $lang)
	{
		//share faceboook	
			$data_face = Recruitment::model()->findByPK($id);
			$this->pageOgImg 		= Yii::app()->params['url_base_http']."/upload/post/recruitment/lg/".$data_face->image;
			if($lang=='vi'){
				$this->pageOgTitles = $data_face->title;
				$this->pageOgDes 	= $data_face->description;
			}else{
				$this->pageOgTitles = $data_face->title_en;
				$this->pageOgDes 	= $data_face->description_en;
			}
		//end share faceboook
			
		$id_recruitment = $id;
		if(isset(Yii::app()->session['page_recruitment']) &&  Yii::app()->session['page_recruitment'] = $id)
		{
			
		}else{
			Yii::app()->session['page_recruitment'] = $id;
			
			$view = Recruitment::model()->findByPK($id_recruitment);

			$total= $view['total_view'];
			$total++;
			Recruitment::model()->updateByPK($id,array('total_view'=>$total));
		}
		
		$career = Recruitment::model()->recruitment_details($id);
		$list_total_view = Recruitment::model()->recruitment_total_view();
		$this->render('detailcareer',array('career'=>$career,'list_total_view'=>$list_total_view));
	}

	public function actionSearchCareer()
	{
		if(isset($_POST['keyword']) && isset($_POST['curpage']))
		{
			$p = new Recruitment;
			$keyword = $_POST['keyword'];
			$curpage = $_POST['curpage'];
			$limit=10;
			$t = new CDbCriteria(array('condition'=>'published="true"'));
			$n = new CDbCriteria();
			$n->addSearchCondition('title', $keyword, true);
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

			$news_line = Recruitment::model()->recruitment_list_pagination($curpage,$keyword);

			//title cua danh sach
			$search = "Kết quả tìm kiếm";
			//danh sach tags hien thi
			$news_new = Recruitment::model()->findAllByAttributes(array('status'=>1));
			$this->renderPartial('list_carrer',array('new'=>$news_new,'news_line'=>$news_line,'search'=>$search,'lst'=>$lst));
		}
	}
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
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

	public function actionSearchCareerEN()
	{
		if(isset($_POST['keyword']) && isset($_POST['curpage']))
		{
			$p = new Recruitment;
			$keyword = $_POST['keyword'];
			$curpage = $_POST['curpage'];
			$limit=10;
			$t = new CDbCriteria(array('condition'=>'published="true"'));
			$n = new CDbCriteria();
			$n->addSearchCondition('title_en', $keyword, true);
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

			$news_line = Recruitment::model()->recruitment_list_paginationEN($curpage,$keyword);

			//title cua danh sach
			$search = "SEARCH RESULTS";
			//danh sach tags hien thi
			$news_new = Recruitment::model()->findAllByAttributes(array('status'=>1));
			$this->renderPartial('list_carrer_en',array('new'=>$news_new,'news_line'=>$news_line,'search'=>$search,'lst'=>$lst));
		}
	}
}