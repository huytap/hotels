<?php
class HeaderWidget extends CWidget{
	
    public function run() {
        $user = Users::model()->findByPk(Yii::app()->user->id);
        if(!Yii::app()->session['hotel']){
            Yii::app()->session['hotel'] = $user['hotel_id'];
        }
        $this->render('header', compact(array('user')));
    }
}