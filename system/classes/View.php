<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 视图类
*+---------------
* @package	Core
* @category	Base
* @author	zjie 2014/02/19
*/
class View extends Ada_View {
	
	/**
	* 构造方法
	*+------------------------------------
	* @param String $file 视图模板文件名称
	* @return Void
	*/
	public function __construct($file) {
		foreach (self::$directory as $folder) {
			$file= $folder.DIRECTORY_SEPARATOR.self::$folder.DIRECTORY_SEPARATOR.$file;
			if (is_file($file)) {
				$this->file = $file;
				break;
			}
		}
		if (!is_file($file)) {
			throw new Ada_Exception('File '.$file.' Is Not Found');
		}
	}
	
	/**
	* 模板赋值
	*+------------------
	* @param Mixed $name
	* @param Mixed $vals
	* @return Self
	*/
	public function assign($name, $vals=NULL) {
		if (is_array($name)) {
			self::$variable = array_merge(self::$variable, $name);
		} else {
			self::$variable[$name] = $vals;
		}
		return $this;
	}
	
	/**
	* 渲染视图
	*+------------
	* @param Void
	* @return Void
	*/
	public function render() {
		extract(self::$variable);
		include $this->file;	
	}
}