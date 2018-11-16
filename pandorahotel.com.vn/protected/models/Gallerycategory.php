<?php

/**
 * This is the model class for table "gallery_categories".
 *
 * The followings are the available columns in table 'gallery_categories':
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $display_order
 * @property integer $status
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 * @property string $hotel_id
 */
class Gallerycategory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gallery_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, slug, added_date, updated_date, updated_by, hotel_id', 'required'),
			array('display_order, status, updated_by', 'numerical', 'integerOnly'=>true),
			array('name, slug', 'length', 'max'=>100),
			array('hotel_id', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, slug, display_order, status, added_date, updated_date, updated_by, hotel_id', 'safe', 'on'=>'search'),
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
			'display_order' => 'Display Order',
			'status' => 'Status',
			'added_date' => 'Added Date',
			'updated_date' => 'Updated Date',
			'updated_by' => 'Updated By',
			'hotel_id' => 'Hotel',
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
		$criteria->compare('status',$this->status);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('hotel_id',$this->hotel_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Gallerycategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getList(){

		$criteria=new CDbCriteria;
		$criteria->compare('status',0,false);
		
		$data= new CActiveDataProvider('Gallerycategory',array(
				'criteria'=>$criteria,
				'sort'=>array('defaultOrder'=>'display_order ASC'),
		));

		return $data;
	}
	public function getIDByUrl($url){
		$criteria = new CDbCriteria;
		$criteria->compare('slug',$url, false);
		$data=GalleryCategories::model()->find($criteria);
		return $data;
	}
	public function getNameByID($id){
		$criteria=new CDbCriteria;
		$data=GalleryCategories::model()->findByPk($id);
		return $data->name;
	}
	public function getUrlByID($id){
		$criteria=new CDbCriteria;
		$data=GalleryCategories::model()->findByPk($id);
		return $data->slug;
	}
	public function getListName(){
		$criteria = new CDbCriteria;
		$criteria->compare('status', 0, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array('defaultOrder'=>'display_order asc')));
		$dataProvider->setPagination(false);
		$arrTheList = array();
		foreach($dataProvider->getData() as $data){
			$arrTheList[$data['id']] = json_decode($data['name'],true)['en'];
		}
		return $arrTheList;
	}
}
