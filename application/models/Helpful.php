<?php namespace App\Models;
class Helpful
{
	private $id;
	private $bookId;
	private $userId;
	private $dateAndTime;
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
	public function setDateAndTime($val){
		$this->dateAndTime = $val;
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
	public function getDateAndTime(){
		return $this->dateAndTime;
	}
	public function setAll($arr){
		if(isset($arr['Hid'])){
			$this->id = $arr['Hid'];
		}
		if(isset($arr['bookid'])){
			$this->bookId = $arr['bookid'];
		}
		if(isset($arr['userid'])){
			$this->userId = $arr['userid'];
		}
		if(isset($arr['dateandtime'])){
			$this->dateAndTime = $arr['dateandtime'];
		}
	}
}