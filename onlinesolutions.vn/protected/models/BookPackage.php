<?php

/**
 * This is the model class for table "book_packages".
 *
 * The followings are the available columns in table 'book_packages':
 * @property integer $id
 * @property integer $booking_id
 * @property integer $package_id
 * @property integer $adult
 * @property integer $child
 * @property string $added_date
 */
class BookPackage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'book_packages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('booking_id, package_id, adult, child, added_date', 'required'),
			array('booking_id, package_id, adult, child, free, exchange_rate', 'numerical', 'integerOnly'=>true),
			array('added_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, booking_id, package_id, adult, child, added_date', 'safe', 'on'=>'search'),
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
			'booking' => array(self::BELONGS_TO, 'Booking', 'booking_id'),
			'package' => array(self::BELONGS_TO, 'Package', 'package_id')
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
			'adult' => 'Adult',
			'child' => 'Child',
			'added_date' => 'Added Date',
			'free' => 'free'
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
		$criteria->compare('adult',$this->adult);
		$criteria->compare('child',$this->child);
		$criteria->compare('added_date',$this->added_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookPackage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getList($booking_id){
		$criteria = new CDbCriteria;
		$criteria->compare('booking_id', $booking_id, false);
		$criteria->addCondition('package_id>0');
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}
}
