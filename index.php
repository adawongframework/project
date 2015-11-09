<?php
define('DS', DIRECTORY_SEPARATOR);
define('ADAPATH', dirname(__FILE__).DS.'system'); //system folder
define('APPPATH', dirname(__FILE__).DS.'application'); // application folder
include ADAPATH.DS.'classes'.DS.'Ada'.DS.'Wong.php';
include ADAPATH.DS.'classes'.DS.'Autoload.php';
try {
	Autoload::register();
	$response = Request::factory()->execute(); // internal request
	if ($response->status() ==200) { // status code
		echo $response;
	}
} catch (Ada_Exception $e) {
	echo $e->getMessage();
	//echo '<div style="text-align:center">404,Page Not Found!</div>';
}
  
