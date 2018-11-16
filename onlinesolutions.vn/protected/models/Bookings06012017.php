<?php
class Bookings extends CActiveRecord
{
	public $email_confirm;
	public function tableName()
	{
		return 'bookings';
	}

	public function rules() 
    {
        return array( 
            //array('first_name, last_name, email, country, card_number, card_name, card_expired, card_cvv', 'required'),
            array('confirm_cvv, card_number, sent_mail, sent_cvv, view, roomtype_id, promotion_id, hotel_id, no_of_adults, no_of_child, no_of_extrabed, no_of_room', 'numerical', 'integerOnly'=>true),
            array('total, total_no_tax,total_no_tax_vnd,total_no_tax_airport,total_no_tax_vnd_airport,extrabed_price,change_currency_rate, total_vnd, tax, service_charge, pickup_price, dropoff_price, rate_vnd, rate', 'numerical'),
            array('short_id', 'length', 'max'=>10),
            array('first_name, last_name, phone, card_expired, card_type, pickup_time, pickup_flight, dropoff_time, dropoff_flight', 'length', 'max'=>20),
            array('email, status, card_name, ip_address,country_code, pickup_vehicle, dropoff_vehicle', 'length', 'max'=>50),
            array('book_from, country, code, srcFile', 'length', 'max'=>100),
            array('currency', 'length', 'max'=>10),
            array('notes, step', 'length', 'max'=>765),
            array('token, seats, reason, verison', 'safe'),
            array('id, short_id, first_name, version,last_name, email, request_date, status, total, country_code,country, code, phone, card_number, card_name, card_expired, card_cvv, change_currency_rate, currency, total_vnd, ip_address, notes, card_type, srcFile, view, tax, service_charge, roomtype_id, promotion_id, hotel_id, no_of_adults, no_of_child, no_of_extrabed, checkin, checkout, pickup_date, pickup_time, pickup_flight, pickup_price, dropoff_date, dropoff_time, dropoff_flight, dropoff_price, no_of_room, rate_vnd, rate', 'safe', 'on'=>'search'),
        ); 
    } 

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'promotion' => array(self::BELONGS_TO, 'Promotion', 'promotion_id'),
			'roomtype' => array(self::BELONGS_TO, 'Roomtype', 'roomtype_id'),
			'hotel' => array(self::BELONGS_TO, 'Hotel', 'hotel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'short_id' => 'Booking ID',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'request_date' => 'Request Date',
			'status' => 'Status',
			'total' => 'Total',
			'country' => 'Country',
			'code' => 'Code',
			'phone' => 'Phone',
			'card_number' => 'Card Number',
			'card_name' => 'Card Name',
			'card_expired' => 'Card Expired',
			'card_cvv' => 'Card Cvv',
			'change_currency_rate' => 'Change Currency Rate',
			'currency' => 'Currency',
			'total_vnd' => 'Total VND',
			'total' => 'Customer\' Rate Total',
			'notes' => 'Additional note for us',
			'hotel_id' => 'Hotel',
			'roomtype_id' => 'Roomtype',
			'promotion_id' => 'Promotion',
			'no_of_adults' => 'No Of Adults',
			'no_of_children' => 'No Of Children',
			'no_of_extrabed' => 'No Of Extrabed',
			'checkin' => 'Checkin',
			'checkout' => 'Checkout',
			'pickup_date' => 'Pickup Date',
			'pickup_time' => 'Pickup Time',
			'pickup_price' => 'Pickup Price',
			'dropoff_date' => 'Dropoff Date',
			'dropoff_time' => 'Dropoff Time',
			'dropoff_price' => 'Dropoff Price',
			'extrabed_price'=>'Extrabed Price',
			'pickup_vehicle' => 'Pickup Vehicle',
			'dropoff_vehicle' => 'Drop-off Vehicle'

		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($params)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('short_id',$this->short_id,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		
		$criteria->compare('total',$this->total);
		$criteria->compare('country_code',$this->country_code);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('card_number',$this->card_number);
		$criteria->compare('card_name',$this->card_name,true);
		$criteria->compare('card_expired',$this->card_expired,true);
		$criteria->compare('card_cvv',$this->card_cvv);
		$criteria->compare('change_currency_rate',$this->change_currency_rate);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('total_vnd',$this->total_vnd);
		$criteria->compare('roomtype_id',$this->roomtype_id);
        $criteria->compare('promotion_id',$this->promotion_id);
        $criteria->compare('version',$this->version);
        $criteria->compare('no_of_adults',$this->no_of_adults);
        $criteria->compare('no_of_child',$this->no_of_child);
        $criteria->compare('no_of_extrabed',$this->no_of_extrabed);
        if(isset($params['fromDate']) && $params['fromDate'] !== '' && 
        	isset($params['toDate']) && $params['toDate'] !== ''){
        	$fromDate = ExtraHelper::date_2_save($params['fromDate']);
			$toDate = ExtraHelper::date_2_save($params['toDate']);
        	$criteria->addCondition('checkin >="'. $fromDate['date'] .'" AND checkout<="'. $toDate['date'] . '"');
        }
        if(isset($params['request_date_from']) && $params['request_date_from'] !== '' && 
        	isset($params['request_date_to']) && $params['request_date_to'] !== ''){
        	$request_fromDate = ExtraHelper::date_2_save($params['request_date_from']);
			$request_toDate = ExtraHelper::date_2_save($params['request_date_to']);
        	$criteria->addCondition('request_date BETWEEN "'. $request_fromDate['date'] .' ' .$params['request_time_from'].':00" AND "'. $request_toDate['date'] . ' '.$params['request_time_to'].':00"');
	    }
        
        if($params['hotel']){
        	$criteria->addCondition('hotel_id='.$params['hotel']);
        }else{
        	$criteria->compare('hotel_id', Yii::app()->session['hotel'], false, 'AND');
        }

        $criteria->compare('pickup_date',$this->pickup_date,true);
        $criteria->compare('pickup_time',$this->pickup_time,true);
        $criteria->compare('pickup_flight',$this->pickup_flight,true);
        $criteria->compare('pickup_price',$this->pickup_price);
        $criteria->compare('dropoff_date',$this->dropoff_date,true);
        $criteria->compare('dropoff_time',$this->dropoff_time,true);
        $criteria->compare('dropoff_flight',$this->dropoff_flight,true);
        $criteria->compare('dropoff_price',$this->dropoff_price);
        $criteria->compare('no_of_room',$this->no_of_room);
        $criteria->compare('rate_vnd',$this->rate_vnd);
        $criteria->compare('rate',$this->rate);
        $criteria->compare('extrabed_price',$this->extrabed_price);
        if($params['status']){
        	$criteria->compare('status',$params['status'], false);
        }
        /*elseif($this->status){
        	//$criteria->compare('status',$this->status);
        	//$criteria->addCondition('status in ("confirmed","failed","cancelled","amended")');
        	$criteria->addCondition('status !="option" AND status!="deleted"');
        }*/
        $criteria->addCondition('status in ("confirmed","failed","cancelled","amended")');
        //$criteria->addCondition('status!="delete"');
		if(isset($_REQUEST['id']) && $_REQUEST['id']=='new'){
			$criteria->compare('view', 0, false);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'request_date DESC'),
			'pagination' => array('pageSize' => 50)
		));
	}

	public function getNotification(){
		$criteria = new CDbCriteria;
		if(Yii::app()->session['hotel']){
			$criteria->compare('hotel_id', Yii::app()->session['hotel'], false);
		}
		$criteria->compare('view',0, false);
		$criteria->limit=5;
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'request_date DESC')));
		$dataProvider->setPagination(false);
		return $dataProvider->getData();
	}

	public function getNew(){
		$criteria= new CDbCriteria;
		$criteria->compare('view',0, false);
		if(Yii::app()->session['hotel']){
			$criteria->compare('hotel_id', Yii::app()->session['hotel'], false);
		}
		//$criteria->compare('status', '')
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'request_date DESC')));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public function getOrderByMonth($filter, $status='done', $hotel=''){
		$fromDate = $filter['year'].'-'.$filter['month'] .'-01';
		$toDate = $filter['year'].'-'.$filter['month'] .'-31';
		$criteria = new CDbCriteria;
		$criteria->select='DATE(t.request_date) request_date,count(DATE(t.request_date)) total';
		if($status=='done'){
			$criteria->condition='t.status="confirmed" OR t.status="amended"';
		}elseif($status=='cancelled'){
			$criteria->condition='t.status="cancelled"';
		}
		
		if($hotel)
			$criteria->addCondition('hotel_id='.$hotel);
		$criteria->addCondition('DATE(request_date) BETWEEN "'. $fromDate .'" AND "'. $toDate . '"');
		$criteria->group='DATE(t.request_date)';
		/*$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria));
		$dataProvider->setPagination(false);*/
		$dataProvider=Bookings::model()->find($criteria);
		return $dataProvider;
	}

	public function getListByDate($filter){
		$criteria = new CDbCriteria;
		if(isset($filter['request_date'])){
			$criteria->condition = 'date(t.request_date)='.date('Y-m-d',strtotime($filter['request_date']));
		}
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public function getList($params){
		$criteria = new CDbCriteria;

		if($params['fromDate'] && $params['toDate']){
        	$fromDate = ExtraHelper::date_2_save($params['fromDate']);
			$toDate = ExtraHelper::date_2_save($params['toDate']);
        	$criteria->addCondition('checkin >="'. $fromDate['date'] .'" AND checkout<="'. $toDate['date'] . '"');
        }
        if($params['request_date_from'] && 
        	$params['request_date_to']){
        	$request_fromDate = ExtraHelper::date_2_save($params['request_date_from']);
			$request_toDate = ExtraHelper::date_2_save($params['request_date_to']);
        	$criteria->addCondition('request_date BETWEEN "'. $request_fromDate['date'] .' ' .$params['request_time_from'].':00" AND "'. $request_toDate['date'] . ' '.$params['request_time_to'].':00"');
	    }
	    /*
		if($params['fromDate'] && $params['toDate']){
			$fromDate = ExtraHelper::date_2_save($params['fromDate']);
			$toDate = ExtraHelper::date_2_save($params['toDate']);
			$criteria->condition = 'DATE(request_date) BETWEEN "'. $fromDate['date'] .'" AND "'. $toDate['date'] . '"';
		}*/
		$criteria->compare('hotel_id', Yii::app()->session['hotel'], false, 'AND');
		if($params['status']){
			$criteria->compare('status', $params['status'], false);
		}

		//$criteria->addCondition('status="confirmed"');
		$criteria->addCondition('status in ("confirmed","failed","cancelled","amended")');
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'request_date ASC')));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public function getBooking($status, $token){
		$criteria = new CDbCriteria;
		$criteria->compare('token', $token, false);
		$criteria->compare('status', $status, false);
		/*$data = new CActiveDataProvider($this, array(
			'criteria' => $criteria));
		$data->setPagination(false);*/
		$data = Bookings::model()->find($criteria);
		return $data;
	}

	public function getByShortID($short_id){
		$criteria = new CDbCriteria;
		$criteria->compare('short_id', $short_id, false);
		$data = Bookings::model()->find($criteria);
		return $data;
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
