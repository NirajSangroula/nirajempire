<?php
\Zend_Session::start();
use \App\Models\PostsMapper;
use \App\Models\UsersMapper;
class Admin_IndexController extends Saffron_AdminAbstractController
{
	public function indexAction(){
		$itemsPerPage = 10;
		$request = $this->getRequest();
		$this->view->moduleName = $request->getModuleName();
		$this->view->authorName = getAuthorRow()->getName();
		$this->view->page = $page = $this->hasParam('page')?$request->getParam('page'):1;
		$this->view->recentPosts = PostsMapper::getInstance()->getAllPages(getAuthorRow()->getId(), $page, $itemsPerPage, ['lastupdated desc']);
		
	}
	public function logoutAction(){
		\Zend_Session::start();
		\Zend_Session::namespaceUnset('AccountAdmin');
		header("location: /");
	}

	
}