<?php namespace App\Forms;
class OldUsers extends \Zend_Form
{
	public function init(){
		$this->setMethod("post");
		$this->setAction("");
		$this->addElement('text', 'ouseremail', array('required' => 'required', 'placeholder' => 'Enter your email', 'label' => 'Email : ', 'class' => 'form-control', 'value' => isset($_POST['ouseremail'])?$_POST['ouseremail']:"" ));
		$this->addElement('password', 'ouserpassword', array('required' => 'required', 'placeholder' => 'Enter a password', 'label' => 'Password: ', 'class' => 'form-control'));
		$this->addElement('submit', 'submitoform', array('label' => 'Log in', 'class' => 'btn btn-primary'));

	}
}