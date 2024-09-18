<?php
use App\Forms\OldUsers;
use App\Models\UsersMapper as Users;
require_once("../vendor/autoload.php");
class SigninController extends Saffron_AbstractController{
	private $oError;
	private $error;
	public function indexAction(){
		$oform = new OldUsers();
		$this->view->signinform = $oform;
// $_POST['submitoform']
		if($this->hasParam('submitoform')){
			$this->signInProcess();
			$this->view->oError = $this->oError;
		}
	}
	public function signInProcess(){
		if(empty($this->getRequest()->getParam('ouseremail')) || empty($this->getRequest()->getParam('ouserpassword'))){
				$this->oError = "Please fill out all the fields";
			}
			else if(!$this->testOldRegularExpPattern()){

			}
			else{

					$userEmail = $this->getRequest()->getParam('ouseremail');
					$userPassword = $this->getRequest()->getParam('ouserpassword');
					$auth = Zend_Auth::getInstance();
					$obj = new \App\Models\Users();
					$obj->setEmail($userEmail);
					$obj->setPassword($userPassword);
					if(Users::getInstance()->getAccountType($obj) == 'Accountadmin'){
						$auth->setStorage(new Zend_Auth_Storage_Session('AccountAdmin'));
					}
					else{
						$auth->setStorage(new Zend_Auth_Storage_Session('AccountUser'));
					}
					$authAdapter = new Zend_Auth_Adapter_DbTable(NULL, 'accounts', 'email', 'password');
					$authAdapter->setIdentity($userEmail);
					$obj1 = new \App\Models\Users();
					$obj1->setPassword($userPassword);//To encrypt the password
					$Password = $obj1->getPassword();
					$authAdapter->setCredential($Password);
					$results = $auth->authenticate($authAdapter);
					if($results->isValid()){
						\Zend_Session::start();
						$namespace = new Zend_Session_Namespace('userInfo');
						$namespace->email = $userEmail;
						$namespace->password = $Password;

						$this->processForSignin($obj);
					}
					else{
						$this->oError = "Incorrect email or password";
					}
				}
		}
	public function testOldRegularExpPattern(){
		$ret = true;
		if(!filter_var($this->getRequest()->getParam('ouseremail', Null), FILTER_VALIDATE_EMAIL)){
			$ret = false;
			$this->error.="Invalid Email Address\n";
		}

		if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $this->getRequest()->getParam('ouserpassword', Null))){
			$this->oError.="Invalid Password! Password must contain at least a number and no special symbols with 8-15 characters long\n";
			$ret = false;
		}

		return $ret;

	}
	public function processForSignin($obj){
		if(Users::getInstance()->getAccountType($obj) == "Accountadmin"){
			header("location: /admin");


		}
		else if(Users::getInstance()->getAccountType($obj) == "Accountuser"){
			$this->redirect('/user');
		}
		else{
			
		}
	}
}