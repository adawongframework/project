<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* ·�ɴ�����
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Route extends Ada_Route {
	
	/**
	* ��ȡ·�ɶ���ʵ��
	* @param Request $request
	* @return Object
	*/
	public static function factory(Request &$request) {
		return new Route($request);
	}
}