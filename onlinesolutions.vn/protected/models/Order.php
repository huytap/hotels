<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $id
 * @property string $short_id
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $country
 * @property string $address
 * @property string $request_date
 * @property integer $status
 * @property string $ip_address
 * @property string $notes
 * @property string $card_type
 * @property string $card_number
 * @property string $card_name
 * @property string $card_expire
 * @property string $card_cvv
 * @property double $change_currency_rate
 * @property string $currency
 * @property integer $hotel_id
 * @property integer $view
 * @property string $token
 * @property integer $sent_mail
 * @property string $code
 *
 * The followings are the available model relations:
 * @property BookServices[] $bookServices
 * @property OrderDetails[] $orderDetails
 */
class Order extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('short_id, title, first_name, last_name, email, country, request_date, status, ip_address, card_type, card_number, card_name, card_expire, card_cvv, change_currency_rate, currency, hotel_id, token, code', 'required'),
			array('status, hotel_id, view, sent_mail', 'numerical', 'integerOnly'=>true),
			array('change_currency_rate', 'numerical'),
			array('short_id, card_expire, currency', 'length', 'max'=>8),
			array('title', 'length', 'max'=>10),
			array('first_name, last_name, email, token, code', 'length', 'max'=>128),
			array('phone, country, ip_address, card_type', 'length', 'max'=>32),
			array('address, notes', 'length', 'max'=>255),
			array('card_number', 'length', 'max'=>20),
			array('card_name', 'length', 'max'=>64),
			array('card_cvv', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, short_id, title, first_name, last_name, phone, email, country, address, request_date, status, ip_address, notes, card_type, card_number, card_name, card_expire, card_cvv, change_currency_rate, currency, hotel_id, view, token, sent_mail, code', 'safe', 'on'=>'search'),
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
			'bookServices' => array(self::HAS_MANY, 'BookServices', 'booking_id'),
			'orderDetails' => array(self::HAS_MANY, 'OrderDetails', 'booking_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'short_id' => 'Short',
			'title' => 'Title',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'phone' => 'Phone',
			'email' => 'Email',
			'country' => 'Country',
			'address' => 'Address',
			'request_date' => 'Request Date',
			'status' => 'Status',
			'ip_address' => 'Ip Address',
			'notes' => 'Notes',
			'card_type' => 'Card Type',
			'card_number' => 'Card Number',
			'card_name' => 'Card Name',
			'card_expire' => 'Card Expire',
			'card_cvv' => 'Card Cvv',
			'change_currency_rate' => 'Change Currency Rate',
			'currency' => 'Currency',
			'hotel_id' => 'Hotel',
			'view' => 'View',
			'token' => 'Token',
			'sent_mail' => 'Sent Mail',
			'code' => 'Code',
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
		$criteria->compare('short_id',$this->short_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('request_date',$this->request_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('card_type',$this->card_type,true);
		$criteria->compare('card_number',$this->card_number,true);
		$criteria->compare('card_name',$this->card_name,true);
		$criteria->compare('card_expire',$this->card_expire,true);
		$criteria->compare('card_cvv',$this->card_cvv,true);
		$criteria->compare('change_currency_rate',$this->change_currency_rate);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('view',$this->view);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('sent_mail',$this->sent_mail);
		$criteria->compare('code',$this->code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
