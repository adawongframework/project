<?php
/**
* 缓存类
*/
class Cache extends Ada_Wong{

	/**
	* 缓存对象容器
	* @var Array
	*/
	private static $instance = array();

	/**
	* 获取一个缓存对象实例
	*/
	public static function factory($driver='file') {
		if (!isset(self::$instance[$driver])) {
			$class = 'Ada_Cache_'.$driver;
			self::$instance[$driver] = new $class;
		}
		return self::$instance[$driver];
	}
}