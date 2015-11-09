<?php
/**
* �Զ��������ļ�
* Autolaod::register()ע���Զ��������ļ�
* ������ʹ���»���"_"�ָ���ӳ�����ļ�����Ŀ¼
* ϵͳ��Ӧ�����ļ����ڷ�����self::$folderָ����Ŀ¼��
* ���ļ�����Ŀ¼��self::$directoryָ����Ŀ¼��
*/
class Autoload extends Ada_Wong {
	
	//�������ļ�����Ŀ¼
	private static $folder = 'classes';
	
	//����������ļ�Ŀ¼
	private static $directory = array(APPPATH, ADAPATH);

	//����������ģʽ
	private static $pattern = array(
		'filename' => '#^[a-z][a-z0-9]*$#i', //�����������ļ�·����ͬ
		'filepath' => '#(?<filepath>(?:[a-z]+_)+)(?<filename>[a-z][a-z0-9]*)#i' //������ӳ�����ļ�·��
	);
	
	/**
	* ע���Զ��������
	* @param Void
	* @return Void
	*/
	public static function register() {
		spl_autoload_register(array('self', '_L'));
	}
	
	/**
	* �������ļ� ������ӳ�����ļ�����Ŀ¼
	* @param $class String ������
	* @return ����ɹ�����TRUE,�����׳��쳣
	*/
	private static function _L($class) {
		$found = FALSE;
		$file = self::_V($class);
		if ($file) {
			$path = str_replace('_', DIRECTORY_SEPARATOR, $file['path']);
			$file = self::$folder.DIRECTORY_SEPARATOR.$path.$file['name'].self::$ext;
			foreach (self::$directory as $folder) {
				if (is_file($folder.DIRECTORY_SEPARATOR.$file) && is_readable($folder.DIRECTORY_SEPARATOR.$file)) {
					include $folder.DIRECTORY_SEPARATOR.$file;
					return TRUE;
				}
			}
		}
		if ($found === FALSE) {
			throw new	Ada_Exception('Class '.$class.' not found');
		}
	}
	
	/**
	* ��֤�������Ƿ�Ϸ�
	* @param $class String ������
	* @return Boolean;
	*/
	private static function _V($class) {
		$file = array('path'=>'', 'name'=>'');
		if (preg_match(self::$pattern['filename'], $class)) {
			$file['name'] = $class;
		} else if (preg_match(self::$pattern['filepath'], $class, $matchs)) {
			$file['name'] = $matchs['filename'];
			$file['path'] = $matchs['filepath'];
		} else {
			return FALSE;
		}
		return $file;
	}
}

