<?php

class SettingsController extends AdminController{
    public function filters(){
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            array('booster.filters.BoosterFilter - delete')
        );
    }

    public function accessRules(){
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

    public function actionCreate(){
        $model=new Settings;

        if(isset($_POST['Settings'])){
            $model->attributes=$_POST['Settings'];
            $model->hotel_id = Yii::app()->session['hotel'];
            ExtraHelper::update_tracking_data($model, 'update');
            if($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    public function actionUpdate($id){
        $model=$this->loadModel($id);

        if(isset($_POST['Settings'])){
            $model->attributes=$_POST['Settings'];
            $model->hotel_id = Yii::app()->session['hotel'];
            ExtraHelper::update_tracking_data($model, 'update');

            if(isset($_POST['s_value'])){
                $model->s_value = json_encode($_POST['s_value']);
            }
            if($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    public function actionDelete($id){
        if($this->loadModel($id)->delete()){
            echo json_encode(1);
        }

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionAdmin(){
        $model = new Settings('search');
        $model->unsetAttributes();
        if(isset($_GET['Settings'])){
            $model->attributes = $_GET['Settings'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }
        
        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    public function loadModel($id){
        $model=Settings::model()->findByPk($id);
        $hotel = Hotel::model()->findByPk($model['hotel_id']);
        AdminExtra::checkPermissionHotel(Yii::app()->user->id, $hotel['chain_id']);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model){
        if(isset($_POST['ajax']) && $_POST['ajax']==='system-settings-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
