<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库驱动扩展接口类
*+-------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/05
*/
abstract class	Ada_Database_Driver {
	
	/**
	* 执行一条查询语句
	*+------------------
	* @param String $sql
	* @return Object
	*/
	abstract public function select($sql);
	
	/**
	* 执行一条插入语句
	*+-----------------------------
	* @param String $table 表名
	* @param Array $params 字段与值
	* @return Boolean
	*/
	abstract public function insert($table, $params);
	
	/**
	* 执行一条更新语句
	*+-----------------------------
	* @param String $table 表名
	* @param Array $params 字段与值
	* @return Boolean
	*/
	abstract public function update($table, $params);
	
	/**
	* 执行一条删除语句
	*+-------------------------
	* @param String $table 表名
	* @param String $where 条件
	* @return Boolean
	*/
	abstract public function delete($table, $where=NULL);
	
	/**
	* 获取数据库插入最后id
	*+--------------------
	* @param Void
	* @return Void
	*/
	abstract public function lastId();
	
	/**
	* 获取数据库影响行数
	*+------------------
	* @param Void
	* @return Void
	*/
	abstract public function affect();
	
	/**
	* 开启事物
	*+------------
	* @param Void
	* @return Void
	*/
	abstract public function start();
	
	/**
	* 提交事物
	*+------------
	* @param Void
	* @return Void
	*/
	abstract public function commit();
	
	/**
	* 回滚事物
	*+------------
	* @param Void
	* @return Void
	*/
	abstract public function rollback();
}