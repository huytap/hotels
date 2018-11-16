<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex(){
		$this->pageTitle = 'Phát triển Website Đặt Phòng Khách Sạn | Online Reservation System | Hotel Reservation System | Booking Engine | Hotel Booking Engine';
		$this->render('index');
	}
	public function actionBooking(){
		$this->pageTitle = 'Booking Engine - Online Solutions';
        Yii::app()->clientScript->registerMetaTag('Demo Booking Engine của công ty TNHH Online Solutions', 'description');
		$this->render('pages/booking');
	}
	public function actionProject(){
		$this->pageTitle = 'Dự án Booking Engine - Online Solutions';
        Yii::app()->clientScript->registerMetaTag('Demo Booking Engine của công ty TNHH Online Solutions', 'description');
		$this->render('pages/project');
	}
	public function actionAbout(){
		$this->pageTitle = 'Giới thiệu về Booking Engine - Online Solutions';
        Yii::app()->clientScript->registerMetaTag('Tìm kiếm công ty thiết kế website và tích hợp Booking Engine tại Hồ Chí Minh', 'description');
		$this->render('pages/about');
	}
	public function index(){
		$this->layout = false;
        $model = new FormBook;
        $now = date('d-m-Y');
        if(isset($_GET['hotel'])){
	        $params = array(
	            'fromDate' => $now,
	            'toDate' => date('d-m-Y', strtotime("$now +1day")),
	            'adult' => 2,
	            'children' => 0
	        );
	        if(isset($_GET['checkindate']) && 
	            strtotime($_GET['checkindate'])>=strtotime($now)){
	            $params['fromDate'] = $_GET['checkindate'];
	        }

	        if(isset($_GET['checkoutdate']) && 
	            strtotime($_GET['checkoutdate'])>strtotime($now) && 
	            strtotime($_GET['checkoutdate'])>strtotime($params['fromDate'])){
	            $params['toDate'] = $_GET['checkoutdate'];   
	        }

	        if(isset($_GET['adult'])){
	            $params['adult'] = $_GET['adult'];
	        }

	        if(isset($_GET['children'])){
	            $params['children'] = $_GET['children'];
	        }

	        if(!Yii::app()->session['change_currency']){
	            Yii::app()->session['change_currency'] = 'VND';
	        }
	        $list_curr = ExchangeRate::model()->getList2();
	        if(isset($_POST['currency'])){
	            Yii::app()->session['change_currency'] = $_POST['currency'];
	        }elseif(!Yii::app()->session['change_currency']){                    
	            Yii::app()->session['change_currency'] = 'VND';
	        }
	        $change_currency = Yii::app()->session['change_currency'];

			$token = 'b96f65a0aaf2b6c4b71f8b17f525a94ba6bd764a1c78f215939e81ed8c9e6b9a4386d924f7c400e3b71d7da2860950a0e5f65b57e96c8ed97f2d9eb122e8d3fb8e1ca1b9fe9167cf85a06528362b60ece58a33184f572502e4973989e309ea48061f32d5f02cba40290843f0085193b7bac5dc0339373c2bcde7cdc399e3453f';
	        
	        $service_url = 'http://localhost/bk/api/booking';
	        $checkin = date('d M Y');
	        $checkout = date('d M Y', strtotime("$checkin +1day"));

	        $curl_header = array();
	        $curl_header[] = 'apikey: ' . $token;
	        $curl_header[] = 'checkin: '. $params['fromDate'];
	        $curl_header[] = 'checkout: '. $params['toDate'];
	        $curl_header[] = 'adult: '. $params['adult'];
	        $curl_header[] = 'children: '. $params['children'];
	        $curl_header[] = 'currency: '. $change_currency;
	        $curl_header[] = 'hotel: '. $hotel;

	        $curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $service_url);
	        curl_setopt($curl, CURLOPT_HTTPHEADER, $curl_header);
	        $curl_response = curl_exec($curl);
	        echo"<pre>";print_r($curl_response);die;
	        if ($curl_response === false) {
	            $info = curl_getinfo($curl);
	            curl_close($curl);
	            die('error occured during curl exec. Additioanl info: ' . var_export($info));
	        }
	        curl_close($curl);
	        $decoded = json_decode($curl_response);
	        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
	            die('error occured: ' . $decoded->response->errormessage);
	        }
	        echo 'response ok!';
	        var_export($decoded->response);
	    }
		//$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->layout = false;
		
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$this->pageTitle = 'Thông tin liên hệ - Online Solutions';
        Yii::app()->clientScript->registerMetaTag('Liên hệ công ty làm Booking Engine tại Hồ Chí Minh', 'description');
		/*$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}*/
		$this->render('contact');
	}
	public function actionService(){
		$this->render('pages/service');
	}
}