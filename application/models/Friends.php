<?php
class Application_Model_Friends extends Zend_Db_Table_Abstract
{
	protected $_name = 'friends';
	
	public function __construct()
	{
		$this->_db = Zend_Registry::get('_db');
	}
	
	public function insertFriends($data) 
	{
		$this->insert($data);
	}
	
	public function getFriendsId($id)
	{
		$result = $this->fetchAll('user1 = ' . $id . ' OR user2 = ' . $id);
		$result->toArray();
		$friends = array();
		foreach($result as $key => $value) {
			if($value['user1'] == $id) {
				$friends[] = $value['user2'];
			} else {
				$friends[] = $value['user1'];
			}
		}
		return $friends;
	}
}