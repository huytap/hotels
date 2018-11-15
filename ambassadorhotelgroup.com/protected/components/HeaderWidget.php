<?php
class HeaderWidget extends CWidget{
	public function init(){
		$hotels = Hotel::model()->getList();
		$lang = Yii::app()->language;
		if(isset($_GET['hotel'])){
			$this->render('header_hotel', compact(array('hotels', 'lang')));
		}else{
			$this->render('header', compact(array('hotels', 'lang')));
		}
	}
}