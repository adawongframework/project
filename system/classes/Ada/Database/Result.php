<?php
/**
* Mysql查询结果类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class Ada_Database_Result {
	
	abstract public function fetchAll();

	abstract public function fetchRow();
	
	abstract public function fetchOne();
}