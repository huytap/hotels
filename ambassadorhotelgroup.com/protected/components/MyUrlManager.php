<?php
class MyUrlManager extends CUrlManager{

	public $dbTable = 'cms';

	protected function processRules(){
		$j=0;
		$hotels = Yii::app()->db->createCommand()->select('slug')->from('hotels')->where('status=0')->queryAll();
      	foreach ($hotels as $hotel){
         	$hotel_parttern .= $hotel['slug'];
         	if($j<count($hotels)-1){
            	$hotel_parttern .= '|';
         	}
         	$j++;
      	} 

		$this->rules = array(
			'admin' => 'admin/site/login',
			'<lang:'.$lang.'>/<hotel:('.$hotel_parttern.')>/<room:rooms>/<room_slug:\S+>.html' => 'room/detail',
			'<lang:'.$lang.'>/<hotel:('.$hotel_parttern.')>/<cms:gallery>.html' => 'gallery/index',
			'<lang:'.$lang.'>/<hotel:('.$hotel_parttern.')>/about.html' => 'site/about',
			'<lang:'.$lang.'>/<hotel:('.$hotel_parttern.')>/<room:rooms>.html' => 'room/index',
			'<lang:'.$lang.'>/<hotel:('.$hotel_parttern.')>/<special:(special-offers)>.html' => 'special/index',
			'<lang:'.$lang.'>/<hotel:('.$hotel_parttern.')>/<cms:services>/<cms_slug:\S+>.html' => 'cms/detail',
			'<lang:'.$lang.'>/<hotel:('.$hotel_parttern.')>/<cms:services>.html' => 'cms/index',
			'<lang:'.$lang.'>/<hotel:('.$hotel_parttern.')>/destination.html' => 'destination/index',
			'<lang:'.$lang.'>/<cms:services>.html' => 'cms/index',
			'<lang:'.$lang.'>/<hotel:('.$hotel_parttern.')>/<cms:services>.html' => 'cms/index',
			'<lang:'.$lang.'>/<hotel:('.$hotel_parttern.')>.html' => 'site/index',
			'<lang:'.$lang.'>/about.html' => 'site/about',
			'<lang:'.$lang.'>/tours.html' => 'tour/index',
			'<lang:'.$lang.'>/tours/<tour_slug:\S+>.html' => 'tour/detail',
			'' => 'site/index',
			'<lang:'.$lang.'>/<special:(special-offers)>.html' => 'special/index',
			'<lang:'.$lang.'>/<hotel:('.$hotel_parttern.')>/<special:(special-offers)>.html' => 'special/index',
			'<lang:'.$lang.'>/<hotel:('.$hotel_parttern.')>/<special:(special-offers|dining-offer|meeting-event-offer)>/<sp_slug:\S+>.html' => 'special/detail',			
			'<lang:'.$lang.'>' => 'site/index',
			'<lang:'.$lang.'>/<cms:contact>.html' => 'site/contact',
			'<lang:'.$lang.'>/404.html' => 'site/error',
			'<lang:'.$lang.'>/<cms:services>.html' => 'cms/index',
			'<controller:\w+>/<id:\d+>'=>'<controller>/view',
			'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
			'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		);
      	parent::processRules();
	}
}