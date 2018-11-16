<?php

class DefaultController extends AdminController
{
	/*public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            array('booster.filters.BoosterFilter - delete')
        );
    }

    public function accessRules(){
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('admin','changepassword'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }*/

	public function actionAdmin(){
		$hotels = Hotel::model()->getList();
		$now = date('Y-m-d');
		$to = date('Y-m-d', strtotime("$now + 1day"));
		$rooms = Rooms::model()->getTotalRoomByHotel(Yii::app()->session['hotel'], $now, $to);

		$filter = array('month' => sprintf('%02d',date('m')),'year'=>date('Y'));
		if(isset($_POST['filter'])){
			$filter = array(
				'month' => $_POST['filter']['month'],
				'year'=>$_POST['filter']['year']
			);
		}

		$order = Bookings::model()->getOrderByMonth($filter);
		$this->render('admin',compact(array('order', 'filter', 'hotels', 'rooms')));
	}

	public function actionAvaibility(){
		$now = date('Y-m-d');
		$period = date('Y-m-d', strtotime("$now + 365days"));
		if(isset($_REQUEST['month'])){
			
		}

		$rooms = Yii::app()->db->createCommand()
            ->select('COUNT(*) as total, date')
            ->from('rooms')  //Your Table name
            ->group('date') 
            ->where('date BETWEEN "'.$now.'" AND "'.$period.'"') // Write your where condition here
            ->queryAll(); //Will get the all selected rows from table
		$arrTheList = array();
		$i=0;
		foreach($rooms as $room){
			$date = explode('-', $room['date']);
			array_push($arrTheList, array('Date.UTC('.$date[0].','.$date[1].','.$date[2].']),'.$room['total']));
			/*if($i<count($rooms)-1){
				$arrTheList .= ',';
			}
			$i++;*/
		}
		$result = json_encode($arrTheList);
		$this->render('avaibility', compact('result'));
	}
	public function actionChangepassword(){
		$model = Users::model()->findByPk(Yii::app()->user->id);		
		$model->scenario = 'change';
		if(isset($_POST['Users'])){
			$model->attributes=$_POST['Users'];
			$model->password = sha1(md5($model['new_password']).'bookingengine');
			if($model->validate() && $model->update()){
				Yii::app()->user->setFlash('change_password', 'Update password success.');
                $this->refresh();
			}
		}
		$this->render('change_password', compact('model'));
	}

	public function actionJson(){
		header('content-type: application/json; charset=utf-8');

	}
}