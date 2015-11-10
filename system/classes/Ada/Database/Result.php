<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库查询结果接口类
*+----------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/05
*/
abstract class Ada_Database_Result {
	
	abstract public function fetchAll();

	abstract public function fetchRow();
	
	abstract public function fetchOne();
}