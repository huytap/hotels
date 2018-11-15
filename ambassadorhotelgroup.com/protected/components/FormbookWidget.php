<?php
class FormbookWidget extends CWidget{
	public function run(){
		$model = new FormBook;
		$now = date('Y-m-d');
		$model->checkin = date('d M Y');
		$model->checkout = date('d M Y', strtotime("$now + 1day"));

		
		if(isset($_GET['checkindate'])){
            $model->checkin = $_GET['checkindate'];
        }

        if(isset($_GET['checkoutdate'])){
            $model->checkout = $_GET['checkoutdate'];   
        }

        if(isset($_GET['adult'])){
            $model['adult'] = $_GET['adult'];
        }

        if(isset($_GET['children'])){
            $model['children'] = $_GET['children'];
        }

       
        if(isset($_POST['FormBook'])){
        	header("Location:".Yii::app()->baseUrl.'/'.Yii::app()->language.'/contact');
        }
        $hotels = Hotel::model()->getList();
		$this->render('formbook', compact(array('model', 'hotels')));
	}
}