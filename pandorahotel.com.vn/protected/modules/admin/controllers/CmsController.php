<?php

class CmsController extends AdminController{

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
        $model = new Cms('search');
        $model->unsetAttributes();
        if(isset($_GET['Cms'])){
            $model->attributes = $_GET['Cms'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('admin', compact(array('model', 'flag')));
    }

    public function actionCreate(){
        $model = new Cms;
        if(isset($_POST['Cms'])){
            $model->attributes = $_POST['Cms'];
            $model->hotel_id = Yii::app()->session['hotel'];
            if(isset($_POST['Cms']['title']['en'])){
                $model->slug = StringHelper::makeLink($_POST['Cms']['title']['en']);
            }

            $photo = CUploadedFile::getInstance($model, 'cover_photo');

            if($photo !== null){
                $ran = rand(0, 999999999);
                $cover_photo = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($photo->name).'.'.$photo->extensionName;
                $model['cover_photo'] = $cover_photo;
                
            }

            $icon = CUploadedFile::getInstance($model, 'icon');

            if($icon !== null){
                $ran = rand(0, 999999999);
                $cover_icon = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($icon->name).'.'.$icon->extensionName;
                $model['icon'] = $cover_icon;
                
            }

            $languages = Yii::app()->params['language_config'];
            $title = $short = $description = array();
            foreach($languages as $key => $lang){
                if(!$_POST['Cms']['short'][$key]){
                    $short[$key]=$_POST['Cms']['short']['en'];
                }else{
                    $short[$key]=$_POST['Cms']['short'][$key];
                }

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

            if(is_array($short)){
                $model->short = json_encode($short);
            }

            if(is_array($description)){
                $model->description = json_encode($description);
            }

            ExtraHelper::update_tracking_data($model, 'create');
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

                if(isset($cover_icon) && $cover_icon){
                    $icon->saveAs(Yii::app()->basePath . "/../uploads/cover/$cover_icon");
                }

                $this->redirect(Yii::app()->createAbsoluteUrl('admin/cms/admin'));
            }
        }

        if(isset($model)){
            $model->title = json_decode($model->title, true);
            $model->short = json_decode($model->short, true);
            $model->description = json_decode($model->description, true);
        }
        $this->render('create', compact('model'));
    }

    public function actionUpdate($id){
        $model = $this->loadModel($id);
        $old_photo = $model->cover_photo;
        $old_icon = $model->icon;
        if(isset($_POST['Cms'])){
            $model->attributes = $_POST['Cms'];
            $model->hotel_id = Yii::app()->session['hotel'];
            if(isset($_POST['Cms']['title']['en'])){
                $model->slug = StringHelper::makeLink($_POST['Cms']['title']['en']);
            }

            $languages = Yii::app()->params['language_config'];
            $title = $short = $description = array();
            foreach($languages as $key => $lang){
                if(!$_POST['Cms']['short'][$key]){
                    $short[$key]=$_POST['Cms']['short']['en'];
                }else{
                    $short[$key]=$_POST['Cms']['short'][$key];
                }

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

            if(is_array($short)){
                $model->short = json_encode($short);
            }

            if(is_array($description)){
                $model->description = json_encode($description);
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


            $icon = CUploadedFile::getInstance($model, 'icon');

            if($icon !== null){
                $ran = rand(0, 999999999);
                $cover_icon = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($icon->name).'.'.$icon->extensionName;
                $model['icon'] = $cover_icon;
                $icon->saveAs(Yii::app()->basePath . "/../uploads/cover/$cover_icon");
                if($old_icon && file_exists(Yii::app()->basePath . "/../uploads/cover/$old_icon")){
                    unlink(Yii::app()->basePath . "/../uploads/cover/$old_icon");
                }
                
            }else{
                $model->icon = $old_icon;
            }

            ExtraHelper::update_tracking_data($model, 'update');
            $model->validate();
            if(!$model->hasErrors() && $model->save()){
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/cms/admin'));
            }
        }
        if(isset($model)){
            $model->title = json_decode($model->title, true);
            $model->short = json_decode($model->short, true);
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