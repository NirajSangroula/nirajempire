<?php namespace App\Models;
class Books
{
	private $bookId;
	private $bookName;
	private $helpfulCount;
	private $commentsCount;
	private $authorId;
	private $lastUpdated;
	public function __construct($val){
		if($val !== NULL){
			$this->setAll($val);
		}
	}
	public function setBookId($id){
		$this->bookId = $id;
	}
	public function setBookName($name){
		$this->bookName = $name;
	}
	public function setHelpfulCount($val){
		$this->helpfulCount = $val;
	}
	public function setCommentsCount($val){
		$this->commentsCount = $val;
	}
	public function setAuthorId($val){
		$this->authorId = $val;
	}
	public function setLastUpdated($val){
			$this->lastUpdated = $val;
	}
	public function setAll($arr){
		if(isset($arr['bookid'])){
			$this->setBookId($arr['bookid']);
		}
		if(isset($arr['bookname'])){
			$this->setBookName($arr['bookname']);
		}
		if(isset($arr['helpfulcount'])){
			$this->setHelpfulCount($arr['helpfulcount']);		
		}
		if(isset($arr['commentscount'])){
			$this->setCommentsCount($arr['commentscount']);		
		}
		if(isset($arr['authorid'])){
			$this->setAuthorId($arr['authorid']);		
		}
		if(isset($arr['lastupdated'])){
			$this->setLastUpdated($arr['lastupdated']);		
		}
	}
	
	public function getBookName(){
		return $this->bookName;
	}
	public function getHelpfulCount(){
		return $this->helpfulCount;
	}
	public function getCommentsCount(){
		return $this->commentsCount;
	}
	public function getBookId(){
		return $this->bookId;
	}
	public function getAuthorId(){
		return $this->authorId;
	}
	public function getLastUpdated(){
		return $this->lastUpdated;
	}
	
}