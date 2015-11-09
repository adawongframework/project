<?php
/**
* 模板引擎实现类
*+----------顺序结构--------------编译之后----------------------------------------------
* {date('Y-m-d H:i:s')/}			-> <?php echo date('Y-m-d H:i:s');?>
* {$name/}							-> <?php echo $this->variables['name'];?>
* {template head.tpl/}				-> <?php include "head.tpl";?>
*
*+----------选择结构--------------编译之后----------------------------------------------
* {if $count == 1}					-> <?php if ($this->variables['count'] > 1) {?>
*	//do1							->   //do1
* {elseif $count > 1}				-> <?php }else if ($this->variables['count'] > 1) {?> 
*	//do2							->	//do2  
* {else}							-> <?php }else {?>
*	//do3							->	//do3
* {/if}								-> <?php }?>
*
*+-----------循环结构-------------编译之后----------------------------------------------
* {loop var=$list key=$index}		-> <?php for ($index = 0; $index < count($this->variables['list'])); $index++{?>
* {$list[$index]/}					-> <?php echo $this->variables["list"][$index];?>
* {/loop}							-> <?php }?>
*
*/
abstract class Ada_Template extends Ada_Wong {
	
	/**
	* 定义编译缓存文件声明内容
	* @var String
	*/
	protected static $tplscript = "<?php if (!\$this instanceOf Template) die('Access Failed');?>\r\n";

	/**
	* 定义模版文件后缀名
	* @var String
	*/
	protected static $tplsuffix = 'tpl';

	/**
	* 定义缓存文件后缀名
	* var String
	*/
	protected static $tmpsuffix = 'tmp';
	
	/**
	* 定义模板文件存放目录
	* @var String
	*/
	protected static $tplfolder = './';

	/**
	* 定义缓存文件存放目录
	* @var String
	*/
	protected static $tmpfolder = './tmp';
	
	/**
	* 定义模板标签定界符
	* @var Array
	*/
	protected static $delimiter = array('{' ,'}');

	/**
	* 模板缓存有效期 单位(秒)
	* @var Int
	*/
	protected static $lifetimes = 60;

	/**
	* 保存模版文件全局变量
	* @var Array
	*/
	protected $variables = array();

	/**
	* 绑定模板变量和值
	*+--------------------------
	* $this->bindvar('name', 'sara');
	*+--------------------------
	* @param Stirng $key
	* @param Mixed $var
	* @return Self
	*/
	public function bindvar($key, $var) {
		$this->variables[$key] = $var;
		return $this;
	}
	
	/**
	* 编译和显示指定模板内容
	*+---------------------------
	* $this->display('demo.tpl');
	*+---------------------------
	* @param String $tplfile
	* @return Boolean
	*/
	public function display($tplfile) {
		$tplfile = $this->checked($tplfile);
		$name = md5($tplfile);
		$path = self::$tmpfolder.DIRECTORY_SEPARATOR.substr($name, 0, 1);
		$tmpfile = $path.DIRECTORY_SEPARATOR.$name.'.'.self::$tmpsuffix; //编译临时文件
		if (!is_dir($path)) {
			mkdir($path, 0777, TRUE);
		}
		if (is_file($tmpfile)) {
			$timestamp = time();
			$modfiyTime = filemtime($tplfile);
			$accessTime = filemtime($tmpfile);
			//检测模板文件修改状态与缓存时间有效状态
			if ($modfiyTime > $accessTime || ($timestamp - $accessTime) >= self::$lifetimes) {
				Ada_Template_Compile::execute($tplfile, $tmpfile); //重新编译模板文件
			}
		} else {
			Ada_Template_Compile::execute($tplfile, $tmpfile); //第一次编译模板文件
		}
		include $tmpfile;
	}
	
	/**
	* 清空模板缓存文件
	*+----------------
	* @param Void
	* @return Void
	*/
	public function cleanAll() {
		$directory = func_num_args() > 0 ? func_get_arg(0) : self::$tmpfolder;
		//判断目录是否为self::$tmpfolder开始,防止删除其他目录文件
		if (!preg_match('`^'.preg_quote(self::$tmpfolder).'.*`', $directory)) {
			throw new Ada_Exception('directory error');
		}
		if (is_dir($directory)) {
			$fp = opendir($directory);
			while (($item=readdir($fp)) !== FALSE) {
				if ($item == '.' || $item == '..') continue;
				$file = $directory.DIRECTORY_SEPARATOR.$item;
				if (is_dir($file)) {
					$this->cleanAll($file);
				} else { //删除有效的缓存文件
					if (preg_match('/.+\.'.self::$tmpsuffix.'$/', $file) && is_file($file) && is_writable($file)) {
						unlink($file);
					}
				}
			}
			closedir($fp);
		}
	}

	/**
	* 检测模板文件是否合法
	* 如果检测成功,返回完成完整名称,否则抛出异常.
	*+--------------------
	* @param string $tplfile
	* @return String
	*/
	private function checked($tplfile) {
		$file = self::$tplfolder.DIRECTORY_SEPARATOR.$tplfile;
		if (!is_file($file) || !is_readable($file)) {
			throw new Ada_Exception('Tpl File Is Not Found');
		}
		if (!preg_match('/.+\.'.self::$tplsuffix.'$/' , $tplfile)) {
			throw new Ada_Exception('Tpl File extension is not allowed');
		}
		return $file;
	}
}