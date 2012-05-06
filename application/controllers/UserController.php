<?php
class UserController extends Zend_Controller_Action
{
	public function init()
	{
		
	}
	
	public function findAction()
	{
		$params = $this->_getAllParams();
		$friends = new Application_Model_Friends();
		$auth = Zend_Auth::getInstance();
		$identity = $auth->getIdentity();
		$user = new Application_Model_User();
		$this->view->users = $user->getUsers($identity->id);
		if(isset($params['save'])) {
			$friends->insertFriends(array('user1' => $identity->id, 'user2' => $params['friends']));
		}
	}
	
	public function friendsAction()
	{
		$friends = new Application_Model_Friends();
		$auth = Zend_Auth::getInstance();
		$identity = $auth->getIdentity();
		$this->view->friends = $friends->getFriendsId($identity->id);
	}
}