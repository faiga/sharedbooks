<?php
class BookController extends Zend_Controller_Action
{
	public function init()
	{

	}

	public function newAction()
	{
		$books = new Application_Model_Books();
		$params = $this->_getAllParams();
		if(isset($params['save'])) {
			if(!empty($params['band'])) {
				$series = new Application_Model_Series();
				$id = $series->getSeriesId(array('titel' => $params['titel']));
				$where = 'author="'.$params['autor'].' AND title="'.$params['band'].'" and series = '.$id;
			} else {
				$where = 'author="'.$params['autor'].' AND title="'.$params['titel'].'"';
			}
			$searchResult = $books->getBooks($where);
			if(count($searchResult)== 0) {
				$books->saveBooks($params);
			} else {
				$this->view->message = 'Buch existiert bereits';
			}
		}
	}

	public function addbookAction() {
		$params = $this->_getAllParams();
		$books = new Application_Model_Books();
		$listBooks = $books->getBooks();
		$series = new Application_Model_Series();
		$listseries = $series->getSeries();
		$Liste = array();
		foreach($listBooks as $key => $data) {
			$Liste[$key] = $listBooks[$key];
			if($data['series'] != 0) {
				$seriesKey = array_search($data['series'], $listseries);
				$Liste[$key]['title'] = $listseries[$seriesKey]['name'] . ' - '. $data['title'];
			}
		}
		$this->view->books = $Liste;
		if(isset($params['save'])) {
			$UserBooks = new Application_Model_UserBook();
			$UserBooks->saveBook(array('user' => 2,'book' => $params['titel'], 'amount' => 1));
		}
	}
	
	public function mybooksAction()
	{
		$books = new Application_Model_UserBook();
		$auth = Zend_Auth::getInstance();
		$identity = $auth->getIdentity();
		$mybooks = $books->getBooks($identity->id);
		$series = new Application_Model_Series();
		$listseries = $series->getSeries();
		$Liste = array();
		foreach($mybooks as $key => $data) {
			$Liste[$key] = $mybooks[$key];
			if($data['series'] != 0) {
				$seriesKey = array_search($data['series'], $listseries);
				$Liste[$key]['title'] = $listseries[$seriesKey]['name'] . ' - ' . $data['title'];
				$Liste[$key]['band'] = $data['title'];
			}
		}
		$this->view->books = $Liste;
	}
	
	public function detailAction()
	{
		$params = $this->_getAllParams();
		$books = new Application_Model_Books();
		$this->view->detail = $books->getBooks('id = ' . $params['id']);
		if($this->view->detail[0]['series'] != 0) {
			$series = new Application_Model_Series();
			$this->view->series = $series->getSeries('id = ' . $this->view->detail[0]['series']);
		}
		//@todo loan, due 
	}
}