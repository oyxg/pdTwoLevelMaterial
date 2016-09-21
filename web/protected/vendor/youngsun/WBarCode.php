<?php
/**
 * 功能：二维码
 * 作者：武仝
 * 日期：2014-4-9 下午3:44:18
 * 版权：Copyright 2007-2013 wutong All Right Reserved.
 * 网址：http://www.wutong.biz
 * 公司：扬晟科技（http://www.iyoungsun.com）
 */
class WBarCode{
	/**
	 * 分隔符
	 */
	const SPLITER="@";
	/**
	 * 保存目录
	 */
	const SAVE_PATH="upload/qrcode/";
	
	/**
	 * 二维码字符串
	 * @var unknown
	 */
	private $qrCode="";
	
	/**
	 * 错误信息
	 */
	public $error="";
	
	/**
	 * 物资
	 * @var Material
	 */
	public $material=null;
	
	/**
	 * 物资类
	 * @var Goods
	 */
	public $goods=null;
	
	/**
	 * 构造函数
	 * @param Material $material
	 */
	public function __construct($material){
		$this->material=$material;
		$this->goods=Goods::model()->findByPk($this->material->goodsID);
	}
	
	/**
	 * 设置二维码
	 */
	public function setQRCode(){
		$data['position']=$this->material->position;
		$data['goodsName']=$this->goods->goodsName;
		$data['endStr']="###";
		$qrCode=implode(self::SPLITER,$data);
		$this->qrCode=$qrCode;
	}
	
	/**
	 * 获取二维码
	 * @return string
	 */
	public function getQRCode(){
		return $this->qrCode;
	}
	
	/**
	 * 获取二维码图片路径
	 * @return string
	 */
	public function getQRCodeImage(){
		$file=self::SAVE_PATH . $this->material->materialID . ".png";
		return $file;
	}
	
	/**
	 * 生成二维码
	 * @return boolean
	 */
	public function create(){
		if(!$this->goods){
			$this->error="不存在此物资类别，无法查看";
			return false;
		}
		if($this->material->position == ""){
			$this->error="货架编码不存在，无法查看";
			return false;
		}
		if(!file_exists(self::SAVE_PATH)){
			$this->errMsg="保存目录不存在，无法创建二维码";
			return false;
		}
		//生成二维码字符串
		$this->setQRCode();
		//生成二维码图片
		require_once "protected/vendor/phpqrcode/qrlib.php";
		$file=self::SAVE_PATH . $this->material->materialID . ".png";
		try{
			QRcode::png($this->getQRCode(),$file,'M',6,2);
		}catch(Exception $e){
			$this->error=$e->getMessage();
			return false;
		}
		return true;
	}
	
	/**
	 * 移除二维码
	 */
	public function remove(){
		@unlink($this->getQRCodeImage());
	}
	
	/**
	 * 解析二维码
	 * @param string $qrCode
	 * @param string $self 是否只入自己的仓库
	 * @throws Exception
	 * @return WBarCode|null
	 */
	public static function parse($qrCode){
		if (trim($qrCode=="")) {
			throw new Exception("请扫描二维码");
		}
		$qrArr=explode(self::SPLITER,$qrCode);
		$store=UserStore::getStoreByUserID();
		if(!$store){
			throw new Exception("没有找到你所属的仓库");
		}
		$storeID=" AND storeID=" . $store->storeID;
		try{
			$material=Material::model()->find(" deleted=0 AND position='{$qrArr[0]}'" . $storeID);
		}catch(Exception $e){
			throw new Exception("解析二维码出错");
		}
		if(!$material){
			return null;
		}
		$barcode=new WBarCode($material);
		return $barcode;
	}
}