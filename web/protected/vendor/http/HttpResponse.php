<?php
/**
 * 功能：http响应
 * 作者：武仝
 * 日期：2013-11-23 上午10:27:09
 * 版权：Copyright 2007-2013 wutong All Right Reserved.
 * 网址：http://www.wutong.biz
 */
class HttpResponse{
	/**
	 * 请求的Url
	 */
	public $requestUrl="";
	/**
	 * 响应返回的信息
	 */
	public $body="";
	/**
	 * cURL连接资源句柄的信息
	 */
	public $curlInfo="";
}