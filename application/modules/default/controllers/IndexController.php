<?php

use App\Forms\OldUsers;
use App\Models\UsersMapper as Users;
require_once("../vendor/autoload.php");
class IndexController extends Saffron_AbstractController
{

	
	
	public function indexAction()
	{
			$this->view->headTitle('Niraj\'s Empire');
		$this->view->controllername = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
		
		
	}


	public function servicesAction(){
		$this->view->headTitle('Our Services');
		echo "Hello";
	}

	public function contactusAction(){
		$this->view->headTitle('Contact Us');
	}

	public function aboutusAction(){
		$this->view->headTitle('About us');
/**
* Testing section
*/
	
	// var_dump(Users::getInstance()->recordExists(['id' => 99]));



	}
}