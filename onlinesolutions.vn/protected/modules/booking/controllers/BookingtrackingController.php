<?php
class BookingtrackingController extends Controller{
	public function actionTracking(){
        var_dump('expression');die;
        if(isset($_POST['fromDate']) && isset($_POST['toDate'])){
            $checkin=$_POST['fromDate'];
            $checkout=$_POST['toDate'];
            $ip=$_SERVER['REMOTE_ADDR'];
            //$hotel=Yii::app()->session['hotel'];
            $hotel=1;
            $date=date('d-m-Y H:m:i');
            $check = BookingTracking::model()->check($ip,$checkin, $checkout, $hotel);
            if(!$check){
                $tracking=new BookingTracking;
                $tracking->ip_address=$ip;
                $tracking->checkin=$checkin;
                $tracking->checkout=$checkout;
                $tracking->added_date=$date;
                $tracking->hotel=$hotel;
                if($tracking->save()){
                    echo json_encode(1);
                }
            }else{
                echo json_encode(0);
            }
        }
    }
}