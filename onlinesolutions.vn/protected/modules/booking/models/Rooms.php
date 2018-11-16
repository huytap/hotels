<?php

/**
 * This is the model class for table "rooms".
 *
 * The followings are the available columns in table 'rooms':
 * @property integer $id
 * @property integer $roomtype_id
 * @property string $date
 * @property string $day
 * @property integer $close
 * @property integer $used_total_allotments
 * @property integer $available
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 */
class Rooms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rooms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('close, available', 'required'),
			array('roomtype_id, close, used_total_allotments, available, updated_by', 'numerical', 'integerOnly'=>true),
			array('day', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, roomtype_id, date, day, close, used_total_allotments, available, added_date, updated_date, updated_by', 'safe', 'on'=>'search'),
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
			'roomtype' => array(self::BELONGS_TO, 'Roomtype', 'roomtype_id')
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
			'date' => 'Date',
			'day' => 'Day',
			'close' => 'Close',
			'used_total_allotments' => 'Used Total Allotments',
			'available' => 'Available',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('day',$this->day,true);
		$criteria->compare('close',$this->close);
		$criteria->compare('used_total_allotments',$this->used_total_allotments);
		$criteria->compare('available',$this->available);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getList($params){
		$criteria = new CDbCriteria;
		$criteria->compare('hotel_id', $params['hotel'], false);
		if(isset($params['fromdate']) && isset($params['todate'])){
			//$date1 = date('d-m-Y', strtotime($params['fromdate']));
			//$date2 = date('d-m-Y', strtotime($params['todate']));
            $fromDate = ExtraHelper::date_2_save($params['fromdate']);
            $toDate = ExtraHelper::date_2_save($params['todate']);
			$criteria->addCondition('date BETWEEN "'. $fromDate['date'] .'" AND "'. $toDate['date'] . '"');
		}
		if(isset($params['type'])){
			$criteria->compare('roomtype_id', $params['type'], false);
		}
		
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'date ASC')
		));
		$dataProvider->setPagination(false);
		return $dataProvider->getData();
	}

	public function checkRoom($roomtype_id, $date){
		$criteria = new CDbCriteria;
		$criteria->compare('roomtype_id', $roomtype_id, false);
		$criteria->compare('date', $date);
		$data = Rooms::model()->find($criteria);
		return $data;
	}

	public function checkRoom2($roomtype_id, $params){
		$criteria = new CDbCriteria;
		$criteria->compare('roomtype_id', $roomtype_id, false);
		$fromDate = ExtraHelper::date_2_save($params['fromDate']);
        $toDate = ExtraHelper::date_2_save($params['toDate']);
		$criteria->addCondition('date BETWEEN "'. $fromDate['date'] .'" AND "'. $toDate['date'] . '"');
		$data = Rooms::model()->find($criteria);
		return $data;
	}

	public function checkRoom3($roomtype_id, $params){
		$criteria = new CDbCriteria;
		$criteria->compare('roomtype_id', $roomtype_id, false, 'AND');
		$criteria->compare('hotel_id', $params['hotel_id'], false, 'AND');
		$criteria->addCondition('available>='.$params['no_of_room']);
		$fromDate = ExtraHelper::date_2_save($params['fromDate']);
        $toDate = ExtraHelper::date_2_save($params['toDate']);
		$criteria->addCondition('date >="'.$fromDate['date'].'" AND date <"'.$toDate['date'].'"');
		//$criteria->addCondition('date BETWEEN "'. $fromDate .'" AND "'. $toDate . '"');
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria));
		$dataProvider->setPagination(false);
		return $dataProvider->getData();
	}

	public function checkRoom4($roomtype_id, $params){
		$criteria = new CDbCriteria;
		$criteria->compare('roomtype_id', $roomtype_id, false, 'AND');
		$criteria->compare('hotel_id', $params['hotel_id'], false, 'AND');
		$fromDate = ExtraHelper::date_2_save($params['fromDate']);
        $toDate = ExtraHelper::date_2_save($params['toDate']);
		$criteria->addCondition('date >="'.$fromDate['date'].'" AND date <"'.$toDate['date'].'"');
		//$criteria->addCondition('date BETWEEN "'. $fromDate .'" AND "'. $toDate . '"');
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria));
		$dataProvider->setPagination(false);
		return $dataProvider->getData();
	}

	public function getListByDate($params, $hotel_id=''){
		$criteria = new CDbCriteria;
		$fromDate = ExtraHelper::date_2_save($params['fromDate']);
		$toDate = ExtraHelper::date_2_save($params['toDate']);
		if($hotel_id){
			$criteria->compare('hotel_id', $hotel_id, false, 'AND');
		}
		$criteria->addCondition('roomtype_id in ('.implode(',',$params['roomtype']).')');
		$criteria->addCondition('date >= "'. $fromDate['date'] .'" AND date < "'. $toDate['date'] . '"');
		
		//$criteria->compare('close', 0, false);
		
		//$criteria->addCondition('available > 0');
		
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'date ASC')
		));
		$dataProvider->setPagination(false);
		return $dataProvider->getData();
	}

	public function getTotalRoomByHotel($hotel, $fromDate, $toDate){
		$criteria = new CDbCriteria;
		$criteria->condition = "hotel_id=".$hotel." AND date>='". $fromDate ."' AND date<'". $toDate . "'";
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
