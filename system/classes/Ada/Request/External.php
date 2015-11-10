<?php if (!defined('ADAPATH')) die ('Access failure');
/**
* 外部请求处理具体实现类
*+-------------------------
* @package	Core
* @category	Base
* @author	zjie 2015/04/01
*/
class Ada_Request_external {
	
	/**
	* 请求的数据
	* @var Array
	*/
	private $data;
	
	/**
	* 是否post请求
	* @var boolean
	*/
	private $ispost;

	/**
	* 请求的方法
	* @var String
	*/
	private $method;
	
	/**
	* 请求对象
	* @var Object
	*/
	private $request;

	/**
	* 响应对象
	* @var Object
	*/
	private $response;

	/**
	* http协议版本
	* @var Int
	*/
	private $version = 1.1;
	
	/**
	* 构造函数
	*+----------------------------------
	* @param Request $request 请求对象
	* @param Response $response 响应对象
	* @param String $method 请求方法
	* @return Void
	*/
	public function __construct(Request $request, Response $response, $method) {
		$this->request = $request;
		$this->method = $method;
		$this->data = $this->request->getparam();
		$this->response = $response;
		$ispost = $this->ispost();
		$this->handle();
	}

	/**
	* 请求处理
	*+------------
	* @param Void
	* @return Void
	*/
	private function handle() {
		if (!function_exists('curl_init')) {
			$this->chinit();
		} else if (!function_exists('fsockopen')) {
			$this->socket();
		} else if (ini_get('allow_url_fopen')) {
			$this->stream();
		} else {
			throw new Ada_Exception('Unable to remote request');
		}
	}

	/**
	* curl请求
	*+------------
	* @param Void
	* @return Void
	*/
	private function chinit() {
		$ch = curl_init();
		if ($this->ispost) {
			curl_setopt($ch, CURLOPT_URL, $this->request->uri());
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
		} else {
			curl_setopt($ch, CURLOPT_URL, rtrim($this->request->uri()).'?'.http_build_query($this->data));
		}
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$contents = curl_exec($ch);
		if ($contents === FALSE) {
			throw new Ada_Exception(curl_error($ch));
		}
		$this->response->body($contents);
		$this->response->status(curl_getinfo($ch, CURLINFO_HTTP_CODE));
		curl_close($ch);
	}
	
	/**
	* fsockopen请求
	*+-------------
	* @param Void
	* @return Void
	*/
	private function socket() {
		$url = parse_url($this->request->uri());
		$fp = @fsockopen($url['host'], isset($url['port']) ? $url['post'] : 80, $errno, $error);
		$timeout = ini_get('max_execution_time');
		stream_set_timeout($fp, $timeout > 0 ? $timeout : 30);
		if ($fp === FALSE) {
			throw new Exception($error);
		}
		$data = http_build_query($this->data);
		if ($this->ispost) { //post
			$head = "{$this->method} ".(isset($url['path']) ? $url['path'] : '/')." HTTP/{$this->version}\r\n";
			$head.= "Content-Type: application/x-www-form-urlencoded\r\n";
		} else {
			$head = "{$this->method} ".(isset($url['path']) ? $url['path'] : '/')."?{$data} HTTP/{$this->version}\r\n";
		}
		$head.= "Content-Length: ".strlen($data)."\r\n";
		$head.= "HOST:{$url['host']}\r\n";
		$head.= "Connection:close\r\n";
		$head.= "\r\n{$data}\r\n";
		fwrite($fp, $head);
		$contents = '';
		while (!feof($fp)) {
			$contents.= fgets($fp);
		}
		fclose($fp);
		$this->result($contents);
	}

	/**
	* stream_create_context请求
	*+-------------------------
	* @param Void
	* @return Void
	*/
	private function stream() {
		$data = http_build_query($this->data);
		$timeout = ini_get('max_execution_time');
		$options = array(
			'http' => array(
				'method' => $this->method,
				'timeout' => $timeout > 0 ? $timeout : 30,
			)	
		);
		if ($this->ispost) {
			$uri =  $this->request->uri();
			$options['http']['header'] = "Content-Type: application/x-www-form-urlencoded;Content-Length: ".strlen($data)."";
			$options['http']['content'] = $data;	
		} else {
			$uri = $uri =  $this->request->getUrl().'?'.$data;
		}
		$stream = stream_context_create($options);
		$this->result(file_get_contents($uri, FALSE, stream_context_create($options)));
	}
	
	/**
	* 处理响应内容和获取状态码
	*+--------------------------------
	* @param String $contents 响应内容
	* @return Void
	*/
	private function result($contents) {
		preg_match('`(?<=http/'.$this->version.')[\s]+(?<status>[1-5][0-9]+)[\s]+`i', $contents, $matchs);
		$this->response->status((isset($matchs['status']) ? $matchs['status'] : 404));
		$result = '';
		if (preg_match('`(\r\n){2}`', $contents)) {
			$contents = preg_split("`(\r\n){2}`", $contents);
			for($i=1; $i < count($contents); $i++) {
				$result.= $contents[$i];
			}
		} else {
			$result = $contents;
		}
		$this->response->body($result);
	}

	/**
	* 是否post方法请求
	*+----------------
	* @param Void
	* @return Boolean
	*/
	private function ispost() {
		return strtolower($this->method) == 'post';	
	}
}




