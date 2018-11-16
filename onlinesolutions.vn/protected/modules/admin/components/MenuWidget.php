<?php
	class MenuWidget extends CWidget
	{
		public function run()
		{
			$user=Users::model()->getInfomation(Yii::app()->user->id);
			$this->render('menu', compact('user'));
		}
	}
?>