<?php

class HotelController extends AdminController{

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
        $data = Hotel::model()->getList();
        if(count($data->getData())==1 && Yii::app()->user->id>1){
            $h = $data->getData();
            $this->redirect(Yii::app()->createUrl('admin/hotel/update',array('id'=>$h[0]['id'])));
        }
        $model = new Hotel('search');
        $model->unsetAttributes();
        if(isset($_GET['Hotel'])){
            $model->attributes = $_GET['Hotel'];
        }

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            header( 'Content-type: application/json' );
            $this->renderPartial('_grid', compact(array('model')));
            Yii::app()->end();
        }
        $this->render('admin', compact(array('model', 'flag')));
    }

    public function actionView($hotelid, $chainid){
        $model = $this->loadModel($hotelid, $chainid);
        $this->render('view', compact('model'));
    }
    public function actionCreate(){
        $model = new Hotel;
        $model->scenario='create';
        if(isset($_POST['Hotel'])){
            $model->attributes = $_POST['Hotel'];
            //$model->slug = StringHelper::makeLink($model->name);
            $tmp_facilities = $temp_sport='';

            if(isset($_POST['Hotel']['facilities'])){
                $i=0;
                foreach($_POST['Hotel']['facilities'] as $facilities){
                    if($facilities){
                        $tmp_facilities .= $facilities;
                        if($i<(count($_POST['Hotel']['facilities'])-1)){
                            $tmp_facilities .=',';
                        }
                    }
                    $i++;
                }
            }
            $model->facilities = $tmp_facilities;
            if(isset($_POST['Hotel']['sports'])){
                $i=0;
                foreach($_POST['Hotel']['sports'] as $sports){
                    if($sports){
                        $temp_sport .= $sports;
                        if($i<(count($_POST['Hotel']['sports'])-1)){
                            $temp_sport .=',';
                        }
                    }
                    $i++;
                }
            }
            $model->sports = $temp_sport;
            $languages = Yii::app()->params['language_config'];
            $term_condition = $address = $city = $country = $description = $short_description = $promotion = $special=array();
            foreach($languages as $key => $lang){
                if(!$_POST['Hotel']['address'][$key]){
                    $address[$key] = $_POST['Hotel']['address']['en'];
                }else{
                    $address[$key] = $_POST['Hotel']['address'][$key];
                }

                if(!$_POST['Hotel']['city'][$key]){
                    $city[$key]=$_POST['Hotel']['city']['en'];
                }else{
                    $city[$key]=$_POST['Hotel']['city'][$key];
                }

                if(!$_POST['Hotel']['country'][$key]){
                    $country[$key]=$_POST['Hotel']['country']['en'];
                }else{
                    $country[$key]=$_POST['Hotel']['country'][$key];
                }

                if(!$_POST['Hotel']['short_description'][$key]){
                    $short_description[$key]=$_POST['Hotel']['short_description']['en'];
                }else{
                    $short_description[$key]=$_POST['Hotel']['short_description'][$key];
                }

                if(!$_POST['Hotel']['description'][$key]){
                    $description[$key]=$_POST['Hotel']['description']['en'];
                }else{
                    $description[$key]=$_POST['Hotel']['description'][$key];
                }

                if(!$_POST['Hotel']['special_offer'][$key]){
                    $special[$key]=$_POST['Hotel']['special_offer']['en'];
                }else{
                    $special[$key]=$_POST['Hotel']['special_offer'][$key];
                }

                if(!$_POST['Hotel']['term_condition'][$key]){
                    $term_condition[$key]=$_POST['Hotel']['term_condition']['en'];
                }else{
                    $term_condition[$key]=$_POST['Hotel']['term_condition'][$key];
                }

                if(!$_POST['Hotel']['promotion'][$key]){
                    $promotion[$key]=$_POST['Hotel']['promotion']['en'];
                }else{
                    $promotion[$key]=$_POST['Hotel']['promotion'][$key];
                }
            }

            if(is_array($address)){
                $model->address = json_encode($address);
            }
            if(is_array($promotion)){
                $model->promotion = json_encode($promotion);
            }
            if(is_array($city)){
                $model->city = json_encode($city);
            }
            if(is_array($country)){
                $model->country = json_encode($country);
            }
            if(is_array($description)){
                $model->description = json_encode($description);
            }

            if(is_array($short_description)){
                $model->short_description = json_encode($short_description);
            }
            if(is_array($term_condition)){
                $model->term_condition = json_encode($term_condition);
            }
            $logo1 = CUploadedFile::getInstance($model, 'logo1');
            $string_logo1='';
            if($logo1 !== null){
                $ran = rand(0, 999999999);
                $string_logo1 = $logo1->name;
                $model['logo1'] = $string_logo1;
            }

            $logo2 = CUploadedFile::getInstance($model, 'logo2');
            $string_logo2='';
            if($logo2 !== null){
                $ran = rand(0, 999999999);
                $string_logo2 = $logo2->name;
                $model['logo2'] = $string_logo2;
                
            }

            //echo"<pre>";print_r($model);die;
            ExtraHelper::update_tracking_data($model, 'create');
            $model->validate();
            if(!$model->hasErrors() && $model->save()){
                if($string_logo1){
                    $logo1->saveAs(Yii::app()->basePath . "/../images/$string_logo1");
                }
                if($string_logo2){
                    $logo2->saveAs(Yii::app()->basePath . "/../images/$string_logo2");
                }
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/hotel/admin'));
            }
        }

        if(isset($model)){
            if($model->address){
                $model->address = json_decode($model->address, true);
            }
            if($model->city){
                $model->city = json_decode($model->city, true);
            }
            if($model->country){
                $model->country = json_decode($model->country, true);
            }
            if($model->promotion){
                $model->promotion = json_decode($model->promotion, true);
            }
            if($model->description){
                $model->description = json_decode($model->description, true);
            }

            /*if($model->special_offer){
                $model->special_offer = json_decode($model->special_offer, true);
            }
            
            if($model->short_description){
                $model->short_description = json_decode($short_description, true);
            }

            if(is_array($special)){
                $model->special_offer = json_encode($special);
            }*/

            if($model->facilities){
                $model->facilities = explode(',', $model->facilities);
            }
            if($model->sports){
                $model->sports = explode(',',$model->sports);
            }
        }
        $this->render('create', compact('model'));
    }

    public function actionUpdate($hotelid, $chainid){
        $model = $this->loadModel($hotelid, $chainid);
        $old_logo1=$model['logo1'];
        $old_logo2=$model['logo2'];
        if(isset($_POST['Hotel'])){
            $model->attributes = $_POST['Hotel'];
            //$model->slug = StringHelper::makeLink($model->name);

            /*$tmp_facilities = $temp_sport='';

            if(isset($_POST['Hotel']['facilities'])){
                $i=0;
                foreach($_POST['Hotel']['facilities'] as $facilities){
                    if($facilities){
                        $tmp_facilities .= $facilities;
                        if($i<(count($_POST['Hotel']['facilities'])-1)){
                            $tmp_facilities .=',';
                        }
                    }
                    $i++;
                }
            }
            $model->facilities = $tmp_facilities;
            if(isset($_POST['Hotel']['sports'])){
                $i=0;
                foreach($_POST['Hotel']['sports'] as $sports){
                    if($sports){
                        $temp_sport .= $sports;
                        if($i<(count($_POST['Hotel']['sports'])-1)){
                            $temp_sport .=',';
                        }
                    }
                    $i++;
                }
            }
            $model->sports = $temp_sport;
            */
            $languages = Yii::app()->params['language_config'];
            $term_condition = $address = $city = $country = $description = $short_description = $promotion = $special = array();
            foreach($languages as $key => $lang){
                if(!$_POST['Hotel']['address'][$key]){
                    $address[$key] = $_POST['Hotel']['address']['en'];
                }else{
                    $address[$key] = $_POST['Hotel']['address'][$key];
                }

                if(!$_POST['Hotel']['city'][$key]){
                    $city[$key]=$_POST['Hotel']['city']['en'];
                }else{
                    $city[$key]=$_POST['Hotel']['city'][$key];
                }

                if(!$_POST['Hotel']['country'][$key]){
                    $country[$key]=$_POST['Hotel']['country']['en'];
                }else{
                    $country[$key]=$_POST['Hotel']['country'][$key];
                }
                /*if(!$_POST['Hotel']['short_description'][$key]){
                    $short_description[$key]=$_POST['Hotel']['short_description']['en'];
                }else{
                    $short_description[$key]=$_POST['Hotel']['short_description'][$key];
                }

                if(!$_POST['Hotel']['description'][$key]){
                    $description[$key]=$_POST['Hotel']['description']['en'];
                }else{
                    $description[$key]=$_POST['Hotel']['description'][$key];
                }

                if(!$_POST['Hotel']['special_offer'][$key]){
                    $special[$key]=$_POST['Hotel']['special_offer']['en'];
                }else{
                    $special[$key]=$_POST['Hotel']['special_offer'][$key];
                }*/
                if(!$_POST['Hotel']['term_condition'][$key]){
                    $term_condition[$key]=$_POST['Hotel']['term_condition']['en'];
                }else{
                    $term_condition[$key]=$_POST['Hotel']['term_condition'][$key];
                }
                /*if(!$_POST['Hotel']['promotion'][$key]){
                    $promotion[$key]=$_POST['Hotel']['promotion']['en'];
                }else{
                    $promotion[$key]=$_POST['Hotel']['promotion'][$key];
                }*/
            }

            if(is_array($address)){
                $model->address = json_encode($address);
            }
            if(is_array($city)){
                $model->city = json_encode($city);
            }
            
            if(is_array($country)){
                $model->country = json_encode($country);
            }
            /*if(is_array($promotion)){
                $model->promotion = json_encode($promotion);
            }
            if(is_array($description)){
                $model->description = json_encode($description);
            }
            if(is_array($special)){
                $model->special_offer = json_encode($special);
            }

            
            if(is_array($short_description)){
                $model->short_description = json_encode($short_description);
            }*/
            if(is_array($term_condition)){
                $model->term_condition = json_encode($term_condition);
            }
            $logo1 = CUploadedFile::getInstance($model, 'logo1');
            $string_logo1='';
            if($logo1 !== null){
                $ran = rand(0, 999999999);
                $string_logo1 = $logo1->name;
                $model['logo1'] = $string_logo1;
            }else{
                $model->logo1=$old_logo1;
            }

            /*$logo2 = CUploadedFile::getInstance($model, 'logo2');
            $string_logo2='';
            if($logo2 !== null){
                $ran = rand(0, 999999999);
                $string_logo2 = $logo2->name;
                $model['logo2'] = $string_logo2;
            }else{
                $model->logo2=$old_logo2;
            }*/

            ExtraHelper::update_tracking_data($model, 'update');
            $model->validate();
            if(!$model->hasErrors() && $model->update()){
                if($string_logo1){
                    if($old_logo1 && file_exists(Yii::app()->basePath . "/../images/$old_logo1")){
                        unlink(Yii::app()->basePath . "/../images/$old_logo1");
                    }
                    
                    $logo1->saveAs(Yii::app()->basePath . "/../images/$string_logo1");
                    
                }
                /*if($string_logo2){
                    if($old_logo2 && file_exists(Yii::app()->basePath . "/../images/$old_logo2")){
                        unlink(Yii::app()->basePath . "/../images/$old_logo2");
                    }
                    
                    $logo2->saveAs(Yii::app()->basePath . "/../images/$string_logo2");                    
                }*/
                $this->redirect(Yii::app()->createAbsoluteUrl('admin/hotel/view', array('hotelid' => $hotelid, 'chainid' => $chainid)));
            }
        }
        if(isset($model)){
            if($model->address){
                $model->address = json_decode($model->address, true);
            }
            if($model->city){
                $model->city = json_decode($model->city, true);
            }
            if($model->country){
                $model->country = json_decode($model->country, true);
            }
            
            if($model->term_condition){
                $model->term_condition = json_decode($model->term_condition, true);
            }
            /*if($model->description){
                $model->description = json_decode($model->description, true);
            }
            if($model->special_offer){
                $model->special_offer = json_decode($model->special_offer, true);
            }
            if($model->promotion){
                $model->promotion = json_decode($model->promotion, true);
            }
            if($model->short_description){
                $model->short_description = json_decode($model->short_description, true);
            }
            if($model->facilities){
                $model->facilities = explode(',', $model->facilities);
            }
            if($model->sports){
                $model->sports = explode(',',$model->sports);
            }*/
        }
        $this->render('update', compact('model'));
    }

    public function actionDelete($id){
        if($this->loadModel($id)->delete()){
            echo json_encode(1);
        }
    }

    public function loadModel($hotelid, $chainid){
        AdminExtra::checkPermissionHotel(Yii::app()->user->id, $chainid);
        $model = Hotel::model()->getByHotelID_ChainID($hotelid, $chainid);
        return $model;
    }
}