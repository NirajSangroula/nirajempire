<?php
require_once("../vendor/autoload.php");
class Admin_BookEditController extends Saffron_AdminAbstractController
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

	public function insideeditAction(){
		$this->view->moduleName = $this->getRequest()->getModuleName();
		$request = $this->getRequest();
		$page = $this->hasParam('page')?$request->getParam('page'):1;
		$bookId = $request->getParam('bookId');
		try{
			if($page>maxPage($bookId)){
				throw new Exception("The book doesn't have page number $page", 1);
				
			}
			if($this->hasParam('submitedit') || $this->hasParam('submitindexedit')){
				$newContents = $request->getParam('bookcontentedit');
				$newHeading = $request->getParam('pageheaderedit');
				$postsMapper = \App\Models\PostsMapper::getInstance();
				$dbAdapter = $postsMapper->getDbTable()->getAdapter();
				$dbAdapter->beginTransaction();
				try{
					$currentTimestamp = date("Y-m-d H:i:s");
					$dbAdapter->update('posts', ['contents' => $newContents, 'pageheader' => $newHeading, 'lastupdated' => $currentTimestamp], ["bookid = ?" => $bookId, "pageno = ?" => $page]);
					$dbAdapter->update('books', ['lastupdated' => $currentTimestamp], ['bookid =?' => $bookId]);
					$dbAdapter->commit();
					$next = $page+1;
					if($this->hasParam('submitedit')){
						header("location: /admin/bookedit/insideedit?page=$next&bookId=$bookId");
					}
					else{
						header("location: /admin/index");
					}
					
				}
				catch(\Zend_Db_Adapter_Exception $e){
					$dbAdapter->rollBack();
					throw new Exception($e->getMessage(), 1);
					
				}

			}
			if(!$this->hasParam('bookId')){
				throw new Exception("Unknown book", 1);
			}
			$this->view->editForm = NULL;
			$postsMapper = \App\Models\PostsMapper::getInstance();
			$this->view->object = $postsMapper->getAll(['bookId' => $bookId, 'pageno' =>$page])['data'][0];
			$request->setParam('heading', $this->view->object->getPageHeader());
			$request->setParam('contents', $this->view->object->getContents());
			$_POST['val'] = $this->view->object->getContents();
			if($this->hasParam('bookId')){
				$this->view->editJump = new \App\Forms\EditJump();
				$this->view->editForm = new \App\Forms\EditBook();

			}
			


		}
		catch(\Exception $e){
			echo $e->getMessage();
		}
	}
	public function jumpAction(){
		$request = $this->getRequest();
		$bookId = $request->getParam('bookId');
		$page = $request->getParam('pagenumber');
		header("location: /admin/bookedit/insideedit?page=$page&bookId=$bookId");
	}
}
