<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 框架视图类
*+-----------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/11
*/
abstract class Ada_View extends Ada_Wong {

	/**
	* 视图文件
	* @var String
	*/
	protected $file;
	
	/**
	* 视图数据
	* @var Array
	*/
	protected static $variable = array();

	/**
	* 视图文件存放相对目录
	* @var String
	*/
	protected static $folder = 'views';

	/**
	* 视图文件查找目录
	* @var String
	*/
	protected static $directory = array(APPPATH, ADAPATH);

	/**
	* 设置视图数据
	*+----------------------------
	* @param $name String 变量名称
	* @param $vals Mixed 变量数据
	* @return self
	*/
	abstract public function assign($name, $vals);

	/**
	* 渲染视图
	*+--------------
	* @param Void
	* @return String
	*/
	abstract public function render();
}