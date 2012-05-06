<?php
class Application_Model_Offers extends Zend_Db_Table_Abstract
{
	protected $_name = 'offers';
	
	public function __construct()
	{
		$this->_db = Zend_Registry::get('_db');
	}
	
	public function getOffers($where = NULL) 
	{
		if(!empty($where)) {
			$result = $this->fetchAll($where);
		} else {
			$result = $this->fetchAll();
		}
		return $result->toArray();
	}
	
	public function saveOffer($offer) 
	{
		$this->insert($offer);
		if(!empty($offer['customer_id'])) {
			$user = new Application_Model_User();
			$books = new Application_Model_Books();
			$sender = $user->getUsers($offer['seller_id']);
			$recipient = $user->getUsers($offer['customer_id']);
			$bookSender = $books->getBooks('id = ' . $offer['book_have']);
			$bookRecipient = $books->getBooks('id = ' . $offer['book_want']);

		$mail = new Application_Model_Class_Mail();
		
		$options = array(
			'topic' => 'Tauschangebot für ' . $bookRecipient[0]['title'] . ' von ' . 
				$sender[0]['nutzer'],
			'sender' => $sender[0]['email'],
			'recipient' => $recipient[0]['email']);
		$mail->message($options);
		
		}
	}
	
}