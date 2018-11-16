<?php
class AdminExtra{
	public static function checkPermissionHotel($user_id, $chain_id){
		$user = Users::model()->findByPk($user_id);
		if($user['chain_id'] == $chain_id){
			return true;
		}elseif(Yii::app()->user->id > 1){
			throw new CHttpException(404,'404 Page Not Found OR You have not permision.');
		}
	}
}