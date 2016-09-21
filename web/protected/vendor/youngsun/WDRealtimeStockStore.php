<?php
/**
 * 功能：仓库的实时库存
 * 作者：武仝
 * 日期：2014-4-12 下午10:45:17
 * 版权：Copyright 2007-2013 wutong All Right Reserved.
 * 网址：http://www.wutong.biz
 * 公司：扬晟科技（http://www.iyoungsun.com）
 */
class WDRealtimeStockStore{
	
	/**
	 * 仓库
	 */
	public $storeName="";
	
	/**
	 * 库存
	 * @var array(name=int)
	 */
	public $total=array();
	
	/**
	 * 类型
	 * @var array(name=string)
	 */
	public $type=array();
	
	/**
	 * 类型名称
	 * @var array(name=string)
	 */
	public $typeName=array();

	/**
	 * 饼图数据
	 * @var array(name=string)
	 */
	public $pie=array();
}