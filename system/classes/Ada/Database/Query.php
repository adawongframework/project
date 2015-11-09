<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 数据库查询字符类
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Ada_Database_Query {
	
	/**
	* 生成一条插入语句
	* @param String $table 数据库表名
	* @param Array $params 插入数据,其中数组key作为字段名
	* @return String
	*/
	public static function insertString($table, $params) {
		$sql = "INSERT INTO `{$table}`";
		$fields = $values = '(';
		if (is_array($params)) {
			$count = count($params);
			$index = 1;
			foreach ($params as $field => $value) {
				$fields.= '`'.$field.'`';
				$values.= is_string($value) ? '\''.addslashes($value).'\'' : (int)$value;
				if ($index < $count) {
					$fields.=',';
					$values.=',';
				}
				$index++;
			}
		}
		return $sql.$fields.')VALUES'.$values.')';		
	}

	/**
	* 生成一条更新语句
	* @param String $table 数据库表名
	* @param Array $params 更新数据,其中数组key作为字段名
	* @param String $where 数据更新条件
	* @return String
	*/
	public static function updateString($table, $params, $where=NULL) {
		$sql = "UPDATE `{$table}` SET ";
		$set = '';
		if (is_array($params)) {
			$count = count($params);
			$index = 1;
			foreach ($params AS $field => $value) {
				$set.='`'.$field.'`='.(is_string($value) ? '\''.addslashes($value).'\'' : (int)$value);
				if ($index < $count) {
					$set.=',';
				}
				$index++;
			}
		}
		return $sql.$set.$where;
	}

	/**
	* 生成一条删除语句
	* @param String $table 数据库表名
	* @param String $where 删除条件
	* @return String
	*/
	public static function deleteString($table, $where=NULL) {
		return "DELETE FROM `$table`".$where;
	}

}