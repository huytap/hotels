<?php
class SiteController extends AdminController{
	public function actionOption(){
		$this->layout = 'false';
		$user = Users::model()->findByPk(Yii::app()->user->id);
        $hotels = Hotel::model()->getListByChain($user['chain_id']);
        if(isset($_POST['hotel'])){
        	Yii::app()->session['hotel'] = $_POST['hotel'];
        	$this->redirect(Yii::app()->createUrl('admin/booking/admin'));
        }
		$this->render('option', compact('hotels'));
	}
	public function actionLogin(){
		if(!isset(Yii::app()->user->id)){
			$this->layout = false;
			$model = new LoginFormAm;
			if(isset($_POST['LoginFormAm'])){
				$model->attributes = $_POST['LoginFormAm'];
				
	            if ($model->validate()) {
	            	if(Yii::app()->user->id==1){
				            $this->redirect(Yii::app()->createAbsoluteUrl('admin/hotel/admin'));
			        }else{
			        	$user = Users::model()->findByPk(Yii::app()->user->id);

	            		if($user['chain_id']){
		            		$hotel = Hotel::model()->getByChainID($user['chain_id']);

		            		if(count($hotel)>1){

		            			$this->redirect(Yii::app()->createAbsoluteUrl('admin/site/option'));
		            		}else{
		            			Yii::app()->session['hotel'] = $hotel[0]['id'];
		            			$this->redirect(Yii::app()->createUrl('admin/booking/admin'));
		            		}
			        		
			        	}
			        }
	            }
			}
			$this->render('login',compact('model'));
		}else{
			$this->redirect(Yii::app()->createAbsoluteUrl('admin/site/option'));
		}
	}

	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->createAbsoluteUrl('admin'));
	}

	public function actionError(){
		$this->render('error');
	}
}