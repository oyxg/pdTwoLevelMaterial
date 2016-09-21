<?php
/**
 * 功能：信息提示
 * 作者：武仝
 * 日期：2014-2-17 下午7:58:45
 * 版权：Copyright 2007-2013 wutong All Right Reserved
 * 网址：http://www.wutong.biz
 */
/**
 * --------------------------------
 * 更新
 * 2014-03-12 增加ajaxInfo方法的header
 *
 */
class WMessage {
	/**
	 * 输出ajax消息
	 * @param string 消息内容
	 * @param number 状态
	 * @param array 数据
	 */
	public static function ajaxInfo($info="操作成功",$status=1,array $data=array()){
		header("content-type:application/json");
		echo json_encode(array(
			"info"=>$info,
			"status"=>$status,
			"data"=>$data
		));
		exit();
	}
	/**
	 * 输出js警告框
	 * @param string 提示文本
	 */
	public static function jsAlert($text){
		echo '<script>alert("'.$text.'")</script>';
	}
	/**
	 * 输出js内容
	 * @param string js内容
	 */
	public static function js($content){
		echo '<script>'.$content.'</script>';
	}
	/**
	 * 输出警告内容
	 * @param string $content
	 * @param bool $isExit
	 */
	public static function htmlWarn($content,$isExit=true){
           header("Content-type:text/html;charset=utf-8");
		if(Yii::app()->request->isAjaxRequest){
			self::ajaxInfo($content,0);
		}else{
			throw new CHttpException(403,$content);
			//Yii::app()->request->redirect(Yii::app()->createUrl("error/nopermission"));
			//self::htmlWarn("没有权限执行此操作");
		}
		if ($isExit) {
			exit();
		}
	}
	/**
	 * 检查权限
	 * @param string $item
	 */
	public static function checkAccess($item){
		if (!Auth::has($item)) {
			$itemRs=Auth::getAuthManager()->getAuthItem($item);
			if ($itemRs) {
				$msg=$itemRs->getDescription();
			}else{
				$msg="";
			}
			self::htmlWarn("你没有".$msg."权限");
		}
	}
}