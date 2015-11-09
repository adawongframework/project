<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 视图类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_View extends Ada_Wong {

	//模版文件
	protected $file;
	
	//存在模版数据
	protected static $variable = array();

	//视图文件夹
	protected static $folder = 'views';

	//视图文件目录
	protected static $directory = array(APPPATH, ADAPATH);

	/**
	* 设置模版数据
	* @param $name String 变量名称
	* @param $vals Mixed 变量数据
	* @return self
	*/
	abstract public function assign($name, $vals);

	/**
	* 显示模版
	* @param Void
	* @return String
	*/
	abstract public function render();
}