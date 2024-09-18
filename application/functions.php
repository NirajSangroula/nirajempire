<?php
require_once("../vendor/autoload.php");
function checkSession(){
	\Zend_Session::start();
	$namespace = new \Zend_Session_Namespace('AccountAdmin');
	$namespaceUser = new \Zend_Session_Namespace('AccountUser');
	if(\Zend_Session::namespaceIsset('AccountAdmin')){
			return 'admin';
		}
	else if(\Zend_Session::namespaceIsset('AccountUser')){
		return 'user';
	}

	}
function createPost($obj1){//test
	\Zend_Session::start();

	$request = $obj1->getRequest();
	$pageNo = ($obj1->hasParam('page'))?$request->getParam('page'):1;
	$mapper = \App\Models\UsersMapper::getInstance();
	$session = \Zend_Session::namespaceGet('userInfo');
	$obj = new \App\Models\Users(['email' => $session['email']]);
	$obj->onlySetPassword($session['password']);
	$row = $mapper->getARow($obj);
	if($request->getParam('bookcontent') == NULL){
		throw new \Exception('Book contents cannot be empty');
	}
	if($val = $obj1->hasParam('bookheader')){
		$bookHeader = $request->getParam('bookheader');
		$book = new \App\Models\Books(array('bookname' => $bookHeader));
	}
	$authorId = $row->getId();
	$pageHeader = $request->getParam('pageheader');
	$contents = $request->getParam('bookcontent');
	if(isset($book)){
		$postsMapper = \App\Models\PostsMapper::getInstance();
		$booksMapper = \App\Models\BooksMapper::getInstance();
		$bookManip = $booksMapper->getDbTable()->getAdapter();
		// $postManip = $postsMapper->getDbTable()->getAdapter();
		if(getBooksRowCount(array('authorid' => $authorId, 'bookname' => $bookHeader))>0){
			throw new \Exception("Sorry, You have already created the book");
		}
		else{
			try{
			$bookManip->beginTransaction();
    		$bookManip->insert($booksMapper->getDbTable()->getName(), array('bookname' => $bookHeader, 'authorid' => $authorId));
    		$bookManip->commit();
    		$bookId = currentBookId(array('bookname' => $bookHeader, 'authorid' => $authorId));
    		$bookManip->beginTransaction();
    		$bookManip->insert($postsMapper->getDbTable()->getName(), array('authorid' => $authorId, 'pageno' => $pageNo, 'pageheader' => $pageHeader, 'contents' => $contents, 'bookid' => $bookId));
    		$bookManip->commit();
    		
    		// $n = new \Zend_Session_Namespace('book');
    		// $n->bookid = $bookId;
    		// $postManip->commit();
    	}
    	catch(\Zend_Db_Adapter_Exception $e){
    		$bookManip->rollBack();
    		throw new \Exception($e->getMessage());
    	}
    	catch(\Zend_Db_Adapter_Exception $e){
    		$bookManip->rollBack();
    		throw new \Exception($e->getMessage());
    		}
		}
		return $bookId;
    }

    else{
    	\Zend_Session::start();
    	$postsMapper = \App\Models\PostsMapper::getInstance();
    	$adapter = $postsMapper->getDbTable()->getAdapter();
	    $existsRow = $postsMapper->existsPageNumber(array('bookid' => $request->getParam('bookId'), 'pageno' => $pageNo));
    		if($existsRow){
    			throw new \Exception('Sorry, page number '.$pageNo.' already exists');
    		}
    		else{
    			$adapter->beginTransaction();
    			$bookId = $request->getParam('bookId');
    			try{
    		$adapter->insert($postsMapper->getDbTable()->getName(), array('authorid' => $authorId, 'pageno' => $pageNo, 'pageheader' => $pageHeader, 'contents' => $contents, 'bookid' => $bookId));
		    	$adapter->commit();
    		
    	}
    	catch(\Zend_Db_Adapter_Exception $e){
    		$adapter->rollback();
    		throw new Exception($e->getMessage());
    	}
    		return $bookId;
		    	
    		}
    	

    	

    }
}

function currentBookId($arr){
	$bookMapper = \App\Models\BooksMapper::getInstance();
	$result = $bookMapper->getAll($arr)['data'][0];
	return $result->getBookId();
}
function getBooksRowCount($arr){
	$bookMapper = \App\Models\BooksMapper::getInstance();
	$result = count($bookMapper->getAll($arr)['data']);
	return $result;
}
function getBooksRowCountPage($arr, $page, $totalPages){
	$bookMapper = \App\Models\BooksMapper::getInstance();
	$result = count($bookMapper->get($arr, [], $page, $totalPages)['data']);
	return $result;
}
function canAccess($bookId){
	\Zend_Session::start();
	$mapper = \App\Models\UsersMapper::getInstance();
	$session = \Zend_Session::namespaceGet('userInfo');
	$obj = new \App\Models\Users(['email' => $session['email']]);
	$obj->onlySetPassword($session['password']);
	$row = $mapper->getARow($obj);

	if(getBooksRowCount(['authorid' => $row->getId(), 'bookid' => $bookId]) > 0){
		return true;
	}
	else{
		return false;
	}
}
function maxPage($bookId){
	$postMapper = \App\Models\PostsMapper::getInstance();
	$res = $postMapper->getAll(['bookid' => $bookId])['data'];
	return count($res);
}
function getAuthorRow(){
	$mapper = \App\Models\UsersMapper::getInstance();
	\Zend_Session::start();
	$session = \Zend_Session::namespaceGet('userInfo');
	$obj = new \App\Models\Users(['email' => $session['email']]);
	$obj->onlySetPassword($session['password']);
	$row = $mapper->getARow($obj);
	return $row;
}