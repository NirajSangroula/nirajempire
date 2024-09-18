<?php
use App\Forms;
use App\Models\HelpfulMapper;
use App\Models\CommentMapper;
use App\Models\UsersMapper;
require_once("../vendor/autoload.php");
class User_OtherBooksViewController extends Saffron_UserAbstractController
{
	public function indexAction(){
		$this->view->moduleName = $this->getRequest()->getModuleName();
		$this->view->form = new Forms\HelpfulandSuggestion();
		if($this->hasParam('helpful')){

		}
		$request = $this->getRequest();
		$displayPages = 9;
		$page = $this->hasParam('page')?$this->getRequest()->getParam('page'):1;
		$this->view->page = $page;
		$this->view->userId = getAuthorRow()->getId();
		$this->view->moduleName = $this->getRequest()->getModuleName();
		$booksMapper = \App\Models\BooksMapper::getInstance();
		$books = $booksMapper->get([], ['lastupdated asc'], $page, $displayPages)['data'];
		$this->view->books = $books;
		$count = count($books);
		$this->view->booksCount = $count;
		$postsMapper = \App\Models\PostsMapper::getInstance();
		$pages = $postsMapper->get(['pageno' => 1], ['lastupdated asc'], $page, $displayPages)['data'];
		$this->view->pages = $pages;
		$totalBooks = count($booksMapper->getAll()['data']);
		if($page  < ($totalBooks/$displayPages)){
			$this->view->next = true;
		}
		else{
			$this->view->next = false;
		}
	}

	public function helpfulAction(){
		try{
			if(!$this->hasParam('page') || !$this->hasParam('bookId') || !$this->hasParam('status')){
				throw new Exception("Error Processing Request", 1);				
			}
			else{
				$userId = getAuthorRow()->getId();
				$request = $this->getRequest();
				$page = $request->getParam('page');
				$bookId = $request->getParam('bookId');
				$action = $request->getParam('status');
				$userId = getAuthorRow()->getId();
				$arrayParam = ['bookid' => $bookId, 'userid' => $userId];
				if($action == 1){
					if(\App\Models\HelpfulMapper::getInstance()->hasHelped($arrayParam)){
						throw new Exception("You have already marked this post helpful", 1);
						
					}
				}
				else{
					if(!\App\Models\HelpfulMapper::getInstance()->hasHelped($arrayParam)){
						throw new Exception("You haven't marked this post helpful");
					}
				}
				$adapter = \App\Models\HelpfulMapper::getInstance()->getDbTable()->getAdapter();
				$oldHelpfulCount = \App\Models\BooksMapper::getInstance()->getAll(['bookid' => $bookId])['data'][0]->getHelpfulCount();
				if($action === '0'){
					try{
						$adapter->beginTransaction();
						$adapter->delete('helpful', ['bookid = ?' => $bookId, 'userid = ?' => $userId]);
						$adapter->update('books', ['helpfulcount' => $oldHelpfulCount-1], ['bookid = ?' => $bookId]);
						$adapter->commit();
						header("location: /admin/otherbooksview/index?page=$page");
					}
					catch(\Zend_Db_Adapter_Exception $e){
						$adapter->rollBack();
						throw new Exception($e->getMessage(), 1);
						
					}
				}
				else{
					try{
						$adapter->beginTransaction();
						$adapter->insert('helpful', ['bookid' => $bookId, 'userid' => $userId]);
						$adapter->update('books', ['helpfulcount' => $oldHelpfulCount+1], ['bookid = ?' => $bookId]);
						$adapter->commit();
						header("location: /admin/otherbooksview/index?page=$page");
					}
					catch(\Zend_Db_Adapter_Exception $e){
						$adapter->rollBack();
						throw new Exception($e->getMessage(), 1);
						
					}
				}

			}
		}
		catch(\Exception $e){
			echo $e->getMessage();
		}
	}

	public function commentAction(){
		if($this->hasParam('helpful')){
			$request = $this->getRequest();
			$bookId = $request->getParam('bookid');
			$comment = $request->getParam('comment');
			$page = $request->getParam('page');
			$authorId = getAuthorRow()->getId();
			try{
				if(is_null($request->getParam('comment'))){
					throw new Exception("Please fill comment", 1);
				}
				if(is_null($request->getParam('bookid'))){
					throw new Exception("Book unknown", 1);
					
				}
				$authorId = getAuthorRow()->getId();
				$adapter = \App\Models\CommentMapper::getInstance()->getDbTable()->getAdapter();
				try{
					$adapter->beginTransaction();
					$adapter->insert('comment', ['bookid' => $bookId, 'content' => $comment, 'userid' => $authorId]);
					$adapter->commit();
					header("location: /admin/otherbooksview?page=$page");
				}
				catch(\Zend_Db_Adapter_Exception $e){
					$adapter->rollBack();
					throw new Exception($e->getMessage(), 1);
					
				}
			}
			catch(\Exception $e){
				echo $e->getMessage();
			}
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
}