<?php
define('ADAPATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'system');
define('APPPATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'application');
include ADAPATH.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'Ada'.DIRECTORY_SEPARATOR.'Wong.php';
include ADAPATH.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'Autoload.php';
try {
	Autoload::register();
	$response = Request::factory()->execute();
	if ($response->status() ==200) {
		echo $response;
	}
} catch (Ada_Exception $e) {
	echo $e->getMessage();
	echo '<div style="text-align:center">404,Page Not Found!</div>';
}
