<?php
class Model_Admin extends Model {
	
	private static $db = NULL;

	public function __construct() {
		self::$db = Database::factory();
	}

	public function checkLogin($username, $password) {
		return self::$db->select("SELECT id,username,password FROM ada_admin WHERE username='{$username}'")->fetchRow();
	}
}