<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
    protected function _initDb()
    {
    	$resource = $this->getPluginResource('db');
    	$db = $resource->getDbAdapter();
    	Zend_Registry::set('_db', $db);
    	 
    }
    
    protected function _initAuth()
    {
    	$this->bootstrap('frontController');
    	$this->getResource('frontController')->registerPlugin(new Application_Model_Plugin_AccessControl());
    }
}

