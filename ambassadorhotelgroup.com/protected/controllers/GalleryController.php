<?php
class GalleryController extends Controller{
	public function actionIndex($hotel){
		$this->layout = 'main';
		$lang = Yii::app()->language;	
		$getHotel=Hotel::model()->getHotelBySlug($hotel);	
		$this->render('index', compact(array('lang', 'getHotel')));
	}
}