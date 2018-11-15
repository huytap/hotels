<?php

class CategoryspaController extends AdminController{

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
        $model = new Categoryspa('search');
        $model->unsetAttributes();
        if(isset($_GET['Categoryspa'])){
            $model->attributes = $_GET['Categoryspa'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('admin', compact(array('model', 'flag')));
    }

    public function actionCreate(){
        $model = new Categoryspa;
        if(isset($_POST['Categoryspa'])){
            $model->attributes = $_POST['Categoryspa'];
            $model->hotel_id = Yii::app()->session['hotel'];
            $languages = Yii::app()->params['language_config'];
            $title = array();
            foreach($languages as $key => $lang){
                if(!$_POST['Categoryspa']['name']['en']){
                    $title[$key]=$_POST['Cms']['name']['en'];
                }else{
                    $title[$key]=$_POST['Categoryspa']['name']['en'];
                }
            }
            
            if(is_array($title)){
                $model->name = json_encode($title);
            }

            ExtraHelper::update_tracking_data($model, 'create');
            $model->validate();
            if(!$model->hasErrors() && $model->save()){
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/categoryspa/admin'));
            }
        }

        if(isset($model)){
            $model->name = json_decode($model->name, true);
        }
        $this->render('create', compact('model'));
    }

    public function actionUpdate($id){
        $model = $this->loadModel($id);
        if(isset($_POST['Categoryspa'])){
            $model->attributes = $_POST['Categoryspa'];
            $model->hotel_id = Yii::app()->session['hotel'];
            $languages = Yii::app()->params['language_config'];
            $title = array();
            foreach($languages as $key => $lang){
                if(!$_POST['Categoryspa']['name']['en']){
                    $title[$key]=$_POST['Categoryspa']['name']['en'];
                }else{
                    $title[$key]=$_POST['Categoryspa']['name']['en'];
                }
            }
            
            if(is_array($title)){
                $model->name = json_encode($title);
            }

            ExtraHelper::update_tracking_data($model, 'update');
            $model->validate();
            if(!$model->hasErrors() && $model->save()){
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/categoryspa/admin'));
            }
        }
        if(isset($model)){
            $model->name = json_decode($model->name, true);
        }
        $this->render('update', compact('model'));
    }

    public function actionDelete($id){
        $model= $this->loadModel($id);
        if($model->delete()){
            echo json_encode(1);
        }
    }

    public function loadModel($id){
        $model = Categoryspa::model()->findByPk($id);

        return $model;
    }
}