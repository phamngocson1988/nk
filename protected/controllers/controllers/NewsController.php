<?php

class NewsController extends HController
{
   	public $pageOgTitles	= '';
   	public $pageOgImg 		= '';
   	public $pageOgDes 		= '';
   	
	public $layout = '//layouts/home_col1';
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
		if(isset($_GET['id']) && $_GET['id'])
		{
			$id_line = $_GET['id'];
			$news_line = News::model()->findAllByAttributes(array('id_news_line'=>$id_line));
		}
		else
		{
			$id_line = 1;
			$news_lines = News::model()->findAllByAttributes(array('id_news_type'=>$id_line));
 		}

 		$limit=10;
		$count=count($news_lines);

		$pager=$this->findPages($count,$limit);
		$vt=$this->findStart($limit);
		$curpage=$_GET["page"];
		$lst=$this->pageList($curpage,$pager);
		$news_line = News::model()->findAllByAttributes(array('status_hiden'=>0),array('limit' => $limit,'offset' =>$vt,'order'=>'createdate DESC'));

		$list_tags = Tags::model()->findAllByAttributes(array('status'=>1));
		$news_new = News::model()->findAllByAttributes(array('status_hiden'=>0),array('order'=>'id DESC','limit'=>3));
		$news_hot = News::model()->findAllByAttributes(array('status_hot'=>1),array('order'=>'id DESC','limit'=>4));

		// print_r(count($news_line));
		// exit();
		$this->render('index',array('new'=>$news_new,'news_line'=>$news_line,'lst'=>$lst,'tags'=>$list_tags,'hot'=>$news_hot));
	}
	public function actionNewsLine($newsline)
	{

		$string = str_replace('-',' ',$newsline);
		
		// $line = NewsLine::model()->findByAttributes(array('name'=>$string));
		$line = NewsLine::model()->findAll();
		$lines="";
		foreach( $line as $item)
		{
			$convert_string=$this->convert_vi_to_en($item['name']);
			$convert_string= str_replace('-',' ',$convert_string);
			if($convert_string===$string)
			{
				$lines = $item;
				break;
			}
		}
		if (!$lines) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		else{
			$news_lines = News::model()->findAllByAttributes(array('id_news_line' => $lines['id']));

			$limit=4;
			$count=count($news_lines);

			$pager=$this->findPages($count,$limit);
			$vt=$this->findStart($limit);
			$curpage=$_GET["page"];
			$lst=$this->pageList($curpage,$pager);

			$news_line = News::model()->findAllByAttributes(array('id_news_line' => $lines['id']),array('limit' => $limit,'offset' =>$vt));
			$list_tags = Tags::model()->findAllByAttributes(array('status'=>1));
			$type = NewsType::model()->findByPK($lines['id_news_type']);
			$news_new = News::model()->findAllByAttributes(array('status'=>1));
			$this->render('index',array('new'=>$news_new,'news_line'=>$news_line,'type'=>$type,'lst'=>$lst,'tags'=>$list_tags));
		}
	}
	public function actionDetailNews($newsline,$title,$id,$lang)
	{

	//share faceboook	
		$data_face = News::model()->findByPK($id);
		$this->pageOgImg 		= Yii::app()->params['url_base_http']."/upload/post/new/lg/".$data_face->image;
		if($lang=='vi'){
			$this->pageOgTitles = $data_face->title;
			$this->pageOgDes 	= $data_face->description;
		}else{
			$this->pageOgTitles = $data_face->title_en;
			$this->pageOgDes 	= $data_face->description_en;
		}
	//end share faceboook

		$id_news=$id;

		if(isset(Yii::app()->session['page_news']) &&  Yii::app()->session['page_news'] = $id)
		{
			
		}else{
			Yii::app()->session['page_news'] = $id;
			
			$view = News::model()->findByPK($id_news);

			$total= $view['total_view'];
			$total++;
			News::model()->updateByPK($id,array('total_view'=>$total));
		}

		$detail = News::model()->findByPK($id_news);
		$newsLine = News::model()->findAllByAttributes(array('id_news_line'=>$detail->id_news_line,'status_hiden'=>0), array('limit'=>4, 'order'=>'RAND()'));
		if($detail)
		{
			$string = $this->convert_vi_to_en($detail['title']);
			$return = substr_compare($string,$title,0);
		}
		if(!$detail || $return == 1 )
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		else{
			$this->render('detailnews',array('detail'=>$detail,'newsLine'=>$newsLine,'lang'=>$lang));
		}
	}
	public function actionPostBanner($title,$id)
	{
		$id_news=$id;
		if(isset(Yii::app()->session['page_news']) &&  Yii::app()->session['page_news'] = $id)
		{
			
		}else{
			Yii::app()->session['page_news'] = $id;
			
			$view = News::model()->findByPK($id_news);

			$total= $view['total_view'];
			$total++;
			News::model()->updateByPK($id,array('total_view'=>$total));
		}
		$detail = News::model()->findByPK($id_news);
		if($detail)
		{
			$string = $this->convert_vi_to_en($detail['title']);
			$return = substr_compare($string,$title,0);
		}
		if(!$detail || $return == 1)
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		else{
			$this->render('detailnews',array('detail'=>$detail));
		}
	}
	public function actionTagsPost($tags)
	{

		$string = str_replace('-',' ',$tags);

		//tim các bài viết có tags lien quan
		$tags_type_all = Tags::model()->findAll();

		$tags_type="";
		foreach( $tags_type_all as $item)
		{
			$convert_string=$this->convert_vi_to_en($item['name']);
			$convert_string= str_replace('-',' ',$convert_string);

			if($convert_string===$string)
			{
				$tags_type = $item;
				break;
			}
		}
		if(!$tags_type)
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		else{
			$allnews = News::model()->findAll(
					'tags LIKE :match',
	                array(':match' => "%".$tags_type['name']."%")
	         );
	 		$limit=10;
			$count=count($allnews);

			$pager=$this->findPages($count,$limit);
			$vt=$this->findStart($limit);
			$curpage=$_GET["page"];
			$lst=$this->pageList($curpage,$pager);


			$allnews = News::model()->findAll(
					'tags LIKE :match',
	                array(':match' => "%".$tags_type['name']."%")
	         );

			$list_tags = Tags::model()->findAllByAttributes(array('status'=>1));

			$this->render('details',array('allnews'=>$allnews,'lst'=>$lst,'tags'=>$list_tags,'newstypename'=>$tags_type['name'], 'typename_en'=>$tags_type['name']));

		}
	}


	public function actionSearchNews()
	{
		if(isset($_POST['keyword']) && isset($_POST['curpage']))
		{
			$p = new News;
			$keyword = $_POST['keyword'];
			$curpage = $_POST['curpage'];
			$lang = $_POST['lang'];
			$limit=10;
			$t = new CDbCriteria(array('condition'=>'published="true"'));
			$n = new CDbCriteria();
			if($lang=='vi'){
				$n->addSearchCondition('title', $keyword, true);
			}else{
				$n->addSearchCondition('title', $keyword, true);
			}
			$t->mergeWith($n);
       		$count=$keyword==0?count($p->findAll($n)):count($p->findAll($n));
       		$pages=(($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;		   
       		$page_list="";	
       		if(($curpage!=1)&&($curpage))
			{
				// $page_list.='<span onclick="pagination(1);" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Trang đầu'><<</a></span>";
			}
			if(($curpage-1)>0)
			{			
				// $page_list.='<span onclick="pagination('.$curpage.'-1);" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Về trang trước'><</a></span>";
			}				
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
			if(($curpage+1)<=$pages)
			{
				// $page_list.='<span onclick="pagination('.$curpage.'+1);" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Đến trang sau'>></a></span>";
				// $page_list.='<span onclick="pagination('.$pages.');" style="cursor:pointer;" class="div_trang">'."<a style='color:#000000;' title='Đến trang cuối'>>></a></span>";
			}	

	       	$lst=$page_list;
			if($lang=='vi'){
				$news_line = News::model()->news_list_pagination($curpage,$keyword);
				$search = "Kết quả tìm kiếm"; //title cua danh sach
			}else{
				$news_line = News::model()->news_list_pagination_en($curpage,$keyword);
				$search = "SEARCH RESULTS"; //title cua danh sach
			}
			$list_tags = Tags::model()->findAllByAttributes(array('status'=>1)); //danh sach tags hien thi
			
			$news_new = News::model()->findAllByAttributes(array('status'=>1)); //danh sach bai viet moi

			$this->renderPartial('listnews',array('new'=>$news_new,'news_line'=>$news_line,'search'=>$search,'lst'=>$lst,'tags'=>$list_tags, 'lang'=>$lang));
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

	public function actionListAllNews()
	{
		$allnews = News::model()->findAllByAttributes(array('status_hiden'=>0));

 		$limit=10;
		$count=count($allnews);

		$pager=$this->findPages($count,$limit);
		$vt=$this->findStart($limit);
		$curpage=$_GET["page"];
		$lst=$this->pageList($curpage,$pager);

		$allnews = News::model()->findAllByAttributes(array('status_hiden'=>0),array('limit' => $limit,'offset' =>$vt,'order'=>'createdate DESC'));

		$list_tags = Tags::model()->findAllByAttributes(array('status'=>1));

		$this->render('listAllNews',array('allnews'=>$allnews,'lst'=>$lst,'tags'=>$list_tags));
	}

	public function actionDetailType($newsline,$id,$lang)
	{
		$allnews = News::model()->findAllByAttributes(array('status_hiden'=>0,'id_news_line'=>$id));

 		$limit=10;
		$count=count($allnews);

		$pager=$this->findPages($count,$limit);
		$vt=$this->findStart($limit);
		$curpage=$_GET["page"];
		$lst=$this->pageList($curpage,$pager);

		$allnews = News::model()->findAllByAttributes(array('status_hiden'=>0,'id_news_line'=>$id),array('limit' => $limit,'offset' =>$vt,'order'=>'createdate DESC'));
		$list_tags = Tags::model()->findAllByAttributes(array('status'=>1));
		$typename = NewsLine::model()->findByPK($id)->name;
		$typename_en =  NewsLine::model()->findByPK($id)->name_en;

		$this->render('details',array('allnews'=>$allnews,'lst'=>$lst,'tags'=>$list_tags,'newstypename'=>$typename, 'typename_en'=>$typename_en));
	}
	 public $pageOgTitle = '';
    public $pageOgDesc = '';
    public $pageOgImage = '';

	public function display_seo()
{
   

    // OPEN GRAPH(FACEBOOK) META
    // -------------------------
    if ( !empty($this->pageOgTitle) ) {
        echo "t".''.PHP_EOL;
    }
    if ( !empty($this->pageOgDesc) ) {
        echo "t".''.PHP_EOL;
    }
    if ( !empty($this->pageOgImage) ) {
        echo "t".''.PHP_EOL;
    }
}
}