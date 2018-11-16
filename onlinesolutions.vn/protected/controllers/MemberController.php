<?php
class MemberController extends Controller{
	public function actionLogin(){
		$model = new LoginForm;
		if(isset($_POST['LoginForm'])){
			$model->attributes = $_POST['LoginForm'];
			if($model->validate() && $model->login()){
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		$this->render('login', compact('model'));
	}

	public function actionSignup(){
		$model = new Member;
		if(isset($_POST['Member'])){
			$model->attributes = $_POST['Member'];
			$model->password = sha1(md5($_POST['Member']['password']).'bkengine');
			if(!$model->hasErrors()){
				$model->save();
			}
		}
		$this->render('signup', compact('model'));
	}
}