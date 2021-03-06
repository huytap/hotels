<?php

/**
 * This is the model class for table "book_services".
 *
 * The followings are the available columns in table 'book_services':
 * @property integer $id
 * @property integer $booking_id
 * @property integer $package_id
 * @property integer $hotel_id
 * @property integer $no_of_adult
 * @property integer $no_of_child
 * @property double $price_adult
 * @property double $price_child
 * @property integer $free
 * @property string $request_date
 *
 * The followings are the available model relations:
 * @property Orders $booking
 * @property Packages $package
 * @property Hotels $hotel
 */
class BookService extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'book_services';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('booking_id, package_id, hotel_id, request_date', 'required'),
			array('booking_id, package_id, hotel_id, no_of_adult, no_of_child, free', 'numerical', 'integerOnly'=>true),
			array('price_adult, price_child', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, booking_id, package_id, hotel_id, no_of_adult, no_of_child, price_adult, price_child, free, request_date', 'safe', 'on'=>'search'),
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
			'package' => array(self::BELONGS_TO, 'Packages', 'package_id'),
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
			'package_id' => 'Package',
			'hotel_id' => 'Hotel',
			'no_of_adult' => 'No Of Adult',
			'no_of_child' => 'No Of Child',
			'price_adult' => 'Price Adult',
			'price_child' => 'Price Child',
			'free' => 'Free',
			'request_date' => 'Request Date',
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
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('no_of_adult',$this->no_of_adult);
		$criteria->compare('no_of_child',$this->no_of_child);
		$criteria->compare('price_adult',$this->price_adult);
		$criteria->compare('price_child',$this->price_child);
		$criteria->compare('free',$this->free);
		$criteria->compare('request_date',$this->request_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookService the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
