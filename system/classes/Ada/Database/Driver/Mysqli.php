<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Mysqli扩展实现类
*+--------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/05
*/
class Ada_Database_Driver_Mysqli extends  Ada_Database_Driver {
	
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
	protected $resource;

	/**
	* 构造方法
	*+-------------------------------
	* @param Array $config 数据库配置
	*/
	public function __construct($config) {
		$this->config = $config;
	}
	
	/**
	* 执行一条查询语句
	*+-----------------------------------------
	* @param String $sql
	* @return Ada_Database_Driver_Mysqli_Result
	*/
	public function select($sql) {
		$this->query($sql);
		return new Ada_Database_Driver_Mysqli_Result($this->resource);
	}

	/**
	* 执行一条插入语句
	*+-------------------------------------------------
	* @param String $table 表名
	* @param Aarry $params 插入数据,数组key作为表字段名
	* @return Boolean
	*/
	public function insert($table, $params) {
		return $this->query(Ada_Database_Query::insertString($table, $params));
	}

	/**
	* 执行一条更新语句
	*+-------------------------------------------------
	* @param String $table 表名
	* @param Aarry $params 更新数据,数组key作为表字段名
	* @param String $wehre 条件
	* @return Boolean
	*/
	public function update($table, $params, $where='') {
		return $this->query(Ada_Database_Query::updateString($table, $params, $where));
	}
	
	
	/**
	* 执行一条删除语句
	*+-------------------------
	* @param String $table 表名
	* @param String $where 条件
	* @return Boolean
	*/
	public function delete($table, $where='') {
		return $this->query(Ada_Database_Query::deleteString($table, $where));
	}
	
	/**
	* 开启事物
	*+------------
	* @param Void
	* @return Void
	*/
	public function start() {
		$this->dblink();
		$this->choose();
		return mysqli_autocommit($this->identity, FALSE);
	}

	/**
	* 提交事物
	*+------------
	* @param Void
	* @return Void
	*/
	public function commit() {
		$this->dblink();
		$this->choose();
		return mysqli_commit($this->identity);
	}
	
	/**
	* 回滚事物
	*+------------
	* @param Void
	* @return Void
	*/
	public function rollback() {
		$this->dblink();
		$this->choose();
		return mysqli_rollback($this->identity);
	}
	
	/**
	* 获取数据库插入id
	*+----------------
	* @param Void
	* @return Void
	*/
	public function lastId() {
		return mysqli_insert_id($this->identity);
	}
	
	/**
	* 获取影响行数
	*+------------
	* @param Void
	* @return Void
	*/
	public function affect() {
		return mysqli_affected_rows($this->identity);
	}

	/**
	* 执行一条sql语句
	*+------------------
	* @param String $sql
	* @return Boolean
	*/
	private function query($sql) {
		$this->dblink();
		$this->choose();
		if (($this->resource = mysqli_query($this->identity, $sql)) == FALSE) {
			throw new Ada_Exception(mysqli_error($this->identity));
		}
		return TRUE;
	}

	/**
	* 连接数据库
	*+---------------
	* @param Void
	* @return Boolean
	*/
	private function dblink() {
		if (is_object($this->identity)) {
			return TRUE;
		}
		if(!($this->identity = @mysqli_connect($this->config['hostname'], $this->config['username'], $this->config['password']))) {
			throw new Ada_Exception(mysqli_connect_error(),mysqli_connect_errno());
		}
		return TRUE;
	}
	
	/**
	* 选择数据库
	*+---------------
	* @param Void
	* @return Boolean
	*/
	private function choose() {
		if(!(mysqli_select_db($this->identity, $this->config['database']))) {
			throw new Ada_Exception(mysqli_error($this->identity), mysqli_errno($this->identity));
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
			mysqli_close($this->identity);
		}
		if (is_resource($this->resource)) {
			mysqli_free_result($this->resource);
		}
		unset($this->config);
	}
}