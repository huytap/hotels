<?php
 
	// this file must be stored in:
	// protected/components/WebUser.php
	 
	class WebUser extends CWebUser {
	 
	  // Store model to not repeat query.
	  private $_model;
	  public $type;
	 
			
	  // This is a function that checks the field 'roles'
	  // in the User model to be equal to 1, that means it's admin
	  // access it by Yii::app()->user->isAdmin()
	  function isUser(){
	  	if(Yii::app()->user->isGuest) return false;
	  	var_dump(Yii::app()->user->id);die;
	    $user = $this->loadUser(Yii::app()->user->id);
	    
	    if(!$user) return false;
		return intval($user->roles) === 'user';
	  }
	  function isAdmin(){
	    $user = $this->loadUser(Yii::app()->user->id);

	    /* if(!$user && !Yii::app()->user->isGuest && Yii::app()->user->id == 9999){
	    	return true;
	    } */
	    if(!$user) return false;
		return intval($user->roles) === 'admin';
	  }
	  
	  // Load user model.
	  protected function loadUser($id=null)
	    {
	        if($this->_model===null)
	        {
	            if($id!==null)
	                $this->_model=Users::model()->findByPk($id);
	        }
	       
	        return $this->_model;
	    }
	}
?>