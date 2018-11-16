<?php

class PromotionController extends AdminController{

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
        $model = new Promotion('search');
        $model->unsetAttributes();
        
        if(isset($_GET['Promotion'])){
            $model->attributes = $_GET['Promotion'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }

        $this->render('admin', compact('model'));
    }

    public function actionCreate(){
        $model = new Promotion;
        if(isset($_POST['Promotion'])){
            $model->attributes = $_POST['Promotion'];
            
            $photo = CUploadedFile::getInstance($model, 'cover_photo');
            if($photo !== null){
                $ran = rand(0, 999999999);
                $cover_photo = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($photo->name).'.'.$photo->extensionName;
                $model['cover_photo'] = $cover_photo;
            }

            if(isset($_POST['Promotion']['packages'])){
                $model->packages = implode(',', $_POST['Promotion']['packages']);
            }
            $model->hotel_id = Yii::app()->session['hotel'];
            $roomtypes = '';
            if(isset($_POST['Promotion']['name']['en'])){
                $model->slug = StringHelper::makeLink($_POST['Promotion']['name']['en']);
            }
            if(isset($_POST['Promotion']['roomtypes'])){
                $i=0;
                foreach($_POST['Promotion']['roomtypes'] as $key => $value){
                    $roomtypes .= $key;
                    if($i < count($_POST['Promotion']['roomtypes'])-1){
                        $roomtypes .=',';
                    }
                    $i++;
                }
            }

            $languages = Yii::app()->params['language_config'];
            $name = $short_description = $description = array();
            foreach($languages as $key => $lang){
                if(isset($_POST['Promotion']['name'][$key]) && !$_POST['Promotion']['name'][$key]){
                    $name[$key] = $_POST['Promotion']['name']['en'];
                }else{
                    $name[$key] = $_POST['Promotion']['name'][$key];
                }
                
                if(isset($_POST['Promotion']['short_content'][$key]) && !$_POST['Promotion']['short_content'][$key]){
                    $short_description[$key] = $_POST['Promotion']['short_content']['en'];
                }else{
                    $short_description[$key] = $_POST['Promotion']['short_content'][$key];
                }

                if(isset($_POST['Promotion']['description'][$key]) && !$_POST['Promotion']['description'][$key]){
                    $description[$key] = $_POST['Promotion']['description']['en'];
                }else{
                    $description[$key] = $_POST['Promotion']['description'][$key];
                }
            }

            if(is_array($name)){
                $model->name = json_encode($name);
            }

            if(is_array($short_description)){
                $model->short_content = json_encode($short_description);
            }

            if(is_array($description)){
                $model->description = json_encode($description);
            }

            $model->roomtypes = $roomtypes;
            $from_date = ExtraHelper::date_2_save($_POST['Promotion']['from_date']);
            $to_date = ExtraHelper::date_2_save($_POST['Promotion']['to_date']);

            $start_date = ExtraHelper::date_2_save($_POST['Promotion']['start_deal_date']);
            $end_date = ExtraHelper::date_2_save($_POST['Promotion']['end_deal_date']);


            $model->from_date=$from_date['date'];
            $model->to_date=$to_date['date'];
            $model->start_deal_date=$start_date['date'];
            $model->end_deal_date=$end_date['date'];
            
            ExtraHelper::update_tracking_data($model, 'create');
            
            $model->validate();

            /*if($_POST['Promotion']['apply_on'] == 'specific_night'){
                $model->specific_night = json_encode($_POST['Promotion']['specific_night']);
            }elseif($_POST['Promotion']['apply_on'] == 'specific_day_of_week'){
                $model->specific_night = json_encode($_POST['Promotion']['specific_day_of_week']);
            }*/
            
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
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/promotion/admin'));
            }

        }

        if($model['packages']){
            $model->packages = explode(',', $model->packages);
        }

        if(isset($model->from_date)){
            $model->from_date = ExtraHelper::date_2_show($model->from_date);
        }
        if(isset($model->to_date)){
            $model->to_date = ExtraHelper::date_2_show($model->to_date);
        }

        if(isset($model->start_deal_date)){
            $model->start_deal_date = ExtraHelper::date_2_show($model->start_deal_date);
        }
        if(isset($model->end_deal_date)){
            $model->end_deal_date = ExtraHelper::date_2_show($model->end_deal_date);
        }

        $Promotion = array();
        if(isset($model->roomtypes)){
            $room = explode(',', $model->roomtypes);
            foreach($room as $rm){
                $Promotion['roomtypes'][$rm]=1;
            }
        }
        $roomtype = Roomtype::model()->getList2(0, Yii::app()->session['hotel']);
        $this->render('create', compact(array('model','roomtype','Promotion')));
    }

    public function actionUpdate($id){
        $model = $this->loadModel($id);
        $old_photo = $model->cover_photo;
        if(isset($_POST['Promotion'])){
            $model->attributes = $_POST['Promotion'];
            $photo = CUploadedFile::getInstance($model, 'cover_photo');
            if($photo !== null){
                $ran = rand(0, 999999999);
                $cover_photo = trim(date('Y-m-d-H-i-s') . $ran) . '-' . StringHelper::makeLink($photo->name).'.'.$photo->extensionName;
                $model['cover_photo'] = $cover_photo;
            }else{
                $model['cover_photo'] = $old_photo;
            }

            if(isset($_POST['Promotion']['name']['en'])){
                $model->slug = StringHelper::makeLink($_POST['Promotion']['name']['en']);
            }
            $model->hotel_id = Yii::app()->session['hotel'];
            $roomtypes = '';
            if(isset($_POST['Promotion']['roomtypes'])){
                $i=0;
                foreach($_POST['Promotion']['roomtypes'] as $key => $value){
                    $roomtypes .= $key;
                    if($i < count($_POST['Promotion']['roomtypes'])-1){
                        $roomtypes .=',';
                    }
                    $i++;
                }
            }

            if(isset($_POST['Promotion']['packages'])){
                $model->packages = implode(',', $_POST['Promotion']['packages']);
            }
            $languages = Yii::app()->params['language_config'];
            $name = $short_description = $description = array();
            foreach($languages as $key => $lang){
                if(isset($_POST['Promotion']['name'][$key]) && !$_POST['Promotion']['name'][$key]){
                    $name[$key] = $_POST['Promotion']['name']['en'];
                }else{
                    $name[$key] = $_POST['Promotion']['name'][$key];
                }

                if(isset($_POST['Promotion']['short_content'][$key]) && !$_POST['Promotion']['short_content'][$key]){
                    $short_description[$key] = $_POST['Promotion']['short_content']['en'];
                }else{
                    $short_description[$key] = $_POST['Promotion']['short_content'][$key];
                }

                if(isset($_POST['Promotion']['description'][$key]) && !$_POST['Promotion']['description'][$key]){
                    $description[$key] = $_POST['Promotion']['description']['en'];
                }else{
                    $description[$key] = $_POST['Promotion']['description'][$key];
                }
            }

            if(is_array($name)){
                $model->name = json_encode($name);
            }

            if(is_array($short_description)){
                $model->short_content = json_encode($short_description);
            }

            if(is_array($description)){
                $model->description = json_encode($description);
            }

            $model->roomtypes = $roomtypes;
            ExtraHelper::update_tracking_data($model, 'update');
            $model->validate();

            $from_date = ExtraHelper::date_2_save($_POST['Promotion']['from_date']);
            $to_date = ExtraHelper::date_2_save($_POST['Promotion']['to_date']);

            $start_date = ExtraHelper::date_2_save($_POST['Promotion']['start_deal_date']);
            $end_date = ExtraHelper::date_2_save($_POST['Promotion']['end_deal_date']);


            $model->from_date=$from_date['date'];
            $model->to_date=$to_date['date'];
            $model->start_deal_date=$start_date['date'];
            $model->end_deal_date=$end_date['date'];


            /*if($_POST['Promotion']['apply_on'] == 'specific_night'){
                $model->specific_night = json_encode($_POST['Promotion']['specific_night']);
            }elseif($_POST['Promotion']['apply_on'] == 'specific_day_of_week'){
                $model->specific_night = json_encode($_POST['Promotion']['specific_day_of_week']);
            }*/

            if(!$model->hasErrors() && $model->update()){
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
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/promotion/admin'));
            }

        }
        if($model['packages']){
            $model->packages = explode(',', $model->packages);
        }

        if(isset($model->from_date)){
            $model->from_date = ExtraHelper::date_2_show($model->from_date);
        }
        if(isset($model->to_date)){
            $model->to_date = ExtraHelper::date_2_show($model->to_date);
        }

        if(isset($model->start_deal_date)){
            $model->start_deal_date = ExtraHelper::date_2_show($model->start_deal_date);
        }
        if(isset($model->end_deal_date)){
            $model->end_deal_date = ExtraHelper::date_2_show($model->end_deal_date);
        }
        
        /*$model->specific_day_of_week = json_decode($model->specific_day_of_week, true);
        $model->specific_night = json_decode($model->specific_night, true);*/
        $roomtype = Roomtype::model()->getList2(0, Yii::app()->session['hotel']);
        
        $Promotion = array();
        if(isset($model->roomtypes)){
            $room = explode(',', $model->roomtypes);
            $j=0;
            foreach($roomtype as $k => $v){
                if(isset($room[$j]) && isset($roomtype[$room[$j]])){
                    $Promotion['roomtypes'][$room[$j]]=1;    
                }else{
                    $Promotion['roomtypes'][$k]=0;
                } 
                $j++;               
            }
        }

        if(isset($model)){
            if($model->name){
                $model->name = json_decode($model->name, true);
            }

            if($model->short_content){
                $model->short_content = json_decode($model->short_content, true);
            }

            if($model->description){
                $model->description = json_decode($model->description, true);
            }
        }
        $this->render('update', compact(array('model', 'roomtype','Promotion')));
    }

    public function actionDelete($id){
        $model = $this->loadModel($id);
        if($model->delete()){
            echo json_encode(1);
        }
    }

    public function loadModel($id){
        $model = Promotion::model()->findByPk($id);
        $hotel = Hotel::model()->findByPk($model['hotel_id']);
        AdminExtra::checkPermissionHotel(Yii::app()->user->id, $hotel['chain_id']);
        return $model;
    }
}