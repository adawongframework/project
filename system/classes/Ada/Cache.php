<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 缓存接口类
*+-------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/02/01
*/
abstract class Ada_Cache extends Ada_Wong {
	
	/**
	* 设置缓存数据
	*+----------------------------
	* @param String $key 缓存key
	* @param Mixed $val 缓存数据
	* @param Int $expires 有效时间
	* @return Boolean
	*/
	abstract public function set($key, $val, $expires=0);
	
	/**
	* 获取缓存数据
	*+--------------------------
	* @param String $key 缓存key
	* @return Mixed
	*/
	abstract public function get($key);
	
	/**
	* 删除指定key缓存数据
	* @param String $key 缓存key
	* @return Boolean
	*/
	abstract public function del($key);
}
// End file ./sytem/classes/Ada/Cache.php