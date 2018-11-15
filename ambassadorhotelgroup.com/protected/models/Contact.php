<?php

/**
 * This is the model class for table "email_offers".
 *
 * The followings are the available columns in table 'email_offers':
 * @property integer $email
 * @property string $type
 * @property string $added_date
 * @property integer $give
 * @property integer $hotel
 * @property integer $confirmed
 */
class Contact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'email_offers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, type, added_date, give, hotel, confirmed', 'required'),
			array('email, give, hotel, confirmed', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>7),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('email, type, added_date, give, hotel, confirmed', 'safe', 'on'=>'search'),
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
			'hotels'=>array(self::BELONGS_TO, 'Hotel', 'hotel')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Email',
			'type' => 'Type',
			'added_date' => 'Added Date',
			'give' => 'Give',
			'hotel' => 'Hotel',
			'confirmed' => 'Confirmed',
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

		$criteria->compare('email',$this->email);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('give',$this->give);
		$criteria->compare('hotel',$this->hotel);
		$criteria->compare('confirmed',$this->confirmed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
