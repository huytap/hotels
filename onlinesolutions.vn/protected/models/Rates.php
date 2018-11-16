<?php

/**
 * This is the model class for table "rates".
 *
 * The followings are the available columns in table 'rates':
 * @property integer $id
 * @property integer $roomtype_id
 * @property integer $date
 * @property string $day
 * @property double $single
 * @property double $double
 * @property double $tripple
 * @property integer $single_sell
 * @property integer $double_sell
 * @property integer $tripple_sell
 * @property integer $breakfast
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 */
class Rates extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('roomtype_id, date, day, single, double, tripple, single_sell, double_sell, tripple_sell, breakfast, added_date, updated_date, updated_by', 'required'),
			array('roomtype_id, breakfast, updated_by', 'numerical', 'integerOnly'=>true),
			array('single, double, tripple, single_sell, double_sell, tripple_sell', 'numerical'),
			array('day', 'length', 'max'=>10),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, roomtype_id, date, day, single, double, tripple, single_sell, double_sell, tripple_sell, breakfast, added_date, updated_date, updated_by', 'safe', 'on'=>'search'),
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
			'date' => 'Date',
			'day' => 'Day',
			'single' => 'Single',
			'double' => 'Double',
			'tripple' => 'Tripple',
			'single_sell' => 'Single Sell',
			'double_sell' => 'Double Sell',
			'tripple_sell' => 'Tripple Sell',
			'breakfast' => 'Breakfast',
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
		$criteria->compare('date',$this->date);
		$criteria->compare('day',$this->day,true);
		$criteria->compare('single',$this->single);
		$criteria->compare('double',$this->double);
		$criteria->compare('tripple',$this->tripple);
		$criteria->compare('single_sell',$this->single_sell);
		$criteria->compare('double_sell',$this->double_sell);
		$criteria->compare('tripple_sell',$this->tripple_sell);
		$criteria->compare('breakfast',$this->breakfast);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getList($params){
		$criteria = new CDbCriteria;
		if(isset($params['fromdate']) && isset($params['todate'])){
			$date1 = date('d-m-Y', strtotime($params['fromdate']));
			$date2 = date('d-m-Y', strtotime($params['todate']));
            $fromDate = ExtraHelper::date_2_save($date1);
            $toDate = ExtraHelper::date_2_save($date2);
			//$criteria->addCondition('date BETWEEN "'. $fromDate['date'] .'" AND "'. $toDate['date'] . '"');
			$criteria->addCondition('date >= "'. $fromDate['date'] .'" AND date < "'. $toDate['date'] . '"');
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

	public function getList2($roomtype_id, $params){
		$criteria = new CDbCriteria;
		if(isset($params['fromDate']) && isset($params['toDate'])){
			$date1 = date('d-m-Y', strtotime($params['fromDate']));
			$date2 = date('d-m-Y', strtotime($params['toDate']));
            $fromDate = ExtraHelper::date_2_save($date1);
            $toDate = ExtraHelper::date_2_save($date2);
            $criteria->addCondition('date >="'.$fromDate['date'].'" AND date <"'.$toDate['date'].'"');
			//$criteria->addCondition('date BETWEEN "'. $fromDate['date'] .'" AND "'. $toDate['date'] . '"');
		}
		$criteria->compare('roomtype_id', $roomtype_id, false);
		
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'date ASC')
		));
		$dataProvider->setPagination(false);
		return $dataProvider->getData();
	}

	public function checkRate($roomtype_id, $date){
		$criteria = new CDbCriteria;
		$criteria->compare('roomtype_id', $roomtype_id, false);
		$criteria->compare('date', $date);
		$data = Rates::model()->find($criteria);
		return $data;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getListByRoomtype($roomtype_id, $params){
		$criteria = new CDbCriteria;
		$date1 = date('d-m-Y', strtotime($params['fromDate']));
		$date2 = date('d-m-Y', strtotime($params['toDate']));
        $fromDate = ExtraHelper::date_2_save($date1);
        $toDate = ExtraHelper::date_2_save($date2);
		$criteria->addCondition('date BETWEEN "'. $fromDate['date'] .'" AND "'. $toDate['date'] . '"');
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

	public function getListByRoomtype2($roomtype_id, $params){
		$criteria = new CDbCriteria;
		/*$date1 = date('d-m-Y', strtotime($params['fromDate']));
		$date2 = date('d-m-Y', strtotime($params['toDate']));*/
        $fromDate = ExtraHelper::date_2_save($params['fromDate']);
        $toDate = ExtraHelper::date_2_save($params['toDate']);
        $criteria->addCondition('date >="'.$fromDate['date'].'" AND date <"'.$toDate['date'].'"');
		$criteria->compare('roomtype_id', $roomtype_id, false);
		
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'date ASC')
		));
		$dataProvider->setPagination(false);
		return $dataProvider->getData();
	}

	public function getRate($hotel, $from, $to, $roomtype_id=0){
        $criteria = new CDbCriteria;
        $criteria->addCondition('date >="'.$from.'" AND date <"'.$to.'"');
        $criteria->compare('hotel_id', $hotel, false, 'AND');
        if($roomtype_id>0){
        	$criteria->compare('roomtype_id', $roomtype_id, false, 'AND');
        }
        //$criteria->compare('roomtype_id', , false, 'AND');
        $criteria->order = 'single ASC';
        $rate = Rates::model()->find($criteria);
        return $rate;
	}

	public function getRate2($hotel, $from, $to){
        $criteria = new CDbCriteria;
        $criteria->addCondition('date >="'.$from.'" AND date <"'.$to.'"');
        $criteria->compare('hotel_id', $hotel, false, 'AND');
        $criteria->order = 'single ASC';
        $rate = Rates::model()->find($criteria);
        return $rate;
	}
}
