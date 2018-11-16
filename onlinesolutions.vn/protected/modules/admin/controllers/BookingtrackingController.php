<?php 
class BookingtrackingController extends AdminController{
	
	public function actionAdmin(){
		//try {

	        //$hotel = Yii::app()->session['_hotel'];
			$hotel=1;

	        $model = new BookingTracking('search');
	        $model->unsetAttributes();
	        if(isset($_GET['BookingTracking'])){
	        	$model->attributes = $_GET['BookingTracking'];
	        }
	        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                header( 'Content-type: application/json' );
                $this->renderPartial('_grid', compact(array('model','id','filter')));
                Yii::app()->end();
            }
	        $this->render('admin', compact('model'));
	}

	public function getDate($dateString, $format = DEFAULT_DATE_FORMAT, $type = 'mongo') {
        $dateObj = new DateTime($dateString);
        if ($type == 'mongo') {
            return new MongoDate(strtotime($dateObj->format($format)));
        }
        if ($type == 'string') {
            return $dateObj->format($format);
        }
        return false;
    }
}