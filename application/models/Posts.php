<?php namespace App\Models;
class Posts
{
	private $pId;
	private $author;
	private $bookId;
	private $pageNo;
	private $pageHeader;
	private $lastUpdated;
	private $contents;

	public function __construct($arr = NULL){
		if($arr !== NULL){
			$this->setAll($arr);
		}
	}
	public function setContents($val){
		$this->contents = $val;
	}
	public function setPId($val){
		$this->pId = $val;
	}
	public function setAuthor($val){
		$this->author = $val;
	}
	public function setBookId($val){
		$this->bookId = $val;
	}
	public function setPageNo($val){
		$this->pageNo = $val;
	}
	public function setPageHeader($val){
		$this->pageHeader = $val;
	}
	
	public function setLastUpdated($val){
		$this->lastUpdated = $val;
	}
	/**Getters **/
	public function getContents(){
		return $this->contents;
	}

	public function getPId(){
		return $this->pId;
	}
	public function getAuthor(){
		return $this->author;
	}
	public function getBookId(){
		return $this->bookId;
	}
	public function getPageNo(){
		return $this->pageNo;
	}
	public function getPageHeader(){
		return $this->pageHeader;
	}
	
	public function getLastUpdated(){
		return $this->lastUpdated;
	}

	public function setAll($arr){
		if(isset($arr['Pid'])){
				$this->setPId($arr['Pid']);		
		}
		if(isset($arr['authorid'])){
			$this->setAuthor($arr['authorid']);		
		}
		if(isset($arr['bookid'])){
			$this->setBookId($arr['bookid']);		
		}
		if(isset($arr['pageno'])){
			$this->setPageNo($arr['pageno']);		
		}
		if(isset($arr['pageheader'])){
			$this->setPageHeader($arr['pageheader']);		
		}
		
		if(isset($arr['contents'])){
			$this->setContents($arr['contents']);		
		}
		if(isset($arr['lastupdated'])){
			$this->setLastUpdated($arr['lastupdated']);
		}
	}

}