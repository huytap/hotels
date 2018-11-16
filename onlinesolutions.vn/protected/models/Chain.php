<?php

/**
 * This is the model class for table "chains".
 *
 * The followings are the available columns in table 'chains':
 * @property integer $chain_id
 * @property string $chain_name
 * @property integer $active
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 */
class Chain extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'chains';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('chain_id, chain_name', 'required'),
			array('active, updated_by', 'numerical', 'integerOnly'=>true),
			array('active, added_date, updated_date', 'safe'),
			array('chain_id, chain_name, domain', 'length', 'max'=>128),
			array('api_key', 'length', 'max' => 256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('chain_id, chain_name, active, added_date, updated_date, updated_by', 'safe', 'on'=>'search'),
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
			'chain_id' => 'Chain',
			'chain_name' => 'Chain Name',
			'active' => 'Active',
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

		$criteria->compare('chain_id',$this->chain_id);
		$criteria->compare('chain_name',$this->chain_name,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Chain the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getList(){
		$criteria = new CDbCriteria;
		$criteria->compare('active', 0, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array('defaultOrder'=>'added_date desc')));
		$dataProvider->setPagination(false);
		$arrTheList = array();
		foreach($dataProvider->getData() as $data){
			$arrTheList[$data['chain_id']] = $data['chain_name'];
		}
		return $arrTheList;
	}
}
