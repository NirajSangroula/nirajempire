<?php namespace App\Models;
/**
* @Entity
* @Table(name="accounts")
***/

class Users
{
	/**
	* @column(type="integer")
	* @userid
	* @GeneratedValue
	**/
	private $id;
	/**
	* @column(type="varchar", name="username", length="30")
	**/
	private $name;

	/**
	* @column(type="varchar", name="email", unique, length="30")
	*
	*/
	private $email;
	/**
	* @column(type="varchar", name="password", length="15")
	*
	*/
	private $password;
	/**
	* @column(type="varchar", name="contactno", length="15")
	*
	*/
	private $contactNo;
	/**
	* @column(type="date", name="dateofbirth")
	
	*/
	private $dateOfBirth;
	/**
	* @column(type="varchar", name="accounttype", length="20")
	*
	*/
	private $accountType;
	/**
	* @column(type="timestamp", name="createdon")
	* @GeneratedValue
	*
	*/
	private $session;
	private $createdOn;

	public function __construct($arr = NULL){
		if($arr !== NULL){
			$this->setAll($arr);
		}
	}

	public function setAll($arr){
			if(isset($arr['id'])){
				$this->setId($arr['id']);		
			}
			if(isset($arr['name'])){
				$this->setName($arr['name']);		
			}
			if(isset($arr['email'])){
				$this->setEmail($arr['email']);		
			}
			if(isset($arr['contactNo'])){
				$this->setContactNo($arr['contactNo']);		
			}
			if(isset($arr['dateOfBirth'])){
				$this->setDateOfBirth($arr['dateOfBirth']);		
			}
			if(isset($arr['password'])){
				$this->setPassword($arr['password']);		
			}
			if(isset($arr['accountType'])){
				$this->setAccountType($arr['accountType']);		
			}
			if(isset($arr['createdOn'])){
				$this->setCreatedOn($arr['createdOn']);		
			}
			if(isset($arr['session'])){
				$this->setSession($arr['session']);		
			}

	}

	public function setId($id){
			$this->id = $id;
		
		
		return $this;
	}

	public function setName($name){
		$this->name = $this->filterData($name);
		return $this;
	}

	public function setEmail($email){
		$this->email = $this->filterData($email);
		return $this;
	}

	public function setPassword($password){
		if($password == $this->filterData($password)){
			$this->password = $this->encryptPassword($this->filterData($password));
		}
		else{
			$this->password = $this->encryptPassword("password");
		}
		return $this;
	}

	public function onlySetPassword($password){
		$this->password = $password;
	}

	public function setContactNo($contactNo){
		$this->contactNo = $contactNo;
		return $this;
	}

	public function setDateOfBirth($dateOfBirth){
		$this->dateOfBirth = $this->arrangeDateOfBirth($dateOfBirth);
		return $this; 
	}

	public function setAccountType($accountType){
		$this->accountType = $accountType;
		return $this;
	}

	public function setCreatedOn($val){
		$this->createdOn = $val;
		return $this;
	}
	public function setSession($val){
		$this->session = $val;
		return $this;
	}



	public function getId(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getPassword(){
		return $this->password;
	}

	public function getContactNo(){
		return $this->contactNo;
	}

	public function getDateOfBirth(){
		return $this->dateOfBirth;
	}

	public function getAccountType(){
		return $this->accountType;
	}

	public function getCreatedOn(){
		return $this->createdOn;
	}
	public function getSession(){
		return $this->session;
	}

	public function filterData($data){
		return htmlspecialchars(strip_tags(trim($data)));
	}

	public function encryptPassword($password){
		return \Zend_Crypt::hash('gost', $password);
	}

	public function arrangeDateOfBirth($dob){
		$arr = explode('/', $dob);
		$str = implode('-', $arr);
		return $str;
	}
}