<?php
use App\Forms\NewUsers;
use App\Models\UsersMapper as Users;
require_once("../vendor/autoload.php");
class SignupController extends Saffron_AbstractController{
	private $error;
	public function indexAction(){
		
	}
	public function signnowAction(){
		$this->view->headTitle('Sign up');
		$form = new NewUsers();
		$this->view->signupform = $form;
		if($this->hasParam('submit')){
			$this->createAccount();
		}
		
		
	}

	public function createAccount(){
		if($this->testEmpty()){
				$this->error = "Please fill out all the fields \n";
			}
			else if($this->getRequest()->getParam('userpassword', Null) != $this->getRequest()->getParam('userpasswordv', Null)){
			$this->error = "Passwords do not match \n";
			}
			elseif(!$this->testReggularExpPattern()){

			}
			else{
				if($this->hasParam('submit')){
					if($this->testEmpty()){
						$this->error = "Please fill out all the fields \n";
						$this->errorStep();
			}
			else if($this->getRequest()->getParam('userpassword', Null) != $this->getRequest()->getParam('userpasswordv', Null)){
				$this->error = "Passwords do not match \n";
			}
			elseif(!$this->testReggularExpPattern()){

			}
			else{
					$accounttype = "Account".$this->getRequest()->getParam('type');
					$types = ['admin', 'user'];
					$res = false;
					foreach($types as $key => $val){
						if($val == $this->getRequest()->getParam('type')){
							$res = true;
						}
		}
		if(!$res){
			$this->error ="Invalid user type!! Don't try to modify url";
		}
		else{

				$arr = array('name' => $this->getRequest()->getParam('username'),
							'email' => $this->getRequest()->getParam('useremail'),
							'password' => $this->getRequest()->getParam('userpassword'),
							'contactNo' => $this->getRequest()->getParam('usercontactno'),
							'dateOfBirth' => $this->getRequest()->getParam('userdob'),
							'accountType' => $accounttype);
				$obj = new \App\Models\Users($arr);
				\App\Models\UsersMapper::getInstance()->insertRecord($obj);
			}
		}
	}
			}
		$this->view->error = $this->error;
	}

	public function testReggularExpPattern(){
		$ret = true;
		if(!preg_match('/^[A-Za-z]{3,18}( )?[A-Za-z]*$/', $this->getRequest()->getParam('username', Null))){
			$ret = false;
			$this->error.="Invalid User Name \n";
		}
		if(!filter_var($this->getRequest()->getParam('useremail', Null), FILTER_VALIDATE_EMAIL)){
			$ret = false;
			$this->error.="Invalid Email Address\n";
		}
		if(!preg_match('/^[0-9]{5,13}$/', $this->getRequest()->getParam('usercontactno', Null))){
			$this->error.="Invalid Contact no\n";
			$ret = false;
		}
		
		if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,15}$/", $this->getRequest()->getParam('userpassword', Null))){
			$this->error.="Invalid Password! Password must contain at least a number and no special symbols with 8-15 characters long\n";
			$ret = false;
		}

		if(!preg_match('/^[0-9]{4}(\/)[0-9]{2}(\/)[0-9]{2}$/', $this->getRequest()->getParam('userdob', Null))){
			$this->error.="Invalid date of birth format. Format should match yyyy/mm/dd\n";
			$ret = false;
		}
		else{
			$arr = explode('/', $this->getRequest()->getParam('userdob', Null));
			if($arr[0]<1958 || $arr[0]>2005){
				$this->error.="Year of date of birth not allowed\n";
				$ret = false;
			}
			if($arr[1]<1 || $arr[1]>12){
				$this->error.="Month of date of birth not allowed\n";
				$ret = false;
			}
			if($arr[2]<1 || $arr[2]>31){
				$this->error.="Day of date of birth not allowed\n";
				$ret = false;
			} 
			
		}

		return $ret;
		//test more patterns later
	}
	
	public function testEmpty(){
		if(empty($this->getRequest()->getParam('username', Null)) || empty($this->getRequest()->getParam('useremail', Null)) ||empty($this->getRequest()->getParam('userdob', Null)) ||empty($this->getRequest()->getParam('userpasswordv', Null)) ||empty($this->getRequest()->getParam('usercontactno', Null)) ||empty($this->getRequest()->getParam('userpassword', Null)))
		{
			return true;
		}
		else{
			return false;
		}
	}
}