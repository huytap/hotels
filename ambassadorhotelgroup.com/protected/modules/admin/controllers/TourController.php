<?php

class TourController extends AdminController{

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
        $model = new Tour('search');
        $model->unsetAttributes();
        if(isset($_GET['Tour'])){
            $model->attributes = $_GET['Tour'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('admin', compact(array('model', 'flag')));
    }

    public function actionCreate(){
        $model = new Tour;
        if(isset($_POST['Tour'])){
            $model->attributes = $_POST['Tour'];
            $languages = Yii::app()->params['language_config'];
            $name = $short_description= $full_description=array();
            foreach($languages as $key => $lang){
                if(!$_POST['Tour']['name'][$key]){
                    $name[$key]=$_POST['Tour']['name']['en'];
                }else{
                    $name[$key]=$_POST['Tour']['name'][$key];
                }
                if(!$_POST['Tour']['short_description'][$key]){
                    $short_description[$key]=$_POST['Tour']['short_description']['en'];
                }else{
                    $short_description[$key]=$_POST['Tour']['short_description'][$key];
                }
                if(!$_POST['Tour']['full_description'][$key]){
                    $full_description[$key]=$_POST['Tour']['full_description']['en'];
                }else{
                    $full_description[$key]=$_POST['Tour']['full_description'][$key];
                }
            }
            $model->slug=ExtraHelper::changeTitle($_POST['Tour']['name']['en']);
            if(is_array($name)){
                $model->name=json_encode($name);
            }
            if(is_array($short_description)){
                $model->short_description=json_encode($short_description);
            }
            if(is_array($full_description)){
                $model->full_description=json_encode($full_description);
            }

            $photo = CUploadedFile::getInstance($model, 'cover_photo');

            if($photo !== null){
                $ran = rand(0, 999999999);
                $cover_photo = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($photo->name);
                $model['cover_photo'] = $cover_photo;
                $photo->saveAs(Yii::app()->basePath . "/../uploads/cover/$cover_photo");
            }

            ExtraHelper::update_tracking_data($model, 'create');
            $model->validate();
            if(!$model->hasErrors() && $model->save()){
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/tour/admin'));
            }
        }
        $this->render('create', compact('model'));
    }

    public function actionUpdate($id){
        $model = $this->loadModel($id);
        $old_photo = $model->cover_photo;
        if(isset($_POST['Tour'])){
            $model->attributes = $_POST['Tour'];
            $languages = Yii::app()->params['language_config'];
            $name = $short_description= $full_description=array();
            foreach($languages as $key => $lang){
                if(!$_POST['Tour']['name'][$key]){
                    $name[$key]=$_POST['Tour']['name']['en'];
                }else{
                    $name[$key]=$_POST['Tour']['name'][$key];
                }
                if(!$_POST['Tour']['short_description'][$key]){
                    $short_description[$key]=$_POST['Tour']['short_description']['en'];
                }else{
                    $short_description[$key]=$_POST['Tour']['short_description'][$key];
                }
                if(!$_POST['Tour']['full_description'][$key]){
                    $full_description[$key]=$_POST['Tour']['full_description']['en'];
                }else{
                    $full_description[$key]=$_POST['Tour']['full_description'][$key];
                }
            }
            $model->slug=ExtraHelper::changeTitle($_POST['Tour']['name']['en']);
            if(is_array($name)){
                $model->name=json_encode($name);
            }
            if(is_array($short_description)){
                $model->short_description=json_encode($short_description);
            }
            if(is_array($full_description)){
                $model->full_description=json_encode($full_description);
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
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/tour/admin'));
            }
        }
        $model->name=json_decode($model->name,true);
        $model->short_description=json_decode($model->short_description,true);
        $model->full_description=json_decode($model->full_description,true);
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
        $model = Tour::model()->findByPk($id);

        return $model;
    }
}