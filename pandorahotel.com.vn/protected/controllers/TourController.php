<?php
class TourController extends Controller{
	public function actionIndex(){
		//try{
			$model = Tour::model()->getList2();
			$this->render('index', compact('model'));
		/*}catch(Exception $ex){
			echo 'System is maintained';
		}*/
	}

	public function actionDetail($id, $tour_slug){
		//try{
			$model2 = Tour::model()->getList2();
			$model = Tour::model()->findByPk($id);
			$this->render('detail', compact('model','model2'));
		/*}catch(Exception $ex){
			echo 'System is maintained';
		}*/
	}

	public function actionGetListPrice(){
		if(isset($_POST['tour'])){
			if(!$_POST['tour'] && Yii::app()->session['_booked']){
				$booked = Yii::app()->session['_booked'];
				unset($booked['tour_name']);
                unset($booked['tour_id']);
                unset($booked['tour_max_adult']);
                unset($booked['tour_price']);
                Yii::app()->session['_booked'] = $booked;
			}
			echo json_encode(Tour::model()->getListPriceByTour($_POST['tour']));
		}
	}
}