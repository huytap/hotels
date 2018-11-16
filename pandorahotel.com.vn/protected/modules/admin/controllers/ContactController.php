<?php

class ContactController extends AdminController{

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

    public function actionCustomer(){
    	$model = new Customer('search');
        $model->unsetAttributes();

        if(isset($_GET['Contact'])){
            $model->attributes = $_GET['Contact'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid_customer', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('customer', compact('model'));
    }

    public function actionAdmin(){
        $model = new Contact('search');
        $model->unsetAttributes();
        if(isset($_GET['Contact'])){
            $model->attributes = $_GET['Contact'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('admin', compact(array('model')));
    }

    public function actionCreate(){
        $model = new Cms;
        if(isset($_POST['Cms'])){
            $model->attributes = $_POST['Cms'];
            if(isset($_POST['Cms']['title']['en'])){
                $model->slug = StringHelper::makeLink($_POST['Cms']['title']['en']);
            }

            $photo = CUploadedFile::getInstance($model, 'cover_photo');

            if($photo !== null){
                $ran = rand(0, 999999999);
                $cover_photo = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($photo->name);
                $model['cover_photo'] = $cover_photo;
                $photo->saveAs(Yii::app()->basePath . "/../uploads/cover/$cover_photo");
            }

            $languages = Yii::app()->params['language_config'];
            $title = $description = array();
            foreach($languages as $key => $lang){
                if(!$_POST['Cms']['description'][$key]){
                    $description[$key]=$_POST['Cms']['description']['en'];
                }else{
                    $description[$key]=$_POST['Cms']['description'][$key];
                }

                if(!$_POST['Cms']['title'][$key]){
                    $title[$key]=$_POST['Cms']['title']['en'];
                }else{
                    $title[$key]=$_POST['Cms']['title'][$key];
                }
            }
            
            if(is_array($title)){
                $model->title = json_encode($title);
            }

            if(is_array($description)){
                $model->description = json_encode($description);
            }

            ExtraHelper::update_tracking_data($model, 'create');
            $model->validate();
            if(!$model->hasErrors() && $model->save()){
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/cms/admin'));
            }
        }

        if(isset($model)){
            $model->title = json_decode($model->title, true);
            $model->description = json_decode($model->description, true);
        }
        $this->render('create', compact('model'));
    }

    public function actionUpdate($id){
        $model = $this->loadModel($id);
        $old_photo = $model->cover_photo;
        if(isset($_POST['Cms'])){
            $model->attributes = $_POST['Cms'];
            if(isset($_POST['Cms']['title']['en'])){
                $model->slug = StringHelper::makeLink($_POST['Cms']['title']['en']);
            }

            $languages = Yii::app()->params['language_config'];
            $title = $description = array();
            foreach($languages as $key => $lang){
                if(!$_POST['Cms']['description'][$key]){
                    $description[$key]=$_POST['Cms']['description']['en'];
                }else{
                    $description[$key]=$_POST['Cms']['description'][$key];
                }

                if(!$_POST['Cms']['title'][$key]){
                    $title[$key]=$_POST['Cms']['title']['en'];
                }else{
                    $title[$key]=$_POST['Cms']['title'][$key];
                }
            }
            
            if(is_array($title)){
                $model->title = json_encode($title);
            }

            if(is_array($description)){
                $model->description = json_encode($description);
            }

            $photo = CUploadedFile::getInstance($model, 'cover_photo');

            if($photo !== null){
                $ran = rand(0, 999999999);
                $cover_photo = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($photo->name);
                $model['cover_photo'] = $cover_photo;
                $photo->saveAs(Yii::app()->basePath . "/../uploads/cover/$cover_photo");
                if($old_photo && file_exists(Yii::app()->basePath . "/../uploads/cover/$old_photo")){
                    unlink(Yii::app()->basePath . "/../uploads/cover/$old_photo");
                }
            }else{
                $model->cover_photo = $old_photo;
            }

            ExtraHelper::update_tracking_data($model, 'update');
            $model->validate();
            if(!$model->hasErrors() && $model->save()){
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/cms/admin'));
            }
        }
        if(isset($model)){
            $model->title = json_decode($model->title, true);
            $model->description = json_decode($model->description, true);
        }
        $this->render('update', compact('model'));
    }

    public function actionDelete($id){
        $model= $this->loadModel($id);
        $old_photo = $model->cover_photo;
        if($model->delete()){
            if($old_photo && file_exists(Yii::app()->basePath . "/../uploads/cover/$old_photo")){
                unlink(Yii::app()->basePath . "/../uploads/cover/$old_photo");
            }
            echo json_encode(1);
        }
    }

    public function loadModel($id){
        $model = Cms::model()->findByPk($id);

        return $model;
    }
}