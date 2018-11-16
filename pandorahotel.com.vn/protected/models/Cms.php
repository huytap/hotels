<?php

/**
 * This is the model class for table "cms".
 *
 * The followings are the available columns in table 'cms':
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $description
 * @property string $cover_photo
 * @property string $type
 * @property integer $hotel_id
 * @property integer $display_order
 * @property integer $status
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 */
class Cms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('parent_id, hotel_id, display_order, status, updated_by', 'numerical', 'integerOnly'=>true),
			array('cover_photo, type, minute, icon', 'length', 'max'=>128),
			array('short, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, title, description, cover_photo, type, hotel_id, display_order, status, added_date, updated_date, updated_by', 'safe', 'on'=>'search'),
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
			'parent_id' => 'Parent',
			'title' => 'Title',
			'short' => 'Short Description',
			'description' => 'Description',
			'cover_photo' => 'Cover Photo',
			'type' => 'Type',
			'hotel_id' => 'Hotel',
			'display_order' => 'Display Order',
			'status' => 'Status',
			'added_date' => 'Added Date',
			'updated_date' => 'Updated Date',
			'updated_by' => 'Updated By',
			'minute' => 'Times'
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('short',$this->description,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('cover_photo',$this->cover_photo,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('hotel_id',Yii::app()->session['hotel'], false);
		$criteria->compare('display_order',$this->display_order);
		$criteria->compare('status',$this->status);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>20)
		));
	}

	public function getList($type, $hotel=''){
		$criteria = new CDbCriteria;
		if($hotel){
			$criteria->compare('hotel_id', $hotel, false, 'AND');
		}
		$criteria->compare('type', $type, false);
		$criteria->compare('status', 0, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'display_order ASC')
		));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public function getListParent(){
		$criteria = new CDbCriteria;
		$criteria->compare('parent_id', 0, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
		$dataProvider->setPagination(false);
		$arrTheList = array();
		foreach($dataProvider->getData() as $data){
			$title = json_decode($data->title, true);
			$arrTheList[$data['id']] = $title['en'];
		}
		return $arrTheList;
	}

	public function getBySlug($slug, $hotel=''){
		$criteria = new CDbCriteria;
		$criteria->compare('slug', $slug, false, 'AND');
		//$criteria->compare('type', $slug, false, 'AND');
		if($hotel)
			$criteria->compare('hotel_id', $hotel, false, 'AND');
		$criteria->compare('status', 0, false, 'AND');
		$data = Cms::model()->find($criteria);
		return $data;
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getDesti($time){
		$criteria = new CDbCriteria;
		$criteria->compare('minute', $time, false, 'AND');
		if($hotel)
			$criteria->compare('hotel_id', $hotel, false, 'AND');
		$criteria->compare('status', 0, false, 'AND');
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'display_order asc')));
		return $dataProvider;
	}
}
