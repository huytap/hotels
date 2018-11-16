<?php

/**
 * This is the model class for table "category_spa".
 *
 * The followings are the available columns in table 'category_spa':
 * @property integer $id
 * @property string $name
 * @property integer $order
 * @property integer $status
 */
class Categoryspa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category_spa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order, status, hotel_id', 'numerical', 'integerOnly'=>true),
			array('name, added_date, updated_date, updated_by', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, order, status', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'order' => 'Order',
			'status' => 'Status',
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
		$criteria->compare('order',$this->order);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getList(){
		$criteria = new CDbCriteria;
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => '`order` ASC')
		));
		$dataProvider->setPagination(false);
		$arrTheList = array();
		foreach ($dataProvider->getData() as $key => $value) {
			$name = json_decode($value['name'], true);
			$arrTheList[] = $name['en'];
		}
		return $arrTheList;
	}

	public function getList2(){
		$criteria = new CDbCriteria;
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => '`order` ASC')
		));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
