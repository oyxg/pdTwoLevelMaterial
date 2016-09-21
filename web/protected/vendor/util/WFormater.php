<?php
/**
 * 功能：格式化相关功能
 * 作者：武仝
 * 日期：2013-10-12
 * 版权：Copytright © 2013 wutong (http://www.wutong.biz)
 * 网站：http://www.wutong.biz
 */

class WFormater {
	/**
	 * 返回表单的错误列表为HTML字符串
	 * @param array 错误列表
	 * @param bool 是否显示首条错误
	 * @return string
	 */
	public static function joinErrors(array $errors,$single=true){
		if ($single) {
			$keys=array_keys($errors);
			if (is_array($errors[$keys[0]])) {
				return $errors[$keys[0]][0];
			}
			return $errors[$keys[0]];
		}
		$i=0;
		$errorsStr="";
		foreach ($errors as $field=>$error){
			$spliter=$i==0 ? "" : "，";
			$errorsStr.=$spliter.implode(",", $error);
			$i++;
		}
		return $errorsStr;
	}
}
