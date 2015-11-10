<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Uri处理类
*+----------------------
* @package	Core
* @category	Base
* @author	zjie 2014/03/11
*/
class Ada_Uri {
	
	/**
	* 获取主机名
	*+--------------
	* @param Void
	* @return String
	*/
	public static function host() {
		return 'http://'.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']);
	}

	/**
	* 获取PATHINFO
	*+------------
	* @param Void
	* @return String
	*/
	public static function path() {
		return trim(preg_replace(
			array(
				'`'.$_SERVER['SCRIPT_NAME'].'`',
				'`(?=[?]).+`',
				'`[\/]{1,}`'
			),
			array(
				'',
				'',
				'/'
			),
			isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']), '/');
	}

	/**
	* 生成一个基于主机名的url
	*+-----------------------
	* @param Mixed $segment
	* @param String $suffix
	* @return String
	*/
	public static function site($segment, $suffix=NULL) {
		return  self::host().'/'.preg_replace(
			'`[\/]{1,}`', 
			'/', 
			is_array($segment) ? $path = implode('/', $segment) : $segment
			).$suffix;
	}
}
//End of file system/classes/Ada/Uri.php