<?php
class Application_Model_Class_Config
{

	public function __construct()
	{
		
	}
	
	public function getConfig($file) {
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/' . $file . '.ini');
		return $config;
	}
}