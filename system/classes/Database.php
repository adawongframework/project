<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库抽象层
*+-------------------------------------------
* 使用self::factory()方法获取数据库驱动对象
*+-------------------------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/14
*/
class Database extends Ada_Wong{
	
	/**
	* 保存已经现实的数据库扩展类
	* @var Array
	*/
	private static $drivers = array('Mysql', 'Mysqli', 'Pdo');

	/**
	* 保存数据库扩展对象实例
	* @var Array
	*/
	private static $instances = array();

	/**
	* 获取一个驱动对象实例
	*+-----------------------------------
	* @param String $name 数据配置组名
	* @param Array $config 数据库配置选项
	* @return Object
	*/
	public static function factory($name='default', $config=NULL) {
		$key = strtolower($name);
		if (!isset(self::$instances[$key]) || !(self::$instances[$key] instanceOf Ada_Database_Driver)) {
			if (!$config) {
				$configs = Config::load('Database', TRUE);
				if (isset($configs[$name])) {
					$config = $configs[$name];
				}
			}
			if (isset($config['driver'])) {
				$driver = ucfirst(strtolower($config['driver']));
				if (in_array($driver, self::$drivers)) {
					$driver = 'Ada_Database_Driver_'.$driver;
					return self::$instances[$key] = new $driver($config);
				}
			}
			throw new Ada_Exception('Database driver not found');
		}
		return self::$instances[$key];
	}
}
