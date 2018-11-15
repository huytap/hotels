<?php
class TourController extends Controller{
	public $layout = 'main';
	public function actionIndex(){
		//try{
			$lang = Yii::app()->language;
			$listTour=Tour::model()->getListTour();
			$this->pageTitle = 'Tours | Ambassador Hotel Group';
			$this->render('index', compact('listTour','lang'));
		/*}catch(Exception $ex){
			$this->render('../site/error');
		}*/
	}

	public function actionDetail($tour_slug){
		//try{
			$lang = Yii::app()->language;
			$data=Tour::model()->getTourlBySlug($tour_slug);	
			$title = json_decode($data['name'], true);
			$this->pageTitle = $title[$lang] .' | Ambassador Hotel Grou';
			$otherTour=Tour::model()->getListOrther($data->id);
			$this->render('detail', compact('data','otherTour','hotel','lang'));
		/*}catch(Exception $ex){
			$this->render('../site/error');
		}*/
	}
	public function actionBooktour($tour_slug){
		try{
			$lang = Yii::app()->language;
			$tour=Tour::model()->getTourlBySlug($tour_slug);
			$title = json_decode($tour['name'], true);
			$model=new TourContacts;
			if(isset($_POST['TourContacts'])){
				$model->attributes=$_POST['TourContacts'];
				$model->tour_id = $_POST['TourContacts']['tour_id'];
				if($model->start_date)
					$model->start_date=date('Y-m-d',strtotime($_POST['TourContacts']['start_date']));
				$model->added_date=date('Y-m-d H:i:s');
				if($model->save()){
					if($lang=='en'){
						$lg='';
					}else{
						$lg=$lg.'/';
					}
					$this->redirect(Yii::app()->createAbsoluteUrl($lg.'tour/book-success.html?tour='.$model->id));
				}
			}
			$model->subject = $title[$lang];
			$this->pageTitle = 'Book '.$title[$lang] .' | Ambassador Hotel Grou';
			//$model->number_of_adults=2;
			$this->render('booking',array(
				'model'=>$model,
				'tourid'=>$tour->id,
				'lang' => $lang,
			));
		}catch(Exception $ex){
			$this->render('../site/error');
		}
	}
	public function actionThankyou(){
		//try{
			//$this->layout=false;
			$model=TourContacts::model()->findByPk($_GET['tour']);
			$hotel = Hotel::model()->findByPk($model['hotel']);
			$output = '';
			$arr_cc = array();
			if($hotel){
				$mail = array('grand' => 'concierge.grand@silverlandhotels.com',
								'sakyo' => 'reception.sakyo@silverlandhotels.com',
								'jolie' => 'reception.jolie@silverlandhotels.com',
								'central' => 'tourdesk.central@silverlandhotels.com',
								'sil' => 'reception.sil@silverlandhotels.com',
								'yen' => 'reception.yen@silverlandhotels.com'
				);
				//$arr_cc = array('tourdesk.'.strtolower($hotel['short_name']).'@silverlandhotels.com'=>'Tour Desk');
				if(isset($mail[strtolower($hotel['short_name'])])){
					$arr_cc = array($mail[strtolower($hotel['short_name'])] =>'Tour Desk');
				}
				$subject = 'Book tour via www.silverlandhotels.com - ['.$hotel['name'].']';
			}else{
				$subject = 'Book tour via www.silverlandhotels.com - [Ambassador Hotel Grou]';
			}
            
            $template_file = "template/tour.htm";

            $arr_content = array(
            	'website' => 'https://www.silverlandhotels.com',
            	'logo' => 'logo-d.png',
            	'full_name' => $model->title. '. '.$model->firstname.' ' .$model->lastname,
            	'phone' => $model->phone,
            	'nationality' => ExtraHelper::$country[$model->nationality],
            	'email' => $model->email,
            	'hotel' => $hotel['name'],
            	'departure_date' => ExtraHelper::date_2_show($model->start_date),
            	'adults' => $model->number_of_adults,
            	'children' => $model->number_of_children,
            	'subject' => $model->subject,
            	'special_request' => $model->special_request,
            	'bookingid' => $model->bookingId
            ); 

            $full_name = $model['subject'];

            if($hotel['id']==6){
            	$arr_to = array('reception.yen@silverlandhotels.com' => 'Tour Desk');
            }else{
            	$arr_to = array('tourdesk@silverlandhotels.com' => 'Tour Desk');
            }
            //$arr_to = array('nghuytap@gmail.com' => 'Tap Nguyen');
            
            $email_reply = $model->email;
            $result = Yii::app()->mailer->send_email($subject, $template_file, $full_name, $arr_content, $arr_to, $arr_cc, $output, false);
            if (!$result) {
                Yii::app()->user->setFlash('contact','Errors!');
            }

			$this->render('success',array(
				'model'=>$model
			));
		/*}catch(Exception $ex){
			$this->render('../site/error');
		}*/
	}

	public function actionGetListPrice(){
		// if(isset($_POST['tour'])){
		// 	if(!$_POST['tour'] && Yii::app()->session['_booked']){
		// 		$booked = Yii::app()->session['_booked'];
		// 		unset($booked['tour_name']);
  //               unset($booked['tour_id']);
  //               unset($booked['tour_max_adult']);
  //               unset($booked['tour_price']);
  //               Yii::app()->session['_booked'] = $booked;
		// 	}
		// 	echo json_encode(Tour::model()->getListPriceByTour($_POST['tour']));
		// }
	}
	
}