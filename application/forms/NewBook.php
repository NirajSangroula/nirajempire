<?php namespace App\Forms;
class NewBook extends \Zend_Form
{
	public function init(){
		$this->setMethod("post");
		$this->setAction("");
		$this->addElement('text', 'bookheader', array("placeholder" => "Name of book", "class" => "form-control", "label" => "Name: ", "style" => "width:60%"));
		include_once("BookCommon.php");
		$this->addElement('submit', 'submitoformindex', array('label' => 'Save', 'class' => 'btn btn-primary'));
		$this->addElement('submit', 'submitoformedit', array('label' => 'Next', 'class' => 'btn btn-primary'));
	}
}