<?php
class Application_Model_UserBook extends Zend_Db_Table_Abstract
{
	protected $_name = 'userbooks'; 
	
	public function __construct()
	{
		$this->_db = Zend_Registry::get('_db');
	}
	
	public function saveBook($data) {
		$this->insert($data);
	}
	
	public function getBooks($id)
	{
		$select = $this->_db->select()
			->from($this->_name)
			->join('books', 'books.id = '.$this->_name.'.book',array('title','author','series'))
			->where($this->_name.'.user = ' . $id)
			->order('books.author asc');
		$result = $this->_db->fetchAll($select);
		return $result;
	}
	
}