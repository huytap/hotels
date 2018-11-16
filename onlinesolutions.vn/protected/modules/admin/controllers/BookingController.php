<?php

class BookingController extends AdminController{

    public function filters(){
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            array('booster.filters.BoosterFilter - delete')
        );
    }

    public function accessRules(){
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
    public function actionAdmin($id=null){
        //try{
            $model = new Bookings('search');
            $model->unsetAttributes();
            if(isset($_GET['Bookings'])){
                $model->attributes = $_GET['Bookings'];
            }

            $filter = array(
                'request_date_from'=>'',
                'request_date_to' => '',
                'request_time_from' =>'',
                'request_time_to' => '',
                'fromDate' => '',
                'toDate'=>'',
                'hotel' => Yii::app()->session['hotel'],
                'status' => '',
            );
            if(isset($_GET['filter'])){
                $filter = $_GET['filter'];
            }
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                header( 'Content-type: application/json' );
                $this->renderPartial('_grid', compact(array('model','id','filter')));
                Yii::app()->end();
            }

            
            if (isset($_REQUEST['do_export']) && $_REQUEST['do_export']=='yes') {
                $data = ReportHelper::dataBooking($filter);
                $arrReport = array(
                    'template' => 'booking.xls',
                    'baserow' => 3,
                    'filename' => 'Bookings Report.xls'
                );
                $arrCells = array(
                    'A1' => 'Bookings Report On ' . date('j F Y'),
                );
                ReportHelper::doExport($arrReport, $data, $arrCells);
            }

            $this->render('admin', compact(array('model','id','filter')));
        //}catch(Exception $ex){echo '';}
    }

    public function actionView($id){
        $model = $this->loadModel($id);
        if($model->view==0){
            $model->view = 1;
            $model->update();
        }
        $this->render('view', compact(array('model')));
    }

    public function actionShowcard(){
        if(isset($_POST['type'])){
            $user = Users::model()->findByPk(Yii::app()->user->id);
            if($user['password'] == sha1(md5($_POST['type']))){
                $Bookings = Bookingss::model()->findByPk($_POST['id']);
                echo json_encode(base64_decode($Bookings['code']));
            }else{
                echo json_encode(-1);
            }
        }else{
            echo json_encode(0);
        }
    }

    public function actionDelete($id){
        $model=$this->loadModel($id);
        //$detail = OrderDetail::model()->getDetail($id);
        /*if(isset($detail)){
           $detail->delete(); 
        }*/
        //if($model->delete()){
        $model->status='delete';
        if($model->update())
            echo json_encode(1);
        //}
    }
    public function loadModel($id){
        $model = Bookings::model()->findByPk($id);
        $hotel = Hotel::model()->findByPk($model['hotel_id']);
        AdminExtra::checkPermissionHotel(Yii::app()->user->id, $hotel['chain_id']);
        return $model;
    }

    public function actionReport(){
        $filter_data = array(
            'fromDate' => '',
            'toDate'=>'',
            'status' => ''
        );
        if(isset($_POST['filter'])){
            $filter_data = $_POST['filter'];
        }

        $data = ReportHelper::dataBooking($filter_data);
        if (isset($_REQUEST['do_export']) && $_REQUEST['do_export']=='yes') {
            $arrReport = array(
                'template' => 'booking.xls',
                'baserow' => 3,
                'filename' => 'Bookings Report.xls'
            );
            $arrCells = array(
                'A1' => 'Bookings Report On ' . date('j F Y'),
            );
            ReportHelper::doExport($arrReport, $data, $arrCells);
        } else {
            $this->render('report',array(
                'datalist'=>$data,
                'filter'=>$filter_data,
            ));
        }
    }

    public function actionCancel(){
        $this->layout=false;
        if(isset($_POST['id']) && isset($_POST['cancel_reason'])){
            $model=$this->loadModel($_POST['id']);
            if($model->BookingsStatus){
                $model->BookingsStatus='cancel';
                $model->cancel_time = date('Y-m-d H:m:i');
                $model->cancel_reason = $_POST['cancel_reason'];
                if($model->update()){
                    if($_POST['send_email']==1){
                        $message = new YiiMailMessage;
                        $message->view = "confirm";                        
                        $params = array(
                            'booked' => $model,
                            'hotel' => $hotel);
                        $message->subject = 'Confirmation for your Bookings ' . strtoupper($model['short_id']);
                        $message->setBody($params, 'text/html');
                        $message->addTo($model['email']);                            
                        $message->addBcc('nghuytap@gmail.com');
                        $message->addReplyTo('no_reply@aristosaigonhotel.com', 'No Reply');
                        $message->addFrom('no_reply@aristosaigonhotel.com', 'Cancelled Bookings');
                        //var_dump($message);die;
                        //$message->cc = $hotel['email_sales'];
                        $result = Yii::app()->mail->send($message);
                    }
                    echo json_encode(MyFunctionCustom::$BookingsStatus[$model->BookingsStatus]);
                }
            }else{
                echo json_encode(0);
            }
        }
    }
}