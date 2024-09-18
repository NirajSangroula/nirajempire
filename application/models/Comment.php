<?php namespace App\Models;
class Comment
{
	private $id;
	private $bookId;
	private $userId;
	private $content;
	private $createdOn;
	public function __construct($arr = NULL){
		if($arr){
			$this->setAll($arr);
		}
	}
	public function setId($val){
		$this->id = $val;
		return $this;
	}
	public function setBookId($val){
		$this->bookId = $val;
	}
	public function setUserId($val){
		$this->userId = $val;
	}
	public function setContent($val){
		$this->content = $val;
	}
	public function setCreatedOn($val){
		$this->createdOn = $val;
	}

	public function getId(){
		return $this->id;
	}
	public function getBookId(){
		return $this->bookId;
	}
	public function getUserId(){
		return $this->userId;
	}
	public function getContent(){
		return $this->content;
	}
	public function getCreatedOn(){
		return $this->createdOn;
	}

	public function setAll($arr){
		if(isset($arr['Cid'])){
			$this->id = $arr['Cid'];
		}
		if(isset($arr['bookid'])){
			$this->bookId = $arr['bookid'];
		}
		if(isset($arr['userid'])){
			$this->userId = $arr['userid'];
		}
		if(isset($arr['content'])){
			$this->content = $arr['content'];
		}
		if(isset($arr['createdon'])){
			$this->createdOn = $arr['createdon'];
		}
	}

}