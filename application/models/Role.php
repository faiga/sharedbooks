<?php
class Application_Model_Role extends Zend_Db_Table_Abstract
{
	protected $_name = 'role';
	
	public function __construct()
	{
		$this->_db = Zend_Registry::get('_db');
	}
	
	public function getRoles()
	{
		$result = $this->fetchAll();
		return $result->toArray();
	}
}