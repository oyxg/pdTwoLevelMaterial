<?php
/**
 * 功能：缓存处理
 * 作者：武仝
 * 日期：2014-4-12 下午3:28:55
 * 版权：Copyright 2007-2014 扬晟科技 All Right Reserved
 * 网址：http://www.iyoungsun.com
 */
class WCache{
	
	/**
	 * 清空全部缓存
	 * @return boolean
	 */
	public static function clearAll(){
		if (Yii::app()->cache->flush()) {
			return true;
		}else{
			return false;
		}
	}
}
