<?php namespace App\Forms;
class HelpfulandSuggestion extends \Zend_Form
{
	// private $bookId;
	// public function setBookId($val){
	// 	$this->bookId = $val;
	// 	return $this;
	// }
	public function init(){
		$this->setMethod('post');
		$this->setAction('/admin/otherbooksview/comment');
		$this->addElement('hidden','bookid');
		$this->addElement('hidden','page');
		$this->addElement('textarea', 'comment', ['placeholder' => 'Write a comment or suggestion', 'style' => 'width:200px; height:100px']);
		$this->addElement('submit', 'helpful', ['label' => 'submit', 'class' => 'btn btn-primary']);
	}
	// public function render(Zend_View_Interface $view = NULL){

	// }

}