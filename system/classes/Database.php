<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库类
*+----------
* 使用self::factory()方法获取数据库驱动类对象
*+----------
* @package	Core
* @category	Base
* @author	zjie 2014/01/14
*/
class Database extends Ada_Wong{
	
	/**
	* 单例对象
	* @var Object
	*/
	private static $instance = NULL;

	/**
	* 获取一个数据驱动对象实例
	*+------------------------
	* @param String $name 驱动名称
	* @param Array $config 配置项
	* @return Object
	*/
	public static function factory($name='default', $config=Array()) {
		if (self::$instance === NULL){
			if ($config === NULL) {
				$db = new Database();
				$config = Config::load('Database', true);
			}
			if (isset($config[$name], $config[$name]['driver'])) {
				$driver = 'Ada_Database_Driver_'.$config[$name]['driver'];
				self::$instance = new $driver($config[$name]);
			} else {
				throw new Ada_Exception('No database configuration file specified');
			}
		}
		return self::$instance;
	}
}
