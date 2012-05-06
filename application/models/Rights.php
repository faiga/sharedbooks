<?php
class Application_Model_Rights extends Zend_Db_Table_Abstract
{
	protected $_name = 'rights';

	public function __construct()
	{
		$this->_db = Zend_Registry::get('_db');
	}

	public function getRights()
	{
		$select = $this->_db->select()
			->from($this->_name)
			->join('resource', 'resource.id = ' . $this->_name . '.resource_id')
			->join('role', 'role.id = ' . $this->_name . '.role');
		$result = $this->_db->fetchAll($select);
		return $result;
	}
	
	public function updateRights($changes,$role)
	{
		foreach ($changes as $key => $data) {
			if($data['access'] == 'ja') {
				$this->insert(array('resource' => $key,'role' => $role));
			} else {
				$this->delete('role = ' . $role . ' and resource = ' . $resource);
			}
		}
	}
}