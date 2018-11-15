<?php

class RoomController extends Controller{

	public $layout = 'main';

	public function actionIndex($lang, $hotel){
		try{
			$getHotel = Hotel::model()->getHotelBySlug($hotel);
			$rooms = Roomtype::model()->getList(0, $getHotel['id']);			
			$this->render('index', compact(array('rooms','getHotel')));
		}catch(Exception $ex){
			echo '';
		}
	}

	public function actionDetail($lang,$room_slug){
		$room = Roomtype::model()->getRoomtypeBySlug($room_slug);
		$others = Roomtype::model()->getlistOther($room['id']);
		$this->render('detail', compact(array('room', 'others')));
	}
}?>