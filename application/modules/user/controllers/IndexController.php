<?php
\Zend_Session::start();
use \App\Models\PostsMapper;
use \App\Models\UsersMapper;
use \App\Models\HelpfulMapper;
use \App\Models\BooksMapper;
class User_IndexController extends Saffron_UserAbstractController
{
	public function indexAction(){
		$this->view->authorName = getAuthorRow()->getName();
		$this->view->moduleName = $this->getRequest()->getModuleName();
		$this->view->helpfulBooks = HelpfulMapper::getInstance()->getAll(['userid' => getAuthorRow()->getId()], ['dateandtime desc'])['data'];
		$this->view->book = [];
		foreach($this->view->helpfulBooks as $key => $value){
			$this->view->book[] = BooksMapper::getInstance()->getBook($value->getBookId());
		}
	}
	public function logoutAction(){
		\Zend_Session::start();
		\Zend_Session::namespaceUnset('AccountUser');
		header("location: /admin/");
	}

	
}