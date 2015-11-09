<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Http请求处理类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Request extends Ada_Request{

	/**
	* 获取一个request请求对象
	* @param String $uri 请求的uri
	* @return Request object
	*/
	public static function factory($uri=NULL) {
		return new Request($uri);
	}
}