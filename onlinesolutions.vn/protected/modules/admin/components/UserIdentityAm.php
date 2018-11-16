<?php
class UserIdentityAm extends CUserIdentity
{
	
	private $_id;
	public $displayname = '';
	const ERROR_ACCOUNT_NOT_ACTIVE = 3;
	public function authenticate()
	{
		$uname = strtolower($this->username);

		$mUser=new Users;
		$criteria=new CDbCriteria;
		$criteria->condition = "(username ='".$uname."' OR email='".$uname."') AND is_admin=1 AND status='A'";
		$criteria->limit = 1;
		$arrUsers = $mUser->findAll($criteria);
		if(is_array($arrUsers) && count($arrUsers)>0) {
			$bOK = FALSE;
			if($arrUsers[0]['password']!==sha1(md5($this->password).'bookingengine')) {
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			} else if ($arrUsers[0]['status'] !== 'A') {
				$this->errorCode=self::ERROR_ACCOUNT_NOT_ACTIVE;
			} else {
				$bOK = TRUE;
			}

			if ($bOK) {
				$chain = $arrUsers[0]['chain_id'];
				$hotels = Hotel::model()->getListByChain($chain);

				if(count($hotels)<2){
					foreach($hotels as $it => $ht){
						Yii::app()->user->setState('hotel_id', $id);
						Yii::app()->session['hotel'] = $id;
					}
				}else{
					$ar_hotel = json_decode($arrUsers[0]['hotel_id']);
					
					Yii::app()->user->setState('hotel_id', $ar_hotel[0]);
					Yii::app()->session['hotel'] = $ar_hotel[0];	
				}

				$this->_id = $arrUsers[0]['id'];
				$roles = trim($arrUsers[0]['roles']);
				Yii::app()->user->id = $this->_id;
				Yii::app()->user->setState('type', strtolower($roles));
				
				Yii::app()->user->setState('displayname', $arrUsers[0]['fullname']); 
				$this->errorCode=self::ERROR_NONE;
				$arrUsers[0]['ip_address']=$_SERVER['REMOTE_ADDR'];
				$arrUsers[0]['last_login_date']=date('Y-m-d H:m:i');
				$arrUsers[0]->update();
			}	
		} else {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}

		return !$this->errorCode;
	}
	public function getId(){
        return $this->_id;
    }
	public function getType(){
        return $this->getState('type');
    }
}