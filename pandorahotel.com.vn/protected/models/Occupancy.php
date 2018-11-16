<?php

/**
 * This is the model class for table "occupancies".
 *
 * The followings are the available columns in table 'occupancies':
 * @property integer $id
 * @property integer $roomtype_id
 * @property integer $no_of_adult
 * @property integer $no_of_child
 * @property integer $no_of_extrabed
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 */
class Occupancy extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'occupancies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('roomtype_id, no_of_adult, no_of_child, no_of_extrabed', 'required'),
			array('roomtype_id, no_of_adult, no_of_child, no_of_extrabed, updated_by', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, roomtype_id, no_of_adult, no_of_child, no_of_extrabed, added_date, updated_date, updated_by', 'safe', 'on'=>'search'),
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
			'roomtype_id' => 'Roomtype',
			'no_of_adult' => 'No Of Adult',
			'no_of_child' => 'No Of Child',
			'no_of_extrabed' => 'No Of Extrabed',
			'added_date' => 'Added Date',
			'updated_date' => 'Updated Date',
			'updated_by' => 'Updated By',
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
		$criteria->compare('roomtype_id',$this->roomtype_id);
		$criteria->compare('no_of_adult',$this->no_of_adult);
		$criteria->compare('no_of_child',$this->no_of_child);
		$criteria->compare('no_of_extrabed',$this->no_of_extrabed);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function checkExists($roomtype){
        $model = Occupancy::model()->findByAttributes(array('roomtype_id' => $roomtype));
        return $model;
    }
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
