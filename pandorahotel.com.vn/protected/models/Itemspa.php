<?php

/**
 * This is the model class for table "item_spa".
 *
 * The followings are the available columns in table 'item_spa':
 * @property integer $id
 * @property integer $category_spa
 * @property string $name
 * @property string $hours
 * @property string $price
 * @property string $price_discount
 * @property integer $display_order
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 */
class Itemspa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_spa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('category_spa, name, hours, price, price_discount, display_order, added_date, updated_date, updated_by, status', 'required'),
			array('category_spa, display_order, updated_by, status, hotel_id', 'numerical', 'integerOnly'=>true),
			array('name, added_date, updated_date', 'safe'),
			array('hours, price, price_discount', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category_spa, name, hours, price, price_discount, display_order, added_date, updated_date, updated_by', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'spa' => array(self::BELONGS_TO, 'Categoryspa', 'category_spa'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_spa' => 'Category Spa',
			'name' => 'Name',
			'hours' => 'Hours',
			'price' => 'Price',
			'price_discount' => 'Price Discount',
			'display_order' => 'Display Order',
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
		$criteria->compare('category_spa',$this->category_spa);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('hours',$this->hours,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('price_discount',$this->price_discount,true);
		$criteria->compare('display_order',$this->display_order);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getList($category){
		$criteria = new CDbCriteria;
		$criteria->compare('category_spa', $category, false);
		$criteria->compare('status', 0, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'display_order ASC')
		));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
