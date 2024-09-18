<?php
class User_OtherUsersViewController extends Saffron_UserAbstractController
{
	public function indexAction(){
		$this->view->moduleName = $this->getRequest()->getModuleName();
		$itemsPerPage = 15;
		$request = $this->getRequest();
		$page = $this->hasParam('page')?$request->getParam('page'):1;
		$usersMapper = \App\Models\UsersMapper::getInstance();
		$users = $usersMapper->get([], ['createdon desc'], $page, $itemsPerPage)['data'];
		$books = [];
		$Books = \App\Models\BooksMapper::getInstance()->getAll()['data'];
		// $default = array(new \App\Models\Books(['bookname' => "Empty"]));
		// $Allbooks = (count($Books)<1)?$default:$Books;
		$Allbooks = $Books;
		foreach($users as $key => $value){
			foreach($Allbooks as $key1 => $value1){
				if($value->getId() === $value1->getAuthorId()){
					$books[$key][] = $value1;
				}
				
			}
			if(!isset($books[$key])){
				$books[$key][] = NULL;
			}
		}
		$this->view->users = $users;
		$this->view->books = $books;
	}
}