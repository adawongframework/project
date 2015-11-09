<?php
/**
* 配置处理类
*/
class Ada_Config {
	
	//配置文件存放目录
	private static $directory = 'config';
	
	//配置文件查找目录
	private static $folders = array(APPPATH, ADAPATH);

	//已载入配置文件
	private static $loaders = array();
	
	//已载入配置项目
	private static $configs = array();

	/**
	* 载入配置文件
	* @param String $file 配置文件名称
	* @param Boolean $return 是否返回配置项目信息
	* @return Mixed 如果载入配置文件返回TRUE,否则抛出异常
	*/
	public static function load($filename, $return=FALSE){
		//防止重复载入
		if (isset(self::$loaders[strtoupper($filename)])) {
			return TRUE;
		}
		$found = FALSE;
		//遍历配置文件存放目录,载入配置文件
		foreach (self::$folders as $folder) {
			$file = $folder.DIRECTORY_SEPARATOR.self::$directory.DIRECTORY_SEPARATOR.$filename.'.php';
			if (is_file($file) && is_readable($file)) {
				$found = TRUE;
				self::$configs[$filename] = include $file;
				self::$loaders[] = strtoupper($file);
			}
		}
		if (!$found) {
			throw new Ada_Exception();
		}
		return $return === TRUE ? self::$configs[$filename] : $found;
	}
	
	/*
	* 获取配置项目信息
	* @param String $path 路径
	* @return Mixed
	*/
	public static function xpath($path) {
	
	}
}