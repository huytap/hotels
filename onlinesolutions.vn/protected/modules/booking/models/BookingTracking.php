<?php

/**
 * This is the model class for table "booking_trackings".
 *
 * The followings are the available columns in table 'booking_trackings':
 * @property integer $id
 * @property integer $hotel
 * @property string $checkin
 * @property string $checkout
 * @property string $added_date
 * @property string $ip_address
 */
class BookingTracking extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'booking_trackings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, hotel, checkin, checkout, added_date, ip_address', 'required'),
			array('id, hotel', 'numerical', 'integerOnly'=>true),
			array('ip_address', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hotel, checkin, checkout, added_date, ip_address', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hotel' => 'Hotel',
			'checkin' => 'Checkin',
			'checkout' => 'Checkout',
			'added_date' => 'Added Date',
			'ip_address' => 'Ip Address',
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
		$criteria->compare('hotel',$this->hotel);
		$criteria->compare('checkin',$this->checkin,true);
		$criteria->compare('checkout',$this->checkout,true);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('ip_address',$this->ip_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookingTracking the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function check($ip, $checkin, $checkout, $hotel){
    	$criteria = new Criteria;
    	$criteria->ip_address=$ip;
    	$criteria->checkin=$checkin;
    	$criteria->checkout=$checkout;
        $criteria->hotel=$hotel;
    	$data = Booking::model()->find($criteria);
    	return $data;
    }
}
