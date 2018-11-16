<?php

class Role extends CActiveRecord{
	public $arrRole='';
    public $arrAction=array();

	public $arrRole2='';
    public $arrAction2=array();

	public $arrRole3='';
    public $arrAction3=array();

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName(){
		return 'roles';
	}
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_name, access_rights', 'required'),
			array('role_name', 'length', 'max'=>64),
			array('remark', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('role_name, access_rightss, remark, added_date, updated_date, updated_by', 'safe', 'on'=>'search'),
		);
	}// rules
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}// relations
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	 public function attributeLabels()
	 {
		return array(
			'role_name' => 'Role name',
			'access_rightss' => 'Function',
			'remark' => 'Notes'
		);
	 }// function attributeLabels

	 public function search()
	 {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;



		$criteria->compare('role_name',$this->role_name,true);
		$criteria->compare('access_rights',$this->access_rights,true);
		$criteria->compare('remark',$this->remark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'role_name',
			),
		));
	 }	// function search
	 public function getListRole()
	 {
		$criteria=new CDbCriteria;
		$dataProvider = new CActiveDataProvider('Role', array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'role_name',
			),
		));
		$dataProvider->setPagination(false);
		$arrTheList = array();
		$arrTheList = $dataProvider->getData();
		$arrCates = array();
		if(is_array($arrTheList)){
			foreach($arrTheList as $k => $v){
				$arrCates[$v['access_rights']] = $v['access_rights'];
			}
		}
        return $arrCates;
	 }
	 public function getAllRoleName()
	 {
		$criteria=new CDbCriteria;
		$dataProvider = new CActiveDataProvider('Role', array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'role_name',
			),
		));
		$dataProvider->setPagination(false);
		$arrTheList = array();
		$arrTheList = $dataProvider->getData();
		$arrCates = array();
		if(is_array($arrTheList)){
			foreach($arrTheList as $k => $v){
				$arrCates[$v['role_name']] = $v['role_name'];
			}
		}
        return $arrCates;
	 }
	 public function getNameUser($iduser=0){

		if($iduser == 0) return '-';
		else{
			$criteria=new CDbCriteria;
			$criteria->compare('id',$iduser,false);

			$dataProvider = new CActiveDataProvider('Users', array(
				'criteria'=>$criteria,
			));
			$arrTheList = array();
			$arrTheList = $dataProvider->getData();
			$arrCates = array();
			if(is_array($arrTheList)){
				foreach($arrTheList as $k => $v){
					$arrCates[$v['id']] = $v['roles'];//username
				}
			}
			if(isset($arrCates[$iduser])){
		        return $arrCates[$iduser];
		    }else{
		    	return array();
		    }
		}
	}
	 public function getRoleName($nameUser=''){

		if($nameUser == '') return ' ';
		else{
			$criteria=new CDbCriteria;
			$criteria->compare('role_name',$nameUser,false);

			$dataProvider = new CActiveDataProvider('Role', array(
				'criteria'=>$criteria,
			));
			$arrTheList = array();
			$arrTheList = $dataProvider->getData();
			$arrCates = array();
			if(is_array($arrTheList)){
				foreach($arrTheList as $k => $v){
					$arrCates[$v['role_name']] = $v['access_rights'];//username
				}
			}
	        return $arrCates[$nameUser];
		}
	}
	public  function checkRole($control,$act){
		return 1;exit;
		$control = strtolower($control);
		$act = strtolower($act);
		$arrList=Yii::app()->params['all_Role'];
		$arrController=array();
		foreach($arrList as $k=> $v){
			$arrController[$k]=array();
			//print_r($arrController);die;
		}
		if($control== null && $act== null){
			//die;
			return 0;
		}
		else
		{
			$user_current= Yii::app()->user->id;// current user
			$arrRole=Role::model()->getNameUser($user_current);
			$arrRole=explode(",",$arrRole);// get Role in user  ex: admin, managers
			foreach($arrRole  as $x=>$y){
				$Role=Role::model()->getRoleName($y);
				$Role=json_decode($Role);

				foreach ($Role as $kk => $vv) {
					foreach ($vv as $kvv => $vvv) {
						if (!isset($arrController[$kk])){
							$arrController[$kk] = $vv;
						}
						else {
							foreach ($vv as $kvv => $vvv) {// each action, foreach to get key =>value, 0=>value;1=>value
								if (!in_array($vvv, $arrController[$kk])) {
										$arrController[$kk][] = $vvv;	// $arrController[key][values];[] set values for array
								}
							}// foreach
						}
					}// foreach
				}
			}


			if (isset($arrController[$control]) && in_array($act,$arrController[$control])) {

				return 1;
			}
		}
		return 0;

	}
	 public function showRight(){
	 	$arr=json_decode($this->access_rights);
		$ret = '';
		foreach($arr as $k => $v)
		{
			$line = '<b>'.$k . '</b>: ';
			$i=0;
			foreach ($v as $a) {
				$line .=$a;
				if($i<count($v)-1){
					$line .=', ';
				}
				$i++;
			}
			$line .= "<br/>";
			$ret .= $line;	
		}
		$ret=str_replace(":,",":", $ret);
		return $ret;
	 }
	 public function getNameRole(){
	 	if($this->access_rights){
	 		 $arr=json_decode($this->access_rights);
	 	}
	 	else{
	 		$arr=array();
	 	}  
		return $arr;	
	}
}

?>