<?php

class ExplorehotelController extends AdminController{

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
        $model = new Explorehotel('search');
        $model->unsetAttributes();
        if(isset($_GET['Explorehotel'])){
            $model->attributes = $_GET['Explorehotel'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('admin', compact(array('model')));
    }

    public function actionCreate(){
        $model = new Explorehotel;
        if(isset($_POST['Explorehotel'])){
            $model->attributes = $_POST['Explorehotel'];

            $photo = CUploadedFile::getInstance($model, 'cover_photo');

            if($photo !== null){
                $ran = rand(0, 999999999);
                $cover_photo = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($photo->name);
                $model['cover_photo'] = $cover_photo;
                $photo->saveAs(Yii::app()->basePath . "/../uploads/cover/$cover_photo");
            }

            $languages = Yii::app()->params['language_config'];
            $title = $text_link = $link = array();
            foreach($languages as $key => $lang){
                if(!$_POST['Explorehotel']['title'][$key]){
                    $title[$key]=$_POST['Explorehotel']['title']['en'];
                }else{
                    $title[$key]=$_POST['Explorehotel']['title'][$key];
                }

                if(!$_POST['Explorehotel']['text_link'][$key]){
                    $text_link[$key]=$_POST['Explorehotel']['text_link']['en'];
                }else{
                    $text_link[$key]=$_POST['Explorehotel']['text_link'][$key];
                }

                if(!$_POST['Explorehotel']['link'][$key]){
                    $link[$key]=$_POST['Explorehotel']['link']['en'];
                }else{
                    $link[$key]=$_POST['Explorehotel']['link'][$key];
                }
            }
            
            if(is_array($text_link)){
                $model->text_link = json_encode($text_link);
            }

            if(is_array($title)){
                $model->title = json_encode($title);
            }

            if(is_array($link)){
                $model->link = json_encode($link);
            }

            ExtraHelper::update_tracking_data($model, 'create');
            $model->validate();
            if(!$model->hasErrors() && $model->save()){
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/explorehotel/admin'));
            }
        }

        if(isset($model)){
            $model->title = json_decode($model->title, true);
        }
        $this->render('create', compact('model'));
    }

    public function actionUpdate($id){
        $model = $this->loadModel($id);
        if($model['hotel_id'] !== Yii::app()->session['hotel']){
            $this->render('../site/error');
        }else{
            $old_photo = $model->cover_photo;
            if(isset($_POST['Explorehotel'])){
                $model->attributes = $_POST['Explorehotel'];

                $languages = Yii::app()->params['language_config'];
                $title = $text_link = $link = array();
                foreach($languages as $key => $lang){
                if(!$_POST['Explorehotel']['title'][$key]){
                    $title[$key]=$_POST['Explorehotel']['title']['en'];
                }else{
                    $title[$key]=$_POST['Explorehotel']['title'][$key];
                }

                if(!$_POST['Explorehotel']['text_link'][$key]){
                    $text_link[$key]=$_POST['Explorehotel']['text_link']['en'];
                }else{
                    $text_link[$key]=$_POST['Explorehotel']['text_link'][$key];
                }

                if(!$_POST['Explorehotel']['link'][$key]){
                    $link[$key]=$_POST['Explorehotel']['link']['en'];
                }else{
                    $link[$key]=$_POST['Explorehotel']['link'][$key];
                }
            }
            
            if(is_array($text_link)){
                $model->text_link = json_encode($text_link);
            }

            if(is_array($title)){
                $model->title = json_encode($title);
            }

            if(is_array($link)){
                $model->link = json_encode($link);
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
                    $this->redirect(Yii::app()->createAbsoluteUrl('admin/explorehotel/admin'));
                }
            }
            if(isset($model)){
                $model->title = json_decode($model->title, true);
            }
            $this->render('update', compact('model'));
        }
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
        $model = Explorehotel::model()->findByPk($id);

        return $model;
    }
}