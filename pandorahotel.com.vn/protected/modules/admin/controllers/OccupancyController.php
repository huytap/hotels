<?php

class OccupancyController extends AdminController{

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
        $roomtypes = Roomtypes::model()->getList(0);
        $roomtype = array();
        foreach($roomtypes->getData() as $rt){
            //$model[$rt['id']]['name'] = $rt['name'];
            $roomtype[$rt['id']]['name'] = $rt['name'];
            $roomtype[$rt['id']]['no_of_adult'] = 0;
            $roomtype[$rt['id']]['no_of_child'] = 0;
            $roomtype[$rt['id']]['no_of_extrabed'] = 0;
        }
        
        if(isset($_POST['Occupancy'])){
            foreach($_POST['Occupancy'] as $key => $oc){
                $check = Occupancy::model()->checkExists($key);
                if(!$check){
                    $model = new Occupancy;
                    $model->attributes = $oc;
                    $model->roomtype_id = $key;
                    ExtraHelper::update_tracking_data($model, 'create');
                    $model->save();
                }else{
                    $check->attributes = $oc;
                    ExtraHelper::update_tracking_data($check, 'update');
                    $check->update();
                }
            }
        }
        
        $this->render('admin', compact(array('roomtype')));
    }

    
    public function loadModel($id){
        $model = Occupancy::model()->findByPk($id);

        return $model;
    }
}