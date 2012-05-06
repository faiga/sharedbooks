<?php
class Application_Model_Resource extends Zend_Db_Table_Abstract
{
	protected $_name = 'resource';

	public function __construct()
	{
		$this->_db = Zend_Registry::get('_db');
	}

	public function getResources($unique)
	{
		$select = $this->select()
			->from($this->_name);
		if($unique) {
			$select->group('controller');
		}
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
	
}