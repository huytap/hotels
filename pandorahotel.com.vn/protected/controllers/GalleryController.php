<?php
class GalleryController extends Controller{
	public function actionIndex(){
		$this->layout = 'main';
		$lang = Yii::app()->language;		
		$this->render('index', compact(array('lang')));
	}
}