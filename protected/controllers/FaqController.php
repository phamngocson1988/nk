<?php

class FaqController extends CController
{
	public $layout = '//layouts/home_col1';
	public function convert_vi_to_en($str) {
	  
	  $str = str_replace(' ','-',$str);
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
		$faq = Faq::model()->findAllByAttributes(array('id_faq_line'=>1));
		if(!$faq)
		{
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		else{
			$this->render('index',array('faq'=>$faq));
		}
	}
	public function actionDetail($faqline,$id)
	{
		$faq = Faq::model()->findAllByAttributes(array('id_faq_line'=>$id));
		$this->render('index',array('faq'=>$faq));
	}
	public function actionSearch()
	{
		if(isset($_POST['keyword']))
		{
			$keyword = $_POST['keyword'];
			$faq = Faq::model()->findAll('question LIKE :keyword',array('keyword'=>'%'.$keyword.'%'));
			$this->renderPartial('detail',array('faq'=>$faq));
		}
	}
	// pagination
	public function actionPagination()
	{	
		if(isset($_POST['curpage'])) 
		{			
			$faq = new Faq;	
			$curpage=$_POST['curpage'];				
	        $limit=10;	       
	        $count=count($faq->findAll());   	                  	
	        $pages=(($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;	 
	       
	       	$lst=$faq->page_list($curpage,$pages);       	
			$faq_list_paging=$faq->faq_list_pagination($curpage,$limit); 
			$this->renderPartial('detail',array('faq'=>$faq_list_paging,'lst'=>$lst),false,false);
		}
	}

	public function actionSendQuestion()
	{
		if(isset($_POST['email']) && isset($_POST['name']) && isset($_POST['Content'])) 
		{	
			$ext     	 = pathinfo($_FILES['img_avatar']['name'], PATHINFO_EXTENSION);
			$rnd     	 = date("dmYHis").uniqid();
			$newName 	 = $rnd.'.'.$ext;
			$phone	 	 = isset($_POST['phone'])	?$_POST['phone']:"";
			$email	 	 = isset($_POST['email'])	?$_POST['email']:"";
			$name	 	 = isset($_POST['name'])	?$_POST['name']:"";
			$content	 = isset($_POST['Content'])	?$_POST['Content']:"";
			$fq 	 	 = new FaqQuestion;
			$fq->email 	 = $email;	
			$fq->name 	 = $name;
			$fq->phone 	 = $phone;
			$fq->content = $content;
			if($_FILES["img_avatar"]["error"]==0)
			{
				move_uploaded_file($_FILES["img_avatar"]["tmp_name"],"./upload/post/faq/$newName");
				$fq->img 	 = $newName;
			}

			if($fq->save())
			{
				echo '1';
				exit;
			}	
				
		}		
			
	}	

	public function actionAnswerQuestions(){
		$this->render('answer_questions');
	}

	public function actionLoadAnswerQuestions(){

		if(isset($_POST['curpage'])) 
		{			
			$faq_question	= new FaqQuestion;	
			$curpage 		= $_POST['curpage'];				
	        $limit 			= 4;	       
	        $count 			= count($faq_question->findAllByAttributes(array('status'=>1))); 

	        $pages 			= (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;	 
	       	$lst 			= $faq_question->page_list($curpage,$pages);  
	           	
			$list_data 		= $faq_question->loadData($curpage,$limit); 

			$this->renderPartial('list_aq',array('list_data'=>$list_data,'lst'=>$lst),false,false);
		}
	}
}