<?php
class RoleHelper {
 
    public static function GetRole($forceController=''){
        $controlID = strtolower(Yii::app()->controller->id);
		if ($forceController) {
			$controlID = $forceController;
		}
        $userType = Yii::app()->user->getState('type');
        
        $arrList=Yii::app()->params['all_roles'];
		$arrController=array();
		
		foreach($arrList as $k=> $v){
			$arrController[$k]=array();
		}

		$user_current= Yii::app()->user->id;// current user
		if($user_current){
			if ($user_current==1) {
				if(isset($arrList[$controlID]))
					return $arrList[$controlID];
				else{
					$arrController[$controlID][] = 'blablabla';
					return $arrController[$controlID];
				}
			}
			$arrRoles=Role::model()->getNameUser($user_current);

			if ($arrRoles) {
				$arrRoles=explode(",",$arrRoles);// get roles in user  ex: admin, managers
			} else {
				$arrRoles = array();
			}

			foreach($arrRoles as $x=>$y){

				$roles=Role::model()->getRoleName($y);
				$roles=json_decode($roles);//get list roles of
				if ($roles) {
					foreach ($roles as $kk => $vv) {
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
					}
				}
			}

			if (count($arrController[$controlID])<=0) {
					$arrController[$controlID][] = 'blablabla';
			}
		}else{
			$arrController[$controlID][] = 'blablabla';
		}
		return $arrController[$controlID];
	}
}
?>