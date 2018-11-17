<?php
class CmsController extends Controller{
	public $layout = 'main';
	public function actionIndex($hotel='',$cms){
		//try{
		if($hotel){
			$getHotel = Hotel::model()->getHotelBySlug($hotel);
			$this->pageTitle = Yii::t('lang', ucfirst($cms)) .' | '.$getHotel['name'];
			$model = Cms::model()->getList($cms, $getHotel['id']);
			$this->render('index', compact(array('model', $getHotel)));
		}else{
			$model = Cms::model()->getList($cms, '');
			$this->pageTitle = Yii::t('lang', ucfirst($cms))  .' | Ambassador Hotel Group';
			$this->render('index', compact('model'));
		}		
		/*}catch(Exception $ec){
			$this->render('../site/error');
		}*/
	}

	public function actionDetail($cms, $cms_slug=''){
		//try{
			$lang = Yii::app()->language;
			$model = Cms::model()->getBySlug($cms_slug);
			$title = json_decode($model['title'], true);
			$this->pageTitle =  $title[$lang].' | '.$model->hotel->name;
			$other = Cms::model()->getList($cms);
			$this->render('detail', compact(array('model', 'cms_slug', 'other')));
		/*}catch(Exception $ec){
			$this->render('../site/error');
		}*/
	}

	/*public function actionOther(){
		try{
			$model = Cms::model()->getList('restaurant', '');
			$this->render('other', compact('model'));
		}catch(Exception $ec){
			$this->render('../site/error');
		}	
	}*/
}