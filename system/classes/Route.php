<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 路由处理类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Route extends Ada_Route {
	
	/**
	* 获取路由对象实例
	* @param Request $request
	* @return Object
	*/
	public static function factory(Request &$request) {
		return new Route($request);
	}
}