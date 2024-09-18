<?php namespace App\Forms;
class EditJump extends \Zend_Form
{
	public function init(){
		$request = \Zend_Controller_Front::getInstance()->getRequest();
		$bookId = $request->getParam('bookId');
		$this->setMethod('get');
		$this->setAction("/admin/bookedit/jump");
		$this->addElement('text', 'pagenumber', ['style' => 'width:60px;', 'label' => 'jump to page']);
		$this->addElement('submit', 'submitwithpageno', ['label' => 'Jump', 'class' => 'btn btn-primary']);
		$this->addElement('hidden', 'bookId', ['label' => 'bookId', 'value' => $request->getParam('bookId')]);
	}
}