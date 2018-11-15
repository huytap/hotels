<?php

/**
 * This is the model class for table "tours".
 *
 * The followings are the available columns in table 'tours':
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property double $max_2_adult
 * @property double $max_4_adult
 * @property double $max_6_adult
 * @property double $max_9_adult
 * @property double $above_10_adult
 * @property integer $show_to_booking
 * @property string $short_description
 * @property string $full_description
 * @property integer $status
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 */
class Tour extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tours';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, short_description, full_description, status', 'required'),
			array('show_to_booking, status, updated_by', 'numerical', 'integerOnly'=>true),
			array('max_2_adult, max_4_adult, max_6_adult, max_9_adult, above_10_adult', 'numerical'),
			array('name, slug', 'length', 'max'=>255),
			array('cover_photo, short_description', 'safe'),
			// @todo Please remove those attributes that should not be searched.
			array('id, name, slug, max_2_adult, max_4_adult, max_6_adult, max_9_adult, above_10_adult, show_to_booking, short_description, full_description, status, added_date, updated_date, updated_by', 'safe', 'on'=>'search'),
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
			'slug' => 'Slug',
			'max_2_adult' => 'Max 2 Adult',
			'max_4_adult' => 'Max 4 Adult',
			'max_6_adult' => 'Max 6 Adult',
			'max_9_adult' => 'Max 9 Adult',
			'above_10_adult' => 'Above 10 Adult',
			'show_to_booking' => 'Show To Booking',
			'short_description' => 'Short Description',
			'full_description' => 'Full Description',
			'status' => 'Status',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('max_2_adult',$this->max_2_adult);
		$criteria->compare('max_4_adult',$this->max_4_adult);
		$criteria->compare('max_6_adult',$this->max_6_adult);
		$criteria->compare('max_9_adult',$this->max_9_adult);
		$criteria->compare('above_10_adult',$this->above_10_adult);
		$criteria->compare('show_to_booking',$this->show_to_booking);
		$criteria->compare('short_description',$this->short_description,true);
		$criteria->compare('full_description',$this->full_description,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getListTour($hotel_id=''){
		$criteria= new CDbCriteria;
		if($hotel_id!='' || $hotel_id>0){
			$criteria->compare('hotel_id',$hotel_id,false);
		}
		$data= new CActiveDataProvider('Tour',array(
				'criteria'=>$criteria,
				'sort'=>array('defaultOrder'=>'id DESC'),
		));
		$data->setPagination(false);
		return $data->getData();
	}
	public function getTourlBySlug($slug){
		$criteria = new CDbCriteria;
		$criteria->compare('slug', $slug, false, 'AND');
		$criteria->compare('status', 0, false, 'AND');
		$data = Tour::model()->find($criteria);
		return $data;
	}
	public function getListOrther($id){
		$criteria = new CDbCriteria;
		if($id){
			$criteria->condition="id !=$id";
		}
		//$criteria->compare('hotel_id', $hotel_id, false, 'AND');
		$criteria->compare('status', 0, false, 'AND');
		$data = Tour::model()->findAll($criteria);
		return $data;
	}
	public function getList2(){
		$criteria = new CDbCriteria;
		$criteria->compare('status', 0, false, 'AND');
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public function getList(){
		$criteria = new CDbCriteria;
		$criteria->compare('status', 0, false, 'AND');
		$criteria->compare('show_to_booking', 1, false, 'AND');
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
		$arrTheList = array();
		foreach($dataProvider->getData() as $data){
			$arrTheList[$data['id']] = $data['name'];
		}
		return $arrTheList;
	}

	public function getListPriceByTour($id){
		$changeRate_VND = (array)ExchangeRate::model()->convertCurrencyToUSD(Yii::app()->session['change_currency']);
		$data = Tour::model()->findByPk($id);
		$link = Yii::app()->baseUrl.'/'. Yii::app()->session['_lang'] .'/tours/'.$data['id'].'/'.$data['slug'].'.html';
		$arrTheList = array();
		if($data['max_2_adult']){
			$arrTheList['max_2_adult'] = 'Group 2 adult - '. number_format($changeRate_VND['sell']*$data['max_2_adult'],2). ' ' .$change_currency .'/ per person';
		}
		if($data['max_4_adult']){
			$arrTheList['max_4_adult'] = 'Group 4 adult - '. number_format($changeRate_VND['sell']*$data['max_4_adult'],2). ' ' .$change_currency .'/ per person';
		}
		if($data['max_6_adult']){
			$arrTheList['max_6_adult'] = 'Group 6 adult - '. number_format($changeRate_VND['sell']*$data['max_6_adult'],2). ' ' .$change_currency .'/ per person';
		}
		if($data['max_9_adult']){
			$arrTheList['max_9_adult'] = 'Group 9 adult - '. number_format($changeRate_VND['sell']*$data['max_9_adult'],2). ' ' .$change_currency .'/ per person';
		}
		if($data['above_10_adult']){
			$arrTheList['above_10_adult'] = 'Group 10+ adult - '. number_format($changeRate_VND['sell']*$data['above_10_adult'],2). ' ' .$change_currency .'/ per person';
		}
		return array($link,$arrTheList);
	}
	public function getPrice($id, $max){
		$data = Tour::model()->findByPk($id);

		$changeRate_VND = (array)ExchangeRate::model()->convertCurrencyToUSD(Yii::app()->session['change_currency']);
		if(isset($data[$max])){
			return $data[$max]*$changeRate_VND['sell'];
		}else{
			return;
		}
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
