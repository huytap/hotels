<?php

class TripController extends AdminController{

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
        $model = new Trip('search');
        $model->unsetAttributes();
        if(isset($_GET['Trip'])){
            $model->attributes = $_GET['Trip'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('admin', compact(array('model')));
    }

    public function actionCreate(){
        $model = new Trip;
        if(isset($_POST['Trip'])){
            $model->attributes = $_POST['Trip'];
            $model->hotel_id = Yii::app()->session['hotel'];
            ExtraHelper::update_tracking_data($model, 'create');
            $model->validate();
            if(!$model->hasErrors() && $model->save()){
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/trip/admin'));
            }
        }
        $this->render('create', compact('model'));
    }

    public function actionUpdate($id){
        $model = $this->loadModel($id);
        if($model['hotel_id'] !== Yii::app()->session['hotel']){
            $this->render('../site/error');
        }else{
            if(isset($_POST['Trip'])){
                $model->attributes = $_POST['Trip'];
                $model->hotel_id = Yii::app()->session['hotel'];
                ExtraHelper::update_tracking_data($model, 'update');
                $model->validate();
                if(!$model->hasErrors() && $model->save()){
                    $this->redirect(Yii::app()->createAbsoluteUrl('admin/trip/admin'));
                }
            }
            $this->render('update', compact('model'));
        }
    }

    public function actionDelete($id){
        $model= $this->loadModel($id);
        if($model->delete()){
            echo json_encode(1);
        }
    }

    public function loadModel($id){
        $model = Trip::model()->findByPk($id);

        return $model;
    }
}