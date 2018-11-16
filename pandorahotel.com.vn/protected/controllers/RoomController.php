<?php

class RoomController extends Controller{

	public $layout = 'main';

	public function actionIndex($lang){
		try{
			$rooms = Roomtype::model()->getList(0);		
			$this->render('index', compact(array('rooms','model')));
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