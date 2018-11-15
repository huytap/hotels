<?php

/**
 * This is the model class for table "explorehotel".
 *
 * The followings are the available columns in table 'explorehotel':
 * @property integer $id
 * @property string $title
 * @property integer $display_order
 * @property string $cover_photo
 * @property string $text_link
 * @property string $link
 * @property integer $hotel_id
 * @property integer $status
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 */
class Explorehotel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'explorehotel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, display_order, cover_photo, text_link, link', 'required'),
			array('display_order, hotel_id, status, updated_by', 'numerical', 'integerOnly'=>true),
			array('title, cover_photo, text_link, link', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, display_order, cover_photo, text_link, link, hotel_id, status, added_date, updated_date, updated_by', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'display_order' => 'Display Order',
			'cover_photo' => 'Cover Photo',
			'text_link' => 'Text Link',
			'link' => 'Link',
			'hotel_id' => 'Hotel',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('display_order',$this->display_order);
		$criteria->compare('cover_photo',$this->cover_photo,true);
		$criteria->compare('text_link',$this->text_link,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('status',$this->status);
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
	 * @return Explorehotel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
