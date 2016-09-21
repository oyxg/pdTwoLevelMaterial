<?php
/**
 * 功能：用户
 * 作者：武仝
 * 日期：2014-4-8 下午5:07:00
 * 版权：Copyright 2007-2014 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class UserController extends Controller{
	
	public $controllerName="用户";
	/**
	 * 列表
	 */
	public function actionList(){
		$this->setBread("用户列表");
		//查询参数
		$condition[]="1=1";
		$condition[]=$_GET['userName'] == "" ? "" : "AND INSTR(userName,'{$_GET['userName']}')>0";
        $condition[]=$_GET['loginName'] == "" ? "" : "AND INSTR(loginName,'{$_GET['loginName']}')>0";
		$condition[]=$_GET['storeID'] == "" ? "" : "AND INSTR(us.storeID,'{$_GET['storeID']}')>0";
		//模型实例化
		$user=new User();
		//条件
		$criteria=new CDbCriteria();
		$criteria->order="t.id desc";
		$criteria->join=' join mod_user_store us on t.id = us.userID ';// join mod_store s on s.storeID=us.storeID
		$criteria->condition=implode(" ",$condition);
		//分页
		$this->pagination=new CPagination();
		$this->pagination->pageSize=15;
		//查找数据
		$rsList=$user->getRecord($criteria,$this->pagination);
		//渲染视图
		$this->render("user_list",array(
			"rsList"=>$rsList
		));
	}
	
	/**
	 * 添加
	 */
	public function actionAdd(){
		WMessage::checkAccess(AI::C_UserAdd);
		if(Yii::app()->request->isAjaxRequest){
			$user=new User();
			if($_POST['lastLogin'] == ""){
				unset($_POST['lastLogin']);
			}
			$user->attributes=$_POST;
			//事务处理
			$transaction=Yii::app()->db->beginTransaction();
			try {
				//保存用户
				$status=$user->add();
				if (!$status) {
					throw new Exception($user->error->getErrorMessage());
				}
				//读取数据
				$role=$_POST['role'];
				$storeID=$_POST['storeID'];
				if(!$storeID){
					throw new Exception("请选择仓库");
				}
				//授权管理器
				$am=Auth::getAuthManager();
				//绑定角色
				$item=$am->assign($role, $user->id);
				if (!($item instanceof CAuthAssignment)) {
					throw new Exception("绑定角色失败");
				}
				//检查用户选择的是什么角色，然后进行逻辑处理
//				if ($role==AI::R_Group || $role==AI::R_Storer || $role==AI::R_Materialer || $role==AI::R_Major) {
					//绑定仓库
					$us=new UserStore();
					$storeID = implode(',',$storeID);
					$us->storeID="$storeID";
					$us->userID=$user->id;
					$status=$us->insert();
					if (!$status) {
						throw new Exception($us->error->getErrorMessage());
					}
//				}else{
//
//				}
				$transaction->commit();
			}catch (Exception $e){
				$transaction->rollback();
				WMessage::ajaxInfo($e->getMessage(),0);
			}
			WCache::clearAll();
			WMessage::ajaxInfo();
		}
		//----------------
		// 获取系统角色
		//----------------
		$am=Auth::getAuthManager();
		$roleList=$am->getAuthItems(AuthItem::TYPE_ROLES);
		//----------------
		// 获取仓库列表
		//----------------
		$storeList=Store::model()->findAll();
		
		//渲染
		$this->setLayoutNone();
		$this->render("user_form",array(
			"roleList"=>$roleList,
			"storeList"=>$storeList,
		));
	}
	
	/**
	 * 修改
	 */
	public function actionEdit(){
		WMessage::checkAccess(AI::C_UserEdit);
		if(Yii::app()->request->isAjaxRequest){
			$user=User::model()->findByPk($_GET['userID']);
			if(!$user){
				WMessage::ajaxInfo("没有找到数据",0);
			}
			if($_POST['loginPassword'] == ""){
				unset($_POST['loginPassword']);
			}else{
				$_POST['loginPassword']=User::encodePassword($_POST['loginPassword']);
			}
			if($_POST['lastLogin'] == ""){
				unset($_POST['lastLogin']);
			}
			$user->attributes=$_POST;
			if($user->edit()){
				WCache::clearAll();
				WMessage::ajaxInfo();
			}else{
				WMessage::ajaxInfo($user->error->getErrorMessage(),0);
			}
		}
		$user=User::model()->findByPk($_GET['userID']);
		if(!$user){
			WMessage::htmlWarn("没有找到数据");
		}
		//----------------
		// 获取系统角色
		//----------------
		$am=Auth::getAuthManager();
		$roleList=$am->getAuthItems(AuthItem::TYPE_ROLES);
		//----------------
		// 获取仓库列表
		//----------------
		$storeList=Store::model()->findAll();
		
		//渲染
		$this->setLayoutNone();
		$this->render("user_form",array(
			"user"=>$user,
			"roleList"=>$roleList,
			"storeList"=>$storeList,
		));
	}
	
	/**
	 * 删除
	 */
	public function actionRemove(){
		WMessage::checkAccess(AI::C_UserDelete);
		if(Yii::app()->request->isAjaxRequest){
			$user=User::model()->findByPk($_GET['userID']);
			if(!$user){
				WMessage::ajaxInfo("没有找到数据",0);
			}
			if(!$user->delete()){
				WMessage::ajaxInfo($user->error->getErrorMessage(),0);
			}
			WCache::clearAll();
			WMessage::ajaxInfo();
		}
	}
	
	public function actionUpdatePassword(){
		if(Yii::app()->request->isAjaxRequest){
			$user=User::model()->findByPk(User::getID());
			if(!$user){
				WMessage::ajaxInfo("没有找到你的用户数据",0);
			}
			if(strpos($_POST['newPwd1']," ")){
				WMessage::ajaxInfo("密码不能包含空格",0);
			}
			if ($user->updatePassword($_POST['srcPwd'],$_POST['newPwd1'],$_POST['newPwd2'])) {
				WMessage::ajaxInfo();
			}else{
				WMessage::ajaxInfo($user->error->getErrorMessage(),0);
			}
		}
		$this->setLayoutNone();
		$this->render("user_password");
	}
}