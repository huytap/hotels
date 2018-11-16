<?php
class SpaController extends Controller{
	public $layout = 'main';
	public function actionIndex(){
		try{
			$model = Categoryspa::model()->getList2();
			$this->render('index', compact('model'));
		}catch(Exception $ec){
			$this->render('../site/error');
		}
	}
}