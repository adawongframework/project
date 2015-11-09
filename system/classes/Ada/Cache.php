<?php
/**
* 缓存接口类
*/
abstract class Ada_Cache extends Ada_Wong {

	abstract public function set($key, $val, $expires=0);

	abstract public function get($key);

	abstract public function del($key);
}