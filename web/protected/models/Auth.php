<?php
/**
 * 功能：授权
 * 作者：武仝
 * 日期：2014-4-10 上午8:23:02
 * 版权：Copyright 2007-2014 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class Auth{
	
	/**
	 * 返回授权管理器
	 * @return CDbAuthManager
	 */
	public static function getAuthManager(){
		return Yii::app()->authManager;
	}
	
	/**
	 * 检测当前用户是否存在某种许可
	 * @param mixed $item
	 * @param int $userID
	 * @return boolean
	 */
	public static function has($item,$userID=null){
		if ($userID==null) {
			$flag=Yii::app()->user->checkAccess($item);
		}else{
			$authMgr=Yii::app()->authManager;
			$flag=$authMgr->checkAccess($item,$userID);
		}
		return $flag;
	}
	
	/**
	 * 根据用户ID获取用户拥有的角色
	 * @param int $userID
	 * @return array roles(name=CAuthItem)
	 */
	public static function getRole($userID=null){
		if ($userID==null) {
			$userID=User::getID();
		}
		$am=self::getAuthManager();
		return $am->getRoles($userID);
	}
	
	/**
	 * 返回用户拥有的角色串接的字符串
	 * @param int $userID
	 * @return string
	 */
	public static function getRoleToString($userID=null){
		$roleList=self::getRole($userID);
		if (is_array($roleList)) {
			$string="";
			$keys=array_keys($roleList);
			for($i=0;$i<count($roleList);$i++){
				$spliter=$i>0 ? "," : "";
				$string.=$spliter.$roleList[$keys[$i]]->getDescription();
			}
			return $string;
		}else{
			return "";
		}
	}
	
	/**
	 * 根据角色返回要跳转的地址
	 * @return string
	 */
	public static function getURLByRole(){
		$url="";
		if (Auth::has(AI::R_Group)) {
			//班组人员
			$url=Yii::app()->createUrl("UseMaterial/ReceiveMF");
		}elseif (Auth::has(AI::R_Major)) {
			//专职人员
			$url=Yii::app()->createUrl("scrap/ScrapFormList")."?type=Untreated";
		}elseif (Auth::has(AI::R_Materialer)){
			//材料管理员
			$url=Yii::app()->createUrl("Material/list");
		}elseif (Auth::has(AI::R_Storer)){
			//仓库管理员
			$url=Yii::app()->createUrl("Material/list");
		}elseif (Auth::has(AI::R_Admin)){
			//超级管理员
			$url=Yii::app()->createUrl("user/list");
		}elseif (Auth::has(AI::R_Visitor)){
			//超级管理员
			$url=Yii::app()->createUrl("Material/list");
		}else{
			$url="/login.html";
		}
		return $url;
	}
}