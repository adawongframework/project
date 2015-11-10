<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Http响应处理实现类
* @package	Core
* @category	Base
* @author	zjie 2014/03/03
*/
abstract class Ada_Response extends Ada_Wong {

	/**
	* 响应内容
	* @var String
	*/
	private $body = '';

	/**
	* 响应状态码
	* @var Int
	*/
	private $code = 404;
	
	/**
	* 获取和设置响应内容
	*+----------------------
	* @param String 响应内容
	* @return String
	*/
	public function body() {
		if(func_num_args() > 0) {
			$this->body = func_get_arg(0);
		}
		return $this->body;
	}
	
	/**
	* 获取设置响应状态码
	*+------------------
	* @param Void
	* @return Int
	*/
	public function status() {
		if(func_num_args() > 0) {
			$this->code = func_get_arg(0);
		}
		return $this->code;
	}
	
	/**
	* 返回响应信息
	*+--------------
	* @param Void
	* @retrun String
	*/
	public function __toString() {
		return $this->body;
	}
	
	/**
	* 析构函数
	*+------------
	* 释放变量
	*+------------
	* @param Void
	* @return Void
	*/
	public function __destruct() {
		$this->body = '';
	}
}