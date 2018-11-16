<?php
class RoomController extends Controller{
	public function actionList(){
		$lang = Yii::app()->language;
		$hotel_id='';
		ExtraHelper::_checkAuth($hotel_id);

        $rooms = Roomtype::model()->getList3($hotel_id);
        $arrRoom = array();

        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d', strtotime("$from +29 day"));
        $rates=array();
        if($rooms && count($rooms->getData())>0)
        foreach($rooms->getData() as $room){
        	$row = array();
        	$description = json_decode($room['description'], true);
        	$photos = Gallery::model()->getList(1, $hotel_id, $room['id']);
            if($photos){
                $pt = $photos->getData();
                $row['cover_photo'] = Yii::app()->params['link'].'uploads/slide/' . $pt[0]['name'];
            }
            $price =Roomtype::model()->getPrice($hotel_id, $from_date, $to_date, $room['id']);
        	$row['price'] = ExtraHelper::roundMoney('VND', $price);
        	$row['from_date'] = $from_date;
        	$row['to_date'] = $to_date;
        	$row['name'] = $room['name'];
        	$row['slug'] = $room['slug'];
        	$row['description'] = $description[$lang];
        	$row['hotel_id'] = $room['hotel_id'];
        	$row['hotel_slug'] = $room['hotel']['slug'];
        	$row['hotel'] = $room['hotel']['name'];
        	$amenities = explode(',', $room['amenities']);
        	$amens=array();
            foreach($amenities as $key => $amen){
                $amens[]= ucfirst(Yii::t('lang', $amen));
            }
	    $row['amenities']=$amens;
            $row['no_of_rooms'] = $room['no_of_rooms'];
            $row['max_per_room'] = $room['max_per_room'];
            $row['size_of_room'] = $room['size_of_room'];
            $row['view'] = Yii::t('lang', $room['view']);
            
            $beds = explode(',', $room['bed']);
			$i=0;
			$h_bed='';
            foreach($beds as $bed){
                $h_bed .= Yii::t('lang',$bed);
                if($i<count($beds)-1){
                    $h_bed .= ' '. Yii::t('lang', 'or').' ';
                }
                $i++;
            }
            $row['bed'] = $h_bed;
            $arrRoom[]=$row;
        	//$arrRoom[] = $room->getAttributes();

        }

        //echo"<pre>";prinT_r($arrRoom);die;
        $result = CJSON::encode($arrRoom);
        echo $result;
	}

	public function actionDetail(){
		$lang = Yii::app()->language;
		ExtraHelper::_checkAuth($hotel_id);
		$request = getallheaders();
		$from_date = date('Y-m-d');
        $to_date = date('Y-m-d', strtotime("$from +29 day"));
        $rates=array();
		if(isset($request['room_slug'])){
        	$room = Roomtype::model()->getRoomtypeBySlug($request['room_slug'], $hotel_id);
        	$arrRoom=array();
        	if($room){
	        	$row = array();
	        	$photos = Gallery::model()->getList(1,$hotel_id, $room['id']);
	        	if($photos && count($photos->getData())>0){
	        		$pt = array();
	        		foreach($photos->getData() as $key => $photo){
	        			$pt[$key]['name'] = Yii::app()->params['link'].'uploads/slide/'.$photo['name'];
	        			$pt[$key]['title'] = $photo['title'];
	        		}
	        		$row['cover_photo'] = $pt;
	        	}
	        	
	        	$description = json_decode($room['description'], true);
	        	
	            $price =Roomtype::model()->getPrice($hotel_id, $from_date, $to_date, $room['id']);
	        	$row['price'] = ExtraHelper::roundMoney('VND', $price);
	        	$row['from_date'] = $from_date;
	        	$row['to_date'] = $to_date;
	        	$row['name'] = $room['name'];
	        	$row['slug'] = $room['slug'];
	        	$row['description'] = $description[$lang];
	        	$amenities = explode(',', $room['amenities']);
	        	$amens=array();
	            foreach($amenities as $key => $amen){
	                $amens[]= ucfirst(Yii::t('lang', $amen));
	            }
	            $row['amenities'] = $amens;
	            $row['no_of_rooms'] = $room['no_of_rooms'];
	            $row['max_per_room'] = $room['max_per_room'];
	            $row['size_of_room'] = $room['size_of_room'];
	            $row['view'] = Yii::t('lang', $room['view']);
	            $row['hotel_slug'] = $room['hotel']['slug'];
	            $row['hotel'] = $room['hotel']['name'];
	            $beds = explode(',', $room['bed']);
				$i=0;
				$h_bed='';
	            foreach($beds as $bed){
	                $h_bed .= Yii::t('lang',$bed);
	                if($i<count($beds)-1){
	                    $h_bed .= ' '. Yii::t('lang', 'or').' ';
	                }
	                $i++;
	            }
	            $row['bed'] = $h_bed;
	            $arrRoom=$row;
	        	$arrOther = array();
	        	$others = Roomtype::model()->getListOther($room['id'], $room['hotel_id']);
	        	foreach ($others->getData() as $key => $value) {
	        		$photos = Gallery::model()->getList(1, $hotel_id, $value['id']);
		            if($photos){
		                $pt = $photos->getData();
		                $value['cover_photo'] = Yii::app()->params['link'].'uploads/slide/' . $pt[0]['name'];
		            }

	        		$arrOther[$key] = $value->getAttributes();
	        		$arrOther[$key]['hotel_slug'] = $value['hotel']['slug'];
	            	$arrOther[$key]['hotel'] = $value['hotel']['name'];
	        	}

	        	$result = CJSON::encode(array('detail' => $arrRoom, 'others' => $arrOther));
	        	echo $result;
	        }else{
	        	echo -1;
	        }
        }else{
        	echo 0;
        }
	}
}