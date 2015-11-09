<?php
/**
* ���ô�����
*/
class Ada_Config {
	
	//�����ļ����Ŀ¼
	private static $directory = 'config';
	
	//�����ļ�����Ŀ¼
	private static $folders = array(APPPATH, ADAPATH);

	//�����������ļ�
	private static $loaders = array();
	
	//������������Ŀ
	private static $configs = array();

	/**
	* ���������ļ�
	* @param String $file �����ļ�����
	* @param Boolean $return �Ƿ񷵻�������Ŀ��Ϣ
	* @return Mixed ������������ļ�����TRUE,�����׳��쳣
	*/
	public static function load($filename, $return=FALSE){
		//��ֹ�ظ�����
		if (isset(self::$loaders[strtoupper($filename)])) {
			return TRUE;
		}
		$found = FALSE;
		//���������ļ����Ŀ¼,���������ļ�
		foreach (self::$folders as $folder) {
			$file = $folder.DIRECTORY_SEPARATOR.self::$directory.DIRECTORY_SEPARATOR.$filename.'.php';
			if (is_file($file) && is_readable($file)) {
				$found = TRUE;
				self::$configs[$filename] = include $file;
				self::$loaders[] = strtoupper($file);
			}
		}
		if (!$found) {
			throw new Ada_Exception();
		}
		return $return === TRUE ? self::$configs[$filename] : $found;
	}
	
	/*
	* ��ȡ������Ŀ��Ϣ
	* @param String $path ·��
	* @return Mixed
	*/
	public static function xpath($path) {
	
	}
}