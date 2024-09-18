<?php namespace App\Forms;
class EditBook extends \Zend_Form{
	public function init(){
		$request = \Zend_Controller_Front::getInstance()->getRequest();
		$this->setMethod('post');
		$this->addElement('text', 'pageheaderedit', array("placeholder" => "Name of Page", "class" => "form-control", "label" => "Heading: ", "style" => "width:60%", "value" => $request->getParam('heading')));
		
		$this->addElement("textarea", "bookcontentedit", array("placeholder" => "Contents", "class" => "form-control", "label" => "Contents", "style" => "width:60%;height:450px;", "value" => $request->getParam('contents')));

		if($request->getParam('page')>1){
			$pre = $request->getParam('page') - 1;
			$this->addElement('submit', 'submitformpreedit', array('label' => 'Previous', 'class' => 'btn btn-primary', "formaction" => "bookedit?page=$pre"));
		}
		
		$next = $request->getParam('page') + 1;
		$this->addElement('submit', 'submitindexedit', array('label' => 'Save', 'class' => 'btn btn-primary'));
		if($request->getParam('page') < $request->getParam('totalpages')){
			$this->addElement('submit', 'submitedit', array('label' => 'Next', 'class' => 'btn btn-primary'));
		}
		
	}
}