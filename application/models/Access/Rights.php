<?php

class Application_Model_Access_Rights 
{
	public function __construct()
	{
	}
	
	public function setRights()
	{
		$acl = new Zend_Acl();
		//Rollen
		$roleModel = new Application_Model_Role();
		$roles = $roleModel->getRoles();
		foreach ($roles as $key => $data) {
			if($data['parent_id'] != 0) {
				$parent = array_search($data['parent_id'], $roles);
				$acl->addRole($data['name'],$roles[$parent]['name']);
			} else {
				$acl->addRole($data['name']);
			}
		}
		
		//Resourcen
		$resourceModel = new Application_Model_Resource();
		$resources = $resourceModel->getResources(true);
		foreach ($resources as $key => $data) {
				$acl->addResource(new Zend_Acl_Resource($data['controller']));
		}
		
		//Rights
		$rightsModel = new Application_Model_Rights();
		$rights = $rightsModel->getRights();
		foreach ($rights as $key => $data) {
			$acl->allow($data['name'],$data['controller'],$data['action']);
		}
		
		//$auth = Zend_Auth::getInstance();
		//$auth->getStorage()->write($acl);
		
		return $acl;
		
	}
	
	//public function getRights();
}