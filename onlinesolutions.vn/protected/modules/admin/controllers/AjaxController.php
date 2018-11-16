<?php
class AjaxController extends AdminController{
	public function filters(){
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            array('booster.filters.BoosterFilter - delete')
        );
    }

    public function actionConfirmcvv(){
        if(isset($_POST['bookingid'])){
            $booking = Bookings::model()->getByShortID($_POST['bookingid']);
            if($booking){
                $booking->confirm_cvv = 1;
                if($booking->update()){
                    echo json_encode(1);
                }else{
                    echo json_encode(0);
                }
            }
        }
    }
    
	public function actionGenerate(){
		if(isset($_POST['flag']) && $_POST['flag']=='generate'){
			$result = ExtraHelper::generateRandomString(256);
			echo json_encode($result);
		}
	}

	public function actionUpdate_photo_order(){
		if(isset($_POST['id']) && isset($_POST['neworder'])){
    		$data = Item::model()->getListByGallery($_POST['gallery']);
    		$itemArray = $_POST['arrItem'];
    		$array=array();
    		if($data && count($data->getData())>0){
    			$i=1;
	    		foreach($data->getData() as $key => $dt){
	    			if($dt->display_order == $_REQUEST['neworder']){
	    				$dt->display_order = $_REQUEST['oldorder'];
	    				if($dt->update()){
	    					echo json_encode(1);
	    				}
	    			}elseif($dt->id ==  $_REQUEST['id']){
	    				$dt->display_order = $_REQUEST['neworder'];
	    				if($dt->update()){
	    					echo json_encode('Ok');
	    				}
	    			}
	    		}
	    	}
    	}
	}
}