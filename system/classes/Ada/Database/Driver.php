<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库接口类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
abstract class	Ada_Database_Driver {
	
	abstract public function select($sql);
	
	abstract public function insert($table, $params);

	abstract public function update($table, $params);

	abstract public function delete($sql);

	abstract public function lastId();
}