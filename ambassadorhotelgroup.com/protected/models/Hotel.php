<?php

/**
 * This is the model class for table "hotels".
 *
 * The followings are the available columns in table 'hotels':
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $display_order
 * @property double $graded_star
 * @property string $email_info
 * @property string $email_sales
 * @property string $hotline
 * @property string $tel
 * @property string $fax
 * @property integer $no_of_rooms
 * @property string $address
 * @property string $city
 * @property string $country
 * @property string $description
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 * @property string $facilities
 * @property string $sports
 * @property string $location
 * @property string $cover_photo
 * @property integer $status
 */
class Hotel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hotels';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email_info, email_sales', 'required', 'message' => 'Please enter {attribute}'),
			array('display_order, no_of_rooms, updated_by, status', 'numerical', 'integerOnly'=>true),
			array('graded_star', 'numerical'),
			array('name, slug, email_info, email_sales', 'length', 'max'=>100),
			array('hotline, fax', 'length', 'max'=>20),
			array('city, country, promotion, address, location, description, lat, lng, short_description, special_offer, trip', 'safe'),
			array('cover_photo, tel', 'length', 'max'=>128),
			array('other_name, home_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, slug, display_order, graded_star, email_info, email_sales, hotline, tel, fax, no_of_rooms, address, city, country, description, added_date, updated_date, updated_by, facilities, sports, location, cover_photo, status', 'safe', 'on'=>'search'),
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
			'special_offer' => 'Special Offer',
			'graded_star' => 'Graded Star',
			'email_info' => 'Email Info',
			'email_sales' => 'Email Sales',
			'hotline' => 'Hotline',
			'tel' => 'Tel',
			'fax' => 'Fax',
			'no_of_rooms' => 'No Of Rooms',
			'address' => 'Address',
			'city' => 'City',
			'country' => 'Country',
			'description' => 'Description',
			'added_date' => 'Added Date',
			'updated_date' => 'Updated Date',
			'updated_by' => 'Updated By',
			'facilities' => 'Facilities',
			'sports' => 'Sports',
			'location' => 'Location',
			'cover_photo' => 'Cover Photo',
			'status' => 'Status',
			'trip' => 'Trip Comment'
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
		$criteria->compare('graded_star',$this->graded_star);
		$criteria->compare('email_info',$this->email_info,true);
		$criteria->compare('email_sales',$this->email_sales,true);
		$criteria->compare('hotline',$this->hotline,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('no_of_rooms',$this->no_of_rooms);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('facilities',$this->facilities,true);
		$criteria->compare('sports',$this->sports,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('cover_photo',$this->cover_photo,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 'status asc, display_order asc')
		));
	}

	public function getList(){
		$criteria = new CDbCriteria;
		$criteria->compare('status', 0, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array('defaultOrder'=>'display_order asc')));
		$dataProvider->setPagination(false);
		return $dataProvider;
	}

	public function getList2(){
		$criteria = new CDbCriteria;
		$criteria->compare('status', 0, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array('defaultOrder'=>'display_order asc')));
		$dataProvider->setPagination(false);
		$arrTheList = array();
		foreach($dataProvider->getData() as $data){
			$arrTheList[$data['id']] = $data['name'];
		}
		return $arrTheList;
	}

	public function getList3(){
		$criteria = new CDbCriteria;
		$criteria->compare('status', 0, false);
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria' => $criteria));
		$dataProvider->setPagination(false);
		$arrTheList = array();
		foreach($dataProvider->getData() as $data){
			$arrTheList[$data['slug']] = $data['id'];
		}
		return $arrTheList;
	}

	public function getHotel($id){
		$data = Hotel::model()->findByPk($id);
		return $data;
	}

	public function getHotelBySlug($slug){
		$criteria = new CDbCriteria;
		$criteria->compare('slug', $slug, false, 'AND');
		$criteria->compare('status', 0, false, 'AND');
		$data = Hotel::model()->find($criteria);
		return $data;
	}

	public static function get_min_price($hotel){
        $roomType = Roomtype::model()->getRoomtypeMinPrice($hotel);
        $arrHotel = array();
        if($roomType){
        	$photos = Gallery::model()->getList(1,$roomType['hotel_id'], $roomType['id']);
            $photo = '';
            if($photos){
                $pt = $photos->getData();
                $photo = $pt[0]['name'];
            }
	        $from = date('Y-m-d');
	        $to = date('Y-m-d', strtotime("$from +29 day"));
	        $rates = Rates::model()->getRate($hotel, $from, $to);
	        //echo"<pre>";print_r($rates);
	        $fD = $rates['date'];
	        $arrHotel=array(
	            'fromDate' => $fD,
	            'toDate' => date('Y-m-d', strtotime("$fD +1 day")),
	            'minRateToday' => 0,
	            'roomType' => $roomType['name']
	        );
	        if($photo){
	        	$arrHotel['photo'] = $photo;
	        }
	        //$minRateToday = 0;
	        if($rates){
	            $rate = $rates['single'];
	            
	            $promotion = Promotion::model()->getPromotionByHotel($hotel);
	            //echo"<pre>";print_r($promotion);
	            $array_rate = array();
	            if(count($promotion) > 0 && $promotion[0]['discount']>0){
	            	$promotion_name = json_decode($promotion[0]->name, true);
	            	$lang=Yii::app()->session['_lang'];
	            	$arrHotel['promotion_name'] = $promotion_name[$lang];
	            	$arrHotel['promotion_slug'] = $promotion[0]['slug'];
	                $arrHotel['minRateToday'] = ($rate * (100 - $promotion[0]['discount']) / 100);
	            }
	        }
	    }
        return $arrHotel;
    }

    public function getLogo($hotel){
    	$criteria = new CDbCriteria;
    	$criteria->compare('slug', $hotel, false);
    	$criteria->compare('status', 0, false);
    	$data = Hotel::model()->find($criteria);
    	return $data['logo1'];
    }
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
