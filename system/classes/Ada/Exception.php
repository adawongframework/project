<?php
class	Ada_Exception extends	Exception{
	
	public function __construct($message, $code=NULL) {
		parent::__construct($message, $code);
	}
}