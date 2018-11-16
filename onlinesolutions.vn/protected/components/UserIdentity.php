<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	private $_id;
	public $displayname = '';
	const ERROR_ACCOUNT_NOT_ACTIVE = 3;
	public function authenticate()
	{
		$uname = strtolower($this->username);
		$mUser=new Member;
		$criteria=new CDbCriteria;
		$criteria->condition = "email ='".$uname."'";
		$criteria->limit = 1;
		$arrUsers = $mUser->findAll($criteria);

		if(is_array($arrUsers) && count($arrUsers)>0) {

			$bOK = FALSE;
			if($arrUsers[0]['password']!==sha1(md5($this->password).'bkengine')) {
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			} else if ($arrUsers[0]['status'] > 0) {
				$this->errorCode=self::ERROR_ACCOUNT_NOT_ACTIVE;
			} else {

				$bOK = TRUE;
			}
			if ($bOK) {

				$this->_id = $arrUsers[0]['id'];
				$this->setState('first_name', $arrUsers[0]['first_name']); 
				$this->errorCode=self::ERROR_NONE;
			}	
		} else {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}

		return !$this->errorCode;
	}
	public function getId(){
        return $this->_id;
    }
}