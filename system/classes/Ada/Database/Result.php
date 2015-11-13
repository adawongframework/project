<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库查询结果接口类
*+--------------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/05
*/
abstract class Ada_Database_Result {
	
	/**
	* 获取所有结果
	*+------------
	* @param Void
	* @return Array
	*/
	abstract public function fetchAll();
	
	/**
	* 获取一条记录
	*+---------------
	* @param Void
	* @return Array
	*/
	abstract public function fetchRow();
	
	/**
	* 获取字段结果
	* @param Void
	* @return Array
	*/
	abstract public function fetchOne();
}