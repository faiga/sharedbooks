<?php 

class Application_Model_User  extends Zend_Db_Table_Abstract{
	
	protected $_name = "user";
	protected $_db;
	protected $_map = array(
		'nutzer' => 'userName',
		'vorname' => 'firstName',
		'nachname' => 'lastName',
		'email' => 'email',
		'pass' => 'password',
		'rolle' => 'role',
		'anrede' => 'gender'
	);
	
	public function __construct()
	{
		$this->_db = Zend_Registry::get('_db');
	}
	
	public function insertUser($data)
	{
		$save = '';
		$columns = '';
		$first = true;
		foreach ($data as $key => $value) {
			if(isset($this->_map[$key])) {
				if($first) {
					$first = false;
				} else {
					$save .= ', ';
					$columns .= ', ';
				}
				$columns .= '`' . $this->_map[$key] . '`';
				if($key == 'pass') {
					$save .= ' PASSWORD("' . $value . '")';
				} else {
					$save .= '"' . $value  . '"';
				}
			}
		}
		$save .= ',3';
		$columns .= ',`role`';

		$this->_db->query('INSERT INTO `user` (' . $columns . ') VALUES ('. $save . ')');
	}
	
	public function getUsers($id) {
		$friends = new Application_Model_Friends();
		$myFriends = $friends->getFriendsId($id);
		$result = $this->fetchAll('id != ' . $id,'userName asc');
		$result->toArray();
		$users = array();
		foreach ($result as $key => $value) {
			if((array_search($value['id'], $myFriends)=== false)) {
				$users[] = array(
					'vorname' => $value['firstName'],
					'nachname' => $value['lastName'],
					'nutzer' => $value['userName'],
					'email' => $value['email'],
					'id' => $value['id']);
			}
		}
		return $users;
	}
}