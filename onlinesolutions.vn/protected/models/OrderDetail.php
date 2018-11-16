<?php

/**
 * This is the model class for table "order_details".
 *
 * The followings are the available columns in table 'order_details':
 * @property integer $id
 * @property integer $booking_id
 * @property integer $roomtype_id
 * @property integer $promotion_id
 * @property integer $hotel_id
 * @property integer $no_of_adult
 * @property integer $no_of_child
 * @property integer $no_of_extrabed
 * @property integer $no_of_rooms
 * @property string $checkin
 * @property string $checkout
 * @property integer $booked_nights
 * @property string $pickup_date
 * @property string $pickup_time
 * @property string $pickup_flight
 * @property double $pickup_price
 * @property string $pickup_vehicle
 * @property string $dropoff_date
 * @property string $dropoff_time
 * @property string $dropoff_flight
 * @property double $dropoff_price
 * @property string $dropoff_vehicle
 * @property double $rate
 * @property double $rate_vnd
 *
 * The followings are the available model relations:
 * @property Orders $booking
 * @property Roomtypes $roomtype
 * @property Promotions $promotion
 * @property Hotels $hotel
 */
class OrderDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('booking_id, roomtype_id, promotion_id, hotel_id, no_of_adult, no_of_child, no_of_extrabed, no_of_rooms, checkin, checkout, rate, rate_vnd', 'required'),
			array('booking_id, roomtype_id, promotion_id, hotel_id, no_of_adult, no_of_child, no_of_extrabed, no_of_rooms, booked_nights', 'numerical', 'integerOnly'=>true),
			array('pickup_price, dropoff_price, rate, rate_vnd', 'numerical'),
			array('pickup_time, dropoff_time', 'length', 'max'=>8),
			array('pickup_flight, pickup_vehicle, dropoff_flight, dropoff_vehicle', 'length', 'max'=>32),
			array('pickup_date, dropoff_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, booking_id, roomtype_id, promotion_id, hotel_id, no_of_adult, no_of_child, no_of_extrabed, no_of_rooms, checkin, checkout, booked_nights, pickup_date, pickup_time, pickup_flight, pickup_price, pickup_vehicle, dropoff_date, dropoff_time, dropoff_flight, dropoff_price, dropoff_vehicle, rate, rate_vnd', 'safe', 'on'=>'search'),
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
			'booking' => array(self::BELONGS_TO, 'Orders', 'booking_id'),
			'roomtype' => array(self::BELONGS_TO, 'Roomtypes', 'roomtype_id'),
			'promotion' => array(self::BELONGS_TO, 'Promotions', 'promotion_id'),
			'hotel' => array(self::BELONGS_TO, 'Hotels', 'hotel_id'),
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
			'roomtype_id' => 'Roomtype',
			'promotion_id' => 'Promotion',
			'hotel_id' => 'Hotel',
			'no_of_adult' => 'No Of Adult',
			'no_of_child' => 'No Of Child',
			'no_of_extrabed' => 'No Of Extrabed',
			'no_of_rooms' => 'No Of Rooms',
			'checkin' => 'Checkin',
			'checkout' => 'Checkout',
			'booked_nights' => 'Booked Nights',
			'pickup_date' => 'Pickup Date',
			'pickup_time' => 'Pickup Time',
			'pickup_flight' => 'Pickup Flight',
			'pickup_price' => 'Pickup Price',
			'pickup_vehicle' => 'Pickup Vehicle',
			'dropoff_date' => 'Dropoff Date',
			'dropoff_time' => 'Dropoff Time',
			'dropoff_flight' => 'Dropoff Flight',
			'dropoff_price' => 'Dropoff Price',
			'dropoff_vehicle' => 'Dropoff Vehicle',
			'rate' => 'Rate',
			'rate_vnd' => 'Rate Vnd',
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
		$criteria->compare('roomtype_id',$this->roomtype_id);
		$criteria->compare('promotion_id',$this->promotion_id);
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('no_of_adult',$this->no_of_adult);
		$criteria->compare('no_of_child',$this->no_of_child);
		$criteria->compare('no_of_extrabed',$this->no_of_extrabed);
		$criteria->compare('no_of_rooms',$this->no_of_rooms);
		$criteria->compare('checkin',$this->checkin,true);
		$criteria->compare('checkout',$this->checkout,true);
		$criteria->compare('booked_nights',$this->booked_nights);
		$criteria->compare('pickup_date',$this->pickup_date,true);
		$criteria->compare('pickup_time',$this->pickup_time,true);
		$criteria->compare('pickup_flight',$this->pickup_flight,true);
		$criteria->compare('pickup_price',$this->pickup_price);
		$criteria->compare('pickup_vehicle',$this->pickup_vehicle,true);
		$criteria->compare('dropoff_date',$this->dropoff_date,true);
		$criteria->compare('dropoff_time',$this->dropoff_time,true);
		$criteria->compare('dropoff_flight',$this->dropoff_flight,true);
		$criteria->compare('dropoff_price',$this->dropoff_price);
		$criteria->compare('dropoff_vehicle',$this->dropoff_vehicle,true);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('rate_vnd',$this->rate_vnd);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
