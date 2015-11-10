<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库驱动扩展接口类
*+-------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/05
*/
abstract class	Ada_Database_Driver {
	
	abstract public function select($sql);
	
	abstract public function insert($table, $params);

	abstract public function update($table, $params);

	abstract public function delete($sql);

	abstract public function lastId();
}