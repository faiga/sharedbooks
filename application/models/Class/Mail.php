<?php
class Application_Model_Class_Mail
{
	public function __construct()
	{
		
	}
	
	public function contactAdmin($mailcontent)
	{
		$mail = new Zend_Mail();
		$mail->setSubject($mailcontent['topic'])
			->setFrom($mailcontent['email'])
			->addTo('angela.moschner@googlemail.com')
			->setBodyText($mailcontent['content'])
			->send();
		return true;
	}
	
	public function message($content)
	{
		$mail = new Zend_Mail();
		$mail->setSubject($content['topic'])
		->setFrom($content['sender'])
		->addTo($content['recipient'])
		//@todo ini Vorlage für email, str_replace
		->setBodyText($content['content'])
		->send();
		return true;
	}
}