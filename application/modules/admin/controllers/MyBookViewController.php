<?php
require_once('../vendor/autoload.php');
use \App\Models\BooksMapper;
use \App\Models\PostsMapper;
use \App\Models\CommentMapper;
use \App\Models\UsersMapper;
use \App\Models\HelpfulMapper;
class Admin_MyBookViewController extends Saffron_AdminAbstractController
{
	public function indexAction(){
			$displayPages = 2*3;
			$page = $this->hasParam('page')?$this->getRequest()->getParam('page'):1;
			$this->view->page = $page;
			$this->view->moduleName = $this->getRequest()->getModuleName();
			$authorId = getAuthorRow()->getId();
			$count = getBooksRowCountPage(['authorid' => $authorId], $page, $displayPages);
			$this->view->booksCount = $count;
			$booksMapper = \App\Models\BooksMapper::getInstance();
			$books = $booksMapper->getBooks($authorId, $page, $displayPages);
			$this->view->books = $books;
			$totalBooks = getBooksRowCount(['authorid' => $authorId]);
			if($page  < ($totalBooks/$displayPages)){
				$this->view->next = true;
			}
			else{
				$this->view->next = false;
			}
	}

	public function insideviewAction(){
		$this->view->moduleName = $this->getRequest()->getModuleName();
		$this->view->page = $this->hasParam('page')?$this->getRequest()->getParam('page'):1;
		try{
			if(!$this->hasParam('bookId')){
				throw new Exception("Book to be viewed is unknown", 1);				
			}
			$this->view->bookId = $this->getRequest()->getParam('bookId');
			if(!$this->hasParam('page')){
				$page = 1;
			}
			$postsMapper = \App\Models\PostsMapper::getInstance();
			$this->view->pages = $postsMapper->getAll(array('bookid' => $bookId = $this->getRequest()->getParam('bookId')))['data'];
			$booksMapper = \App\Models\BooksMapper::getInstance();
			
			$this->view->bookName = $booksMapper->getAll(['bookid' => $bookId])['data'][0]->getBookName();
			$helpfulObj = HelpfulMapper::getInstance()->getAll(['bookid' => $bookId], ['dateandtime desc'])['data'];
			$helpful = [];
			foreach ($helpfulObj as $key => $value) {
				$helpful[] = [UsersMapper::getInstance()->getUserName(['id' => $value->getUserId()]), $value->getDateAndTime()];
			}
			$commentsObj = CommentMapper::getInstance()->getAll(['bookid' => $bookId], ['createdOn desc'])['data'];
			$comments = [];
			foreach ($commentsObj as $key => $value) {
				$comments[] = array(UsersMapper::getInstance()->getUserName(['id' => $value->getUserId()]), $value->getCreatedOn(), $value->getContent());
			}
			$this->view->comments = $comments;
			$this->view->helpful = $helpful;
		}
		catch(\Exception $e){
			echo $e->getMessage();
		}
	}

	public function bookdeleteAction(){
		$request = $this->getRequest();
		try{
			if(!$this->hasParam('page') || !$this->hasParam('bookId')){
				throw new Exception("Unknown pageId or previous page", 1);
			}
			else{
				$page = $request->getParam('page');
				$bookId = $request->getParam('bookId');
				$adapter = BooksMapper::getInstance()->getDbTable()->getAdapter();
				$adapter->beginTransaction();
				$adapter->delete('books', ['bookid = ?' => $bookId]);
				$adapter->delete('posts', ['bookid = ?' => $bookId]);
				$adapter->commit();
				header("location: /admin/mybookview?page=$page");
			}

		}
		catch(\Exception $e){
			echo $e->getMessage();
		}
	}

	public function bookinsidedeleteAction(){
		$request = $this->getRequest();
		try{
			if(!$this->hasParam('page') || !$this->hasParam('pageid') || !$this->hasParam('bookid')){
				throw new Exception("Unknown bookId, pageId or previous page", 1);
			}
			else{
				$page = $request->getParam('page');
				$pageId = $request->getParam('pageid');
				$bookId = $request->getParam('bookid');
				if(PostsMapper::getInstance()->getPageNo($pageId) == 1){
					throw new Exception("Can't delete first page!! edit the first page or delete entire book.", 1);
				}
				$adapter = BooksMapper::getInstance()->getDbTable()->getAdapter();
				$adapter->beginTransaction();
				$adapter->delete('posts', ['Pid = ?' => $pageId]);
				$adapter->commit();
				header("location: /admin/mybookview/insideview?page=$page&bookId=$bookId");
			}

		}
		catch(\Exception $e){
			echo $e->getMessage();
		}
	}
}