<?php
/**
 * 功能：用户仓库
 * 作者：武仝
 * 日期：2014-4-8 下午5:07:37
 * 版权：Copyright 2007-2014 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class UserStoreController extends Controller{

	public $controllerName="仓库";

	public function actionList(){
		$this->setBread("用户仓库列表");
		$sql="
			SELECT
				u.userName,
				us.storeID,
				us.userID
			FROM
				mod_user u
			INNER JOIN mod_user_store us
			 ON u.id = us.userID";
		$condition[]=$_GET['userName'] == "" ? "" : "AND INSTR(userName,'{$_GET['userName']}')>0";
		//条件
		$criteria=new CDbCriteria();
		$criteria->order="u.id desc";
		$criteria->condition=implode(" ",$condition);
		//分页
		$this->pagination=new CPagination();
		$this->pagination->pageSize=15;
		//查找数据
		$sqlWhere=" WHERE 1=1 ".$criteria->condition;
		$sqlOrder=" ORDER BY ".$criteria->order;
		$sqlMerge=$sql.$sqlWhere.$sqlOrder;
		$command=Yii::app()->db->createCommand($sqlMerge);
		$rsList=ActiveRecord::getRecordByCMD($command,$this->pagination,$criteria);
		//渲染视图
		$this->render("/store/user_store_list",array(
			"rsList"=>$rsList
		));
	}
	
	/**
	 * 绑定用户仓库
	 */
	public function actionBindUser(){
		if(Yii::app()->request->isAjaxRequest){
			$userID=$_POST['userID'];
			if (!is_numeric($userID)) {
				WMessage::ajaxInfo("非法的用户",0);
			}
			$storeID=$_POST['storeID'];
			if (!$storeID) {
				WMessage::ajaxInfo("非法的仓库",0);
			}
			$storeID = implode(',',$storeID);
			$us=UserStore::model()->find("userID=".$userID);
			if ($us) {
				$us->storeID="$storeID";
				$us->isNewRecord=false;
			}else{
				$us=new UserStore();
				$us->userID=$userID;
				$us->storeID="$storeID";
				$us->isNewRecord=true;
			}
			if($us->save()){
				WMessage::ajaxInfo();
			}else{
				WMessage::ajaxInfo($us->error->getErrorMessage(),0);
			}
		}
		$userID=$_GET['userID'];
		if ($userID=="") {
			$userID=0;
			$storeID=0;
		}else{
			$us=UserStore::model()->find("userID=".$userID);
			if ($us) {
				$userID=$us->userID;
				$storeID=$us->storeID;
			}else{
				$userID=0;
				$storeID=0;
			}
		}
		$this->setLayoutNone();
		$this->render("/store/user_store_form",array(
			"userID"=>$userID,
			"storeID"=>$storeID,
			"type"=>$_GET['type']
		));
	}
	
	/**
	 * 移除绑定的用户
	 */
	public function actionRemoveUser(){
		$userID=$_POST['userID'];
		if (UserStore::model()->deleteAll("userID=".$userID)) {
			WMessage::ajaxInfo();
		}else{
			WMessage::ajaxInfo("删除失败",0);
		}
	}
}