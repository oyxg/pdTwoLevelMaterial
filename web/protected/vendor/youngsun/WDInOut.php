<?php
/**
 * 功能：仓库的出入库记录
 * 作者：武仝
 * 日期：2014-4-12 下午10:45:17
 * 版权：Copyright 2007-2013 wutong All Right Reserved.
 * 网址：http://www.wutong.biz
 * 公司：扬晟科技（http://www.iyoungsun.com）
 */
class WDInOut{
	
	/**
	 * 仓库
	 */
	public $storeName="";
	
	/**
	 * 进的次数
	 * @var array(name=int)
	 */
	public $inCount=array();
	
	/**
	 * 出的次数
	 * @var array(name=int)
	 */
	public $outCount=array();
	
	/**
	 * 物资进数量
	 * @var array(name=int)
	 */
	public $inTotal=array();
	
	/**
	 * 物资出数量
	 * @var array(name=int)
	 */
	public $outTotal=array();
	
	/**
	 * 出入次数
	 * @var array
	 */
	public $countTotal=array();
	
	/**
	 * 出入数量
	 * @var array
	*/
	public $total=array();
	
}