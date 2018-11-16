<?php

class ChainController extends AdminController{

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
        $model = new Chain('search');
        $model->unsetAttributes();
        if(isset($_GET['Chain'])){
            $model->attributes = $_GET['Chain'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }
        $this->render('admin', compact(array('model', 'flag')));
    }

    public function actionView($id){
        $model = $this->loadModel($id);
        $this->render('view', compact('model'));
    }
    public function actionCreate(){
        $model = new Chain;
        $model->scenario='create';
        if(isset($_POST['Chain'])){
            $model->attributes = $_POST['Chain'];
            ExtraHelper::update_tracking_data($model, 'create');
            $model->validate();
            if(!$model->hasErrors() && $model->save()){
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/chain/admin'));
            }
        }
        $this->render('create', compact('model'));
    }

    public function actionUpdate($id){
        $model = $this->loadModel($id);
        if(isset($_POST['Chain'])){
            $model->attributes = $_POST['Chain'];
            ExtraHelper::update_tracking_data($model, 'update');
            $model->validate();
            if(!$model->hasErrors() && $model->update()){
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/chain/admin'));
            }
        }
        $this->render('update', compact('model'));
    }

    public function actionDelete($id){
        if($this->loadModel($id)->delete()){
            echo json_encode(1);
        }
    }

    public function loadModel($id){
        AdminExtra::checkPermissionHotel(Yii::app()->user->id, $id);
        $model = Chain::model()->findByPk($id);
        return $model;
    }
}