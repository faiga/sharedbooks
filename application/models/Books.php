<?php
class Application_Model_Books extends Zend_Db_Table_Abstract
{
	protected $_name = 'books';
	protected $_map = array(
		'buchnummer' => 'id',
		'titel' => 'title',
		'sprache' => 'language',
		'seiten' => 'pages',
		'autor' => 'author',
		'kategorie' => 'category',
		'sammelband' => 'series'
	);
	
	public function __construct()
	{
		$this->_db = Zend_Registry::get('_db');
	}
	
	public function saveBooks($data) {
		$save = array();
		foreach ($data as $key => $value) {
			if(isset($this->_map[$key])) {
				$save[$this->_map[$key]] = $value;
			}
		}
		if($save['series'] !== 0) {
			$save['title'] = $data['band'];
			$series = new Application_Model_Series();
			$id = $series->getSeriesId($data);
			$save['series'] = $id;
		}
		$this->insert($save);
	}
	
	public function getBooks($data = NULL) {
		if(!empty($data)) {
			$result = $this->fetchAll($data);
		} else {
			$select = $this->select()
			 ->from($this->_name)
			 ->order('author asc');
			$result = $this->fetchAll($select);
		}
		return $result;
	}
	
}