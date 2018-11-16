<?php

/**
 * This is the model class for table "booking_details".
 *
 * The followings are the available columns in table 'booking_details':
 * @property integer $id
 * @property integer $booking_id
 * @property integer $hotel_id
 * @property integer $roomtype_id
 * @property integer $promotion_id
 * @property integer $guest_stay
 * @property integer $no_of_adults
 * @property integer $no_of_children
 * @property integer $no_of_extrabed
 * @property string $checkin
 * @property string $checkout
 * @property string $pickup_date
 * @property string $pickup_time
 * @property string $pickup_price
 * @property string $dropoff_date
 * @property integer $dropoff_time
 * @property integer $dropoff_price
 */
class BookingDetail extends CActiveRecord
{
	public function tableName()
	{
		return 'booking_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('booking_id, hotel_id, roomtype_id, promotion_id, guest_stay, no_of_adults, no_of_children, no_of_extrabed, checkin, checkout, pickup_date, pickup_time, pickup_price, dropoff_date, dropoff_time, dropoff_price', 'required'),
			array('no_of_room, booking_id, hotel_id, roomtype_id, promotion_id, no_of_adults, no_of_children, no_of_extrabed', 'numerical', 'integerOnly'=>true),
			array('pickup_time,dropoff_flight,dropoff_flight', 'length', 'max'=>20),
			array('rate, rate_vnd, extrabed_price, guest_stay, dropoff_time, dropoff_price','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, booking_id, hotel_id, roomtype_id, promotion_id, guest_stay, no_of_adults, no_of_children, no_of_extrabed, checkin, checkout, pickup_date, pickup_time, pickup_price, dropoff_date, dropoff_time, dropoff_price', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'promotion' => array(self::BELONGS_TO, 'Promotion', 'promotion_id'),
			'roomtype' => array(self::BELONGS_TO, 'Roomtypes', 'roomtype_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'booking_id' => 'Booking',
			'hotel_id' => 'Hotel',
			'roomtype_id' => 'Roomtype',
			'promotion_id' => 'Promotion',
			'guest_stay' => 'Guest Stay',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('booking_id',$this->booking_id);
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('roomtype_id',$this->roomtype_id);
		$criteria->compare('promotion_id',$this->promotion_id);
		$criteria->compare('guest_stay',$this->guest_stay);
		$criteria->compare('no_of_adults',$this->no_of_adults);
		$criteria->compare('no_of_children',$this->no_of_children);
		$criteria->compare('no_of_extrabed',$this->no_of_extrabed);
		$criteria->compare('checkin',$this->checkin,true);
		$criteria->compare('checkout',$this->checkout,true);
		$criteria->compare('pickup_date',$this->pickup_date,true);
		$criteria->compare('pickup_time',$this->pickup_time,true);
		$criteria->compare('pickup_price',$this->pickup_price,true);
		$criteria->compare('dropoff_date',$this->dropoff_date,true);
		$criteria->compare('dropoff_time',$this->dropoff_time);
		$criteria->compare('dropoff_price',$this->dropoff_price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getDetail($id){
		$criteria = new CDbCriteria;
		$criteria->compare('booking_id', $id, false);
		$data = BookingDetail::model()->find($criteria);
		return $data;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
