<?php
require_once("../vendor/autoload.php");
class Admin_BookCreateController extends Saffron_AdminAbstractController
{
	public function indexAction(){

		$pageno = ($this->hasParam('page'))?$this->getRequest()->getParam('page'):1;
		$this->view->pageno = $pageno;
		$this->view->moduleName = $this->getRequest()->getModuleName();
			$bookForm = new App\Forms\NewBook();
			$this->view->newBook = $bookForm;
			if($this->hasParam('submitoformedit') || $this->hasParam('submitoformindex')){
				try{
					$bookId = createPost($this);
					if($this->hasParam('submitoformedit')){
						header("location:/admin/bookwrite/write?bookId=$bookId&page=2");
					}
					else{
						header("location:/admin/");
					}
					
				}
				catch(\Exception $e){
					echo $e->getMessage();
				}
			}
			
	}
}