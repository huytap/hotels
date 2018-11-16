<?php
class SpecialController extends Controller{
	public $layout = 'main';
	public function actionIndex(){
		try{
			$model = Offer::model()->getList($special);
			$hotel = Hotel::model()->find();
			$this->render('index', compact(array('model', 'hotel')));
		}catch(Exception $ec){
			$this->render('../site/error');
		}
	}

	public function actionDetail($special, $sp_slug){
		//try{
			/*$model = new FormBook;
			$now = date('Y-m-d');
			$model->checkin = date('j F, Y');
			$model->checkout = date('j F, Y', strtotime("$now + 1day"));

			if(isset($_POST['FormBook'])){
				$model->attributes=$_POST['FormBook'];
				$model->validate();
				$params = array();
				if(!$model->hasErrors()){
					$params = $model->getAttributes();
					$url = Yii::app()->params['booking'].Yii::app()->session['_lang'].'/search?checkindate='.date('d-m-Y',strtotime(str_replace(',', '', $model['checkin']))).'&checkoutdate='.date('d-m-Y', strtotime(str_replace(',', '', $model['checkout']))).'&adult=' .$model['adult'].'&children='.$model['children'];
					if(isset($_POST['promo'])){
						$url .='&promo='.$_POST['promo'];
					}
					 if(isset($_POST['roomtype_id'])){
                        $url .='&roomtype='.$data['roomtype_id'];
                    }
					header('Location: '.$url);die;
				}
			}
			if(isset($_GET['checkindate'])){
	            $model->checkin = $_GET['checkindate'];
	        }

	        if(isset($_GET['checkoutdate'])){
	            $model->checkout = $_GET['checkoutdate'];   
	        }

	        if(isset($_GET['adult'])){
	            $model['adult'] = $_GET['adult'];
	        }

	        if(isset($_GET['children'])){
	            $model['children'] = $_GET['children'];
	        }*/

	        //$flash = Promotion::model()->getFlash();
	        $model = Offer::model()->getOther($sp_slug); 
			$data = Offer::model()->getBySlug($sp_slug);
			$hotel = Hotel::model()->find();
			$this->render('detail', compact(array('model', 'data', 'hotel')));
		/*}catch(Exception $ec){
			$this->render('../site/error');
		}*/	
	}
}