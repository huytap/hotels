<?php
class HeaderWidget extends CWidget{
	
    public function run() {
    	$user = Users::model()->findByPk(Yii::app()->user->id);
    	if($user){
	        $hotels = Hotel::model()->getListByChain($user['chain_id']);
	        $noti_booking = Bookings::model()->getNotification();
	        $this->render('header', compact(array('hotels', 'user','noti_booking')));
		}else{
			header("Location: ".(Yii::app()->createUrl('admin/site/logout')));
		}
    }
}