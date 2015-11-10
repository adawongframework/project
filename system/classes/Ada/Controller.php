<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 基础控制器类
* @package	Core
* @category	Base
* @author	zjie 2014/02/01
*/
abstract class Ada_Controller extends Ada_Wong {
	
	/**
	* 请求对象实例
	* @var Object
	*/
	protected $request;

	/**
	* 构造函数
	*+-----------------------
	* @param Request $request
	*/
	public function __construct(Request $request) {
		$this->request = $request;
	}
	
	/**
	* 在action之前调用
	*+----------------
	* @param Void
	*/
	public function	before() {

	}
	
	/**
	* 在action之后调用
	*+----------------
	* @param Void
	*/
	public function	after(){
		
	}

	/**
	* 析构函数
	*+--------
	* 释放资源
	*+--------
	* @param Void
	* @return Void
	*/
	public function __destruct() {
		unset($this->request);
	}
}