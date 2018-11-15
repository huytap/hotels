<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
			array('username', 'email', 'message' => 'Email không đúng định dạng'),
			array('username', 'uniqueEmail', 'message' => 'Email này chưa được đăng ký'),
		);
	}

	public function uniqueEmail($attribute, $params) {
        $check = Users::model()->findByAttributes(array(
            'email' => $this->username));
        if (!$check) {
            $this->addError('username', 'Email này chưa được đăng ký');
        }
    }

	public function attributeLabels()
	{
		return array(
			'password' => 'Mật khẩu',
			'username' => 'Email'
		);
	}

	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentityFE($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Email hoặc mật khẩu không đúng.');
		}
	}

	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentityFE($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentityFE::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
