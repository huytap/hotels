<?php

/**
 * This is the model class for table "items".
 *
 * The followings are the available columns in table 'items':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $file_ext
 * @property string $old_name
 * @property integer $gallery_id
 * @property integer $thumb_nails
 * @property integer $active_status
 *
 * The followings are the available model relations:
 * @property Galleries $gallery
 */
class Item extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Item the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('display_order, gallery_id, cover_image, thumb_nails, active_status', 'numerical', 'integerOnly'=>true),
			array('name, file_ext, old_name', 'length', 'max'=>255),
			array('url, description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url, file_ext, old_name,cover_image, gallery_id, thumb_nails, active_status', 'safe', 'on'=>'search'),
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
			'gallery' => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
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
			'url' => 'Path',
			'file_ext' => 'File Ext',
			'old_name' => 'Old Name',
			'gallery_id' => 'Gallery',
			'thumb_nails' => 'Thumb Nails',
            'active_status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($gallery_id='')
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('file_ext',$this->file_ext,true);
		$criteria->compare('old_name',$this->old_name,true);
        if($gallery_id) {
            $criteria->compare('gallery_id', $gallery_id, false, 'AND');
        }
		$criteria->compare('thumb_nails',$this->thumb_nails);
		$criteria->with = 'gallery';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>500,
				),
			'sort' => array(
				'defaultOrder' => array(
					'display_order' => 'ASC'
					),
				),
		));
	}

	public function getList($status=null, $limit=9){
		$criteria = new CDbCriteria;
		if($status !== null){
			$criteria->compare('active_status', $status, false);
		}
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => $limit)
			)
		);
		//$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public function getFirstItem($gallery_id){
		$criteria = new CDbCriteria;
		$criteria->compare('gallery_id', $gallery_id, false);
		$criteria->order = 'display_order ASC';
		$criteria->limit=1;
		$data = Item::model()->find($criteria);
		return $data;
	}

	public function getLastItem($gallery_id){
		$criteria = new CDbCriteria;
		$criteria->compare('gallery_id', $gallery_id, false);
		$criteria->order = 'display_order DESC';
		$criteria->limit=1;
		$data = Item::model()->find($criteria);
		return $data['display_order'];
	}

	public function getListByGallery($id){
		$criteria = new CDbCriteria;
		$criteria->compare('gallery_id', $id, false);
		$data = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 'display_order asc')));
		$data->setPagination(false);
		return $data;
	}
    public function search_data(){
        $criteria=new CDbCriteria;
        $criteria->compare('thumb_nails',$this->thumb_nails);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>500,
            ),
            'sort' => array(
                'defaultOrder' => array(
                    'id' => 'DESC'
                ),
            ),
        ));
    }
}