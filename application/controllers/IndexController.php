<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
                
    }
    
    public function loginAction()
    {
    	$params = $this->_getAllParams();
    	if(isset($params['error'])) {
    		$this->view->message = $params['error'];
    	}
    	$this->_helper->viewRenderer->setNoRender(true);
    	if(isset($params['login']) && $params['login'] == 'Anmelden') {
    		$myauth = new Application_Model_Access_Adapter();
    		$auth = Zend_Auth::getInstance();
    		$myauth->setIdentity($params['nutzer']);
    		$myauth->setCredential($params['pass']);
    		if($auth->authenticate($myauth)) {
    				
    			$storage = $auth->getStorage();
    			$identity = $myauth->getResultRowObject(null, 'password');
    			$identity->active = time();
    			$storage->write($identity);
    			$this->_redirect('book/mybooks');
    		} else {
    			$this->_redirect('index/index');
    		}
    	}
    }
    
    public function logoutAction()
    {
    	$auth = Zend_Auth::getInstance();
    	$auth->clearIdentity();
    	$this->_redirect('index/index');
    }
    
    public function registerAction()
    {
    	$auth = Zend_Auth::getInstance();
    	if($auth->hasIdentity()) {
    		$this->_redirect('book/mybooks');
    	} else {
    		$params = $this->_getAllParams();
    		if(isset($params['create'])) {
    			$users  = new Application_Model_User();
    			$users->insertUser($params);
    			$this->_redirect('index/index');
    		}
    		
    	}
    }


}

