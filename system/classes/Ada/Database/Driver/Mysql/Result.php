<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库结果类
*+-------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/05
*/
class Ada_Database_Driver_Mysql_Result extends Ada_Database_Result {
	
	/**
	* 查询结构对象
	* var Resource
	*/
	private $resource = NULL;
	
	/**
	* 构造方法
	*+------------
	* @param Resource $resource
	*/
	public function __construct(&$resource) {
		$this->resource = $resource;
	}
	
	/**
	* 获取所有结果
	*+------------
	* @param Void
	* @return Array
	*/
	public function fetchAll() {
		$result = NULL;
		if (is_resource($this->resource)) {
			while ($row = mysql_fetch_assoc($this->resource)) {
				$result[] = $row;
			}
		}
		return $result;
	}
	
	/**
	* 获取一行结果
	*+-------------
	* @param Void
	* @return Array
	*/
	public function fetchRow() {
		$result = $this->fetchAll();
		if (isset($result[0])) {
			return $result[0];
		}
		return NULL;
	}
	
	/**
	* 获取字段数据
	*+------------------------------------
	* @param Mixed $field 字段名称或者索引
	* @return Mixed
	*/
	public function fetchOne($field='') {
		$result = $this->fetchRow();
		if ($result) {
			if(!empty($field) && isset($result[$field])) {
				return $result[$field];
			} else {
				$fields = array_keys($result);
				return $result[$fields[0]];
			}
		}
		return NULL;
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
		if (is_resource($this->resource)) {
			mysql_free_result($this->resource);
		}
	}
}