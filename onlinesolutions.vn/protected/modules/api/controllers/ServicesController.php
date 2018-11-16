<?php
class ServicesController extends Controller{

	public function actionIndex($hotel_chain, $hotel_id, $format='json'){

		$formatList = array('json', 'xml');
		if (isset($_GET['format'])) {
			$format = $_GET['format'];
		} else {
			$format = 'json';
		}
		if (!in_array($format, $formatList)) {
			$format = 'json';
		}

		$hotel = Hotel::model()->getByHotelID_ChainID($hotel_id, $hotel_chain);
		
		$arr_rooms = array();

		if($hotel){
			$rooms = Roomtype::model()->getList(0, $hotel['id']);

			foreach($rooms->getData() as $room){
				$row = array();
	        	$description = json_decode($room['description'], true);
	        	$photos = Gallery::model()->getList(1, $hotel['id'], $room['id']);
	            if($photos){
	                $pt = $photos->getData();
	                $row['cover_photo'] = Yii::app()->params['link'].'uploads/slide/' . $pt[0]['name'];
	                foreach($pt as $p){
	                	$row['photos'][] = Yii::app()->params['link'].'uploads/slide/' . $p['name'];
	                }
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
	            $arr_rooms[]=$row;
			}
		}

		if ($format == 'json') {
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($arr_rooms);
		}
		/*if ($format == 'xml') {
			header('Content-type: text/xml; charset=utf-8');
			echo '<users>';
			foreach ($arr_rooms as $student) {
				echo '<user>';
				if (is_array($student)) {
					foreach ($student as $key => $value) {
						echo '<', $key, '>', $value, '</', $key, '>';
					}
				}
				echo '</user>';
			}
			echo '</users>';
		}*/

	}
}
?>