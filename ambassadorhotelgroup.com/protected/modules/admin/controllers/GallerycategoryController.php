<?php

class GallerycategoryController extends AdminController
{

	public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            array('booster.filters.BoosterFilter - delete')
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>RoleHelper::GetRole(),//array('create','update','admin'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionAdmin(){
		
		$model = new Category('search');
        $model->unsetAttributes();
        if(isset($_GET['Category'])){
            $model->attributes = $_GET['Category'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('admin', compact(array('model')));
	}
	
	public function actionCreate(){
		$model=new Gallerycategory;
		$this->performAjaxValidation($model);
		if(isset($_POST['Gallerycategory'])){
			$model->attributes=$_POST['Gallerycategory'];
			$languages = Yii::app()->params['language_config'];
            $title = $short_content= $full_content=array();

            $model->hotel_id = implode(',', $_POST['Gallerycategory']['hotel_id']);
            
            foreach($languages as $key => $lang){
                if(!isset($_POST['Gallerycategory']['title'][$key])){
                    $title[$key]=$_POST['Gallerycategory']['name']['en'];
                }else{
                    $title[$key]=$_POST['Gallerycategory']['name'][$key];
                }
            }
            $model->slug=ExtraHelper::changeTitle($_POST['Gallerycategory']['name']['en']);
            ExtraHelper::update_tracking_data($model, 'create');
            if(is_array($title)){
                $model->name=json_encode($title);
            }
			if($model->save()){
                $this->redirect(Yii::app()->createUrl('admin/gallerycategory/admin'));
            }

		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id){
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Gallerycategory']))
		{
			$model->attributes=$_POST['Gallerycategory'];
			
			ExtraHelper::update_tracking_data($model, 'update');
			$languages = Yii::app()->params['language_config'];
            $title = $short_content= $full_content=array();
            $model->hotel_id = implode(',', $_POST['Gallerycategory']['hotel_id']);
            foreach($languages as $key => $lang){
                if(!$_POST['Gallerycategory']['name'][$key]){
                    $title[$key]=$_POST['Gallerycategory']['name']['en'];
                }else{
                    $title[$key]=$_POST['Gallerycategory']['name'][$key];
                }
            }
            $model->slug=ExtraHelper::changeTitle($_POST['Gallerycategory']['name']['en']);
            if(is_array($title)){
                $model->name=json_encode($title);
            }
			if($model->save()){
				$this->redirect(Yii::app()->createAbsoluteUrl('admin/gallerycategory/admin'));
			}
		}
		if($model['hotel_id']){
            $model['hotel_id'] = explode(',', $model['hotel_id']);
        }
		$model->name=json_decode($model->name,true);
		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id){
		$model = $this->loadModel($id);
        if($model->delete()){
            echo json_encode(1);
        }
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Gallerycategory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Gallerycategory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Gallerycategory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='nearby-category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
