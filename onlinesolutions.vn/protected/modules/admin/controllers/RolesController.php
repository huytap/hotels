<?php
class RolesController extends AdminController{

	public $layout='//layouts/column2';

	public function filters(){
		return array(
			'accessControl',
			'postOnly + delete',
			//array('booster.filters.BoosterFilter - delete')
		);
	}// function filters
	public function accessRules(){
		return array(
				array('allow',
					'actions'=>RoleHelper::GetRole(),
					'users'=>array('@'),
				),
				array('deny',
					'users'=>array('*'),
				),
		);
	}
	public function actionCreate(){

		$model= new Role();
		if(isset($_POST['Role']))
		{
			$model->attributes=$_POST['Role'];
			$action= $_POST['checkbox'];
			$arr_Role = array();
			if (is_array($action)) {
				foreach($action as $k=>$v){
					$arr=explode("_",$v);
					if (count($arr)>=2) {
						if (!isset($arr_Role[$arr[0]])) {
							 $arr_Role[$arr[0]] = array();
						}
						$arr_Role[$arr[0]][] = $arr[1];
					}
				}
			}
			$bOK = TRUE;
			if(count($arr_Role)<=0){
				$model->addError('GENERAL','Please select the rights');
				$bOK = FALSE;
			} else {
				$right=json_encode($arr_Role);
				$model->access_rights=$right;
			}
			if ($bOK) {
			try{
				if($model->save()){
					ExtraHelper::writeLog('create','Role',$model->getPrimaryKey(), $model->role_name, null, $model);
					$this->redirect(array('roles/admin'));
				}
			}
			catch(Excaption $e){
				$model->addError('GENERAL','Create fail');
			}
		}
		}
		//print_r($model);
		$this->render('create',array('model'=>$model,));
	}// actionCrea
	public function actionUpdate($id){
		$model= new Role();
		$model=$this->loadModel($id);
		$orin=$this->loadModel($id);

		if(isset($_POST['Role']))
		{
			    $model->attributes=$_POST['Role'];
				$action=$_POST['checkbox'];
				$arr_Role = array();
				foreach($action as $k=>$v){
					$arr=explode("_",$v);
					if (count($arr)>=2) {
						if (!isset($arr_Role[$arr[0]])) {
							 $arr_Role[$arr[0]] = array();
					}
						$arr_Role[$arr[0]][] = $arr[1];
					}
				}
				$right=json_encode($arr_Role);
				$model->access_rights=$right;
			try{
				if($model->save())
				{
					ExtraHelper::writeLog('update','Role', $orin->role_name,null, $orin, $model);
					$this->redirect(array('roles/admin'));
				}
			}
			catch(Excaption $e){
				$model->addError('Upldate fail');
			}
		}
		$this->render('update',array('model'=>$model,));
	}// function actionUpdate
	public function actionDelete($id){
		$orin=$this->loadModel($id);
		$model=$this->loadModel($id);
		if($model->delete()){
			ExtraHelper::writeLog('delete','Role',$orin->role_name,null, $orin,null);
			echo CJSON::encode(1);
			return;
		}
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}// actionDelete
	
	public function actionAdmin(){
		$model=new Role('search');

		$model->unsetAttributes();
		if(isset($_GET['Role']))
			$model->attributes=$_GET['Role'];
		if (Yii::app()->getRequest()->getIsAjaxRequest()) {
			header( 'Content-type: application/json' );
			$this->renderPartial('_grid', compact('model'));
			Yii::app()->end();
		}
		//$model = Role::model()->findAll();
		//echo"<pre>";print_r($model->search());die;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionGetActionRole()
	{
		$idModule=Yii::app()->request->getParam('idModel');
		echo $idModule;die();
	}
	public function loadModel($id)
	{
		$model= Role::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Object not found.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param UsersPositions $model the model to be validated
	 */

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-positions-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}// class Role
?>