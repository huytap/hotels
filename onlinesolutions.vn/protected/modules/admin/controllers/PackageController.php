<?php

class PackageController extends AdminController{

    public function filters(){
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            array('booster.filters.BoosterFilter - delete')
        );
    }

    public function accessRules(){
        return array(
            array(
                'allow',
                'actions'=>RoleHelper::GetRole(),//array('create','update','admin'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionAdmin(){
        $model = new Package('search');
        $model->unsetAttributes();
        if(isset($_GET['Package'])){
            $model->attributes = $_GET['Package'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }
        $this->render('admin', compact(array('model', 'flag')));
    }

    public function actionCreate(){
        $model = new Package;
        if(isset($_POST['Package'])){
            $model->attributes = $_POST['Package'];
            //$model->slug = ExtraHelper::makeLinkToSlug(strip_tags($model->name));
            $from_date = ExtraHelper::date_2_save($model->from_date);
            $to_date = ExtraHelper::date_2_save($model->to_date);
            $model->from_date = $from_date["date"];
            $model->to_date = $to_date["date"];
            
            $languages = Yii::app()->params['language_config'];
            $short_desc = $full_desc = array();
            foreach($languages as $key => $lang){
                if(!$_POST['Package']['short_description'][$key]){
                    $short_desc[$key] = $_POST['Package']['short_description']['en'];
                }else{
                    $short_desc[$key] = $_POST['Package']['short_description'][$key];
                }

                if(!$_POST['Package']['full_description'][$key]){
                    $city[$key]=$_POST['Package']['full_description']['en'];
                }else{
                    $city[$key]=$_POST['Package']['full_description'][$key];
                }
            }

            if(is_array($short_desc)){
                $model->short_description = json_encode($short_desc);
            }
            if(is_array($full_desc)){
                $model->full_description = json_encode($full_desc);
            }

            $cover_photo = CUploadedFile::getInstance($model, 'cover_photo');
            $string = '';
            if($cover_photo !== null){
                $ran = rand(0, 999999999);
                $string = $cover_photo->name;
                $model['cover_photo'] = $string;
            }

            ExtraHelper::update_tracking_data($model, 'create');
            $model->validate();
            if(!$model->hasErrors() && $model->save()){
                if($cover_photo){
                    $cover_photo->saveAs(Yii::app()->basePath . "/../uploads/cover/$string");
                }
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/package/admin'));
            }
        }
        $model->from_date = ExtraHelper::date_2_show($model->from_date);
        $model->to_date = ExtraHelper::date_2_show($model->to_date);

        if($model->short_description){
            $model->short_description = json_decode($model->short_description, true);
        }
        if($model->full_description){
            $model->full_description = json_decode($model->full_description, true);
        }
        $this->render('create', compact('model'));
    }

    public function actionUpdate($id){
        $model = $this->loadModel($id);
        $old_cover = $model['cover_photo'];
        if(isset($_POST['Package'])){
            $model->attributes = $_POST['Package'];
            $model->hotel_id = Yii::app()->session['hotel'];
            //$model->slug = ExtraHelper::makeLinkToSlug(strip_tags($model->name));
            $from_date = ExtraHelper::date_2_save($model->from_date);
            $to_date = ExtraHelper::date_2_save($model->to_date);
            $model->from_date = $from_date["date"];
            $model->to_date = $to_date["date"];

            $languages = Yii::app()->params['language_config'];
            $short_desc = $full_desc = array();
            foreach($languages as $key => $lang){
                if(!$_POST['Package']['short_description'][$key]){
                    $short_desc[$key] = $_POST['Package']['short_description']['en'];
                }else{
                    $short_desc[$key] = $_POST['Package']['short_description'][$key];
                }

                if(!$_POST['Package']['full_description'][$key]){
                    $full_desc[$key]=$_POST['Package']['full_description']['en'];
                }else{
                    $full_desc[$key]=$_POST['Package']['full_description'][$key];
                }
            }

            if(is_array($short_desc)){
                $model->short_description = json_encode($short_desc);
            }
            if(is_array($full_desc)){
                $model->full_description = json_encode($full_desc);
            }

            $cover_photo = CUploadedFile::getInstance($model, 'cover_photo');
            $string = '';
            if($cover_photo !== null){
                $ran = rand(0, 999999999);
                $string = $cover_photo->name;
                $model['cover_photo'] = $string;
            }else{
                $model->cover_photo = $old_cover;
            }

            ExtraHelper::update_tracking_data($model, 'update');
            $model->validate();
            
            if(!$model->hasErrors() && $model->save()){
                if($cover_photo){
                    $cover_photo->saveAs(Yii::app()->basePath . "/../uploads/cover/$string");
                }
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/package/admin'));
            }
        }
        $model->from_date = ExtraHelper::date_2_show($model->from_date);
        $model->to_date = ExtraHelper::date_2_show($model->to_date);

        if($model->short_description){
            $model->short_description = json_decode($model->short_description, true);
        }
        if($model->full_description){
            $model->full_description = json_decode($model->full_description, true);
        }
        $this->render('update', compact('model'));
    }

    public function actionDelete($id){
        if($this->loadModel($id)->delete()){
            echo json_encode(1);
        }
    }

    public function loadModel($id){
        $model = Package::model()->findByPk($id);
        $hotel = Hotel::model()->findByPk($model['hotel_id']);
        //AdminExtra::checkPermissionHotel(Yii::app()->user->id, $hotel['chain_id']);
        return $model;
    }
}