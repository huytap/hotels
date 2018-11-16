<?php

class RoomtypeController extends AdminController{

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
        $model = new Roomtype('search');

        $model->unsetAttributes();
        if(isset($_GET['Roomtype'])){
            $model->attributes = $_GET['Roomtype'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('admin', compact('model'));
    }

    public function actionCreate(){
        //try{
            $model = new Roomtype();
            $uploadPath = Yii::app()->basePath . '/../uploads/roomtype/';
            if (isset($_POST['Roomtype'])) {
                $model->attributes = $_POST['Roomtype'];
                $model->slug = StringHelper::makeLink($model->name);
                $model->hotel_id = Yii::app()->session['hotel'];
                ExtraHelper::update_tracking_data($model, 'create');
                

                $languages = Yii::app()->params['language_config'];
                $description = array();
                foreach($languages as $key => $lang){
                    if(!$_POST['Roomtype']['description'][$key]){
                        $description[$key]=$_POST['Roomtype']['description']['en'];
                    }else{
                        $description[$key]=$_POST['Roomtype']['description'][$key];
                    }
                }

                if(is_array($description)){
                    $model->description = json_encode($description);
                }


                if($_POST['Roomtype']['amenities'] !== ''){
                    $model->amenities = implode(',', $_POST['Roomtype']['amenities']);    
                }
                if($_POST['Roomtype']['bed'] !== ''){
                    $model->bed = implode(',', $_POST['Roomtype']['bed']);
                }
                
                $photo = CUploadedFile::getInstance($model, 'cover_photo');

                if($photo !== null){
                    $ran = rand(0, 999999999);
                    $cover_photo = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($photo->name).'.'.$photo->extensionName;
                    $model['cover_photo'] = $cover_photo;
                    
                }
                

                if($model->save()){
                    if(!is_dir(Yii::app()->basePath . '/../uploads')){
                        mkdir(Yii::app()->basePath . '/../uploads');
                    }
                    if(!is_dir(Yii::app()->basePath . '/../uploads/cover')){
                        mkdir(Yii::app()->basePath . '/../uploads/cover');
                    }
                    if(isset($cover_photo) && $cover_photo){
                        $photo->saveAs(Yii::app()->basePath . "/../uploads/cover/$cover_photo");
                    }
                    $this->redirect(Yii::app()->createUrl('admin/roomtype/admin'));
                }
            }

            if($model){
                $model->description = json_decode($model->description, true);
                $model->amenities = explode(',', $model->amenities);
                $model->bed = explode(',',$model->bed);
            }

            return $this->render('create', compact('model'));
        /*}catch(Exception $ex){
            Yii::log("Invalid request. Please do not repeat this request again.");
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }*/
    }

    public function actionUpdate($id){
        try{
            $uploadPath = Yii::app()->basePath .'/../uploads/roomtype/';
            $model = $this->loadModel($id);
            $old_photo = $model->cover_photo;
            if (isset($_POST['Roomtype'])) {
                $model->attributes = $_POST['Roomtype'];
                $model->slug = StringHelper::makeLink($model->name);
                $model->hotel_id = Yii::app()->session['hotel'];
                
                $languages = Yii::app()->params['language_config'];
                $description = array();
                foreach($languages as $key => $lang){
                    if(!$_POST['Roomtype']['description'][$key]){
                        $description[$key]=$_POST['Roomtype']['description']['en'];
                    }else{
                        $description[$key]=$_POST['Roomtype']['description'][$key];
                    }
                }
                
                if(is_array($description)){
                    $model->description = json_encode($description);
                }

                if(isset($_POST['Roomtype']['amenities'])){
                    $model->amenities = implode(',', $_POST['Roomtype']['amenities']);    
                }
                //echo"<pre>";print_r($model->amenities);die;
                if($_POST['Roomtype']['bed'] !== ''){
                    $model->bed = implode(',', $_POST['Roomtype']['bed']);
                }
                $photo = CUploadedFile::getInstance($model, 'cover_photo');

                if($photo !== null){
                    $ran = rand(0, 999999999);
                    $cover_photo = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($photo->name).'.'.$photo->extensionName;
                    $model['cover_photo'] = $cover_photo;
                }else{
                    $model['cover_photo'] = $old_photo;
                }
               
                if($model->update()){
                    if(!is_dir(Yii::app()->basePath . '/../uploads')){
                        mkdir(Yii::app()->basePath . '/../uploads');
                    }
                    if(!is_dir(Yii::app()->basePath . '/../uploads/cover')){
                        mkdir(Yii::app()->basePath . '/../uploads/cover');
                    }
                    if(isset($cover_photo) && $cover_photo){
                        $photo->saveAs(Yii::app()->basePath . "/../uploads/cover/$cover_photo");
                        if($old_photo && file_exists(Yii::app()->basePath . "/../uploads/cover/$old_photo")){
                            unlink(Yii::app()->basePath . "/../uploads/cover/$old_photo");
                        }
                    }
                    $this->redirect(Yii::app()->createUrl('admin/roomtype/admin'));
                }
            }
            if($model){
                $model->description = json_decode($model->description, true);
                $model->amenities = explode(',', $model->amenities);
                $model->bed = explode(',',$model->bed);
            }
            $this->render('update', compact('model'));
        }catch(Exception $ex){
            Yii::log("Invalid request. Please do not repeat this request again.");
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionDelete($id){
        $uploadPath = Yii::app()->basePath .'/../uploads/roomtype/';
        $model = $this->loadModel($id);
        if($model->delete()){
            echo json_encode(1);
        }
    }

    public function loadModel($id){
        $model = Roomtype::model()->findByPk($id);
        $hotel = Hotel::model()->findByPk($model['hotel_id']);
        AdminExtra::checkPermissionHotel(Yii::app()->user->id, $hotel['chain_id']);
        return $model;
    }
}