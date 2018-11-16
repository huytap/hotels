<?php

/**
 * This is the model class for table "Roomtype".
 *
 * The followings are the available columns in table 'Roomtype':
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $display_order
 * @property string $description
 * @property string $amenities
 * @property integer $no_of_rooms
 * @property integer $max_per_room
 * @property string $size_of_room
 * @property string $view
 * @property integer $bed
 * @property integer $status
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 */
class Roomtype extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'roomtypes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, display_order', 'required'),
			array('display_order, no_of_rooms, max_per_room, status, updated_by, no_of_adult, no_of_extrabed, no_of_child', 'numerical', 'integerOnly'=>true),
			array('name, slug, view', 'length', 'max'=>100),
			array('bed', 'length', 'max'=>765),
			array('amenities', 'length', 'max'=>300),
			array('size_of_room', 'length', 'max'=>50),
			array('description, cover_photo','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, slug, display_order, description, amenities, no_of_rooms, max_per_room, size_of_room, view, bed, status, added_date, updated_date, updated_by', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'slug' => 'Slug',
			'display_order' => 'Display Order',
			'description' => 'Description',
			'amenities' => 'Amenities',
			'no_of_rooms' => 'No Of Rooms',
			'max_per_room' => 'Max Per Room',
			'size_of_room' => 'Size Of Room',
			'view' => 'View',
			'bed' => 'Bed',
			'status' => 'Status',
			'added_date' => 'Added Date',
			'updated_date' => 'Updated Date',
			'updated_by' => 'Updated By',
			'cover_photo' => 'Cover Photo'
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
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('display_order',$this->display_order);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('amenities',$this->amenities,true);
		$criteria->compare('no_of_rooms',$this->no_of_rooms);
		$criteria->compare('max_per_room',$this->max_per_room);
		$criteria->compare('size_of_room',$this->size_of_room,true);
		$criteria->compare('view',$this->view,true);
		$criteria->compare('bed',$this->bed);
		$criteria->compare('status',$this->status);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('hotel_id', Yii::app()->session['hotel'], false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getList($status='', $hotel='', $adult=0, $children=0){
		$criteria = new CDbCriteria;
		if($status !== '')
			$criteria->compare('status', $status, false, 'AND');
		if($hotel){
			$criteria->compare('hotel_id', $hotel, false, 'AND');
		}
		if($adult>0){
			$criteria->addCondition('no_of_adult>='.$adult .' AND max_per_room>='.$adult);
		}
		if($children>0){
			$criteria->addCondition('no_of_child>='.$children .' AND max_per_room>='.$children);	
		}
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array('defaultOrder'=>'display_order desc')));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public function getList2($status='', $hotel=0){
		$criteria = new CDbCriteria;
		if($status !== '')
			$criteria->compare('status', $status, false, 'AND');
		$criteria->compare('hotel_id', $hotel, false, 'AND');
		$dataProvider = new CActiveDataProvider($this, array('criteria' => $criteria));
		$dataProvider->setPagination(false);
		$arrTheList = array();
		foreach($dataProvider->getData() as $rt){
			$arrTheList[$rt['id']] = $rt['name'];
		}
		return $arrTheList;
	}

	function getRoomtypeById($id){
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', explode(',', $id));
		$criteria->compare('hotel_id', $hotel, false, 'AND');
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'display_order ASC')
		));
		$dataProvider->setPagination(false);
		return $dataProvider->getData();
	}

	public function getRoomtypeBySlug($slug, $hotel){
		$criteria = new CDbCriteria;
		$criteria->addCondition('hotel_id="'.$hotel.'" AND t.slug="'.$slug.'"');
		$data = Roomtype::model()->find($criteria);
		return $data;
	}

	public function getNameById($id){
		$model = Roomtype::model()->findByPk($id);
		return $model['name'];
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function checkRoomtype($id){
		$criteria = new CDbCriteria;
		$criteria->compare('id', $id, false);
		$criteria->compare('status', 0, false);
		$data = Roomtype::model()->find($criteria);
		return $data;
	}

	public function getRoomtypeMinPrice($hotel){
        $criteria = new CDbCriteria;
        $criteria->compare('hotel_id', $hotel, false);
        $criteria->order = 'display_order asc';
        $data = Roomtype::model()->find($criteria);
        
        return $data;
    }

    public function getPrice($hotel, &$from, &$to, $id){	        
        $rates = Rates::model()->getRate($hotel, $from, $to, $id);
        $from = $rates['date'];
        $to = date('Y-m-d', strtotime("$from +1 day"));
        $price = 0;
        if($rates){
            $rate = $rates['single'];
            $promotion = Promotion::model()->getPromotionByHotel($hotel);
            if(count($promotion) > 0){
                $price = ($rate * (100 - $promotion[0]['discount']) / 100);
            }
        }
        return $price;
    }

    public function getIdBySlug($slug){
    	$criteria = new CDbCriteria;
    	$criteria->compare('slug', $slug, false);
    	$model = Roomtype::model()->find($criteria);
    	return $model['id'];
    }
}
