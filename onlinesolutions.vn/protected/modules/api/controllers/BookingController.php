<?php
class BookingController extends Controller
{
    private $format = 'json';

    public function filters(){
            return array();
    }

    public function actionIndex(){
        ExtraHelper::_checkAuth($chain_id);
        $auth = getallheaders();
        if(isset($auth['hotel'])){
            $hotel = Hotel::model()->getHotelBySlug2($auth['hotel'], $chain_id);
            if($hotel){
                Yii::app()->session['_hotel'] = $hotel;
                unset(Yii::app()->session['_booked']);
                $model = new FormBook;
                $now = date('d-m-Y');
                
                $params = array(
                    'fromDate' => $now,
                    'toDate' => date('d-m-Y', strtotime("$now +1day")),
                    'adult' => 2,
                    'children' => 0,
                    'hotel' => $hotel['id'],
                    'no_of_room' => 0
                );
                
                /*post method*/
                if(isset($_POST['checkindate']) && 
                    strtotime($_POST['checkindate'])>=strtotime($now)){
                    $params['fromDate'] = $_POST['checkindate'];
                }
                if(isset($_POST['checkoutdate']) && 
                    strtotime($_POST['checkoutdate'])>strtotime($now) && 
                    strtotime($_POST['checkoutdate'])>strtotime($params['fromDate'])){
                    $params['toDate'] = $_POST['checkoutdate'];   
                }
                if(isset($_POST['adult'])){
                    $params['adult'] = $_POST['adult'];
                }
                if(isset($_POST['children'])){
                    $params['children'] = $_POST['children'];
                }
                Yii::app()->session['_params'] = $params;
                if(!Yii::app()->session['change_currency']){
                    Yii::app()->session['change_currency'] = 'VND';
                }
                $list_curr = ExchangeRate::model()->getList2();
                if(isset($_POST['currency'])){
                    Yii::app()->session['change_currency'] = $_POST['currency'];
                }elseif(!Yii::app()->session['change_currency']){                    
                    Yii::app()->session['change_currency'] = 'VND';
                }
                $change_currency = Yii::app()->session['change_currency'];
                /*USD is default currency*/
                $defaultRate = (array)ExchangeRate::model()->convertCurrencyToUSD('USD');
                /*submit change currency*/
                $changeRate = (array)ExchangeRate::model()->convertCurrencyToUSD($change_currency);
                $exchangeRate = $defaultRate['sell'] / $changeRate['sell'];
                $params['exchangeRates'] = $exchangeRate;
                $params['currency'] = $change_currency;
                /*get room available*/
                $available = BookingHelper::getRoomRate($params);
                //echo"<pre>";print_r($available);die;
                Yii::app()->session['_available']=$available;
                /*book roomtype*/
                if(isset($_GET['flag']) && $_GET['flag']==true || 
                    (isset($_POST['flag']) && $_POST['flag']==true)){
                    $this->layout = false;
                    $this->render('ajax', array(
                        'available' => $available, 
                        'params' => $params,
                        'model' => $model,
                        'hotel'=>$hotel));
                }else{
                    $this->render('index', array(
                        'available' => $available, 
                        'params' => $params,
                        'model' => $model,
                        'hotel'=>$hotel));
                }
            }else{
                echo json_encode(0);
            }
        }

        echo CJSON::encode(array(1, 2, 3));
    }

    public function actionList(){
        $this->_checkAuth();
        switch($_GET['model'])
        {
            case 'posts': // {{{ 
                $models = Post::model()->findAll();
                break; // }}} 
            default: // {{{ 
                $this->_sendResponse(501, sprintf('Error: Mode <b>list</b> is not implemented for model <b>%s</b>',$_GET['model']) );
                exit; // }}} 
        }
        if(is_null($models)) {
            $this->_sendResponse(200, sprintf('No items where found for model <b>%s</b>', $_GET['model']) );
        } else {
            $rows = array();
            foreach($models as $model)
                $rows[] = $model->attributes;

            $this->_sendResponse(200, CJSON::encode($rows));
        }
    }

    public function actionView(){
        $this->_checkAuth();
        // Check if id was submitted via GET
        if(!isset($_GET['id']))
            $this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );

        switch($_GET['model'])
        {
            // Find respective model    
            case 'posts': // {{{ 
                $model = Post::model()->findByPk($_GET['id']);
                break; // }}} 
            default: // {{{ 
                $this->_sendResponse(501, sprintf('Mode <b>view</b> is not implemented for model <b>%s</b>',$_GET['model']) );
                exit; // }}} 
        }
        if(is_null($model)) {
            $this->_sendResponse(404, 'No Item found with id '.$_GET['id']);
        } else {
            $this->_sendResponse(200, $this->_getObjectEncoded($_GET['model'], $model->attributes));
        }
    }

    public function actionCreate(){
        $this->_checkAuth();

        switch($_GET['model'])
        {
            // Get an instance of the respective model
            case 'posts': // {{{ 
                $model = new Post;                    
                break; // }}} 
            default: // {{{ 
                $this->_sendResponse(501, sprintf('Mode <b>create</b> is not implemented for model <b>%s</b>',$_GET['model']) );
                exit; // }}} 
        }
        // Try to assign POST values to attributes
        foreach($_POST as $var=>$value) {
            // Does the model have this attribute?
            if($model->hasAttribute($var)) {
                $model->$var = $value;
            } else {
                // No, raise an error
                $this->_sendResponse(500, sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var, $_GET['model']) );
            }
        }
        // Try to save the model
        if($model->save()) {
            // Saving was OK
            $this->_sendResponse(200, $this->_getObjectEncoded($_GET['model'], $model->attributes) );
        } else {
            // Errors occurred
            $msg = "<h1>Error</h1>";
            $msg .= sprintf("Couldn't create model <b>%s</b>", $_GET['model']);
            $msg .= "<ul>";
            foreach($model->errors as $attribute=>$attr_errors) {
                $msg .= "<li>Attribute: $attribute</li>";
                $msg .= "<ul>";
                foreach($attr_errors as $attr_error) {
                    $msg .= "<li>$attr_error</li>";
                }        
                $msg .= "</ul>";
            }
            $msg .= "</ul>";
            $this->_sendResponse(500, $msg );
        }

        var_dump($_REQUEST);
    }

    public function actionUpdate(){
        $this->_checkAuth();

        // Get PUT parameters
        parse_str(file_get_contents('php://input'), $put_vars);

        switch($_GET['model'])
        {
            // Find respective model
            case 'posts': // {{{ 
                $model = Post::model()->findByPk($_GET['id']);                    
                break; // }}} 
            default: // {{{ 
                $this->_sendResponse(501, sprintf('Error: Mode <b>update</b> is not implemented for model <b>%s</b>',$_GET['model']) );
                exit; // }}} 
        }
        if(is_null($model))
            $this->_sendResponse(400, sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",$_GET['model'], $_GET['id']) );
        
        // Try to assign PUT parameters to attributes
        foreach($put_vars as $var=>$value) {
            // Does model have this attribute?
            if($model->hasAttribute($var)) {
                $model->$var = $value;
            } else {
                // No, raise error
                $this->_sendResponse(500, sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var, $_GET['model']) );
            }
        }
        // Try to save the model
        if($model->save()) {
            $this->_sendResponse(200, sprintf('The model <b>%s</b> with id <b>%s</b> has been updated.', $_GET['model'], $_GET['id']) );
        } else {
            $msg = "<h1>Error</h1>";
            $msg .= sprintf("Couldn't update model <b>%s</b>", $_GET['model']);
            $msg .= "<ul>";
            foreach($model->errors as $attribute=>$attr_errors) {
                $msg .= "<li>Attribute: $attribute</li>";
                $msg .= "<ul>";
                foreach($attr_errors as $attr_error) {
                    $msg .= "<li>$attr_error</li>";
                }        
                $msg .= "</ul>";
            }
            $msg .= "</ul>";
            $this->_sendResponse(500, $msg );
        }
    }

    public function actionDelete(){
        $this->_checkAuth();

        switch($_GET['model'])
        {
            // Load the respective model
            case 'posts': // {{{ 
                $model = Post::model()->findByPk($_GET['id']);                    
                break; // }}} 
            default: // {{{ 
                $this->_sendResponse(501, sprintf('Error: Mode <b>delete</b> is not implemented for model <b>%s</b>',$_GET['model']) );
                exit; // }}} 
        }
        // Was a model found?
        if(is_null($model)) {
            // No, raise an error
            $this->_sendResponse(400, sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",$_GET['model'], $_GET['id']) );
        }

        // Delete the model
        $num = $model->delete();
        if($num>0)
            $this->_sendResponse(200, sprintf("Model <b>%s</b> with ID <b>%s</b> has been deleted.",$_GET['model'], $_GET['id']) );
        else
            $this->_sendResponse(500, sprintf("Error: Couldn't delete model <b>%s</b> with ID <b>%s</b>.",$_GET['model'], $_GET['id']) );
    }
}