<?php
class Application_Model_Series extends Zend_Db_Table_Abstract
{
	protected $_name = 'series';
	protected $_map = array(
		'sammelband' => 'id',
		'titel' => 'name',
	);
	
	public function __construct()
	{
		$this->_db = Zend_Registry::get('_db');
	}
	
	public function getSeriesId($data) {
		$result = $this->fetchAll('name="'. $data['titel'] .'"');
		$result->toArray();
		if(count($result)>0) {
			return $result[0]['id'];
		} else {
			foreach ($data as $key => $value) {
				if(isset($this->_map[$key])) {
					$save[$this->_map[$key]] = $value;
				}
			}
			$this->insert($save);
			return $this->_db->lastInsertId();
		}
	}
	
	public function getSeries($where = NULL) 
	{
		if(!empty($where)) {
			$result = $this->fetchAll($where);
		} else {
			$result = $this->fetchAll();
		}
		return $result->toArray();
	}
}