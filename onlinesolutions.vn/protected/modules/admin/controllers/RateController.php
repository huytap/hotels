<?php

class RateController extends AdminController{

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
        $Rates = array();
        $flag = '';
        if(isset($_POST['save'])){
            if($no_of_day >= 0){
                if($filter['type'] > 0){
                    for($i=0;$i<=$no_of_day;$i++){
                        $dateSave = ExtraHelper::date_2_save($filter['fromdate']);
                        $date = date('d/m/Y', strtotime($dateSave['date'] ." + ".$i."day"));
                        $date_format=$dateSave['date'];                  
                        $dateRange = date('Y-m-d', strtotime($dateSave['date'] . " + " .$i ."day"));      
                        $checkRate = Rates::model()->checkRate($filter['type'], $dateRange);
                        if(!$checkRate){
                            $rate = new Rates;
                            $rate->date = $dateRange;
                            $rate->hotel_id = Yii::app()->session['hotel'];
                            $rate->day = date('D',strtotime($dateRange));
                            $rate->single_sell = $_POST['Rates'][$date]['single_sell'];
                            $rate->single = round($rate->single_sell/1.155,2);
                            $rate->double_sell = $_POST['Rates'][$date]['double_sell'];
                            $rate->double = round($rate->double_sell/1.155,2);
                            $rate->tripple_sell = $_POST['Rates'][$date]['tripple_sell'];
                            $rate->tripple = round($rate->tripple_sell/1.155,2);
                            $rate->roomtype_id = $filter['type'];
                            $rate->breakfast = isset($_POST['Rates'][$date]['breakfast']) ? 1 : 0;
                            ExtraHelper::update_tracking_data($rate, 'create');
                            if($rate->save()){
                                $flag='Create new rate from '. $filter['fromdate'] . ' to '. $filter['todate'].' success!';
                            }
                        }else{
                            $checkRate->single_sell = $_POST['Rates'][$date]['single_sell'];
                            $checkRate->single = round($checkRate->single_sell/1.155);
                            $checkRate->double_sell = $_POST['Rates'][$date]['double_sell'];
                            $checkRate->double = $checkRate->double_sell/1.155;
                            $checkRate->tripple_sell = $_POST['Rates'][$date]['tripple_sell'];
                            $checkRate->tripple = $checkRate->tripple_sell/1.155;
                            $checkRate->breakfast = isset($_POST['Rates'][$date]['breakfast']) ? 1 : 0;
                            ExtraHelper::update_tracking_data($checkRate, 'update');
                            if($checkRate->update()){
                                $flag='Update rate from '. $filter['fromdate'] . ' to '. $filter['todate'].' success!';
                            }else{
                                $flag='Update error';
                                break;
                            }
                        }
                    }
                }
            }
        }
        
        $model = Rates::model()->getList($filter);
        if(isset($_POST['autofill'])){
            $breakfast = isset($_POST['breakfast']) ? $_POST['breakfast'] : 0;
            $single_sell = isset($_POST['single_sell']) ? $_POST['single_sell'] : '';
            $double_sell = isset($_POST['double_sell']) ? $_POST['double_sell'] : '';
            $tripple_sell = isset($_POST['tripple_sell']) ? $_POST['tripple_sell'] : '';
            for($i=0;$i<=$no_of_day;$i++){
                $dateSave = ExtraHelper::date_2_save($filter['fromdate']);
                $date = date('d/m/Y', strtotime($dateSave['date'] ." + ".$i."day"));
                $date_format=$dateSave['date']; 
                $dateRange = date('Y-m-d', strtotime($dateSave['date'] . " + " .$i ."day"));      
                $checkRate = Rates::model()->checkRate($filter['type'], $dateRange);
                
                if($checkRate){
                    $Rates[$date]['date'] = $date;
                    $Rates[$date]['day'] = date('D', strtotime($date));
                    $Rates[$date]['single_sell'] = (($single_sell !=='') ? $single_sell: $checkRate['single_sell']);
                    $Rates[$date]['single'] = round($Rates[$date]['single_sell']/1.155,2);
                    $Rates[$date]['double_sell'] = (($double_sell !=='') ? $double_sell: $checkRate['double_sell']);
                    $Rates[$date]['double'] = $Rates[$date]['double_sell']/1.155;
                    $Rates[$date]['tripple_sell'] = (($tripple_sell !=='') ? $tripple_sell: $checkRate['tripple_sell']);
                    $Rates[$date]['tripple'] =  $Rates[$date]['tripple_sell']/1.155;
                    $Rates[$date]['breakfast'] = (($breakfast !== 0) ?  $breakfast : $checkRate['breakfast']);
                    $Rates[$date]['updated_date'] = $checkRate['updated_date'];
                }else{
                    $Rates[$date]['date'] = $date;
                    $Rates[$date]['day'] = date('D', strtotime($date));
                    $Rates[$date]['single_sell'] = (($single_sell !=='') ? $single_sell: 100);
                    $Rates[$date]['single'] = round($Rates[$date]['single_sell']/1.155,2);
                    $Rates[$date]['double_sell'] = (($double_sell !=='') ? $double_sell: 150);
                    $Rates[$date]['double'] = $Rates[$date]['double_sell']/1.155;
                    $Rates[$date]['tripple_sell'] = (($tripple_sell !=='') ? $tripple_sell: 200);
                    $Rates[$date]['tripple'] = $Rates[$date]['tripple_sell']/1.155;

                    $Rates[$date]['breakfast'] = (($breakfast !== 0) ?  $breakfast : $checkRate['breakfast']);
                    $Rates[$date]['updated_date'] = '';
                }
            }
        }else{
            for($i=0;$i<=$no_of_day;$i++){
                $dateSave = ExtraHelper::date_2_save($filter['fromdate']);
                $date = date('d/m/Y', strtotime($dateSave['date'] ." + ".$i."day"));
                $date_format=$dateSave['date'];
                $dateRange = date('Y-m-d', strtotime($dateSave['date'] . " + " .$i ."day"));      
                $checkRate = Rates::model()->checkRate($filter['type'], $dateRange);
                if($checkRate){
                    $Rates[$date]['date'] = $date;
                    $Rates[$date]['day'] = $checkRate['day'];
                    $Rates[$date]['single'] = $checkRate['single'];
                    $Rates[$date]['single_sell'] = $checkRate['single_sell'];
                    $Rates[$date]['double'] = $checkRate['double'];
                    $Rates[$date]['double_sell'] = $checkRate['double_sell'];
                    $Rates[$date]['tripple'] = $checkRate['tripple'];
                    $Rates[$date]['tripple_sell'] = $checkRate['tripple_sell'];

                    $Rates[$date]['breakfast'] = $checkRate['breakfast'];
                    $Rates[$date]['updated_date'] = $checkRate['updated_date'];
                }else{
                    $Rates[$date]['date'] = $date;
                    $Rates[$date]['day'] = date('D', strtotime($date));
                    $Rates[$date]['single_sell'] = 100;
                    $Rates[$date]['single'] = round($Rates[$date]['single_sell']/1.155,2);
                    $Rates[$date]['double_sell'] = 200;
                    $Rates[$date]['double'] = round($Rates[$date]['double_sell']/1.155,2);
                    $Rates[$date]['tripple_sell'] = 300;
                    $Rates[$date]['tripple'] = round($Rates[$date]['tripple_sell']/1.155,2);

                    $Rates[$date]['breakfast'] = 0;
                    $Rates[$date]['updated_date'] = '';
                }
            }
        }

        $this->render('admin', compact(array('roomtypes', 'filter','Rates','flag')));
    }
}