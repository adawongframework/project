<?php
/**
* Pdo扩展驱动实现类
*+--------------------------
* @package	Core
* @category	Base
* @author	zjie 2014/01/05
*/
class Ada_Database_Driver_Pdo extends Ada_Database_Driver {
	
	/**
	* 数据库配置选项
	* @var Array
	*/
	private $config = array();
	
	/**
	* 数据库连接句柄
	* @var Resource
	*/
	private $identity;

	/**
	* 查询结果资源句柄
	* @var Resource
	*/
	private $resource;
	
	/**
	* 构造函数
	*+--------
	* @param Array $config 数据库配置项信息
	* @return Void
	*/
	public function __construct($config) {
		if (!extension_loaded('pdo') || !extension_loaded('pdo_mysql')) {
			throw new Ada_Exception('Pdo Or Pdo_mysql Expansion is not enabled');
		}
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
		return new Ada_Database_Driver_Pdo_Result($this->resource);
	}
	
	/**
	* 执行一条插入语句
	*+-------------------------------------------------
	* @param String $table 表名
	* @param Aarry $params 插入数据,数组key作为表字段名
	* @return Boolean
	*/
	public function insert($table, $params) {
	
	}
	
	/**
	* 执行一条更新语句
	*+-------------------------------------------------
	* @param String $table 表名
	* @param Aarry $params 更新数据,数组key作为表字段名
	* @param String $wehre 条件
	* @return Boolean
	*/
	public function update($table, $params) {
	
	}

	/**
	* 执行一条删除语句
	*+-------------------------
	* @param String $table 表名
	* @param String $where 条件
	* @return Boolean
	*/
	public function delete($table, $where=NULL) {
	
	}

	/**
	* 获取数据库插入id
	*+----------------
	* @param Void
	* @return Void
	*/
	public function lastId() {
	
	}
	
	/**
	* 返回影响的行数
	*+--------------
	* @param Void
	* @return Void
	*/
	public function affect() {
		
	}
	
	/**
	* 开启事物
	*+------------
	* @param Void
	* @return Void
	*/
	public function start() {
	
	}
	
	/**
	* 提交事物
	*+------------
	* @param Void
	* @return Void
	*/
	public function commit() {
	
	}

	/**
	* 回滚事物
	*+------------
	* @param Void
	* @return Void
	*/
	public function rollback() {
		
	}
	
	/**
	* 执行一条sql语句
	*+------------------
	* @param String $sql
	* @return Boolean
	*/
	private function query($sql) {
		$this->dblink();
		if(($this->resource = $this->identity->query($sql)) == FALSE) {
			$this->error();	
		}
		return TRUE;
	}
	
	/**
	* 抛出异常信息
	*+------------
	* @param Void
	* @return Void
	*/
	private function error() {
		if (is_object($this->identity)) {
			$error = $this->identity->errorinfo();
			if (isset($error[2])) {
				throw new Ada_Exception($error[2]);
			}
		}
	}
	
	/**
	* 连接数据库
	*+----------
	* @param Void
	* @return Boolean
	*/
	private function dblink() {
		if (!is_object($this->identity)) {
			try {
				@$this->identity = new Pdo('mysql:host='.$this->config['hostname'].';dbname='.$this->config['database'],$this->config['username'], $this->config['password']);
			} catch (PDOException $e) {
				throw new Ada_Exception($e->getMessage());
			}
		}
		return TRUE;
	}
}