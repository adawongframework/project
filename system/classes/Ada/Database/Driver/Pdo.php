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
	* 查询资源句柄
	* @var Resource
	*/
	private $resource;

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
	}
	
	/**
	* 连接数据库
	*+----------
	* @param Void
	* @return Void
	*/
	private function dblink() {
		echo time();
	}
}