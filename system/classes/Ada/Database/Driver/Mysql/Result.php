<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库结果类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Ada_Database_Driver_Mysql_Result extends Ada_Database_Result {
	
	private $resource = NULL;

	public function __construct(&$resource) {
		$this->resource = $resource;
	}

	public function fetchAll() {
		$result = NULL;
		if (is_resource($this->resource)) {
			while ($row = mysql_fetch_assoc($this->resource)) {
				$result[] = $row;
			}
		}
		return $result;
	}

	public function fetchRow() {
		$result = $this->fetchAll();
		if (isset($result[0])) {
			return $result[0];
		}
		return NULL;
	}

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

	public function __destruct() {
		if (is_resource($this->resource)) {
			mysql_free_result($this->resource);
		}
	}
}