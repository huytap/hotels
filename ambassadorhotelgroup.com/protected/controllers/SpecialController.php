<?php
class SpecialController extends Controller{
	public $layout = 'main';
	public function actionIndex($hotel=''){
		try{
			if($hotel){
				$getHotel = Hotel::model()->getHotelBySlug($hotel);
				$model = Offer::model()->getList($getHotel['id']);
				$this->pageTitle = Yii::t('lang', 'Special Offers') .' | ' .$getHotel['name'];
				$this->render('index', compact(array('model', 'getHotel')));
			}else{
				$model = Offer::model()->getList();
				$this->pageTitle = Yii::t('lang', 'Special Offers') .' | Ambassador Hotel Group';
				$this->render('index', compact(array('model')));
			}
		}catch(Exception $ec){
			$this->render('../site/error');
		}
	}

	public function actionDetail($hotel, $special, $sp_slug){
		$getHotel = Hotel::model()->getHotelBySlug($hotel);
        $model = Offer::model()->getOther($sp_slug, $getHotel['id']); 
        $data = Offer::model()->getBySlug($sp_slug);
        $lang = Yii::app()->language;
        $title = json_decode($data['title'], true);
        $this->pageTitle =  $title[$lang].' | ' .$getHotel['name'];
		
		$this->render('detail', compact(array('model', 'data', 'hotel')));
	}
}