<?php
class Application_Model_Access_Adapter extends Zend_Auth_Adapter_DbTable
{
	
	public function __construct()
	{
		$registry = Zend_Registry::getInstance();
		$this->_setDbAdapter($registry->get('_db'));
		$this->setTableName('user');
		$this->setIdentityColumn('userName');
		$this->setCredentialColumn('password');
		$this->setCredentialTreatment('PASSWORD(?)');
	}
}