<?php

class DetailproductController extends CController
{
	public $layout = '//layouts/home_col1';
	public function actionIndex()
	{
		if(isset($_GET['id']) && $_GET['id'])
		{
			$id = $_GET['id'];
			$data = Product::model()->findByPK($id);
		}
		$this->render('index', array('list'=>$data));
	}
	public function actionAddShoppingCart()
	{
        if(Yii::app()->user->getState('customer_id')=='') {
        	echo "-1";
        	exit;
        }
        if($_POST['idProduct']){
            if(!isset($_SESSION)){
                session_start();
            }
            $flag   = false;
            $cart   = array();
            $cart['id']     = $_POST['idProduct'];
            $cart['name']   = $_POST['name'];
            $cart['price']  = $_POST['price'];
            $cart['qty'] 	= $_POST['qty'];
            $cart['amount'] = $_POST['amount'];
            $cart['stock'] 	= $_POST['stock'];
            
            if(isset($_SESSION['cart'])){
                foreach($_SESSION['cart'] as $key => &$val){
                    if($val['id'] == $cart['id'] ){
                        $amount = $val['amount'] + $_POST['amount'];
                        $qty = $val['qty'] + $_POST['qty'];
                        $flag           = true;
                        $val['amount']  = $amount;
                        $val['qty']  = $qty;
                    }
                }
                if($flag == false){
                    array_push($_SESSION['cart'], $cart);
                }
            }else{
                $_SESSION['cart'][0]= $cart;
            }
        }
    }

    public function actionCart()
	{
   		$arr = isset(Yii::app()->session['cart'])?Yii::app()->session['cart']:'';
        if($arr){
            $cart = $arr;
        }else{

       		 $cart="";
       	}
       
		$this->render('cart',array('cart'=>$cart));
	}
	public function actionRemoveShopingCart()
   	{
         if(isset($_POST['rowCart'])){
            $total = 0;
            if(!isset($_SESSION)){
                session_start();
            }
            unset($_SESSION['cart'][$_POST['rowCart']]);
            foreach($_SESSION['cart'] as $key => &$val){
                $total += $val['amount'];
            }
            $this->renderPartial('cart', array('cart'	=> $_SESSION['cart'],
            								   'total' 	=> $total));
        }

	}
	public function actionChangeSession()
	{
		$key 	= isset($_POST['key'])			? 	$_POST['key'] : false;
		$id 	= isset($_POST['id'])			? 	$_POST['id'] : false;
		$qty 	= isset($_POST['qty'])			? 	$_POST['qty'] : false;
		$amount = isset($_POST['amount'])		? 	$_POST['amount'] : false;
		$stock  = isset($_POST['stock'])		? 	$_POST['stock'] : false;

		if(!$id) {
			echo -1;			// ko co ma san pham
			exit;
		}

		$session = Yii::app()->session;

		if(!isset($session['cart']) || empty($session['cart'])) {
			echo -2;			// ko co session cart
			exit;
			$this->redirect('index');
		}

		$cart_item['qty'] 		= $qty;
		$cart_item['amount'] 	= $amount;
		$cart["key"] 			= $cart_item;
		$session['cart']  		= $cart;
	}

	public function actionAddCart(){
		if(Yii::app()->user->getState('customer_id')=='') {
			echo "-2"; //chua dang nhap
		}
		$id_customer = Yii::app()->user->getState('customer_id');
		$trans = Yii::app()->db->beginTransaction();
    	try {

    		if(!$_POST['name'] || !$_POST['phone']||  !$_POST['address']){
				echo "-1";
				exit; //dien thong tin day du
			}
			
			$cart 	= Yii::app()->session['cart'];
			$addCart = Order::model()->shoppingCart($cart, $_POST['note'],$_POST['name'],$_POST['phone'],$_POST['email'],$_POST['address'],$_POST['sumTotalCart'],$id_customer);
			
			print_r($addCart);
			
			unset(Yii::app()->session['cart']);
			$trans->commit(); 
    	}
    	catch (Exception $e) {
			$trans->rollback();
	  	}
	}

}
