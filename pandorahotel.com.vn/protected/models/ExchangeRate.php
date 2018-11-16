<?php

/**
 * This is the model class for table "exchange_rate".
 *
 * The followings are the available columns in table 'exchange_rate':
 * @property string $the_date
 * @property string $exchange_rate
 * @property string $original_xml
 */
class ExchangeRate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'exchange_rate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('the_date', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('the_date, exchange_rate, original_xml', 'safe', 'on'=>'search'),
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
			'the_date' => 'The Date',
			'exchange_rate' => 'Exchange Rate',
			'original_xml' => 'Original Xml',
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

		$criteria->compare('the_date',$this->the_date,true);
		$criteria->compare('exchange_rate',$this->exchange_rate,true);
		$criteria->compare('original_xml',$this->original_xml,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'the_date DESC',
			),
		));
	}

	public function convertCurrencyToUSD($currency='USD'){
		$the_date = date('Y-m-d');
		$data = $this->getListCurrency($the_date);
		if(!$data){
			$data = $this->getLastUpdateCurrency();
		}
		$ex_currency = $data[$currency];
		return $ex_currency;
	}

	public function getLastUpdateCurrency(){
		$criteria = new CDbCriteria;
		$criteria->order = 'the_date DESC';
		$data = ExchangeRate::model()->find($criteria);
		$arrCurrency = json_decode($data['exchange_rate'], true);
		return $arrCurrency;
	}

	public function getListCurrency($the_date){
		if($the_date==''){
	 		return array();
	 	}
	 	else{
	 		$criteria=new CDbCriteria;
			$criteria->compare('the_date', $the_date,false);
			$data = ExchangeRate::model()->findByPk($the_date);
			$arrCurrency = json_decode($data['exchange_rate'], true);
	        return $arrCurrency;
	 	}
	}

	public function getList($the_date){
	 	if($the_date==''){
	 		return array();
	 	}
	 	else{
	 		$criteria=new CDbCriteria;
			$criteria->compare('the_date',$the_date,false);
			$dataProvider = new CActiveDataProvider('ExchangeRate', array(
				'criteria'=>$criteria,
			));
			$dataProvider->setPagination(false);
			$arrTheList = array();
			$arrTheList = $dataProvider->getData();
		
			$arrCates = array();
			if(is_array($arrTheList)){
				foreach($arrTheList as $k => $v){
					$arrCates=$v;
				}
			}
	        return $arrCates;
	 	}
	 	
	}
	
	public function getList2(){
	 	
 		$criteria=new CDbCriteria;
		$criteria->order = 'the_date DESC';
		$data = ExchangeRate::model()->find($criteria);
	
		$array_currency = json_decode($data->exchange_rate, true);

		$arrayCurrency = array();
	    foreach ($array_currency as $key => $currency) {
	        $arrayCurrency[$key] = $currency['name'] . ' (' . $key . ')';
	    }
        return $arrayCurrency;
	 	
	 }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
