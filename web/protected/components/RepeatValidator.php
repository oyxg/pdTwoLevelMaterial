<?php
/**
 * 功能：重复检测
 * 作者：武仝
 * 日期：2014-5-27 上午9:04:50
 * 版权：Copyright 2007-2014 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */

/**
 * 更新----------------------------------
 * 2014-06-05 增加了 allowEmpty 属性，用来是否允许忽略空字符串的重复
 * 2014-06-24 增加了 condition属性的描述
 * 2015-02-13 增加了 showRealValue属性 出现重复的值的时候是否提示
 *
 */
class RepeatValidator extends CValidator{
	
	/**
	 * 主键ID字段名称
	 * @var string
	 */
	public $pkName="id";
	
	/**
	 * 是否允许为空
	 * @var bool
	 */
	public $allowEmpty=true;
	
	/**
	 * 出现重复的值的时候是否提示
	 * @var bool
	 */
	public $showRealValue=false;
	
	/**
	 * 额外判断条件
	 * <p>元素为模型的属性</p>
	 * @var array
	 * 
	 */
	public $condition=array();
	
	/*
	 * 验证属性
	 * @see
	 * CValidator::validateAttribute()
	 * */
	protected function validateAttribute($object,$attribute){
		//额外查询条件
		$condition="";
		foreach($this->condition as $key){
			$condition.=" AND `{$key}`='{$object->$key}'";
		}
		//主键名
		$pk=$this->pkName;

		//如果是在添加场景下
		if(in_array(ActiveRecord::SCENES_ADD,$this->on)){
			//目标对象属性的数量
			$count=$object->count("`".$attribute . "`='{$object->$attribute}' {$condition}");
		}else if(in_array(ActiveRecord::SCENES_EDIT,$this->on)){
			//目标对象属性的数量
			$count=$object->count("`".$attribute . "`='{$object->$attribute}' AND `{$this->pkName}`!='{$object->$pk}' {$condition}");
		}
		
		if($this->allowEmpty){
			//如果屬性为空的话
			if($object->$attribute == ""){
				$count=0;
			}
		}
		
		//如果数量大于1就重复了
		if($count > 0){
			$value=$object->$attribute;
			$tipMsg=$this->showRealValue ? "{attribute} （{$value}）已经存在" : "{attribute} 已经存在";
			$message=$this->message != "" ? $this->message : $tipMsg;
			$this->addError($object,$attribute,$message);
		}
	}
}