<?php
class AjaxController extends AdminController{
	public function actionUpdate_photo_order(){
		if(isset($_REQUEST['id']) && isset($_REQUEST['neworder'])){
    		$data = Item::model()->getListByGallery($_REQUEST['gallery']);
    		$itemArray = $_REQUEST['arrItem'];

    		$array=array();
    		if(count($data->getData())>0){
    			$i=1;
	    		foreach($data->getData() as $key => $dt){
	    			$dt->thumb_nails=0;
	    			$dt->display_order = $itemArray[$dt->id];
	    			if($itemArray[$dt->id]=1){
	    				$dt->thumb_nails = 1;
	    			}
	    			$dt->update();
	    			/*if($dt->id !== $_REQUEST['id']){
		    			if($_REQUEST['neworder'] < $_REQUEST['oldorder']){
		    				if(($key+1)<$_REQUEST['oldorder'] && ($key+1)>=$_REQUEST['neworder']){
		    					$dt->display_order=($_REQUEST['neworder']+$key+1);
		    					$dt->update();
		    				}
		    			}else{
		    				if(($key+1)<=$_REQUEST['neworder'] && ($key+1) > $_REQUEST['oldorder']){
		    					$dt->display_order = $key;

		    					if($dt->update()){
		    						
		    					}
		    				}
		    			}
		    		}else{
	    				$dt->display_order=$_REQUEST['neworder'];
	    				$dt->update();
	    			}*/
	    		}
	    	}
	    	/*$first = Item::model()->getFirstItem($_REQUEST['gallery']);
	    	$first->thumb_nails=1;
	    	$first->update();*/
    		echo json_encode(1);
    	}
	}
}