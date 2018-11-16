<?php

/**
 * This is the model class for table "packages".
 *
 * The followings are the available columns in table 'packages':
 * @property integer $id
 * @property integer $is_book
 * @property integer $display_order
 * @property string $name
 * @property string $short_description
 * @property string $full_description
 * @property double $rate
 * @property integer $status
 * @property string $from_date
 * @property string $to_date
 * @property integer $nights
 * @property string $cover_photo
 * @property string $slug
 * @property integer $hotel_id
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 */
class Package extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $available;
	public function tableName()
	{
		return 'package';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('display_order, name, short_description, full_description, rate, from_date, to_date, nights, type', 'required'),
			array('is_book, max_nights, adult, children, display_order, roomtype_id, night_to_book, dropoff, pickup, status, nights, hotel_id, updated_by', 'numerical', 'integerOnly'=>true),
			array('rate, rate_child', 'numerical'),
			array('cover_photo, slug,type', 'length', 'max'=>128),
			array('added_date, updated_date, updated_by', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, is_book, display_order, name, short_description, full_description, rate, status, from_date, to_date, nights, cover_photo, slug, hotel_id, added_date, updated_date, updated_by', 'safe', 'on'=>'search'),
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
			'is_book' => 'Is Book',
			'roomtype_id' => 'Room type',
			'display_order' => 'Display Order',
			'name' => 'Package Name',
			'short_description' => 'Short Description',
			'full_description' => 'Full Description',
			'rate' => 'Rate',
			'rate_child' => 'Rate Child',
			'status' => 'Status',
			'from_date' => 'From Date',
			'to_date' => 'To Date',
			'nights' => 'Minimum Stay',
			'night_to_book' => 'Minimum no. of days to book in advance/Maximum no. of days to book before check-in',
			'cover_photo' => 'Cover Photo (720x400)',
			'slug' => 'Slug',
			'hotel_id' => 'Hotel',
			'added_date' => 'Added Date',
			'updated_date' => 'Updated Date',
			'updated_by' => 'Updated By',
			'type' => 'Type',
			'roomtype' => 'Room type',
			'max_nights' => 'Maximum Stay (0=Unlimited)',
			'adult' => 'Max adults'
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
		$criteria->compare('is_book',$this->is_book);
		$criteria->compare('display_order',$this->display_order);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('short_description',$this->short_description,true);
		$criteria->compare('full_description',$this->full_description,true);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('status',$this->status);
		$criteria->compare('from_date',$this->from_date,true);
		$criteria->compare('to_date',$this->to_date,true);
		$criteria->compare('nights',$this->nights);
		$criteria->compare('cover_photo',$this->cover_photo,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getList($from_date='',$to_date ='', $stay){
		
		$from_date = date('Y-m-d', strtotime($from_date));
		$to_date = date('Y-m-d', strtotime($to_date));
		
		$criteria = new CDbCriteria;
		if($from_date && $to_date){
			$criteria->condition = 'nights <= '.$stay.' && max_nights >='.$stay.' && from_date <= "'.$from_date.'" AND "'.$from_date.'<to_date" AND to_date >= "'.$to_date.'"';
		}
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria
		));
		$dataProvider->setPagination(false);
		return $dataProvider;
		/*if($from_date && $to_date){
			return $dataProvider;
		}else{
			$arrTheList = array();
			foreach($dataProvider->getData() as $dt){
				$arrTheList[$dt->id] = $dt->name;
			}
			return $arrTheList;
		}*/
	}

	public function getPackage($from_date, $to_date, $hotel_id, $roomtype_id, $stay){

		$from_date = date('Y-m-d', strtotime($from_date));
		$to_date = date('Y-m-d', strtotime($to_date));
		
		$criteria = new CDbCriteria;
		if($from_date && $to_date){
			$criteria->condition = 'nights <= '.$stay.' && max_nights >='.$stay.' && from_date <= "'.$from_date.'" AND "'.$from_date.'<to_date" AND to_date >= "'.$to_date.'"';
		}
		$criteria->compare('roomtype_id', $roomtype_id, false);
		$criteria->compare('hotel_id', $hotel_id, false);
		$data = Package::model()->find($criteria);
		
		return $data;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
