<?php

/**
 * This is the model class for table "slideshow".
 *
 * The followings are the available columns in table 'slideshow':
 * @property integer $id
 * @property string $name
 * @property integer $ordering
 * @property integer $status
 * @property string $description
 */
class Slideshow extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'slideshow';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, ordering', 'required'),
			array('ordering, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('description', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, ordering, status, description', 'safe', 'on'=>'search'),
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
			'name' => 'Photo',
			'ordering' => 'Display order',
			'status' => 'Status',
			'description' => 'Description',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('status',$this->status);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getList(){
		$criteria = new CDbCriteria;
		$criteria->compare('status', 1, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array('defaultOrder'=>'ordering ASC')));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public function getListbytype($type){
		$criteria = new CDbCriteria;
		$criteria->compare('type', $type, false);
		$criteria->compare('status', 1, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array('defaultOrder'=>'ordering ASC')));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
