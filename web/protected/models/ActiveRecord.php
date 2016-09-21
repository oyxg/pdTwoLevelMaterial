<?php
/**
 * 功能：模型父类
 * 作者：武仝
 * 日期：2014-2-17 下午8:09:01
 * 版权：Copyright 2007-2013 wutong All Right Reserved.
 * 网址：http://www.wutong.biz
 */

/**
 * ------------------------------------------------
 * 更新记录
 * 2014-03-21 修正了getRecordBySQL方法无法使用order排序的问题
 * 2014-04-08 增加了getRecordByCMD方法
 */
class ActiveRecord extends CActiveRecord{
	/**
	 * 场景-添加
	 */
	const SCENES_ADD="insert";
	/**
	 * 场景-编辑
	 */
	const SCENES_EDIT="edit";
	
	
	/**
	 * 错误
	 * @var WError
	 */
	public $error;
	/**
	 * 同步公开的变量到数据库的字段：
	 * $type=1 为公开变量到私有attributes，
	 * $type=2 为私有attributes到公开变量
	 * @param int 同步类型
	 */
	public function sync($type=1){
		//获取映射
		$map=$this->map();
		//数据库的字段属性
		$attributes=$this->attributes;
		//数据库的字段
		$keys=array_keys($attributes);
		//循环同步
		for($i=0;$i<count($keys);$i++){
			if (array_key_exists($keys[$i],$map)) {
				if ($type==1) {
					$this[$keys[$i]]=$this->$map[$keys[$i]];
				}else if($type==2){
					$this->$map[$keys[$i]]=$this[$keys[$i]];
				}
			}
		}
	}
	/**
	 * 将公开属性变量写入到私有属性
	 * @return void
	 */
	public function syncWrite(){
		$this->sync(1);
	}
	/**
	 * 读取私有属性并放入公开属性变量
	 * @return void
	 */
	public function syncRead(){
		$this->sync(2);
	}
	/**
	 * 获取记录
	 * @param CDbCriteria 条件
	 * @param CPagination 分页
	 * @return ActiveRecord
	 */
	public function getRecord(CDbCriteria $criteria=null,CPagination $pagination=null){
		//条件
		if (!($criteria instanceof CDbCriteria)) {
			$criteria=new CDbCriteria();
		}
		//记录总数
		$class=get_class($this);
		$obj=new $class;
		$count=$obj->count($criteria);
		//分页
		if($pagination instanceof CPagination){
			$pagination->setItemCount($count);
			$pagination->applyLimit($criteria);
		}
		//查询
		$rsList=$this->findAll($criteria);
		//返回
		return $rsList;
	}
	/**
	 * 根据SQL获取分页记录
	 * @param CDbCriteria 提交对象
	 * @param CPagination 分页对象
	 * @param string 表名，也可以包括on语句
	 * @return array
	 */
	public function getRecordBySQL(CDbCriteria $criteria=null,CPagination $pagination=null,$tables=null){
		if (!$criteria) {
			$criteria=new CDbCriteria();
		}
		if (!$pagination) {
			$pagination=new CPagination();
			$pagination->pageSize=10;
		}
		if (!$tables) {
			$tables=$this->tableName();
		}
		if (trim($criteria->select)=="") {
			$criteria->select="*";
		}
		if (trim($criteria->condition)=="") {
			$criteria->condition=" 1 ";
		}
		$countSQL="SELECT COUNT(*) AS total_count FROM ".$tables." WHERE ".$criteria->condition;
		$command=new CDbCommand(Yii::app()->db);
		$command->setText($countSQL);
		$countRs=$command->queryRow();
		if (!$countRs) {
			$count=0;
		}else{
			$count=$countRs['total_count'];
		}
		$pagination->setItemCount($count);
		$pagination->applyLimit($criteria);
		$order=$criteria->order=="" ? "" : " ORDER BY ".$criteria->order;
		$sql="SELECT ".$criteria->select." FROM ".$tables." WHERE ".$criteria->condition." ".$order." LIMIT ".$criteria->offset.",".$criteria->limit;
		$command->setText($sql);
		$result=$command->queryAll();
		return $result;
	}
	
	/**
	 * 根据SQL获取分页记录
	 * @param CDbCommand $command
	 * @param CPagination $pagination
	 * @param CDbCriteria $criteria
	 * @return mixed
	 */
	public static function getRecordByCMD(CDbCommand $command,CPagination $pagination=null,CDbCriteria $criteria=null){
		if (!$pagination) {
			$pagination=new CPagination();
			$pagination->pageSize=10;
		}
		if ($criteria==null) {
			$criteria=new CDbCriteria();
		}
		
		//获取查询的语句
		$queryText=$command->getText();
		//select起始位置
		$selectStart=mb_strpos(strtolower($queryText), "select",0,"utf-8");
		//from起始位置
		$fromStart=mb_strpos(strtolower($queryText), "from",0,"utf-8");
		//中间的字段
		$field=mb_substr($queryText, $selectStart+6,$fromStart-$selectStart-6,"utf8");
		//查询总数的SQL语句
		$countSQL=str_replace($field, " COUNT(*) total_count ", $queryText);
		//总数记录
		$countRs=$command->setText($countSQL)->queryRow();
		//设置分页数据的总数据量
		$pagination->setItemCount($countRs['total_count']);
		//设置取记录范围
		$pagination->applyLimit($criteria);
		$queryText.=" LIMIT ".$criteria->offset." ,".$criteria->limit;
		//获取记录集
		$rsList=$command->setText($queryText)->queryAll();
		return $rsList;
	}
	/**
	 * 重写验证
	 * @see CModel::validate()
	 */
	public function validate($attributes=null,$clearErrors=true){
		$result=parent::validate($attributes,$clearErrors);
		if (!$result) {
			$this->error=new WError(WFormater::joinErrors($this->getErrors()));
		}
		return $result;
	}
	/**
	 * 重写保存
	 * @see CActiveRecord::save()
	 */
	public function save($runValidation=true,$attributes=null){
		$result=parent::save($runValidation,$attributes);
		if(!$result){
			$this->error=new WError(WFormater::joinErrors($this->getErrors()));
		}
		return $result;
	}
	/**
	 * 是否存在指定ID
	 * @param int $id
	 * @param string $class
	 * @return bool
	 */
	public static function hasOne($id,$class=__CLASS__){
		if($class::model()->count('id='.$id)>0){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 获取列表
	 * @param string $class
	 * @return array
	 */
	public static function getList($class=__CLASS__){
		return $class::model()->findAll();
	}
	
	/**
	 * 获取名称
	 * @param int $id
	 * @param string $class
	 * @return string
	 */
	public static function getName($id,$class=__CLASS__){
		$rs=$class::model()->findByPk($id);
		if (!$rs) {
			return "";
		}
		$ref=new ReflectionClass($rs);
		if($ref->hasProperty("name")){
			return $rs->name;
		}else{
			return "";
		}
	}
	
	/**
	 * 添加
	 * @return boolean
	 */
	public function add(){
		$this->setScenario(self::SCENES_ADD);
		$this->isNewRecord=true;
		return parent::save();
	}
	
	/**
	 * 修改
	 * @return boolean
	 */
	public function edit(){
		$this->setScenario(self::SCENES_EDIT);
		$this->isNewRecord=false;
		return parent::save();
	}
}