<?php
/**
* 缓存工厂类
*+-----------------------------------------------
* 使用self::factory()方法获取指定缓存驱动对象实例
* file:文件驱动 默认
*+-----------------------------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/11
*/
abstract class Cache extends Ada_Wong{

	/**
	* 定义缓存对象存放容器
	* @var Array
	*/
	private static $instances = array();

	/**
	* 获取一个缓存对象实例
	*+--------------------
	* @param String $driver 缓存驱动名称
	* @return Object
	*/
	public static function factory($driver='file') {
		$driver = strtolower($driver);
		if (!isset(self::$instances[$driver])) {
			$class = 'Ada_Cache_'.$driver;
			self::$instances[$driver] = new $class;
		}
		return self::$instances[$driver];
	}
}