<?php
class DestinationController extends Controller{
	public $layout = 'main';
	public function actionIndex($hotel){
		//try{
			$getHotel = Hotel::model()->getHotelBySlug($hotel);
			$model = Cms::model()->getList('destination', $getHotel['id']);
			$this->render('index', compact(array('model','getHotel')));
		/*}catch(Exception $ec){
			$this->render('../site/error');
		}*/
	}

	public function actionDetail($cms, $cms_slug=''){
		//try{
			$model = Cms::model()->getBySlug($cms_slug);
			$other = Cms::model()->getList($cms);
			$this->render('detail', compact(array('model', 'cms_slug', 'other')));
		/*}catch(Exception $ec){
			$this->render('../site/error');
		}*/
	}
}