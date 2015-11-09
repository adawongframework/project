<?php
/**
* 自动载入类文件
* Autolaod::register()注册自动加载类文件
* 类名称使用下划线"_"分割来映射类文件所在目录
* 系统及应用类文件都在放在由self::$folder指定的目录中
* 类文件载入目录由self::$directory指定的目录中
*/
class Autoload extends Ada_Wong {
	
	//定义类文件所在目录
	private static $folder = 'classes';
	
	//定义查找类文件目录
	private static $directory = array(APPPATH, ADAPATH);

	//定义类名称模式
	private static $pattern = array(
		'filename' => '#^[a-z][a-z0-9]*$#i', //类名称与类文件路径相同
		'filepath' => '#(?<filepath>(?:[a-z]+_)+)(?<filename>[a-z][a-z0-9]*)#i' //类名称映射类文件路径
	);
	
	/**
	* 注册自动载入机制
	* @param Void
	* @return Void
	*/
	public static function register() {
		spl_autoload_register(array('self', '_L'));
	}
	
	/**
	* 载入类文件 类名称映射类文件所在目录
	* @param $class String 类名称
	* @return 如果成功返回TRUE,否则抛出异常
	*/
	private static function _L($class) {
		$found = FALSE;
		$file = self::_V($class);
		if ($file) {
			$path = str_replace('_', DIRECTORY_SEPARATOR, $file['path']);
			$file = self::$folder.DIRECTORY_SEPARATOR.$path.$file['name'].self::$ext;
			foreach (self::$directory as $folder) {
				if (is_file($folder.DIRECTORY_SEPARATOR.$file) && is_readable($folder.DIRECTORY_SEPARATOR.$file)) {
					include $folder.DIRECTORY_SEPARATOR.$file;
					return TRUE;
				}
			}
		}
		if ($found === FALSE) {
			throw new	Ada_Exception('Class '.$class.' not found');
		}
	}
	
	/**
	* 验证类名称是否合法
	* @param $class String 类名称
	* @return Boolean;
	*/
	private static function _V($class) {
		$file = array('path'=>'', 'name'=>'');
		if (preg_match(self::$pattern['filename'], $class)) {
			$file['name'] = $class;
		} else if (preg_match(self::$pattern['filepath'], $class, $matchs)) {
			$file['name'] = $matchs['filename'];
			$file['path'] = $matchs['filepath'];
		} else {
			return FALSE;
		}
		return $file;
	}
}

