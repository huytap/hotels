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
            if(isset($_POST['Tour']['name'])){
                $model->slug = StringHelper::makeLink($_POST['Tour']['name']);
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
            if(isset($_POST['Tour']['name'])){
                $model->slug = StringHelper::makeLink($_POST['Tour']['name']);
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