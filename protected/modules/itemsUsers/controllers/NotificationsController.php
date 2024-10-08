<?php

class NotificationsController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/layouts_menu';

	/**
	* @return array action filters
	*/
	public function filters()
	{
	return array(
	'accessControl', // perform access control for CRUD operations
	);
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules()
	{
		return parent::accessRules();
	}

	public function actionView($code = "")
	{
		$branch = Branch::model()->findAll();
		$branchList = CHtml::listData($branch, 'id', 'name');

		$this->render('view',array('branch'=>$branchList,'code'=>$code));
	}
	public function watchedNotifications(){

		if($_POST['id']){

		}
	}

	public function actionViewDetail()
	{
		$page   = isset($_POST['page']) ? $_POST['page'] : 1;
		$limit  = 10;
		$type   = isset($_POST['type']) ? $_POST['type'] : 1;
		$startDate   = isset($_POST['startDate']) ? $_POST['startDate'] : 1;
		$endDate   = isset($_POST['endDate']) ? $_POST['endDate'] : 1;
		$code   = isset($_POST['code']) ? $_POST['code'] : 1;

		$noties = VNotification::model()->searchNotification($page,$limit, $type, $startDate, $endDate, $code);
	
		$noty   = $noties['data'];
		$count  = $noties['count'];

		$page_list = $this->paging($page,$count,$limit,$type, $startDate, $endDate);

		$this->renderpartial('notyList',array('noty'=>$noty,'page_list'=>$page_list));
	}

    public function paging($page,$count,$limit,$type, $startDate, $endDate)
    {
        $curpage = $page;
        $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;

        $page_list = '';

        if(($curpage!=1)&&($curpage))
        {
            $page_list .= '<span onclick="loadNoti(1'.",$type, '$startDate', '$endDate'".');" style="cursor:pointer;" class="div_trang">';
            $page_list .= '<a style="color:#000000;" title="Trang đầu"><<</a></span>';
        }
        if(($curpage-1)>0)
        {
            $page_num = $curpage - 1;
            $page_list .= '<span onclick="loadNoti('.$page_num.",$type, '$startDate', '$endDate'".');" style="cursor:pointer;" class="div_trang">';
            $page_list .= '<a style="color:#000000;" title="Về trang trước"><</a></span>';
        }               
        $vtdau=max($curpage-3,1);
        $vtcuoi=min($curpage+3,$pages);             
        for($i=$vtdau;$i<=$vtcuoi;$i++)
        {
            if($i==$curpage)
            {
                $page_list .= '<span style="background:rgba(115, 149, 158, 0.80);"  class="div_trang">'."<b style='color:#FFFFFF;'>".$i."</b></span>";
            }
            else
            {
                $page_list .= '<span onclick="loadNoti('.$i.",$type, '$startDate', '$endDate'".');" style="cursor:pointer;" class="div_trang">';
                $page_list .= '<a style="color:#000000;" title="Trang' .$i.'">'.$i.'</a></span>';
            }
        }
        if(($curpage+1)<=$pages)
        {
            $page_list .= '<span onclick="loadNoti('.$curpage.' + 1'.",$type, '$startDate', '$endDate'".');" style="cursor:pointer;" class="div_trang"><a style="color:#000000;" title="Đến trang sau">></a></span>';
            $page_list.='<span onclick="loadNoti('.$pages.",$type, '$startDate', '$endDate'".');" style="cursor:pointer;" class="div_trang"><a style="color:#000000;" title="Đến trang cuối">>></a></span>';
        }

        return $page_list;
    }

    public function actionListViewLayoutNoti(){
   

	  //$CsNotifications    = new CsNotifications;
	  if(Yii::app()->user->getState('user_id') && Yii::app()->user->getState('group_id') == Yii::app()->params['id_group_dentist']){

	   $data   = Yii::app()->db->createCommand()
	          ->select('*')
	          ->from('cs_notifications')
	    ->where('cs_notifications.id_dentist=:id_dentist', array(':id_dentist' => $id_user))
	          ->limit(10)
	          ->order('cs_notifications.createdate DESC')
	          ->queryAll();
	  }else{
	   $data   = Yii::app()->db->createCommand()
	          ->select('*')
	          ->from('cs_notifications')
	          ->limit(10)
	          ->order('cs_notifications.createdate DESC')
	          ->queryAll();
	  }

	  echo json_encode($data);

	    }


	    public function actionGetSumNotiLayout(){


	  $CsNotifications    = new CsNotifications;

	  $sum_notifications = $CsNotifications->getSumNotificationsNotSeen(Yii::app()->user->getState('user_id'));

	  echo $sum_notifications;


	}

}
