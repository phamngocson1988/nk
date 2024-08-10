<?php

/** 
 * This is the model class for table "v_quotations". 
 * 
 * The followings are the available columns in table 'v_quotations': 
 * @property integer $id
 * @property string $code
 * @property integer $id_branch
 * @property string $branch_name
 * @property integer $id_customer
 * @property string $customer_name
 * @property integer $id_author
 * @property string $author_name
 * @property string $create_date
 * @property string $payment_date
 * @property string $sum_amount
 * @property string $sum_tax
 * @property string $note
 * @property integer $status
 */ 
class VQuotations extends CActiveRecord
{ 
    /** 
     * @return string the associated database table name 
     */ 
    public function tableName() 
    { 
        return 'v_quotations'; 
    } 

    /** 
     * @return array validation rules for model attributes. 
     */ 
    public function rules() 
    { 
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array( 
            array('branch_name, author_name', 'required'),
            array('id, id_branch, id_group_history, id_customer, id_author, status', 'numerical', 'integerOnly'=>true),
            array('code', 'length', 'max'=>45),
            array('branch_name, customer_name', 'length', 'max'=>255),
            array('author_name', 'length', 'max'=>128),
            array('sum_amount, sum_tax', 'length', 'max'=>12),
            array('create_date, payment_date, note', 'safe'),
            // The following rule is used by search(). 
            // @todo Please remove those attributes that should not be searched. 
            array('id, code, id_branch, id_group_history, branch_name, id_customer, customer_name, id_author, author_name, create_date, payment_date, sum_amount, sum_tax, note, status', 'safe', 'on'=>'search'),
        ); 
    } 

    /** 
     * @return array relational rules. 
     */ 
    public function relations() 
    { 
        // NOTE: you may need to adjust the relation name and the related 
        // class name for the relations automatically generated below. 
        return array( 
        ); 
    } 

    /** 
     * @return array customized attribute labels (name=>label) 
     */ 
    public function attributeLabels() 
    { 
        return array( 
            'id' => 'ID',
            'code' => 'Code',
            'id_branch' => 'Văn phòng',
            'branch_name' => 'Văn phòng',
            'id_customer' => 'Id Customer',
            'customer_name' => 'Customer Name',
            'id_author' => 'Id Author',
            'author_name' => 'Author Name',
            'create_date' => 'Ngày tạo',
            'payment_date' => 'Ngày hết hạn',
            'sum_amount' => 'Tổng cộng',
            'sum_tax' => 'Bao gồm thuế',
            'note' => 'Ghi chú',
            'status' => 'Trạng thái',
        ); 
    } 

    /** 
     * Retrieves a list of models based on the current search/filter conditions. 
     * 
     * Typical usecase: 
     * - Initialize the model fields with values from filter form. 
     * - Execute this method to get CActiveDataProvider instance which will filter 
     * models according to data in model fields. 
     * - Pass data provider to CGridView, CListView or any similar widget. 
     * 
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions. 
     */ 
    public function search() 
    { 
        // @todo Please modify the following code to remove attributes that should not be searched. 

        $criteria=new CDbCriteria; 

        $criteria->compare('id',$this->id);
        $criteria->compare('code',$this->code,true);
        $criteria->compare('id_branch',$this->id_branch);
        $criteria->compare('branch_name',$this->branch_name,true);
        $criteria->compare('id_customer',$this->id_customer);
        $criteria->compare('customer_name',$this->customer_name,true);
        $criteria->compare('id_author',$this->id_author);
        $criteria->compare('author_name',$this->author_name,true);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('payment_date',$this->payment_date,true);
        $criteria->compare('sum_amount',$this->sum_amount,true);
        $criteria->compare('sum_tax',$this->sum_tax,true);
        $criteria->compare('note',$this->note,true);
        $criteria->compare('status',$this->status);

        return new CActiveDataProvider($this, array( 
            'criteria'=>$criteria, 
        )); 
    } 

    /** 
     * Returns the static model of the specified AR class. 
     * Please note that you should have this exact method in all your CActiveRecord descendants! 
     * @param string $className active record class name. 
     * @return VQuotations the static model class 
     */ 
    public static function model($className=__CLASS__) 
    { 
        return parent::model($className); 
    } 

	public function searchQuotation($curpage, $limit, $quote_time, $branch, $customer, $code, $start, $end) {
        $start_point = $limit*($curpage-1);
      
        $p = new VQuotations;           
        $q = new CDbCriteria(array(
        'condition'=>'published="true"'
        ));
        $v = new CDbCriteria(); 
        $v->addCondition('t.status >= 0');
        $time = 0;

        if($quote_time) {
            if ($quote_time == 5) {
                $v->addCondition("'$start' <= Date(create_date)");
                $v->addCondition("'$end' >= Date(create_date)");
            } else if($quote_time == 2) {
                $time = date('Y-m-d');
                $v->addCondition('DATE(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            } else if ($quote_time == 3) {         // 7 ngày trước
                $time = date('Y-m-d',strtotime(date('Y-m-d') . ' - 7 day'));
                $v->addCondition('DATE(create_date) >= :create_date');
                $v->params = array(':create_date' => $time);
            } else {                               // tháng trước
                $time = date('m',strtotime(date('Y-m-d')));
                $v->addCondition('MONTH(create_date) = :create_date');
                $v->params = array(':create_date' => $time);
            }
        }

        if($branch) {$v->addCondition('id_branch ='. $branch);}

        if($customer) {$v->addCondition('id_customer = '. $customer);}

        if($code) {$v->addSearchCondition('code', $code, true);}

        $count = count($p->findAll($v));
      
        $v->order= 'id DESC';
        $v->limit = $limit;
        $v->offset = $start_point;
        $q->mergeWith($v);

        $data = $p->findAll($v);

        return array('count'=>$count,'data'=>$data);
    }

    public function paging($page,$count,$limit,$action,$param)
	{
		$curpage = $page;
		$pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;

		$page_list = '';

		if(($curpage!=1)&&($curpage))
		{
			$page_list .= '<span onclick="'.$action.'(1,'. $param.');" style="cursor:pointer;" class="div_trang">';
			$page_list .= '<a style="color:#000000;" title="Trang đầu"><<</a></span>';
		}
		if(($curpage-1)>0)
		{
			$page_num = $curpage - 1;
			$page_list .= '<span onclick="'.$action.'('.$page_num.','.$param.');" style="cursor:pointer;" class="div_trang">';
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
				$page_list .= '<span onclick="'.$action.'('.$i.','.$param.');" style="cursor:pointer;" class="div_trang">';
				$page_list .= '<a style="color:#000000;" title="Trang' .$i.'">'.$i.'</a></span>';
			}
		}
		if(($curpage+1)<=$pages)
		{
			$page_list .= '<span onclick="'.$action.'('.$curpage.' + 1,'.$param.');" style="cursor:pointer;" class="div_trang"><a style="color:#000000;" title="Đến trang sau">></a></span>';
			$page_list.='<span onclick="'.$action.'('.$pages.','.$param.');" style="cursor:pointer;" class="div_trang"><a style="color:#000000;" title="Đến trang cuối">>></a></span>';
		}

		return $page_list;
	}

    public function getListTreatmentOfQuotation($curpage, $lpp, $id_customer, $id_group_history)
    {   
        if(!$id_customer)
            return array('status' => -1, 'error' => 'Khong co ma khach hang.');
        $start_point=$lpp*($curpage-1);
        
        $q = new VQuotationDetail;
        $v  = new CDbCriteria();
        
        $v->addCondition('id_customer = ' . $id_customer);

        if($id_group_history)
            $v->addCondition('id_group_history = ' . $id_group_history);

        $v->addCondition('status = 1');

        $numRow=count($q->findAll($v));
        $numPage = ceil($numRow/$lpp);
      
        $v->order  = 'id_quotation';
        $v->limit  = $lpp;
        $v->offset = $start_point;

        $data = $q->findAll($v);

        $id_quotation = '';
        $pay = 0;
        $sum = 0;

        if($data){
            if($id_group_history)
                $id_quotation = end($data)->id_quotation;
            
            if($id_quotation){
                $inv = Invoice::model()->findAllByAttributes(array('id_quotation'=>$id_quotation));
                if($inv){
                    foreach ($inv as $key => $value) {
                        $pay += $value['sum_amount'] - $value['balance'];
                        $sum += $value['sum_amount'];
                    }
                }
            }
        }

        return array('numRow'=>$numRow, 'numPage'=> $numPage,'data'=>$data, 'pay'=>$pay);
    }

    public function totalQuotation($status,$branch,$month,$year){ //tổng số báo giá
        $con = Yii::app()->db;
        if ($status==="sum") {
            $sql="select SUM(sum_amount) AS totalSumAmount FROM v_quotations  WHERE 1=1";
        }
        else if($status==="count") {
            $sql="select COUNT(id) AS totalQuotation FROM v_quotations  WHERE 1=1";
        }
        if ($branch) {
            $sql.=" and id_branch=$branch";
        }
        if($month && $year){
            $sql.= " and (month(v_quotations.`create_date`)='$month' and year(v_quotations.`create_date`)='$year')";
        }
        $data = $con->createCommand($sql)->queryAll();
        if ($data) {
            return $data;
        }
    }
}
