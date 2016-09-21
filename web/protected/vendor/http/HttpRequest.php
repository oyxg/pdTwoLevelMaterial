<?php
/**
 * 功能：发送http请求
 * 作者：武仝
 * 日期：2013-11-23 上午8:42:58
 * 版权：Copyright 2007-2013 wutong All Right Reserved.
 * 网址：http://www.wutong.biz
 */
class HttpRequest{
	
	const POST="post";
	const GET="get";
	/**
	 * 要传输的非application/x-www-form-urlencode数据
	 */
	private $rawData="";
	/**
	 * 要传输的数据POST
	 */
	private $params=array();
	/**
	 * curl参数
	 */
	private $options=array();
	/**
	 * header参数
	 */
	private $headers=array();
	/**
	 * 返回的结果
	 */
	private $httpResult;
	/**
	 * 要发送的url地址
	 */
	public $url="";
	/**
	 * 请求方法
	 */
	public $method=self::GET;
	/**
	 * 响应
	 * @var HttpResponse
	 */
	private $response=null;
	/**
	 * 错误信息
	 */
	protected $errInfo="";
	/**
	 * curl句柄
	 */
	public $curl=null;
	/**
	 * 构造
	 * @param string $url
	 */
	public function __construct($url=""){
		$this->url=$url;
		$this->response=new HttpResponse();
	}
	/**
	 * 获取错误信息
	 * @return string
	 */
	public function getErrorInfo(){
		return $this->errInfo;
	}
	/**
	 * 设置错误信息
	 * @param string $info
	 */
	public function setErrorInfo($info){
		$this->errInfo=$info;
	}
	/**
	 * 设置请求参数
	 * @param mixed $key
	 * @param mixed $value
	 */
	public function setParam($key,$value){
		$this->params[$key]=$value;
	}
	/**
	 * 设置curl_opt参数
	 * @param mixed $key
	 * @param mixed $value
	 */
	public function setOption($key,$value){
		$this->options[$key]=$value;
	}
	/**
	 * 设置header
	 * @param mixed $value
	 */
	public function setHeader($value){
		$this->headers[]=$value;
	}
	/**
	 * 设置连接超时时间 （毫秒）
	 * @param number $ms
	 */
	public function setConnectionTimeOut($ms=15000){
		$this->options[CURLOPT_CONNECTTIMEOUT_MS]=$ms;
	}
	/**
	 * 禁用SSL
	 */
	public function disableSSL(){
		$this->setOption(CURLOPT_SSL_VERIFYPEER ,false);
		$this->setOption(CURLOPT_SSL_VERIFYHOST, 0);
	}
	/**
	 * 设置代理服务器
	 * @param string $addr
	 * @param number $port
	 */
	public function setProxy($addr,$port=80){
		$this->setOption(CURLOPT_PROXY, $addr);
		$this->setOption(CURLOPT_PROXYPORT, $port);
	}
	/**
	 * 获取发送后的返回结果
	 * @return mixed
	 */
	public function getHttpResult(){
		return $this->httpResult;
	}
	/**
	 * 返回响应的对象
	 * @return HttpResponse
	 */
	public function getResponse(){
		return $this->response;
	}
	/**
	 * 设置不带字段的POST数据
	 * @param mixed $data
	 */
	public function setRAWData($data){
		$this->rawData=$data;
	}
	/**
	 * 发送http请求
	 * @return bool 是否发送成功
	 */
	public function send(){
		//如果不存在curl_init函数
		if (!function_exists("curl_init")) {
			$this->setErrorInfo("请开启curl扩展库");
			return false;
		}
		//初始化请求
		$this->curl=curl_init($this->url);
		//设置请求方法
		if ($this->method==self::GET) {
			$this->setOption(CURLOPT_HTTPGET, true);
		}else{
			$this->setOption(CURLOPT_POST, true);
			//设置请求参数
			if ($this->rawData!="") {
				$this->setOption(CURLOPT_POSTFIELDS, $this->rawData);
			}else{
				$this->setOption(CURLOPT_POSTFIELDS, http_build_query($this->params));
			}
		}
		//设置header
		if (count($this->headers)>0) {
			$this->setOption(CURLOPT_HTTPHEADER, $this->headers);
		}
		//设置超时时间
		if (!array_key_exists(CURLOPT_CONNECTTIMEOUT_MS, $this->options)) {
			$this->setOption(CURLOPT_CONNECTTIMEOUT_MS, 15000);
		}
		//将curl_exec()获取的信息以文件流的形式返回，而不是直接输出
		$this->setOption(CURLOPT_RETURNTRANSFER, true);
		//设置header回调函数
		//$this->setOption(CURLOPT_HEADERFUNCTION, array("HttpRequest","headerCallBack"));
		//将所有配置参数全部赋值
		curl_setopt_array($this->curl, $this->options);
		//执行请求
		$result=curl_exec($this->curl);
		if ($result===false) {
			$this->setErrorInfo(curl_error($this->curl));
			return false;
		}else{
			$this->httpResult=$result;
			$this->response->requestUrl=$this->url;
			$this->response->body=$result;
			$this->response->curlInfo=curl_getinfo($this->curl);
		}
		//关闭并释放资源
		curl_close($this->curl);
		return true;
	}
	/**
	 * header回调函数
	 * @param resource $curlResource
	 * @param string $headerData
	 * @return number
	 */
	public function headerCallBack($curlResource,$headerData){
		return strlen($headerData);
	}
}