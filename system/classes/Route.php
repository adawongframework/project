<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 路由处理类
*+-----------------------------------------
* 使用self::factory()方法获取路由类对象实例
*+-----------------------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/02/05
*/
class Route extends Ada_Route {
	
	/**
	* 获取路由对象实例
	*+----------------
	* @param Request $request 请求对象实例
	* @return Object
	*/
	public static function factory(Request &$request) {
		return new Route($request);
	}
}