<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Pdo驱动扩展查询结果类
*+-----------------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/05
*/
class Ada_Database_Driver_Pdo_Result extends Ada_Database_Result {
	
	/**
	* 查询结果资源对象
	* var Resource
	*/
	private $object = NULL;

	/**
	* 构造方法
	*+------------
	* @param Resource $resource
	*/
	public function __construct(&$object) {
		if ($object InstanceOf PDOStatement) {
			$this->object = $object;
		}	
	}
	
	/**
	* 获取所有结果
	*+------------
	* @param Void
	* @return Array
	*/
	public function fetchAll() {
		$result = array();
		$this->object->setFetchMode(PDO::FETCH_ASSOC);
		while ($row = $this->object->fetch()) {
			$result[] = $row;
		}
		return $result;
	}
	
	/**
	* 获取一条结果
	*+-------------
	* @param Void
	* @return Array
	*/
	public function fetchRow() {
		$result = $this->fetchAll();
		if (isset($result[0])) {
			return $result[0];
		}
		return array();
	}
	
	/**
	* 获取字段结果
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
		unset($this->object);
	}
}
