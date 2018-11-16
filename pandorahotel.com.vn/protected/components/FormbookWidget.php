<?php
class FormbookWidget extends CWidget{
	public function run(){
		$model = new FormBook;
		$now = date('Y-m-d');
		$model->checkin = date('j F, Y');
		$model->checkout = date('j F, Y', strtotime("$now + 1day"));

		/*if(isset($_POST['FormBook'])){
			$model->attributes=$_POST['FormBook'];
			$model->validate();
			$params = array();
			if(!$model->hasErrors()){
				$params = $model->getAttributes();
				
				$url = Yii::app()->params['booking'].Yii::app()->session['_lang'].'/search?checkindate='.date('d-m-Y',strtotime(str_replace(',', '', $model['checkin']))).'&checkoutdate='.date('d-m-Y', strtotime(str_replace(',', '', $model['checkout']))).'&adult=' .$model['adult'].'&children='.$model['children'];
				header('Location: '.$url);
			}
		}*/
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
        }

        //$flash = Promotion::model()->getFlash();
        if(isset($_POST['FormBook'])){
        	header("Location:".Yii::app()->baseUrl.'/'.Yii::app()->language.'/contact');
        }
		$this->render('formbook', compact(array('model')));
	}
}