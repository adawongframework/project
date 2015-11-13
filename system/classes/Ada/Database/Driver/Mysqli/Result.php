<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Mysqli驱动扩展查询结果类
*+------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/05
*/
class Ada_Database_Driver_Mysqli_Result extends Ada_Database_Result {
	
	/**
	* 查询结果资源对象
	* @var Resource
	*/
	private $resource = NULL;
	
	/**
	* 构造函数
	*+-------------------------
	* @param Resource $resource
	*/
	public function __construct(&$resource) {
		$this->resource = $resource;
	}
	
	/**
	* 获取所有结果
	*+------------
	* @param Void
	* @return Void
	*/
	public function fetchAll() {
		$data = array();
		while ($row = mysqli_fetch_assoc($this->resource)) {
			$data[] = $row;
		}
		return $data;
	}
	
	/**
	* 获取一条结果
	*+------------
	* @param Void
	* @return Void
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
	*+------------
	* @param Void
	* @return Void
	*/
	public function fetchOne() {
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
			mysqli_free_result($this->resource);
		}
	}
}