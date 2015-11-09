<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* ���ݿ��ѯ�ַ���
* @package	AdaWong
* @category	Base
* @author	cyhy
*/
class Ada_Database_Query {
	
	/**
	* ����һ���������
	* @param String $table ���ݿ����
	* @param Array $params ��������,��������key��Ϊ�ֶ���
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
	* ����һ���������
	* @param String $table ���ݿ����
	* @param Array $params ��������,��������key��Ϊ�ֶ���
	* @param String $where ���ݸ�������
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
	* ����һ��ɾ�����
	* @param String $table ���ݿ����
	* @param String $where ɾ������
	* @return String
	*/
	public static function deleteString($table, $where=NULL) {
		return "DELETE FROM `$table`".$where;
	}

}