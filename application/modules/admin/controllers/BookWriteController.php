<?php
require_once("../vendor/autoload.php");
class Admin_BookWriteController extends Saffron_AdminAbstractController
{
	public function indexAction(){
			// $displayPages = 3;
			// $page = $this->hasParam('page')?$this->getRequest()->getParam('page'):1;
			// $this->view->page = $page;
			// $this->view->moduleName = $this->getRequest()->getModuleName();
			// $authorId = getAuthorRow()->getId();
			// $count = getBooksRowCountPage(['authorid' => $authorId], $page, $displayPages);
			// $this->view->booksCount = $count;
			// $booksMapper = \App\Models\BooksMapper::getInstance();
			// $books = $booksMapper->getBooks($authorId, $page, $displayPages);
			// $this->view->books = $books;
			// $postsMapper = \App\Models\PostsMapper::getInstance();
			// $pages = $postsMapper->getPages($authorId, 1, $page, $displayPages);
			// $this->view->pages = $pages;
			// $totalBooks = getBooksRowCount(['authorid' => $authorId]);
			// if($page  < ($totalBooks/$displayPages)){
			// 	$this->view->next = true;
			// }
			// else{
			// 	$this->view->next = false;
			// }
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

	public function writeAction(){
		$this->view->moduleName = $this->getRequest()->getModuleName();
		$pageno = ($this->hasParam('page'))?$this->getRequest()->getParam('page'):1;
		$this->view->pageno = $pageno;
		$bookForm = new App\Forms\WriteBook();
		$bookForm1 = new App\Forms\EditJump();
		$this->view->writeBook = $bookForm;	
		$this->view->editJump = $bookForm1;
		$request = $this->getRequest();
		try{
			if(!$this->hasParam('bookId')){
				throw new Exception("Book unknown", 1);
				
			}
			if(!canAccess($request->getParam('bookId'))){
				throw new Exception("Sorry, you cannot extend others book", 1);
				
			}
			if($pageno != maxPage($this->getRequest()->getParam('bookId'))+1 ){
				throw new Exception("Can't write skipping pages or into written page", 1);
				
			}
			if($this->hasParam('submitformedit') || $this->hasParam('submitformindex')){
			try{
				$bookId = createPost($this);
				if($request->getParam('submitformindex') !== NULL){
					header("location:index");
				}
				else{
					$nextPageno = $pageno + 1;
					header("location:write?page=$nextPageno&bookId=$bookId");
				}
			}
			catch(Exception $e){
				echo $e->getMessage();
			}

		}
		

	}
	catch(\Exception $e){
			echo $e->getMessage();
		}
		

		
	}
}