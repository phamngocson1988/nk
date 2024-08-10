<?php

class ShoppingController extends HController
{
	public $layout = '//layouts/home_col1';
	public $pageOgTitles	= '';
   	public $pageOgImg 		= '';
   	public $pageOgDes 		= '';
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
		$page=isset($_GET['page'])?$_GET['page']:1;
		$products = Product::model()->findAll();
		$limit=12;
		$count=count($products);
		$pager=$this->findPages($count,$limit);
		$vt=$this->findStart($limit);
		$curpage=$_GET["page"];
		$lst=$this->pageList($curpage,$pager);
		$product=Product::model()->findAllByAttributes(array(),array('limit' => $limit,'offset' =>$vt));
		$this->render('index',array('product' => $product,'lst'=>$lst));
	}


	public function actionSearchTypeProduct(){
		if(isset($_POST['type']) && isset($_POST['curpage']))
		{	$lang = $_POST['lang'];
			$search_type = isset($_POST['type'])?$_POST['type']:'';
			$curpage = $_POST['curpage'];
			$id_product_line = $_POST['id_product_line'];
			$p = new Product;
			$limit=12;
			$t = new CDbCriteria(array('condition'=>'published="true"'));
			$n = new CDbCriteria();
			$n->addCondition('status_product >= 0');

			if($id_product_line){
				$n->addCondition('t.id_product_line = :id_product_line');
				$n->params = array(':id_product_line' => $id_product_line);
			}

			$t->mergeWith($n);
       		$count=$search_type==0?count($p->findAll($n)):count($p->findAll($n));
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
			$product=Product::model()->search_product_web($curpage,$search_type,$id_product_line);
			$this->renderPartial('listproduct',array('product' => $product,'lst'=>$lst,'lang'=>$lang));
		}
		
	}
	public function actionLamSach()
	{
		$this->render('lamsach');
	}

	public function actionChamSocRang()
	{
		$this->render('lamtrang');
	}
	
	public function actionChiNhaKhoa()
	{
		$this->render('chinhakhoa');
	}
	
	
	public function actionSanPhamKhac()
	{
		$this->render('sanphamkhac');
	}
	public function actionDetailProduct($title,$id,$lang)
	{
		//share faceboook	
			$data_face = Product::model()->findByPK($id);
			$data_img  = ProductImage::model()->findByAttributes(array('id_product'=>$id));
			if($data_img){
				$this->pageOgImg 		= Yii::app()->params['url_base_http']."/upload/product_image/lg/".$data_img->name_upload;
			}
			if($lang=='vi'){
				$this->pageOgTitles = $data_face->name;
			}else{
				$this->pageOgTitles = $data_face->name_en;
			}
		//end share faceboook
		
		$list = Product::model()->findByPK($id);
		$this->render('deail_product', array('list'=>$list));
	}
	
	
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