<?php

class SpecialController extends AdminController{

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
        $model = new Offer('search');
        $model->unsetAttributes();
        if(isset($_GET['Offer'])){
            $model->attributes = $_GET['Offer'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('admin', compact(array('model', 'flag')));
    }

    public function actionCreate(){
        $model = new Offer;
        if(isset($_POST['Offer'])){
            $model->attributes = $_POST['Offer'];
            if(isset($_POST['Offer']['title']['en'])){
                $model->slug = StringHelper::makeLink($_POST['Offer']['title']['en']);
            }

            $photo = CUploadedFile::getInstance($model, 'cover_photo');

            if($photo !== null){
                $ran = rand(0, 999999999);
                $cover_photo = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($photo->name).'.'.$photo->extensionName;
                $model['cover_photo'] = $cover_photo;
                
            }

            $languages = Yii::app()->params['language_config'];
            $title = $description = $short = array();
            foreach($languages as $key => $lang){
                if(!$_POST['Offer']['description'][$key]){
                    $description[$key]=$_POST['Offer']['description']['en'];
                }else{
                    $description[$key]=$_POST['Offer']['description'][$key];
                }

                if(!$_POST['Offer']['short_description'][$key]){
                    $short[$key]=$_POST['Offer']['short_description']['en'];
                }else{
                    $short[$key]=$_POST['Offer']['short_description'][$key];
                }

                if(!$_POST['Offer']['title'][$key]){
                    $title[$key]=$_POST['Offer']['title']['en'];
                }else{
                    $title[$key]=$_POST['Offer']['title'][$key];
                }
            }
            
            if(is_array($title)){
                $model->title = json_encode($title);
            }

            if(is_array($description)){
                $model->description = json_encode($description);
            }

            if(is_array($short)){
                $model->short_description = json_encode($short);
            }

            $model->validate();
            if(!$model->hasErrors() && $model->save()){

                if(!is_dir(Yii::app()->basePath . '/../uploads')){
                    mkdir(Yii::app()->basePath . '/../uploads');
                }
                if(!is_dir(Yii::app()->basePath . '/../uploads/cover')){
                    mkdir(Yii::app()->basePath . '/../uploads/cover');
                }
                if(isset($cover_photo) && $cover_photo){
                    $photo->saveAs(Yii::app()->basePath . "/../uploads/cover/$cover_photo");
                }

                $this->redirect(Yii::app()->createAbsoluteUrl('admin/special/admin'));
            }
        }

        if(isset($model)){
            $model->title = json_decode($model->title, true);
            $model->description = json_decode($model->description, true);
            $model->short_description = json_decode($model->short_description, true);
        }
        $this->render('create', compact('model'));
    }

    public function actionUpdate($id){
        $model = $this->loadModel($id);
        $old_photo = $model->cover_photo;
        if(isset($_POST['Offer'])){
            $model->attributes = $_POST['Offer'];
            if(isset($_POST['Offer']['title']['en'])){
                $model->slug = StringHelper::makeLink($_POST['Offer']['title']['en']);
            }

            $languages = Yii::app()->params['language_config'];
            $title = $description = $short = array();
            foreach($languages as $key => $lang){
                if(!$_POST['Offer']['description'][$key]){
                    $description[$key]=$_POST['Offer']['description']['en'];
                }else{
                    $description[$key]=$_POST['Offer']['description'][$key];
                }

                if(!$_POST['Offer']['short_description'][$key]){
                    $short[$key]=$_POST['Offer']['short_description']['en'];
                }else{
                    $short[$key]=$_POST['Offer']['short_description'][$key];
                }

                if(!$_POST['Offer']['title'][$key]){
                    $title[$key]=$_POST['Offer']['title']['en'];
                }else{
                    $title[$key]=$_POST['Offer']['title'][$key];
                }
            }
            
            if(is_array($title)){
                $model->title = json_encode($title);
            }

            if(is_array($description)){
                $model->description = json_encode($description);
            }

            if(is_array($short)){
                $model->short_description = json_encode($short);
            }

            $photo = CUploadedFile::getInstance($model, 'cover_photo');

            if($photo !== null){
                $ran = rand(0, 999999999);
                $cover_photo = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($photo->name).'.'.$photo->extensionName;
                $model['cover_photo'] = $cover_photo;
                $photo->saveAs(Yii::app()->basePath . "/../uploads/cover/$cover_photo");
                if($old_photo && file_exists(Yii::app()->basePath . "/../uploads/cover/$old_photo")){
                    unlink(Yii::app()->basePath . "/../uploads/cover/$old_photo");
                }
            }else{
                $model->cover_photo = $old_photo;
            }

            $model->validate();
            if(!$model->hasErrors() && $model->save()){
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/special/admin'));
            }
        }
        if(isset($model)){
            $model->title = json_decode($model->title, true);
            $model->description = json_decode($model->description, true);
            $model->short_description = json_decode($model->short_description, true);
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
        $model = Offer::model()->findByPk($id);

        return $model;
    }
}