<?php
class SpecialController extends Controller{
	public $layout = 'main';
	public function actionIndex($hotel=''){
		try{
			$getHotel = Hotel::model()->getHotelBySlug($hotel);
			$model = Offer::model()->getList($getHotel['id']);
			
			$this->render('index', compact(array('model', 'getHotel')));
		}catch(Exception $ec){
			$this->render('../site/error');
		}
	}

	public function actionDetail($hotel, $special, $sp_slug){
		$getHotel = Hotel::model()->getHotelBySlug($hotel);
        $model = Offer::model()->getOther($sp_slug, $getHotel['id']); 
		$data = Offer::model()->getBySlug($sp_slug);
		$this->render('detail', compact(array('model', 'data', 'hotel')));
	}
}