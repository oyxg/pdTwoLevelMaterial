<?php

/**
 * 功能：上传文件
 * 作者：武仝
 * 日期：2013-08-13
 * 版权：Copytright © 2013 wutong (http://www.wutong.biz)
 * 网站：http://www.wutong.biz
 */
/**-----------------------------------------------------------------
 changelog:
 	2013-10-21 增加了 transSourceToArray 静态方法
 	2013-12-11 修正了 transSourceToArray 方法的返回类型错误
 			    增加了一个 $rawName 属性
-----------------------------------------------------------------*/

/**-----------------------------------------------------------------
 example:
 	//注意：设置保存文件名必须在调用init方法之后
 	 
 	//单个文件
 	
	$upload=new WUpload($_FILES['file']);
	$upload->init();
	$upload->setFileName(Upload::MD5_DATE);
	try {
		$upload->save();
	}catch (\Exception $e){
		echo $e->getMessage();
	}
	echo $upload->getFileName()."<br>";
	echo $upload->getFileSaveFullName()."<br>";
	
	//多文件
	
	$newFiles=WUpload::transSourceToArray($_FILES);
	$upload = new WUpload ();
	$upload->setAllowType("*");
	$upload->setMaxSize ( 1024 * 4 );
	$upload->setSavePath ( $dir );
	for ($i=0;$i<count($newFiles['files']);$i++){
		try {
			$upload->setSourceData($newFiles['files'][$i]);
			$upload->init();
			$upload->setFileName(WUpload::DATE_TIME);
			$upload->save ();
		} catch ( Exception $err ) {
			Message::ajaxInfo($err->getMessage(),0);
		}
	}
-----------------------------------------------------------------*/

//namespace biz\wutong\http;

class WUpload {
	/**
	 * 按照 2013-08-13 格式命名
	 * @var string
	 */
	const DATE="date";
	/**
	 * 按照 2013-08-13-06-07-08 格式命名
	 * @var string
	 */
	const DATE_TIME="date_time";
	/**
	 * 按照对日期md5加密格式命名
	 * @var string
	 */
	const MD5_DATE="md5_date";
	/**
	 * 按照对日期时间md5加密格式命名
	 * @var string
	 */
	const MD5_DATE_TIME="md5_date_time";
	
	const SOURCE_NAME="source_name";
	
	private static $infoList=array(
			"system_error"=>"系统发生错误",
			"save_path_exists" => "保存目录不存在",
			"file_size_big" => "上传的文件超过指定大小",
			"invalid_file_name" => "不是允许的文件",
			"save_fail"=>"保存文件出错",
			"not_file"=>"没有选择要上传的文件"
	);
	
	/**
	 * 文件域的name值
	 * @var string
	 */
	private $inputName="";
	/**
	 * 保存路径
	 * @var string
	 */
	private $savePath="./";
	/**
	 * 允许上传的文件类型列表
	 * @var array
	 */
	private $allowType=array(
		"jpg","gif","png","doc","xls","txt","pdf","zip","rar","docx"
	);
	/**
	 * 允许上传文件的大小（字节），默认10M
	 */
	private $maxSize=10485760 ;
	/**
	 * 上传的文件要保存的名称
	 * @var string
	 */
	private $fileName="";
	/**
	 * 提交过来的文件原始数据
	 * @var array
	 */
	private $sourceData;
	/**
	 * 不包含扩展名的文件名
	 * @var string
	 */
	private $fileShortName="";
	/**
	 * 扩展名
	 */
	private $fileExtName="";
	/**
	 * 文件保存全名称
	 * @var string
	 */
	private $fileSaveFullName="";
	/**
	 * 最原始文件名
	 * @var string
	 */
	public $rawName="";
	
	/**
	 * 构造方法
	 * @param array 文件域，就是包含【name、type、tmp_name、error、size】的一个数组
	 * @return void
	 */
	public function __construct(array $file=null){
		if ($file!=null) {
			$this->sourceData=$file;
		}
	}
	/**
	 * 设置文件域的数据
	 * @param array 文件域，就是包含【name、type、tmp_name、error、size】的一个数组
	 */
	public function setSourceData(array $file){
		$this->sourceData=$file;
	}
	/**
	 * 初始化相关数据
	 * @return void
	 */
	public function init(){
		$this->fileShortName=self::getFileShortName($this->sourceData['name']);
		$this->rawName=$this->sourceData['name'];
		$this->fileExtName=strtolower(self::getFileExtName($this->sourceData['name']));
	}
	/**
	 * 设置保存路径
	 * @param string $path
	 * @return void
	 */
	public function setSavePath($path){
		$this->savePath=$path;
	}
	/**
	 * 设置允许上传文件的扩展名
	 * @param string $extName
	 * @return void
	 */
	public function setAllowType($extName){
		if ($extName==null) {
			return;
		}
		$extNameLowercase=strtolower($extName);
		$this->allowType=explode(",", $extNameLowercase);
	}
	/**
	 * 设置上传文件的大小（兆）
	 * @param int $size
	 * @return void
	 */
	public function setMaxSize($size){
		$this->maxSize=$size*1024*1024;
	}
	/**
	 * 设置上传文件保存的名称
	 * @param string $fileName
	 * @return void
	 */
	public function setFileName($fileName){
		switch ($fileName) {
			case self::DATE :
				$_fileName = date ( "Y-m-d" );
				break;
			case self::DATE_TIME :
				$_fileName = date ( "Y-m-d-h-i-s-" ).rand(10000, 99999);
				break;
			case self::MD5_DATE :
				$_fileName = md5(date ( "Y-m-d" ));
				break;
			case self::MD5_DATE_TIME:
				$_fileName = md5(date ( "Y-m-d-h-i-s" ));
				break;
			case self::SOURCE_NAME:
				$_fileName = $this->fileShortName;
				break;
			default:
				$_fileName=$fileName;
		}
		$this->fileShortName=$_fileName;
	}
	/**
	 * 保存文件
	 * @throws \Exception
	 * @return void
	 */
	public function save(){
		//检测文件名
		if ($this->sourceData['name']=="") {
			throw new Exception(self::$infoList['not_file']);
		}
		//检测是否发生系统错误
		if ($this->sourceData['error']!=0) {
			throw new Exception(self::$infoList['system_error']);
		}
		//检测文件是否合法
		if ($this->allowType[0]!="*") {
			if(!in_array($this->fileExtName, $this->allowType)){
				throw new Exception(self::$infoList['invalid_file_name']);
			}
		}
		//检测目录是否存在
		clearstatcache();
		if (!is_dir($this->savePath)) {
			throw new Exception(self::$infoList['save_path_exists']);
		}
		//检测文件大小
		if($this->maxSize<$this->sourceData['size']){
			throw new Exception(self::$infoList['file_size_big']);
		}
		//设置保存路径
		$this->fileName=$this->fileShortName.".".$this->fileExtName;
		$this->fileSaveFullName=$this->savePath.$this->fileName;
		//保存文件
		$result=move_uploaded_file($this->sourceData['tmp_name'], $this->getFileSaveFullName("gbk"));
		if (!$result) {
			throw new Exception(self::$infoList['save_fail']);
		}
	}
	/**
	 * 返回文件保存全名称
	 * @return string
	 */
	public function getFileSaveFullName($charset="utf-8"){
		$fileName=$this->fileSaveFullName;
		if ($charset=="gbk") {
			$fileName=iconv("utf-8", "gbk", $this->fileSaveFullName);
		}
		return $fileName;
	}
	public function getFileName(){
		return $this->fileName;
	}
	/**
	 * 获取不含扩展名的文件名
	 * @param string $fileName
	 * @return string
	 */
	public static function getFileShortName($fileName=""){
		if ($fileName=="") {
			return $fileName;
		}else{
			if(strpos($fileName,".")!==false) {
				$fileNameArr=explode(".",$fileName);
				return $fileNameArr[count($fileNameArr)-2];
			}else{
				return $fileName;
			}
		}
	}
	/**
	 * 获取文件的扩展名
	 * @param string $fileName
	 * @return string
	 */
	public static function getFileExtName($fileName){
		$fileNameArr=explode(".",$fileName);
		return $fileNameArr[count($fileNameArr)-1];
	}
	/**
	 * 转换客户端采用同名文件域传过来的不友好的数据格式
	 * @param array 文件域的数据如【$_FILES['images']】
	 * @return array 转换过后的数组
	 */
	public static function transSourceToArray(array $files){
		//索引
		$filesKeys=array_keys($files);
		//循环更改
		for ($i=0;$i<count($filesKeys);$i++){
			$count=count($files[$filesKeys[$i]]['name']);
			if (is_array($files[$filesKeys[$i]]['name'])) {
				for($j=0;$j<count($files[$filesKeys[$i]]['name']);$j++){
					$files[$filesKeys[$i]][$j]['name']=$files[$filesKeys[$i]]['name'][$j];
					$files[$filesKeys[$i]][$j]['type']=$files[$filesKeys[$i]]['type'][$j];
					$files[$filesKeys[$i]][$j]['tmp_name']=$files[$filesKeys[$i]]['tmp_name'][$j];
					$files[$filesKeys[$i]][$j]['error']=$files[$filesKeys[$i]]['error'][$j];
					$files[$filesKeys[$i]][$j]['size']=$files[$filesKeys[$i]]['size'][$j];
				}
				unset($files[$filesKeys[$i]]['name']);
				unset($files[$filesKeys[$i]]['type']);
				unset($files[$filesKeys[$i]]['tmp_name']);
				unset($files[$filesKeys[$i]]['error']);
				unset($files[$filesKeys[$i]]['size']);
			}
		}
		return $files;
	}
	/**
	 * 返回大小（字節）
	 * @return int 字節:
	 */
	public function getSize(){
		return $this->sourceData['size'];
	}
	/**
	 * 返回擴展名
	 * @return string
	 */
	public function getExtName(){
		return $this->fileExtName;
	}
	/**
	 * 返回短文件名
	 * @return string
	 */
	public function getShortName(){
		return $this->fileShortName;
	}
}
