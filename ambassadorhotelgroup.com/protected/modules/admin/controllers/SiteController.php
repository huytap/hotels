<?php
class SiteController extends AdminController{
	
	public function actionLogin(){
		if(!isset(Yii::app()->user->id)){
			$this->layout = false;
			$model = new LoginFormAm;
			if(isset($_POST['LoginFormAm'])){
				$model->attributes = $_POST['LoginFormAm'];
				
	            if ($model->validate()) {
		            $this->redirect(Yii::app()->createAbsoluteUrl('admin/default/admin'));
	            }
			}
			$this->render('login',compact('model'));
		}else{
			$this->redirect(Yii::app()->createAbsoluteUrl('admin/default/admin'));
		}
	}

	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->createAbsoluteUrl('/'));
	}

	public function actionError(){
		$this->render('error');
	}
}