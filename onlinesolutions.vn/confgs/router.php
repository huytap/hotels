<?php
$language = require_once('language_configs.php');
$lang = '';
$i=0;
var_dump('expression');die;
if(!isset($language[Yii::app()->session['_lang']])){
    $app->session['_lang'] = Yii::app()->language;
    var_dump('expression');die;
}
foreach ($language as $key => $value) {
	$lang .=$key;
	if($i<count($language)-1){
		$lang .= '|';
	}
	$i++;
}
return array(
			'http://admin.aristosaigonhotel.com' => 'admin/site/login',
			'addtocart' => 'ajax/addtobooking',
			'ajax/changeattributes' => 'ajax/changeattributes',
			'ajax/getservices' => 'ajax/getservices',
			'ajax/term' => 'ajax/term',
			'removecart' => 'ajax/removebooking',
			'tracking' => 'bookingtracking/tracking',
			'' => 'site/index',
			'<lang:'.$lang.'>' => 'site/index',
			'<lang:'.$lang.'>/<booking:search>' => 'booking/index',
			'prebook' => 'booking/prebook',
			'<lang:'.$lang.'>/<booking:payment>' => 'booking/payment',
			'<lang:'.$lang.'>/<booking:thankyou>' => 'booking/thankyou',
			'<lang:'.$lang.'>/<room:rooms>/<room_slug:\S+>' => 'room/detail',
			'<lang:'.$lang.'>/<room:rooms>' => 'room/index',
			'<lang:'.$lang.'>/<spa:spa>' => 'spa/index',
			'<lang:'.$lang.'>/<cms:gallery>' => 'gallery/index',
			'<lang:'.$lang.'>/<cms:contact>' => 'site/contact',
			'<lang:'.$lang.'>/404' => 'site/error',
			'<lang:'.$lang.'>/<cms:\S+>' => 'cms/index',			
			
			'<lang:'.$lang.'>/site/recieve' => 'site/recieve',
			'<controller:\w+>/<id:\d+>'=>'<controller>/view',
			'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
			'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		);
?>