<?php

class AdminController extends Controller{
	public $layoutPath;
	public $layout='/layouts/main';

	public $menu = array();

   
    public $breadcrumbs = array();

    public function init() {
    	parent::init();
        if(isset($_POST['_hotel'])){
            Yii::app()->session['hotel']=$_POST['_hotel'];
            header('Location: '. Yii::app()->createUrl('admin/booking/admin'));
        }
        /*if(!Yii::app()->session['hotel']){
            $user = Users::model()->findByPk(Yii::app()->user->id);
            Yii::app()->session['hotel'] = $user['hotel_id'];                
        }*/
    	$this->layoutPath = Yii::getPathOfAlias('application.modules.admin.views.layouts.main');
    	$this->layout = 'application.modules.admin.views.layouts.main';
    }

    //Insert Multiple
    public function multiexplode ($delimiters,$string) {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }
}