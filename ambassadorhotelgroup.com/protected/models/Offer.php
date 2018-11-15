<?php

/**
 * This is the model class for table "offers".
 *
 * The followings are the available columns in table 'offers':
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $short_description
 * @property string $cover_photo
 * @property integer $display_order
 * @property integer $status
 * @property integer $type
 */
class Offer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'offers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, description, short_description, type', 'required'),
			array('roomtype_id, display_order, status, promotion_id, hotel_id', 'numerical', 'integerOnly'=>true),
			array('slug, cover_photo, type', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, slug, description, short_description, cover_photo, display_order, status, type', 'safe', 'on'=>'search'),
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
			'hotel' => array(self::BELONGS_TO, 'Hotel', 'hotel_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'slug' => 'Slug',
			'description' => 'Description',
			'short_description' => 'Short Description',
			'cover_photo' => 'Cover Photo',
			'display_order' => 'Display Order',
			'status' => 'Status',
			'type' => 'Type',
			'roomtype_id' => 'Roomtype',
			'promotion_id' => 'Promotion'
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('short_description',$this->short_description,true);
		$criteria->compare('cover_photo',$this->cover_photo,true);
		$criteria->compare('display_order',$this->display_order);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => 50)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Offer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getList($hotel=''){
		$criteria = new CDbCriteria;
		if($hotel){
			$criteria->compare('hotel_id', $hotel, false);
		}
		$criteria->compare('status', 0, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'display_order ASC')
		));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public function getOther($slug){
		$criteria = new CDbCriteria;
		$criteria->addCondition('slug!="'.$slug.'"');
		$criteria->compare('status', 0, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'display_order ASC')
		));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public function getBySlug($slug){
		$criteria = new CDbCriteria;
		$criteria->compare('slug', $slug, false);
		$criteria->compare('status', 0, false);
		$dataProvider = Offer::model()->find($criteria);
		return $dataProvider;
	}
}
