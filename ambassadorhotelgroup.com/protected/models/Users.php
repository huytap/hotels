<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $status
 * @property string $added_date
 * @property string $updated_date
 * @property integer $updated_by
 * @property string $last_login_date
 * @property string $roles
 * @property string $fullname
 * @property string $cellphone
 * @property string $email
 * @property string $remarks
 * @property integer $is_admin
 */
class Users extends CActiveRecord
{
	public $new_password;
	public $confirm_new_password;
	public $old_password;
	public function tableName()
	{
		return 'users';
	}

	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, fullname, email', 'required', 'on'=>'create,update'),
			array('new_password', 'safe','on'=>'create,update'),
			//array('password, cellphone, gender, hotel_id, is_admin, roles, remarks, status', 'on' => 'create, update'),
			array('old_password, new_password, confirm_new_password', 'required', 'on'=>'change'),
			array('confirm_new_password', 'compare', 'compareAttribute'=>'new_password', 'message' => 'Confirm new password not true', 'on'=>'change'),
			array('old_password', 'equalPasswords', 'on'=>'change'),
			array('password', 'required', 'on'=>'create'),
			array('updated_by, is_admin, hotel_id', 'numerical', 'integerOnly'=>true),
			array('username, password', 'length', 'max'=>128),
			array('status', 'length', 'max'=>1),
			array('roles, avatar', 'length', 'max'=>255),
			array('fullname, email', 'length', 'max'=>200),
			array('ip_address','safe'),
			array('cellphone,last_login_date, gender', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, status, added_date, updated_date, updated_by, last_login_date, roles, fullname, cellphone, email, remarks, is_admin', 'safe', 'on'=>'search'),
		);
	}

	public function equalPasswords($attribute, $params){
	    $user = Users::model()->findByPk(Yii::app()->user->id);
	    if ($user->password !== sha1(md5($this->old_password))){
	        $this->addError($attribute, 'Old password is incorrect.');
	    }
	}

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
			'username' => 'Username',
			'password' => 'Password',
			'status' => 'Status',
			'added_date' => 'Added Date',
			'updated_date' => 'Updated Date',
			'updated_by' => 'Updated By',
			'last_login_date' => 'Last Login Date',
			'roles' => 'Roles',
			'fullname' => 'Fullname',
			'cellphone' => 'Cellphone',
			'email' => 'Email',
			'remarks' => 'Remarks',
			'is_admin' => 'Is Admin',
			'hotel_id' => 'Hotel',
			'new_password'=>'New password',
			'old_password'=>'Old password',
			'confirm_new_password'=>'Confirm new password'
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('added_date',$this->added_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('last_login_date',$this->last_login_date,true);
		$criteria->compare('roles',$this->roles,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('cellphone',$this->cellphone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('is_admin',$this->is_admin);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getInfomation($id){
		$data = Users::model()->findByPk($id);
		return $data;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
