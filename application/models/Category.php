<?php
class Application_Model_Category extends Zend_Db_Table_Abstract
{
	protected $_name = 'category';
	
	public function __construct()
	{
		$this->_db = Zend_Registry::get('_db');
	}
	
	public function saveCategory($data) {
		$this->insert($data);
	}
	
	public function getCategories(){
		$result = $this->fetchAll();
		return $result->toArray();
	}
}