<?php
/**
 * 功能：审核员
 * 作者：武仝
 * 日期：2014-4-11 上午11:35:04
 * 版权：Copyright 2007-2014 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class WChecker{

	/**
	 * 仓库ID
	 * @var string
	 */
	public $storeID;
	
	/**
	 * 获取审核员列表
	 * @return array
	 */
	public function getList(){
		$userList=UserStore::model()->findAll("storeID IN(".$this->storeID.")");
		if ($userList==null) {
			return null;
		}
		$userArr=null;
		foreach ($userList as $key=>$us){
			if (Auth::has(AI::R_Checker,$us->userID)) {
				if ($userArr==null) {
					$userArr=array();
				}
				array_push($userArr, User::getUserByID($us->userID));
			}
		}
		return $userArr;
	}
}
