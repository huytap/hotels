<?php

class UserController extends AdminController{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules(){
		return array(			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => RoleHelper::GetRole(),
				'users' => array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function username_exists($uname) {
		$criteria=new CDbCriteria;
		$criteria->compare('username', $uname, false);
		$dataProvider = new CActiveDataProvider('Users', array(
			'criteria'=>$criteria,
		));
		$dataProvider->setPagination(false);
		$arrTheList = array();
		$arrTheList = $dataProvider->getData();
		if ($arrTheList && count($arrTheList)>0) {
			return $arrTheList[0];
		}
		return FALSE;
	}

	public function actionCreate(){
		$model= new Users('create');
		if(isset($_REQUEST['Users'])){
			$model->attributes=$_POST['Users'];			
			$model->is_admin=1;
			ExtraHelper::update_tracking_data($model, 'create');
			if(!empty($model->password)){
				$model->password = sha1(md5($model->password));
			}
			if (isset($_POST['Users']['roles'])) {
				$model->roles = implode(',', $_POST['Users']['roles']);
			}else{
				$model->roles="user";
			}
			$model->validate();
			if($model->save()){
				$this->redirect(Yii::app()->createUrl('admin/user/admin'));
			}
		}	
		$this->render('create',compact('model'));
	}
	
	public function actionUpdate($id){
		$model = $this->loadModel($id);
		$model->scenario= 'update';
		$old_password=$model->password;
		if(isset($_POST['Users'])){
			$model->attributes = $_POST['Users'];
			$model->is_admin=1;
			ExtraHelper::update_tracking_data($model, 'update');
			if(!empty($model->new_password)){
				$model->password = sha1(md5($model->new_password));
			}else{
				$model->password=$old_password;
			}
			if (isset($_POST['Users']['roles'])) {
				$model->roles = implode(',', $_POST['Users']['roles']);
			}else{
				$model->roles="user";
			}
			$model->validate();
			if(!$model->hasErrors() && $model->save()){
				$this->redirect(Yii::app()->createUrl('admin/user/admin'));
			}
		}
		$this->render('update', compact('model'));
	}

	
	public function actionDelete($id)
	{
		if($this->loadModel($id)->delete()){
			echo CJSON::encode(1);
		}
		else{
			echo CJSON::encode(0);
		}
	}

	public function actionAdmin()
	{
		$model= new Users('search');
		$model->unsetAttributes();
		if(isset($_GET['Users'])){
			$model->attributes=$_GET['Users'];
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }
		$this->render('admin', compact('model'));	
	}

	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
