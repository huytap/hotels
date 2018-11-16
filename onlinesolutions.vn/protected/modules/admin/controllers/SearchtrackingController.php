<?php

class SearchtrackingController extends AdminController{
	public function filters(){
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            array('booster.filters.BoosterFilter - delete')
        );
    }

    public function accessRules(){
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
    public function actionAdmin($id=null){
        $model = new SearchTracking('search');
        $model->unsetAttributes();
        if(isset($_GET['SearchTracking'])){
            $model->attributes = $_GET['SearchTracking'];
        }
        $this->render('admin', compact(array('model')));
    }
}