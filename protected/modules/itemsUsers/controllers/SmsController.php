<?php

class SmsController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/layouts_menu';
    
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

    public function actionView()
    {
        // role
        $group_id   =  Yii::app()->user->getState('group_id');
        $roleUpSms  = 0;

        //group cskh
        if ($group_id == 5) {
             $roleUpSms  = 1; 
        }
        // group dieu hanh + admin
        elseif($group_id == 1 || $group_id == 2){
             $roleUpSms  = 1;
        }

        $branch     = Branch::model()->findAll();
        $branchList = CHtml::listData($branch, 'id', 'name');

        $this->render('view',array('branch'=>$branchList, 'roleUpSms'=>$roleUpSms));
    }

    public function actionSendSMS()
    {
        $phone       = isset($_POST['phone'])         ? $_POST['phone']       : '';
        $text        = isset($_POST['text'])          ? $_POST['text']        : '';
        $type        = isset($_POST['type'])          ? $_POST['type']        : 1;
        $source      = isset($_POST['source'])        ? $_POST['source']      : 1;
        $id_author   = isset($_POST['id_author'])     ? $_POST['id_author']   : Yii::app()->user->getState('user_id');
        $author      = isset($_POST['author'])        ? $_POST['author']      : Yii::app()->user->getState('name');
        $customer    = isset($_POST['cus'])           ? $_POST['cus']         : '';
        $id_customer = isset($_POST['id_cus'])        ? $_POST['id_cus']      : 0;
        $id_schedule = isset($_POST['id_sch'])        ? $_POST['id_sch']      : 0;
        $id_template = isset($_POST['id_template'])   ? $_POST['id_template'] : 0;
        $template_data = isset($_POST['template_data'])   ? $_POST['template_data'] : [];

        $id_branch = Yii::app()->user->user_branch;

        if(!$phone || !$text) {
            echo "-1"; // ko du du lieu
            exit;
        }

        $send = 1;
        if ($id_template) { // send by zalo service
            $id_sms = 'zalo_' . strtotime('now');
            $result = Yii::app()->zalo->sendSms($id_template, $phone, $text, $template_data);
            $send = $result['code'] === '0' ? 1 : -1;
            $save = Sms::model()->saveSMS(array(
                'id_sms'      => $id_sms,
                'id_author'   => $id_author,
                'author'      => $author,
                'phone'       => $phone,
                'content'     => $text,
                'type'        => $type,      // 1: thong bao, 2: tai khoan, 3: lich hen
                'source'      => $source,    // 1: NV, 2: KH
                'status'      => $send,    // 1: thanh cong
                'id_customer' => $id_customer,
                'customer'    => $customer,
                'id_schedule' => $id_schedule,
                'flag'        => 1,
                'id_branch'   => $id_branch,
            ));
        } else {
            $send = Sms::model()->sendSms($phone, $text, $id_branch, $id_author, $author, $id_customer, $customer, $id_schedule);
        }

        echo json_encode($send);
        exit;
    }

    public function actionViewDetail()
    {
        // role
        $group_id   =  Yii::app()->user->getState('group_id');
        $roleUpSms  = 0;
        $roleDelSms = 0;

        //group cskh
        if ($group_id == 5) {
             $roleUpSms  = 1;
             $roleDelSms = 0; 
        }
        // group dieu hanh + admin
        elseif($group_id == 1 || $group_id == 2){
             $roleUpSms  = 1;
             $roleDelSms = 1; 
        }

        $page      = isset($_POST['page'])              ? $_POST['page']            : '';
        $sms_phone = isset($_POST['sms_phone'])         ? $_POST['sms_phone']       : '';
        $sms_ct    = isset($_POST['sms_ct'])            ? $_POST['sms_ct']          : '';
        $sms_time  = isset($_POST['sms_time'])          ? $_POST['sms_time']        : '';
        
        $limit  = 15;
        
        $sms = Sms::model()->searchSms($page,$limit,$sms_time,$sms_phone,$sms_ct);
        
        $smss   = $sms['data'];
        $count  = $sms['count'];
        $page_list = $this->paging($page,$count,$limit);
        
        $this->renderpartial('smsList',array('sms'=>$smss,'page_list'=>$page_list,'roleDelSms'=>$roleDelSms,'roleUpSms'=>$roleUpSms));
    }

    public function actionDelSms()
    {
        $id   = isset($_POST['id']) ? $_POST['id'] : '';
        
        if(!$id) {
            echo "1";
            exit;
        }

        $del = Sms::model()->delSms($id);

        echo $del;
    }

    public function paging($page,$count,$limit)
    {
        $curpage = $page;
        $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;

        $page_list = '';

        if(($curpage!=1)&&($curpage))
        {
            $page_list .= '<span onclick="loadSms(1);" style="cursor:pointer;" class="div_trang">';
            $page_list .= '<a style="color:#000000;" title="Trang đầu"><<</a></span>';
        }
        if(($curpage-1)>0)
        {
            $page_num = $curpage - 1;
            $page_list .= '<span onclick="loadSms('.$page_num.');" style="cursor:pointer;" class="div_trang">';
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
                $page_list .= '<span onclick="loadSms('.$i.');" style="cursor:pointer;" class="div_trang">';
                $page_list .= '<a style="color:#000000;" title="Trang' .$i.'">'.$i.'</a></span>';
            }
        }
        if(($curpage+1)<=$pages)
        {
            $page_list .= '<span onclick="loadSms('.$curpage.' + 1);" style="cursor:pointer;" class="div_trang"><a style="color:#000000;" title="Đến trang sau">></a></span>';
            $page_list.='<span onclick="loadSms('.$pages.');" style="cursor:pointer;" class="div_trang"><a style="color:#000000;" title="Đến trang cuối">>></a></span>';
        }

        return $page_list;
    }

    public function actionFilterCustomer()
    {
        $dateStart  = isset($_POST['dateStart']) ? $_POST['dateStart'] : '';
        $dateEnd    = isset($_POST['dateEnd']) ? $_POST['dateEnd'] : '';
        $filterType = isset($_POST['filterType']) ? $_POST['filterType'] : '';
        $curpage    = isset($_POST['curpage']) ? $_POST['curpage'] : 1;
        $limit = 50;

        $filter = Sms::model()->filterCustomer($curpage, $limit, $filterType, $dateStart, $dateEnd);

        print_r($filter);

        //$this->renderpartial('cusList',array('sms'=>$smss,'page_list'=>$page_list));

    }
}
?>