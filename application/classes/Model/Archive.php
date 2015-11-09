<?php
class Model_Archive extends Ada_Model {
	
	private static $db = NULL;

	private static $instance = NULL;
	
	/**
	* 获取文章列表
	* @param Array $params 查询条件
	* @param Int $offset 分页开始数
	* @param Int $size 每页大小
	* @param Ref $count 总记录数
	* @return Array
	*/
	public function fetchList($params=array(), $offset=0, $size=20, &$count) {
		$query = ' WHERE a.status=1'. $this->buildSearchQuery($params);
		$count = self::$db->select("SELECT COUNT(*) FROM ada_archive a JOIN ada_category c ON a.category=c.id {$query}")->fetchOne();
		return self::$db->select("SELECT a.*,c.title AS category FROM ada_archive a JOIN ada_category c ON a.category=c.id {$query} ORDER BY a.createtime DESC LIMIT {$offset},{$size}")->fetchAll();
	}

	/**
	* 获取文章详情
	* @param Int $id 文件id
	* @return Array
	*/
	public function fetchDetails($id) {
		return self::$db->select("SELECT a.*,ab.body FROM ada_archive a JOIN ada_archive_body ab ON a.id=ab.aid WHERE a.id=".$id)->fetchRow();
	}

	public static function factory() {
		self::$instance === NULL AND self::$instance = new self();
		return self::$instance;
	}
	
	private function buildSearchQuery($params=array()) {
		$query = '';
		isset($params['id']) && $params['id'] > 0 AND $query.=' AND a.category='.(int)$params['id'];
		empty($params['keyword']) OR $query.=' AND a.title LIKE "%'.$params['keyword'].'%"';
		return $query;
	}
	private function __construct() {
		self::$db = Database::factory();
	}
}

