<?php

class RoomController extends AdminController{

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            array('booster.filters.BoosterFilter - delete')
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>RoleHelper::GetRole(),//array('create','update','admin'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionAdmin(){
        $hotel_id = Yii::app()->session['hotel'];
        $now = date('Y-m-d');
        $to = date('Y-m-d', strtotime("$now +1 month"));
        
        $filter = array(
            'type' => 0,
            'fromdate' => ExtraHelper::date_2_show($now),
            'todate' => ExtraHelper::date_2_show($to),
            'hotel' => Yii::app()->session['hotel']
        );
        if(isset($_POST['search']) || isset($_POST['save']) || isset($_POST['autofill'])) {
            $filter['type'] = $_POST['roomtype'];
            $filter['fromdate'] = $_POST['fromdate'];
            $filter['todate'] = $_POST['todate'];
        }
        $roomtypes = Roomtype::model()->getList2(0);
        $no_of_day = ExtraHelper::date_diff($filter['fromdate'], $filter['todate']);
        $Rooms = array();
        $flag='';
        if(isset($_POST['save'])){
            if($no_of_day >= 0){
                if($filter['type'] > 0){
                    for($i=0;$i<=$no_of_day;$i++){
                        $dateSave = ExtraHelper::date_2_save($filter['fromdate']);
                        $date = date('d/m/Y', strtotime($dateSave['date'] ." + ".$i."day"));
                        $date1=$dateSave['date'];
                        $date_format=date('Y-m-d', strtotime($date1.' + '. $i. "day"));
                        $checkRoom = Rooms::model()->checkRoom($filter['type'], $date_format);
                        if(!$checkRoom){
                            $roomtype = new Rooms;
                            $roomtype->hotel_id=Yii::app()->session['hotel'];
                            $roomtype->date = $date_format;
                            $roomtype->day = date('D',strtotime($date_format));
                            $roomtype->close = isset($_POST['Rooms'][$date]['close']) ? 1 : 0;
                            $roomtype->available = $_POST['Rooms'][$date]['available'];
                            $roomtype->roomtype_id = $filter['type'];
                            $roomtype->auto_fill = isset($filter['auto_fill'])?$filter['auto_fill']:0;
                            ExtraHelper::update_tracking_data($roomtype, 'create');
                            if($roomtype->save()){
                                $flag='Create new room from '. $filter['fromdate'] . ' to '. $filter['todate'].' success!';
                            }
                        }else{
                            $checkRoom->close = isset($_POST['Rooms'][$date]['close']) ? 1 : 0;
                            $checkRoom->available = $_POST['Rooms'][$date]['available'];
                            $checkRoom->auto_fill = $_POST['Rooms'][$date]['auto_fill'];
                            $checkRoom->hotel_id=Yii::app()->session['hotel'];
                            ExtraHelper::update_tracking_data($checkRoom, 'update');
                            if($checkRoom->update()){
                                $flag='Update room from '. $filter['fromdate'] . ' to '. $filter['todate'].' success!';
                            }
                        }
                    }
                }
            }
        }

        $model = Rooms::model()->getList($filter);
        if(isset($_POST['autofill'])){
            $close = ($_POST['close'] !== '') ? $_POST['close'] : '';
            $available = isset($_POST['available']) ? $_POST['available'] : '';
            $auto_fill=$_POST['auto_fill']?$_POST['auto_fill']:'';
            for($i=0;$i<=$no_of_day;$i++){
                $dateSave = ExtraHelper::date_2_save($filter['fromdate']);
                $date = date('d/m/Y', strtotime($dateSave['date'] ." + ".$i."day"));
                $date_format = $dateSave['date'];
                $dateRange = date('Y-m-d', strtotime($dateSave['date'] . " + " .$i ."day"));
                $checkRoom = Rooms::model()->checkRoom($filter['type'], $dateRange);
                if($checkRoom){
                    $Rooms[$date]['date'] = $date;
                    $Rooms[$date]['day'] = date('D', strtotime($date));
                    $Rooms[$date]['used_total_allotments'] = $checkRoom['used_total_allotments'];
                    if($checkRoom['close']==1){
                        $Rooms[$date]['available'] = $checkRoom['available'];
                        $Rooms[$date]['auto_fill'] = $checkRoom['auto_fill'];
                    }else{
                        $Rooms[$date]['available'] = ($_POST['available'] !=='') ? $_POST['available'] : $checkRoom['available'];
                        $Rooms[$date]['auto_fill'] = ($_POST['auto_fill'] !=='') ? $_POST['auto_fill'] : $checkRoom['auto_fill'];
                    }

                    $Rooms[$date]['close'] = ($_POST['close'] !== '') ? $_POST['close'] : $checkRoom['close'];
                    $Rooms[$date]['updated_date'] = $checkRoom['updated_date'];
                }else{
                    $Rooms[$date]['date'] = $date;
                    $Rooms[$date]['day'] = date('D', strtotime($date));
                    $Rooms[$date]['used_total_allotments'] = 0;
                    $Rooms[$date]['available'] = $available;
                    $Rooms[$date]['auto_fill'] = $auto_fill;
                    $Rooms[$date]['close'] = $close;
                    $Rooms[$date]['updated_date'] = '';
                }
            }
        }else{
            for($i=0;$i<=$no_of_day;$i++){
                $dateSave = ExtraHelper::date_2_save($filter['fromdate']);
                $date = date('d/m/Y', strtotime($dateSave['date'] ." + ".$i."day"));
                $dateRange = date('Y-m-d', strtotime($dateSave['date'] . " + " .$i ."day"));
                $checkRoom = Rooms::model()->checkRoom($filter['type'], $dateRange);
                if($checkRoom){
                    $Rooms[$date]['date'] = $date;
                    $Rooms[$date]['day'] = $checkRoom['day'];
                    $Rooms[$date]['used_total_allotments'] = $checkRoom['used_total_allotments'];
                    $Rooms[$date]['available'] = $checkRoom['available'];
                    $Rooms[$date]['auto_fill'] = $checkRoom['auto_fill'];
                    $Rooms[$date]['close'] = $checkRoom['close'];
                    $Rooms[$date]['updated_date'] = $checkRoom['updated_date'];
                }else{
                    $Rooms[$date]['date'] = $date;
                    $Rooms[$date]['day'] = date('D', strtotime($date));
                    $Rooms[$date]['used_total_allotments'] = 0;
                    $Rooms[$date]['available'] = 5;
                    $Rooms[$date]['close'] = 0;
                    $Rooms[$date]['auto_fill'] = 0;
                    $Rooms[$date]['updated_date'] = '';
                }
            }
        }
        $this->render('admin', compact(array('roomtypes', 'filter','Rooms','flag')));
    }
}