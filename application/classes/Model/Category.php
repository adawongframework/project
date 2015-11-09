<?php
class Model_Category extends Model {
	
	private static $db = NULL;

	private static $instance = NULL;
	
	/**
	* 获取类别列表
	*/
	public function fetchList() {
		return self::$db->select("SELECT * FROM ada_category")->fetchAll();
	}

	public static function factory() {
		if (self::$instance === NULL) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	private function __construct() {
		self::$db = Database::factory();
	}
}