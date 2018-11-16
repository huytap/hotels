<?php

class SiteController extends Controller{

	public $layout = 'main';

	public function actions(){
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionIndex(){
			
			$getHotel = Hotel::model()->getHotelBySlug($hotel);
			$rooms = Roomtype::model()->getList(0, $getHotel['id']);
			//$slider = Gallery::model()->getList(1,$getHotel['id']);
			//$model = Gallery::model()->getList(0);
			$this->render('index', compact(array('getHotel', 'rooms')));
	}

	public function actionError(){
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionContact($cms){
		try{
			$model=new ContactForm;
			$hotel = Hotel::model()->find();
			if(isset($_POST['ContactForm'])){
				$model->attributes=$_POST['ContactForm'];
				if($model->validate()){
		            $subject = 'Contact from website www.pandora.com.vn - ['.$model['first_name'].' ' .$model['last_name'].']';
		            $content = '';
		            $full_name = $model->first_name.' '.$model->last_name;
		            $arr_to=array($hotel['email_sales']=>$hotel['email_sales']);
		            $reply = $model['email'];
		            $output='';
		            $template_file='templates/contact.htm';
		            $result = Yii::app()->mailer->send_email($subject, $template_file, $full_name, $model, $arr_to, array(), $output, $reply);
		            if (!$result) {
		                Yii::app()->user->setFlash('contact','Errors!');
		            }else{
		                Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
		            }
					//$this->refresh();
				}
			}
			$this->render('contact',array('model'=>$model, 'hotel' => $hotel));
		}catch(Exception $ex){
			$this->render('../site/error');
		}
	}

	public function actionAbout(){
		$hotel = Hotel::model()->find();
		$this->render('pages/about', compact('hotel'));
	}
}