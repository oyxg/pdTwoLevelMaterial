<?php 
header("content-type:text/html; charset=utf-8");
function clean_xss(&$string, $low = true)
{
	if (! is_array ( $string ))
	{
		$string = trim ( $string );
		$string = strip_tags ( $string );
		//$string = htmlspecialchars ( $string );
		if ($low)
		{
			return True;
		}
		$string = str_replace ( array ('"', "\\", "'", "/", "..", "../", "./", "//" ), '', $string );
		$no = '/%0[0-8bcef]/';
		$string = preg_replace ( $no, '', $string );
		$no = '/%1[0-9a-f]/';
		$string = preg_replace ( $no, '', $string );
		$no = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';
		$string = preg_replace ( $no, '', $string );
		return True;
	}
	$keys = array_keys ( $string );
	foreach ( $keys as $key )
	{
		clean_xss ( $string [$key] );
	}
}

function _sqlfilter()
{
	$pattern = '/‘|’|“|”|\/\*|sleep|select|insert|and|update|delete|SELECT|INSERT|AND|CONST|ROW|COUNT|const|row|count|UPDATE|DELETE|or|OR/i';//
	$pattern2 = '/<|>|script/i';
//	var_dump($_REQUEST);
	foreach($_REQUEST as $key => $para){
			if(is_array($para) || is_object($para) || 0 < preg_match($pattern,$para)){
					 echo '<script language="JavaScript">alert("系统警告1：\n\n请不要尝试在参数中包含非法字符尝试注入！");
					 history.go(-1);
					 </script>' . var_dump($para);
					exit;
			}

			if(is_array($para) || is_object($para) || 0 < preg_match($pattern2,$para)){
					 echo '<script language="JavaScript">alert("系统警告2：\n\n请不要尝试在参数中包含非法字符尝试注入！");
					 history.go(-1);
					 </script>';
					exit;
			}
			//$_REQUEST[$key] = mysql_real_escape_string($para);
	}
	//($_SERVER['REQUEST_METHOD'] == 'GET')?$_GET = $_REQUEST:$_POST = $_REQUEST;
	return true;
}
	//_sqlfilter();

?>