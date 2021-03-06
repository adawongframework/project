<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Mysql扩展驱动实现类
*+--------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/05
*/
class Ada_Database_Driver_Mysql extends Ada_Database_Driver {

	/**
	* 数据库配置信息
	* @var Array
	*/
	private $config;
	
	/**
	* 链接句柄
	* @var Resource
	*/
	private $identity;
	
	/**
	* 查询结果句柄
	* @var Resource
	*/
	private $resource;

	/**
	* 设置debug模式
	* @var Boolean
	*/
	private $debug = FALSE;

	/**
	* 保存错误信息
	* @var String
	*/
	private $error = '';
	
	/**
	* 构造函数
	*+--------------------
	* @param Array $config
	*/
	public function __construct($config) {
		if (!extension_loaded('mysql')) {
			throw new Ada_Exception('Mysql Expansion is not enabled');
		}
		$this->config = $config;
		$this->debug = $config['debug'];
	}
 
	/**
	* 执行一条查询语句,返回一个查询结果对象
	*+-----------------------------------------------
	* @param String $sql 查询语句
	* @return Object Ada_Database_Driver_Mysql_Result
	*/
	public function select($sql){
		$this->query($sql);
		return new	Ada_Database_Driver_Mysql_Result($this->resource);
	}

	/**
	* 执行一条插入语句
	*+--------------------------------------------------
	* @param String $table 数据库表名
	* @param Array $params 插入数据,其中数组key作为字段名
	* @return Bool
	*/
	public function insert($table, $params){
		if ($this->query(Ada_Database_Query::InsertString($table, $params))) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	* 执行一条更新语句
	*+---------------------------------------------------
	* @param String $table 数据库表名
	* @param Array $params 更新数据,其中数组key作为字段名
	* @param String $where 更新条件
	* @return Bool
	*/
	public function update($table, $params, $where=NULL){
		return $this->query(Ada_Database_Query::updateString($table, $params, $where));
	}

	/**
	* 执行一条删除语句
	*+-------------------------------
	* @param String $table 数据库表名
	* @param String $where 删除条件
	* @return Bool
	*/
	public function delete($table, $where=NULL){
		return $this->query(Ada_Database_Query::deleteString($table, $where));
	}

	/**
	* 返回最后插入自增id
	*+------------------
	* @param Void
	* @return Int
	*/
	public function lastId() {
		return mysql_insert_id($this->identity);
	}

	/**
	* 返回影响的行数
	*+--------------
	* @param Void
	* @return Int
	*/				
	public function affect() {
		return mysql_affected_rows($this->identity);
	}

	/**
	* 开启事物
	*+-----------
	* @param Void
	* @return Bool
	*/
	public function start() {
		return $this->query("START transaction");
	}
	
	/**
	* 回滚事物
	*+-----------
	* @param Void
	* @return Bool
	*/
	public function rollback() {
		return $this->query("ROLLBACK");
	}

	/**
	* 提交事物
	*+------------
	* @param Void
	* @return Bool
	*/
	public function commit() {
		return $this->query("COMMIT");
	}

	/**
	* 获取错误信息
	*+---------------
	* @param Void
	* @return String
	*/
	public function error() {
		return $this->error;
	}
	
	/**
	* 连接数据库
	*+---------------
	* @param Void
	* @return Boolean
	*/
	private function dblink() {
		if (is_resource($this->identity)) {
			return TRUE;
		}
		if(!$this->identity = @mysql_connect($this->config['hostname'], $this->config['username'], $this->config['password'])) {
			$this->debug();
			return FALSE;
		}
		return TRUE;
	}

	/**
	* 选择数据库
	*+------------
	* @param Void
	* @return Void
	*/
	private function choose() {
		if(!mysql_select_db($this->config['database'])) {
			$this->debug();
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	* 执行sql语句
	*+------------------
	* @param String $sql
	* @return Boolean
	*/
	private function query($sql) {
		if($this->dblink() && $this->choose()) {
			mysql_query("SET NAMES {$this->config['charset']}", $this->identity); //set charset
			if($this->resource = mysql_query($sql, $this->identity)) {
				return TRUE;
			}
			$this->debug();
		}
		return FALSE;
	}
	
	/**
	* 设置或者捕获错误信息
	*+--------------------
	* @param Void
	* @return Boolean
	*/
	private function debug() {
		if ($this->debug) {
			throw new Ada_Exception(mysql_error(), mysql_errno());
		} else {
			$this->error = mysql_error();
		}
		return TRUE;
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
		if (is_resource($this->identity)) {
			mysql_close($this->identity);
		}
		if (is_resource($this->resource)) {
			mysql_result_free($this->resource);
		}
		unset($this->config);
	}
}