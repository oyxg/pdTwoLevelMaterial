<?php
/**
 * 功能：仓库管理员
 * 作者：武仝
 * 日期：2014-4-11 上午11:35:04
 * 版权：Copyright 2007-2014 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class WStorer{

	/**
	 * 仓库ID
	 * @var string
	 */
	public $storeID;
	
	/**
	 * 获取仓库管理员列表
	 * @return array
	 */
	public function getList(){
		$userList=UserStore::model()->findAll("storeID IN(".$this->storeID.")");
		if ($userList==null) {
			return null;
		}
		$userArr=null;
		foreach ($userList as $key=>$us){
			if (Auth::has(AI::R_Storer,$us->userID)) {
				if ($userArr==null) {
					$userArr=array();
				}
				array_push($userArr, User::getUserByID($us->userID));
			}
		}
		return $userArr;
	}
}
