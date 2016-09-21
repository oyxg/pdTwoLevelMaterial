<?php

/**
 * 功能：日期常用操作
 * 作者：武仝
 * 日期：2013-09-02
 * 版权：Copytright © 2013 wutong (http://www.wutong.biz)
 * 网站：http://www.wutong.biz
 */
/**-----------------------------------------------------------------
 changelog:
	2013-12-17 增加了 getMonthCount 静态方法
	2013-12-17 增加了 getYearAndMonth 静态方法
	2013-12-17 增加了 getDatesStartAndEnd 静态方法
	2014-02-17 增加了getPreMonthDate方法注释
-----------------------------------------------------------------*/
class WDate{
	/**
	 * 星期一
	 */
	const Monday=1;
	/**
	 * 星期二
	 */
	const Tuesday=2;
	/**
	 * 星期三
	 */
	const Wednesday=3;
	/**
	 * 星期四
	 */
	const Thursday=4;
	/**
	 * 星期五
	 */
	const Friday=5;
	/**
	 * 星期六
	 */
	const Saturday=6;
	/**
	 * 星期日
	 */
	const Sunday=7;
	
	/**
	 * 获得这个星期的日期时间戳列表
	 */
	public static function getCurrWeekDateList(){
		return self::getWeekDateList();
	}
	/**
	 * 获得下个星期的日期时间戳列表
	 */
	public static function getNextWeekDateList(){
		return self::getWeekDateList(1);
	}
	/**
	 * 获得星期的日期时间戳列表
	 * 
	 * @param int 当前的第几个星期
	 *        	
	 */
	public static function getWeekDateList($limit=0){
		$dateList=array();
		$dateList['monday']=self::getTimeByWeekday(self::Monday,$limit);
		$dateList['tuesday']=self::getTimeByWeekday(self::Tuesday,$limit);
		$dateList['wednesday']=self::getTimeByWeekday(self::Wednesday,$limit);
		$dateList['thursday']=self::getTimeByWeekday(self::Thursday,$limit);
		$dateList['friday']=self::getTimeByWeekday(self::Friday,$limit);
		$dateList['saturday']=self::getTimeByWeekday(self::Saturday,$limit);
		$dateList['sunday']=self::getTimeByWeekday(self::Sunday,$limit);
		return $dateList;
	}
	
	/**
	 * 获得时间戳列表的指定格式化日期
	 * @param array 时间戳数组
	 * @param string 格式
	 */
	public static function getDateByTimeList(array $dateList,$format="Y-m-d"){
		$dIndex=array_keys($dateList);
		for($i=0; $i<count($dateList); $i++){
			$dateList[$dIndex[$i]]=date($format,$dateList[$dIndex[$i]]);
		}
		return $dateList;
	}
	
	/**
	 * 判断一个指定的日期是否在这个星期里面
	 * @param string 标准日期
	 */
	public static function isExistsInCurrWeek($date){
		$currWeek=self::getDateByTimeList(self::getCurrWeekDateList());
		if(in_array($date,$currWeek)){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 指定一个这个星期几，获得这个星期几的时间戳
	 * @param int 要提供的星期几
	 * @param int 增加/减少 几个星期
	 * @return int 时间戳
	 */
	public static function getTimeByWeekday($weekday,$limit=0){
		// 当前这个星期的第几天
		$currWeekday=date("w")==0 ? 7 : date("w");
		// 提供的星期几减去当前的星期几
		$end=$weekday-$currWeekday;
		// 算出时间戳
		$endTime=strtotime(date("Y-m-d"))+$end*24*60*60+$limit*7*24*60*60;
		return $endTime;
	}
	/**
	 * 指定一个日期，返回星期几
	 * @param date 日期，如：2013-06-12
	 * @return string
	 */
	public static function getWeekDay($date){
		$num=date("N",strtotime($date));
		$day="未知";
		switch($num){
			case self::Monday :
				$day="星期一";
				break;
			case self::Tuesday :
				$day="星期二";
				break;
			case self::Wednesday :
				$day="星期三";
				break;
			case self::Thursday :
				$day="星期四";
				break;
			case self::Friday :
				$day="星期五";
				break;
			case self::Saturday :
				$day="星期六";
				break;
			case self::Sunday :
				$day="星期日";
				break;
		}
		return $day;
	}
	/**
	 * 返回2个日期之间的月数，包含起始日期和结束日期
	 * @param string $dateStart
	 * @param string $dateEnd
	 */
	public static function getMonthCount($dateStart,$dateEnd){
		$dateStart=strtotime($dateStart);
		$dateEnd=strtotime($dateEnd);
		$yearStart=date("Y",$dateStart);
		$yearEnd=date("Y",$dateEnd);
		$monthStart=date("n",$dateStart);
		$monthEnd=date("n",$dateEnd);
		$yearCount=$yearEnd-$yearStart;
		$monthCount=$monthEnd-$monthStart;
		$op=1;
		$overCount=$yearCount*12+$monthCount+$op;
		return $overCount;
	}
	/**
	 * 根据日期返回年月
	 * @param string $date
	 * @return array
	 */
	public static function getYearAndMonth($date){
		$date=strtotime($date);
		$year=date("Y",$date);
		$month=date("n",$date);
		return array(
			"year"=>$year,
			"month"=>$month
		);
	}
	/**
	 * 根据两个日期返回每个月的初始日期和结束日期
	 * @param string $dateStart
	 * @param string $dateEnd
	 * @return array
	 */
	public static function getDatesStartAndEnd($dateStart,$dateEnd){
		$monthCount=self::getMonthCount($dateStart, $dateEnd);
		$date=self::getYearAndMonth($dateStart);
		$dateArr=array();
		for($i=0;$i<$monthCount;$i++){
			$range=$i==0 ? 0 : 1;
			$date['month']+=$range;
			if ($date['month']>12) {
				$date['month']=1;
				$date['year']+=1;
			}
			$year=$date['year'];
			$month=$date['month']<10 ? "0".$date['month'] : "".$date['month'];
			$dateEnd=date("t",strtotime($date['year'].$month."01"));
			$dateArr[$i]=array(
				"year"=>$year,
				"month"=>$month,
				"day_start"=>"01",
				"day_end"=>$dateEnd,
				"date_start"=>$year."-".$month."-01",
				"date_end"=>$year."-".$month."-".$dateEnd
			);
		}
		return $dateArr;
	}
	/**
	 * 获得本月的开始日期和结束日期
	 * @return array
	 */
	public static function getCurrMonthDate(){
		$date=date("Y-m-");
		$start=$date."01";
		$end=$date.date("t");
		$array=array(
			"start"=>$start,
			"end"=>$end
		);
		return $array;
	}
	/**
	 * 获得上个月的开始和结束日期
	 * @return array
	 */
	public static function getPreMonthDate(){
		$time=time()-30*24*60*60;
		$date=date("Y-m-",$time);
		$start=$date."01";
		$end=$date.date("t",$time);
		$array=array(
			"start"=>$start,
			"end"=>$end
		);
		return $array;
	}
}



