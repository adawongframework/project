<?php if (!defined('ADAPATH')) die('Access Failed');
/**
* 框架基础类
*/
abstract class Ada_Wong {
	
	private static $debug = TRUE;
	/**
	* 定义php文件后缀
	*/
	protected static $ext = '.php';

	/**
	* 调用未定义或者私有成员方法触发异常
	* @param String $method 成员方法名称
	* @param Mixed $args 参数
	* @return Void
	*/
	public function __call($method, $args=NULL) {
		exit('Call to undefined method '.get_class($this).'::'.$method.'()');
	}

	/**
	* 设置debug模式
	*/
	public static function debug() {
		if(func_num_args() > 0) {
			self::$debug = func_get_arg(0);
		}
		return self::$debug;
	}

	/**
	* 设置未定义或者私有成员属性触发异常
	* @param String $key 成员属性名称
	* @param Mixed $var 成员属性数据
	* @return Void
	*/
	public function __set($key, $var) {
		exit('Cannot access private property '.get_class($this).'::'.$key);
	}

	/**
	* 获取未定义或者私有成员属性触发异常
	* @param String $key 成员属性名称
	* @return Void
	*/
	public function __get($key) {
		exit('Undefined property '.get_class($this).'::'.$key);
	}
	
	/**
	* 打印对象
	* @param Void
	* @return String
	*/
	public function __toString() {
		return serialize($this);
	}

	/**
	* 调用未定义或者私有静态方法触发异常
	* @param String $method 成员方法名称
	* @param Mixed $args 参数
	* @return Void
	*/
	public static function __callstatic($method, $args=NULL) {
		exit('Call to undefined static method '.$method.'()');
	}
}