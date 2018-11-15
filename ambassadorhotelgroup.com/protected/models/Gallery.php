<?php

/**
 * This is the model class for table "galleries".
 *
 * The followings are the available columns in table 'galleries':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $added_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property string $updated_by
 */
class Gallery extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'galleries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('updated_by, type, roomtype_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('gallery_categories, description, added_date, updated_date, updated_by, photos', 'safe'),
			array('roomtype_id', 'checkRoom'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, added_date, updated_by, updated_date, updated_by', 'safe', 'on'=>'search'),
		);
	}

	public function checkRoom($attributes, $params){
		if($this->name=='room_hotel' && !$this->roomtype_id){
			$this->addError('roomtype_id', 'Please select roomtype');
		}
	}
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'items' => array(self::HAS_MANY,'Item','gallery_id'),
			'roomtype' => array(self::BELONGS_TO,'Roomtype','roomtype_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'roomtype_id'=>'Room type',
			'name' => 'Name',
			'description' => 'Description',
			'added_date' => 'Created Date',
			'updated_by' => 'Created By',
			'updated_date' => 'Updated Date',
			'updated_by' => 'Updated By',
		);
	}

	public function getGalleryByType($type, $roomtype_id=0){
		$criteria = new CDbCriteria;
		$criteria->compare('type', $type, false, 'AND');
		$criteria->compare('roomtype_id', $roomtype_id, false, 'AND');
		
		$data = Gallery::model()->find($criteria);
		return $data;
	}

	public function getGalleryByType2($type, $hotel='', $roomtype_id=''){
		$criteria = new CDbCriteria;
		$criteria->compare('type', $type, false, 'AND');
		$criteria->addInCondition('roomtype_id', explode(',', $roomtype_id));
		if($hotel){
			$criteria->compare('hotel_id', $hotel, false, 'AND');
		}
		$data = Gallery::model()->findAll($criteria);
		$array = array();
		foreach($data as $dt){
			$array[] = $dt['id'];
		}
		return $array;
	}


	public function getList($type, $roomtype_id=0){
		$gallery = $this->getGalleryByType($type, $roomtype_id);
		if($gallery){
			$criteria = new CDbCriteria;			
			$criteria->compare('gallery_id', $gallery['id'], false);
			$dataProvide = new CActiveDataProvider('Item', array(
				'criteria' => $criteria,
				'sort' => array('defaultOrder' => 'display_order ASC')));
			$dataProvide->setPagination(false);
			return $dataProvide;
		}else{
			return '';
		}	
	}

	public function getList2($type, $roomtype_id=0){
		$gallery = $this->getGalleryByType2($type, $roomtype_id);
		if($gallery){
			$criteria = new CDbCriteria;			
			$criteria->addInCondition('gallery_id', $gallery);
			$dataProvide = new CActiveDataProvider('Item', array(
				'criteria' => $criteria,
				'sort' => array('defaultOrder' => 'display_order ASC')));
			$dataProvide->setPagination(false);
			return $dataProvide;
		}else{
			return '';
		}	
	}

	public function search($type=''){
		$criteria=new CDbCriteria;
		//$criteria->compare('hotel_id', Yii::app()->session['hotel'],false, 'AND');
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		
		$criteria->compare('type', $type,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getListbytype($type){
		$gallery = $this->getItemByGalleryType($type);
		if($gallery){
			$criteria = new CDbCriteria;			
			$criteria->compare('gallery_id', $gallery['id'], false);
			$dataProvide = new CActiveDataProvider('Item', array(
				'criteria' => $criteria,
				'sort' => array('defaultOrder' => 'display_order ASC')));
			$dataProvide->setPagination(false);
			return $dataProvide;
		}else{
			return '';
		}	
	}

	public function getItemByGalleryType($type){
		$criteria = new CDbCriteria;
		$criteria->compare('name', $type, false);
		$gallery = Gallery::model()->find($criteria);
		return $gallery;
	}

	public function getListbyName($name){
		$gallery = $this->getItemByGalleryType($name);
		if(count($gallery)>0){
			$criteria = new CDbCriteria;			
			$criteria->compare('gallery_id', $gallery['id'], false);
			$dataProvide = new CActiveDataProvider('Item', array(
				'criteria' => $criteria,
				'sort' => array('defaultOrder' => 'display_order ASC')));
			$dataProvide->setPagination(false);
			return $dataProvide;

		}else{
			return '';
		}	
	}

	public function getListByCate($gallery_id){
		$criteria = new CDbCriteria;			
		$criteria->compare('gallery_id', $gallery_id, false);
		$dataProvide = new CActiveDataProvider('Item', array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'display_order ASC')));
		$dataProvide->setPagination(false);
		return $dataProvide;
	}

	public function getGalleryByCate($cate, $hotel_id){
		$criteria = new CDbCriteria;			
		$criteria->compare('gallery_categories', $cate, false);
		$criteria->compare('hotel_id', $hotel_id, false);
		$dataProvide = Gallery::model()->find($criteria);
		return $dataProvide;
	}
}