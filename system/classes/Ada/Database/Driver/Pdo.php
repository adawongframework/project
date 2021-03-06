<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* Pdo扩展驱动实现类
*+-----------------------
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
	* 保存影响的行数
	* @var Int
	*/
	private $affect = 0;

	/**
	* 是否开启debug模式
	* @var Boolean
	*/
	private $debug = FALSE;

	/**
	* 保存上次错误信息
	* @var String
	*/
	private $error = '';
	
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
		$this->debug = $config['debug'];
	}
	
	/**
	* 执行一条查询语句
	*+-----------------------------------------
	* @param String $sql
	* @return Ada_Database_Driver_Pdo_Result
	*/
	public function select($sql) {
		$this->dblink();
		if(($this->resource = $this->identity->query($sql)) == FALSE) {
			$this->debug();
			return FALSE;
		}
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
		$this->dblink();
		if (($this->affect = $this->identity->exec(Ada_Database_Query::insertString($table, $params))) === FALSE) {
			$this->debug();
			return	FALSE;
		}
		return TRUE;
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
		$this->dblink();
		if (($this->affect = $this->identity->exec(Ada_Database_Query::updateString($table, $params))) === FALSE) {
			$this->debug();
			return	FALSE;
		}
		return TRUE;
	}

	/**
	* 执行一条删除语句
	*+-------------------------
	* @param String $table 表名
	* @param String $where 条件
	* @return Boolean
	*/
	public function delete($table, $where=NULL) {
		$this->dblink();
		if (($this->affect = $this->identity->exec(Ada_Database_Query::deleteString($table, $where))) === FALSE) {
			$this->debug();
			return	FALSE;
		}
		return TRUE;
	}

	/**
	* 获取数据库插入id
	*+----------------
	* @param Void
	* @return Void
	*/
	public function lastId() {
		$this->dblink();
		return $this->identity->lastInsertId();
	}

	/**
	* 返回影响的行数
	*+--------------
	* @param Void
	* @return Void
	*/
	public function affect() {
		return $this->affect;
	}
	
	/**
	* 开启事物
	*+------------
	* @param Void
	* @return Void
	*/
	public function start() {
		$this->dblink();
		$this->identity->beginTransaction();
	}
	
	/**
	* 提交事物
	*+------------
	* @param Void
	* @return Void
	*/
	public function commit() {
		$this->dblink();
		$this->identity->commit();
	}

	/**
	* 回滚事物
	*+------------
	* @param Void
	* @return Void
	*/
	public function rollback() {
		$this->dblink();
		$this->identity->rollback();
	}

	/**
	* 获取错误信息
	*+------------
	* @param Void
	* @return Void
	*/
	public	function error() {
		return $this->error;
	}
	
	/**
	* 连接数据库
	*+---------------
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
			$this->identity->query("SET NAMES '{$this->config['charset']}'"); // set charset
		}
		return TRUE;
	}

	/**
	* 设置错误信息
	*+--------------
	* @param Void
	* @retrun Bolean
	*/
	private function debug() {
		if (is_object($this->identity)) {
			$error = $this->identity->errorInfo();
			if (isset($error[2])) {
				if ($this->debug) {
					throw new Ada_Exception($error[2]);
				} else {
					$this->error = $error[2];
				}
			}
		}
		return TRUE;
	}
	
	/**
	* 析构函数
	*+------------
	* 释放资源
	* @param Void
	* @return Void
	*/
	public function __destruct() {
		$this->identity = NULL;
		$this->resource = NULL;
	}
}