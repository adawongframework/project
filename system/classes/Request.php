<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Http请求处理类
*+--------------
* 使用self::factory()获取一个请求实例
*+--------------
* @package	Core
* @category	Base
* @author	zjie 2014/02/10
*/
class Request extends Ada_Request{

	/**
	* 获取一个request请求对象
	*+-----------------------
	* @param String $uri 请求的uri
	* @return Object
	*/
	public static function factory($uri=NULL) {
		return new Request($uri);
	}
}