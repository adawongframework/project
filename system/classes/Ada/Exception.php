<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 异常处理类
*+--------------
* @package	Core
* @category	Base
* @author	zjie 2014/02/10
*/
class	Ada_Exception extends	Exception{
	
	public function __construct($message, $code=NULL) {
		parent::__construct($message, $code);
	}
}