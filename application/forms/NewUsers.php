<?php namespace App\Forms;

	class NewUsers extends \Zend_Form
	{
		public function init(){
			$this->setMethod("post");
			//$this->setAttribute('class')

			$url = '/registration/index?type='.$_GET['type'];
			$this->setAction("");
			// /registration/index
			$this->addElement('text', 'username', array('required' => 'required', 'placeholder' => 'Enter your name', 'label' => 'Full Name:', 'class' => 'form-control', 'value' => isset($_POST['username'])?$_POST['username']:"" ));

			$this->addElement('text', 'useremail', array('required' => 'required', 'placeholder' => 'Enter your email', 'label' => 'Email: ', 'class' => 'form-control', 'value' => isset($_POST['useremail'])?$_POST['useremail']:"" ));
			$this->addElement('text', 'usercontactno', array('required' => 'required', 'placeholder' => 'Enter your contact no', 'label' => 'Contact no:' , 'class' => 'form-control', 'value' => isset($_POST['usercontactno'])?$_POST['usercontactno']:"" ));
			$this->addElement('text', 'userdob', array('required' => 'required', 'placeholder' => 'Enter your birth date', 'label' => 'Dob(yyyy/mm/dd): ', 'class' => 'form-control', 'value' => isset($_POST['userdob'])?$_POST['userdob']:"" ));
			$this->addElement('password', 'userpassword', array('required' => 'required', 'placeholder' => 'Create a password', 'label' => 'Password: ', 'class' => 'form-control'));
			$this->addElement('password', 'userpasswordv', array('required' => 'required', 'placeholder' => 'Verify password', 'label' => 'Verify password: ', 'class' => 'form-control'));

			$this->addElement('submit', 'submit', array('label' => 'Create account', 'class' => 'btn btn-primary'));
		}
	}