<?php

/**
 * This is the model class for table "promotions".
 *
 * The followings are the available columns in table 'promotions':
 * @property integer $id
 * @property integer $hotel_id
 * @property string $name
 * @property string $from_date
 * @property string $to_date
 * @property string $roomtypes
 * @property string $type
 * @property string $cancel_1
 * @property string $cancel_2
 * @property string $cancel_3
 * @property integer $no_of_day
 * @property double $discount
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 * @property integer $status
 * @property integer $min_stay
 * @property string $sale_start
 * @property string $sale_end
 * @property string $display_on
 * @property integer $min_room
 * @property string $apply_on
 * @property double $every_night
 * @property string $specific_night
 * @property string $specific_day_of_week
 * @property string $cancel_text_1
 * @property string $cancel_text_2
 * @property string $cancel_text_3
 */
class Promotion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'promotions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_date, to_date, roomtypes, type, no_of_day, min_stay', 'required', 'message' => 'Please enter {attribute}'),
			array('hotel_id, no_of_day, updated_by, status, min_stay, max_stay, min_room, increase', 'numerical', 'integerOnly'=>true),
			array('discount, every_night, pickup, dropoff', 'numerical'),
			array('roomtypes', 'length', 'max'=>50),
			array('promotion_code', 'length', 'max' => 8),
			array('type', 'length', 'max'=>100),
			array('cover_photo', 'length', 'max'=>128),
			array('cancel_1, cancel_2, cancel_3, slug', 'length', 'max'=>255),
			array('cancel_text_1, cancel_text_2, cancel_text_3', 'length', 'max'=>765),
			array('description, short_content,name, start_deal_date, end_deal_date, packages', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hotel_id, promotion_code, name, from_date, to_date, roomtypes, type, cancel_1, cancel_2, cancel_3, no_of_day, discount, added_date, updated_date, updated_by, status, min_stay, sale_start, sale_end, display_on, min_room, apply_on, every_night, specific_night, specific_day_of_week, cancel_text_1, cancel_text_2, cancel_text_3', 'safe', 'on'=>'search'),
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
			'hotel_id' => 'Hotel',
			'name' => 'Promotion Name',
			'from_date' => 'Stay Date From',
			'to_date' => 'Stay Date To',
			'roomtypes' => 'Roomtypes',
			'type' => 'Promotion Type',
			'cancel_1' => 'Cancellation 1',
			'cancel_2' => 'Cancellation 2',
			'cancel_3' => 'Cancellation 3',
			'no_of_day' => 'No. of Day To Book',
			'discount' => 'Discount (%)',
			'added_date' => 'Added Date',
			'updated_date' => 'Updated Date',
			'updated_by' => 'Updated By',
			'status' => 'Status',
			'min_stay' => 'Minimum Stay',
			'max_stay' => 'Maximum Stay (0=N/A)',
			'sale_start' => 'Sale Start',
			'sale_end' => 'Sale End',
			'display_on' => 'Display On',
			'min_room' => 'Min Room',
			'apply_on' => 'Apply On',
			'every_night' => 'Every Night',
			'specific_night' => 'Specific Night',
			'specific_day_of_week' => 'Specific Day Of Week',
			'cancel_text_1' => 'Cancel Text 1',
			'cancel_text_2' => 'Cancel Text 2',
			'cancel_text_3' => 'Cancel Text 3',
			'pickup' => 'Free pick-up?',
			'dropoff' => 'Free drop-off?',
			'packages' => 'Packages',
			'increase' => 'Increase',
			'promotion_code' => 'Promotion/Package Code',
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
		$criteria->compare('hotel_id',Yii::app()->session['hotel'], false, 'AND');
		$criteria->compare('name',$this->name,true);
		$criteria->compare('from_date',$this->from_date,true);
		$criteria->compare('to_date',$this->to_date,true);
		$criteria->compare('roomtypes',$this->roomtypes,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('cancel_1',$this->cancel_1,true);
		$criteria->compare('cancel_2',$this->cancel_2,true);
		$criteria->compare('cancel_3',$this->cancel_3,true);
		$criteria->compare('no_of_day',$this->no_of_day);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('status',$this->status);
		$criteria->compare('min_stay',$this->min_stay);
		$criteria->compare('sale_start',$this->sale_start,true);
		$criteria->compare('sale_end',$this->sale_end,true);
		$criteria->compare('display_on',$this->display_on,true);
		$criteria->compare('min_room',$this->min_room);
		$criteria->compare('apply_on',$this->apply_on,true);
		$criteria->compare('every_night',$this->every_night);
		$criteria->compare('specific_night',$this->specific_night,true);
		$criteria->compare('specific_day_of_week',$this->specific_day_of_week,true);
		$criteria->compare('cancel_text_1',$this->cancel_text_1,true);
		$criteria->compare('cancel_text_2',$this->cancel_text_2,true);
		$criteria->compare('cancel_text_3',$this->cancel_text_3,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getList($params){
		$fromDate = ExtraHelper::date_2_save($params['fromDate']);
        $toDate = ExtraHelper::date_2_save($params['toDate']);
		$criteria = new CDbCriteria;
		$criteria->compare('status', 0, false, 'AND');
		$criteria->compare('hotel_id', $params['hotel'], false, 'AND');
		$criteria->addCondition('from_date <="'.$fromDate['date'].'" AND to_date >="'.$toDate['date'].'"');
		$criteria->addCondition('min_stay>=1');
		//$criteria->condition = "from_date<='".$fromDate."' AND to_date>='".$toDate."'";
		/*if(isset($params['roomtype'])){
					$criteria->addCondition('roomtype_id in ('.implode(',',$params['roomtype']).')');
		}*/
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=> $criteria,
			'sort' => array('defaultOrder' => 'discount desc')));
		return $dataProvider;
		/*$theArrayList = array();
		foreach ($dataProvider->getData() as $promotion) {
            if (((strtotime($promotion->from_date) <= strtotime($params['fromDate']) &&
                    strtotime($params['fromDate']) <= strtotime($promotion->to_date))
                     ||
                    (
                    strtotime($promotion->from_date) < strtotime($params['toDate']) &&
                    strtotime($params['toDate']) < strtotime($promotion->to_date)
                    )
                    )
            ) {
                if ($promotion['type'] === 'early_bird') {
                    if ($params['today'] >= $promotion->no_of_day && $promotion['min_stay'] >= $params['bookedNights']){
                        $theArrayList['matchPromotions'][] = $promotion;
                    }
                } elseif($promotion['type'] == 'last_minutes') {
                    //if ($params['today'] <= $promotion->no_of_day && $promotion['min_stay'] >= $params['bookedNights']){
                        $theArrayList['matchPromotions'][] = $promotion;
                    //}
                } elseif($promotion['type'] == 'deal' ){
                    $theArrayList['matchPromotions'][] = $promotion;
                }else{
                    $theArrayList['matchPromotions'][] = $promotion;
                }
            }
        }
        return $theArrayList;*/
	}

	public function getList2($hotel=''){
		//$fromDate = ExtraHelper::date_2_save($params['fromDate']);
        //$toDate = ExtraHelper::date_2_save($params['toDate']);
		$criteria = new CDbCriteria;
		$criteria->compare('status', 0, false, 'AND');
		if($hotel){
			$criteria->compare('hotel_id', $hotel, false, 'AND');
		}
		$criteria->addCondition('from_date <="'.date('Y-m-d').'" AND to_date >="'.date('Y-m-d').'"');
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=> $criteria,
			'sort' => array('defaultOrder' => 'discount DESC, hotel_id asc')));
		return $dataProvider;
	}

	public function getDetail($hotel, $slug){
		$criteria = new CDbCriteria;
		$criteria->compare('hotel_id', $hotel, false, 'AND');
		$criteria->compare('slug', $slug, false, 'AND');
		$criteria->compare('status', 0, false, 'AND');
		$data = Promotion::model()->find($criteria);
		return $data;
	}

	public function getPromotionDiscountMax($date){
		$criteria = new CDbCriteria;
		$criteria->compare('status', 0, false);
		$criteria->addCondition('from_date <="'.$date.'" AND to_date >="'.$date.'"');
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=> $criteria,
			'sort' => array('defaultOrder' => 'discount DESC')));
		return $dataProvider->getData();
	}
	public function getPromotion($id){
		$model = Promotion::model()->findByPk($id);
		return $model;
	}

	public function getPromotionByHotel($hotel){
		$criteria = new CDbCriteria;
        $criteria->compare('hotel_id', $hotel, false);
        $criteria->compare('min_stay', 1, false);
        $criteria->order = 'discount DESC';
        $promotion = Promotion::model()->findAll($criteria);
        return $promotion;
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getFlash($hotel_id=''){
		$now = date('Y-m-d');
		$criteria = new CDbCriteria;
		$criteria->compare('type', 'deal', false, 'AND');
		if($hotel_id)
			$criteria->compare('hotel_id', $hotel, false);
        $criteria->compare('min_stay', 1, false);
		$criteria->addCondition('start_deal_date <="'. $now .'" AND end_deal_date>="'.$now.'"');
		$criteria->addCondition('from_date <="'.$now.'" AND to_date >="'.$now.'"');
		$data = Promotion::model()->find($criteria);
		return $data;
	}

	public function getListPackage($hotel=''){
		$criteria = new CDbCriteria;
		$criteria->compare('status', 0, false, 'AND');
		if($hotel){
			$criteria->compare('hotel_id', $hotel, false, 'AND');
		}
		$criteria->compare('type', 'package', false, 'AND');
		$criteria->addCondition('from_date <="'.date('Y-m-d').'" AND to_date >="'.date('Y-m-d').'"');
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=> $criteria,
			'sort' => array('defaultOrder' => 'discount DESC')));
		return $dataProvider;
	}

	public function getPromotionRoomByHotel($hotel, $date, $roomtype_id){
		$criteria = new CDbCriteria;
        $criteria->compare('hotel_id', $hotel, false);
        $criteria->compare('min_stay', 1, false);
        $criteria->addCondition('FIND_IN_SET('.$roomtype_id.', roomtypes)');
        $criteria->addCondition('from_date <="'.$date.'" AND to_date >="'.$date.'"');
        $criteria->order = 'discount DESC';
        $promotion = Promotion::model()->findAll($criteria);
        return $promotion;
    }

    public function getPromotionByHotel2($hotel, $type=''){
		$criteria = new CDbCriteria;
        $criteria->compare('hotel_id', $hotel, false);
        if($type){
        	$criteria->addCondition('type != "package"');
        }
        $criteria->order = 'discount DESC';
        $promotion = Promotion::model()->findAll($criteria);
        return $promotion;
    }

    public function checkRatePromo(&$params, $pr){
    	$now = date('Y-m-d');
    	if($pr['type'] == 'early_bird'){
    		$checkin = date('Y-m-d', strtotime($now ."+".$pr['no_of_day']." day"));
    		$checkout = date('Y-m-d', strtotime("$checkin +".$pr['min_stay']." day"));
    	}else{
    		$checkin = date('Y-m-d');
    		$checkout = date('Y-m-d', strtotime("$checkin +".$pr['min_stay']." day"));
    	}
        $to = date('Y-m-d', strtotime("$checkin +29 day"));
        $params2=array('fromDate'=>$checkin, 'toDate'=>$to, 'roomtype'=>$pr['roomtypes']);
        $room = Rooms::model()->getAvailableIn1Month($params2, $hotel);
    	if(count($rooms)>0){
    		$params = array(
            	'checkin' => $room['date'],
            	'checkout' => date('Y-m-d', strtotime($room['date'] ." +".$pr['min_stay']." day")),
            	'adult'=>1,
            	'children'=>0,
            	'lang' => $lang,
            	'roomtype' => '',
            	'promo'=> $pr['slug'],
            	'currency'=>'USD'
            );
    	}else{
        	$params = array(
            	'checkin' => $checkin,
            	'checkout' => $checkout,
            	'adult'=>1,
            	'children'=>0,
            	'lang' => $lang,
            	'roomtype' => '',
            	'promo'=> $pr['slug'],
            	'currency'=>'USD'
            );
        }
        $rates = Rates::model()->getRate($hotel, $params['checkin'], $params['checkout'], $room['roomtype_id']);
        if($pr['discount']>0){
            $rate = $rates['single_sell'];
        	$price = ($rate * (100 - $pr['discount']) / 100);
            return $price;
        }
        return 0;
    }
    public function getBySlug($hotel, $slug){
    	$criteria = new CDbCriteria;
    	$criteria->compare('slug', $slug, false);
    	$criteria->compare('hotel_id', $hotel, false);
    	$model = new CActiveDataProvider($this, array(
    		'criteria' => $criteria));
    	return $model;
    }
}
