<?php

/**
 * This is the model class for table "contacts".
 *
 * The followings are the available columns in table 'contacts':
 * @property integer $id
 * @property string $subject
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property integer $hotel_id
 * @property integer $type
 */
class Contact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contacts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject, email, phone, message', 'required'),
			array('hotel_id, type', 'numerical', 'integerOnly'=>true),
			array('subject', 'length', 'max'=>256),
			array('email', 'length', 'max'=>128),
			array('phone', 'length', 'max'=>20),
			array('date','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, subject, email, phone, message, hotel_id, type', 'safe', 'on'=>'search'),
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
			'subject' => 'Subject',
			'email' => 'Email',
			'phone' => 'Phone',
			'message' => 'Message',
			'hotel_id' => 'Hotel',
			'type' => 'Type',
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
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getList($date, $hotel=''){
		$criteria = new CDbCriteria;
		$criteria->condition = 'DATE(date) BETWEEN "'.$date.'-01" AND "'.$date.'-31"';
		if($hotel)
			$criteria->compare('hotel_id', $hotel, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
