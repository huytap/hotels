<?php

/**
 * This is the model class for table "trackings".
 *
 * The followings are the available columns in table 'trackings':
 * @property string $id
 * @property string $type
 * @property string $object_id
 * @property string $object_name
 * @property string $date
 * @property string $user_id
 * @property string $value
 */
class Trackings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'trackings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id, type, object_id, object_name, date, user_id', 'required'),
			array('id, user_id', 'length', 'max'=>10),
			array('object_type, type, object_id', 'length', 'max'=>50),
			array('object_name', 'length', 'max'=>100),
			array('value', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, object_type, object_id, object_name, date, user_id, value', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'object_type' => 'Object Type',
			'object_id' => 'Object ID',
			'object_name' => 'Object Name',
			'date' => 'Date',
			'user_id' => 'User',
			'value' => 'Value',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('object_type',$this->object_type,true);
		$criteria->compare('object_id',$this->object_id,true);
		$criteria->compare('object_name',$this->object_name,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Trackings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
