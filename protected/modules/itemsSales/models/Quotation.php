<?php

/**
 * This is the model class for table "quotation".
 *
 * The followings are the available columns in table 'quotation':
 * @property integer $id
 * @property string $code
 * @property integer $id_author
 * @property integer $id_customer
 * @property integer $id_branch
 * @property integer $id_segment
 * @property string $segment_description
 * @property integer $id_group_history
 * @property string $create_date
 * @property string $complete_date
 * @property double $sum_amount
 * @property double $sum_amount_usd
 * @property double $sum_tax
 * @property integer $id_note
 * @property integer $status
 */

class Quotation extends CActiveRecord {
    #region --- PARAMS
    public $note;
    #endregion

    #region --- TABLE NAME
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'quotation';
    }
    #endregion

    #region --- RULES
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_author, id_customer, id_branch, id_segment, id_group_history, id_note, status', 'numerical', 'integerOnly'=>true),
            array('sum_amount, sum_amount_usd, sum_tax', 'numerical'),
            array('code', 'length', 'max'=>45),
            array('segment_description', 'length', 'max'=>255),
            array('complete_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, id_author, id_customer, id_branch, id_segment, segment_description, id_group_history, create_date, complete_date, sum_amount, sum_amount_usd, sum_tax, id_note, status', 'safe', 'on'=>'search'),
        );
    }
    #endregion

    #region --- RELATIONS
    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }
    #endregion

    #region --- ATTRIBUTE LABELS
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'id_author' => 'Người tạo',
            'id_customer' => 'Khách hàng',
            'id_branch' => 'Văn phòng',
            'id_segment' => 'Nhóm Khách hàng',
            'segment_description' => 'Segment Description',
            'id_group_history' => 'Id Group History',
            'create_date' => 'Ngày tạo',
            'complete_date' => 'Ngày kết thúc',
            'sum_amount' => 'Sum Amount',
            'sum_tax' => 'Sum Tax',
            'note' => 'Note',
            'status' => 'Status',
        );
    }
    #endregion

    #region --- SEARCH
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('code',$this->code,true);
        $criteria->compare('id_author',$this->id_author);
        $criteria->compare('id_customer',$this->id_customer);
        $criteria->compare('id_branch',$this->id_branch);
        $criteria->compare('id_segment',$this->id_segment);
        $criteria->compare('segment_description',$this->segment_description,true);
        $criteria->compare('id_group_history',$this->id_group_history);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('complete_date',$this->complete_date,true);
        $criteria->compare('sum_amount',$this->sum_amount);
        $criteria->compare('sum_tax',$this->sum_tax);
        $criteria->compare('note',$this->note,true);
        $criteria->compare('status',$this->status);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    #endregion

    #region --- MODEL
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Quotation the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    #endregion

    #region --- DANH SACH NHOM KHACH HANG
    public function getCusSeg($id_customer) {
        if(!$id_customer)
            return -1;      // khong co ma khach hang

        return $cusSeg = Yii::app()->db->createCommand()
                ->select('customer_segment.id_customer,customer_segment.id_segment,segment.name')
                ->from('customer_segment')
                ->where('id_customer=:id_customer', array(':id_customer' => $id_customer))
                ->leftJoin('segment', 'segment.id = customer_segment.id_segment')
                ->queryAll();
    }
    #endregion

    #region --- LAY MA BAO GIA - YYYYMMDD0001
    public function createCodeQuotation() {
        $date = date('Y-m-d');
        $code = str_replace(array('-', ' ', ':'), '', substr($date, 2));
        $num = Quotation::model()->count(array('condition' => 'date(create_date)="' . $date . '"')) + 1;
        $codenum = str_pad($num, '3', '0', STR_PAD_LEFT);
        $code .= $codenum;
        return $code;
    }
    #endregion

    #region --- TAO BAO GIA
    public function addQuotation($quoteData = array(), $quoteDetailData = array()) {
        if (empty($quoteData) || !is_array($quoteData)) {
            return array('status' => 'fail', 'error-message' => 'Không tồn tại thông tin báo giá!');
        }

        if (empty($quoteDetailData) || !is_array($quoteDetailData)) {
            return array('status' => 'fail', 'error-message' => 'Không tồn tại thông tin dịch vụ báo giá!');
        }

        $quote = new Quotation();
        $quote->attributes = $quoteData;
        $quote->code = $this->createCodeQuotation();

        $quoteDetailArray = array();
        $hasInvoice = false;

        if ($quote->validate()) {
            foreach ($quoteDetailData as $k => $val) {
                $quoteDetail = new QuotationService();
                $quoteDetail->attributes = $val;

                if ($quoteDetail->validate()) {
                    if (!$hasInvoice && $quoteDetail->status == 1) {
                        $hasInvoice = true;
                    }
                    $quoteDetail->id_author = $quote->id_author;
                    $quoteDetailArray[] = $quoteDetail;
                } else {
                    return array('status' => 'fail', 'error-message' => $quoteDetail->getErrors());
                }
            }
        } else {
            return array('status' => 'fail', 'error-message' => $quote->getErrors());
        }

        $note = isset($quoteData['note']) ? $quoteData['note'] : false;
        if ($note) {
            $noteObj = CustomerNote::model()->addnote(array(
                'note' => $note,
                'id_user' => $quote->id_author,
                'id_customer' => $quote->id_customer,
                'flag' => 2,
                'important' => 0,
                'status' => 1,
            ));
            if (isset($noteObj['id'])) {
                $quote->id_note = $noteObj['id'];
            }
        }

        if ($hasInvoice) {
            $quote->status = 1;
        }

        unset($quote->create_date);

        if ($quote->save()) {
            $quoteDetaiReturn = array();

            $id_quotation = $quote->id;
            foreach ($quoteDetailArray as $key => $value) {
                $value->id_quotation = $id_quotation;

                unset($value->create_date);

                if (!$value->save()) {
                    return array('status' => 'fail', 'error-message' => $value->getError());
                }

                if ($value->status == 1) {
                    $dataObj = $value->attributes;
                    $dataObj['id_quotation_item'] = $value->id;
                    $quoteDetaiReturn[] = $dataObj;
                }
            }

            return array('status' => 'successful', 'data' => array(
                'quotation' => $quote->attributes,
                'quotationItem' => $quoteDetaiReturn,
                'hasInvoice' => $hasInvoice
            ));
        } else {
            return array('status' => 'fail', 'error-message' => $quote->getErrors());
        }
    }
    #endregion

    #region --- CAP NHAT BAO GIA
    public function updateQuotation($quoteData = array(), $quoteDetailData = array()) {
        if (!is_array($quoteData) || empty($quoteData)) {
            return array('status' => 'fail', 'error-message' => 'Không có thông tin báo giá!');
        }
        if (!is_array($quoteDetailData) || empty($quoteDetailData)) {
            return array('status' => 'fail', 'error-message' => 'Không có thông tin dịch vụ báo giá!');
        }

        $id_quotation = isset($quoteData['id']) ? $quoteData['id'] : false;

        if (!$id_quotation) {
            return array('status' => 'fail', 'error-message' => 'Không có thông tin mã báo giá!');
        }

        $quote = Quotation::model()->findByPk($id_quotation);

        if (!$quote) {
            return array('status' => 'fail', 'error-message' => 'Thông tin báo giá không tồn tại!');
        }

        $quote->sum_amount = $quoteData['sum_amount'];
        $quote->sum_amount_usd = $quoteData['sum_amount_usd'];
        $quote->complete_date = $quoteData['complete_date'];

        $hasInvoice = false;

        if ($quote->validate()) {
            foreach ($quoteDetailData as $k => $val) {
                if ($val['id']) {
                    $id_item = $val['id'];
                    $quoteDetail = QuotationService::model()->findByPk($id_item);

                    if (!$quoteDetail) {
                        $quoteDetail = new QuotationService();
                        unset($quoteDetail->create_date);
                    } else if($quoteDetail->status == 1) {
                        continue;
                    }

                } else {
                    $quoteDetail = new QuotationService();
                    unset($quoteDetail->create_date);
                }

                if ($val['isDel'] == 1) {
                    $quoteDetail->status = -1;
                } else {
                    $quoteDetail->attributes = $val;
                }

                if ($quoteDetail->isNewRecord) {
                    $quoteDetail->id_author = Yii::app()->user->getState('user_id');
                }

                if ($quoteDetail->validate()) {
                    if (!$hasInvoice && $quoteDetail->status == 1) {
                        $hasInvoice = true;
                    }

                    $quoteDetailArray[] = $quoteDetail;
                } else {
                    return array('status' => 'fail', 'error-message' => $quoteDetail->getErrors());
                }
            }
        } else {
            return array('status' => 'fail', 'error-message' => $quote->getErrors());
        }

        $note = isset($quoteData['note']) ? $quoteData['note'] : false;
        if ($note) {
            $id_note = $quote->id_note;
            if ($id_note) {
                $noteObj = CustomerNote::model()->updatenote($id_note, $quoteData['note']);
            } else {
                $noteObj = CustomerNote::model()->addnote(array(
                    'note' => $note,
                    'id_user' => $quote->id_author,
                    'id_customer' => $quote->id_customer,
                    'flag' => 2,
                    'important' => 0,
                    'status' => 1,
                ));
                if (isset($noteObj['id'])) {
                    $quote->id_note = $noteObj['id'];
                }
            }
        }

        if ($hasInvoice) {
            $quote->status = 1;
        }

        if ($quote->save()) {
            $quoteDetaiReturn = array();

            $id_quotation = $quote->id;
            foreach ($quoteDetailArray as $key => $value) {
                $value->id_quotation = $id_quotation;

                if (!$value->save()) {
                    return array('status' => 'fail', 'error-message' => $value->getError());
                }

                if ($value->status == 1) {
                    $quoteDetaiReturn[] = $value->attributes;
                }
            }

            return array('status' => 'successful', 'data' => array(
                'quotation' => $quote->attributes,
                'quotationItem' => $quoteDetaiReturn,
                'hasInvoice' => $hasInvoice
            ));
        } else {
            return array('status' => 'fail', 'error-message' => $quote->getErrors());
        }
    }
    #endregion
}
