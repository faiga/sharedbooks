<?php
class Application_Model_Plugin_AccessControl extends Zend_Controller_Plugin_Abstract
{
	protected $_auth;
	protected $_acl;	
	
	public function __construct()
	{
		$this->_auth = Zend_Auth::getInstance();
		$this->_acl = new Zend_Acl();
		$rights = new Application_Model_Access_Rights();
		$this->_acl = $rights->setRights();
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		//$this->_auth->getStorage()->clear();
		$controller = $request->getControllerName();
		$action = $request->getActionName();
		if(!$this->_auth->hasIdentity()) {
			$role = 'guest';
		} else {
			$identity = $this->_auth->getIdentity();
			//if($activity['']))
			echo time()- $identity->active;
			if((time()- $identity->active)<600) {
				$identity->active = time();
				$role = $identity->role;
			} else {
				$role = 'guest';
				$this->_auth->getStorage()->clear();
			}
		}
		$access = $this->_acl->isAllowed($role,$controller,$action);
		if(!$access && $action != 'register') {
			$request->setActionName('index');
			$request->setControllerName('index');
			$request->setModuleName('default');
			$request->setParam('error', 'Zugriff verweigert');
			//$this->view->message = 'Zugriff verweigert';
		}
	}
}