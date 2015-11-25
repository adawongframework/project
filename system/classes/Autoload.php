<?php
/**
* 自动载入类文件
*+-------------------------------------------------------------
* 使用self::register()方法注册自动载入机制
* 类名称使用下划线"_"映射类文件相对于classes目录存放的位置
* 自动载入机制优先查找APPPATH/classes,其次是ADAPATH/classes目录
*+-------------------------------------------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/10
*/
abstract class Autoload extends Ada_Wong {
	
	/**
	* 定义类文件存放相对目录
	* @var String
	*/
	private static $folder = 'classes';
	
	/**
	* 定义类文件查找目录 目录名称越靠前,优先级越高
	* @var String
	*/
	private static $directory = array(APPPATH, ADAPATH);

	/**
	* 定义类名称匹配模式
	* @var String
	*/
	private static $pattern = array(
		'filename' => '#^[a-z][a-z0-9]*$#i', //类名称
		'filepath' => '#(?<filepath>(?:[a-z]+_)+)(?<filename>[a-z][a-z0-9]*)#i' //类目录
	);
	
	/**
	* 注册自动载入机制
	*+----------------
	* @param Void
	* @return Void
	*/
	public static function register() {
		if (function_exists('spl_autoload_register')) {
			spl_autoload_register(array('self', 'loadfile'));
		} else {
			throw new Exception('SPL Expansion Is Not Enabled');
		}
	}
	
	/**
	* 载入类文件
	*+----------
	* @param $class String 类名称
	* @return 如果成功返回TRUE,否则抛出异常
	*/
	private static function loadfile($class) {
		$found = FALSE;
		$file = self::checked($class);
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
			throw new	Ada_Exception('Class '.$class.' Is Not Found');
		}
	}
	
	/**
	* 检测类名是否合法
	*+----------------
	* @param $class String 类名称
	* @return Mixed;
	*/
	private static function checked($class) {
		$file = array('path'=>'', 'name'=>'');
		if (preg_match(self::$pattern['filename'], $class)) {
			$file['name'] = ucfirst($class);
		} else if (preg_match(self::$pattern['filepath'], $class, $matchs)) {
			$file['name'] = ucfirst($matchs['filename']);
			$path = explode('_', $matchs['filepath']);
			foreach ($path as $p) {
				$file['path'] = ucfirst($p).'_';
			}
		} else {
			return FALSE;
		}
		return $file;
	}
}

