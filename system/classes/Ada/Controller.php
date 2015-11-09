<?php
/**
* 控制器类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Controller extends Ada_Wong {
	
	protected $request;

	/**
	* 构造函数
	* @param Request $request
	*/
	public function __construct(Request $request) {
		$this->request = $request;
	}
	
	/**
	* 在action之前调用
	* @param Void
	*/
	public function	before() {

	}
	
	/**
	* 在action之后调用
	* @param Void
	*/
	public function	after(){
		
	}

	/**
	* 析构函数
	* @param Void
	* @return Void
	*/
	public function __destruct() {
		unset($this->request);
	}
}