<?php namespace App\Forms;
class WriteBook extends \Zend_Form
{
	public function init(){
		$this->setMethod("post");//Note, All these elements should have default values from db
		$this->addElement('text', 'pageheader', array("placeholder" => "Name of Page", "class" => "form-control", "label" => "Heading: ", "style" => "width:60%"));
		
		$this->addElement("textarea", "bookcontent", array("placeholder" => "Contents", "class" => "form-control", "label" => "Contents", "style" => "width:60%;height:450px;"));
		// if($_GET['page']>1){
		// 	$pre = $_GET['page'] - 1;
		// 	$this->addElement('submit', 'submitformpreedit', array('label' => 'Previous', 'class' => 'btn btn-primary', "formaction" => "bookedit?page=$pre"));
		// }
		
		$next = $_GET['page'] + 1;
		$this->addElement('submit', 'submitformindex', array('label' => 'Save', 'class' => 'btn btn-primary', "formaction" => ""));
		$this->addElement('submit', 'submitformedit', array('label' => 'Next', 'class' => 'btn btn-primary', 'formaction' => ""));
		
	}

}