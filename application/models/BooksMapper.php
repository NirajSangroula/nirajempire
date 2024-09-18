<?php namespace App\Models;
class BooksMapper extends \Saffron_BaseModel
{
	private static $_instance;
	private $tableGateway;
	public function getDbTable(){
		if($this->tableGateway == NULL){
			$this->setDbTable(new \App\Models\DbTable\BooksTable());
		}
		return $this->tableGateway;
	}

	public function setDbTable($val){
		$this->tableGateway = $val;
	}
	public function getModelName(){
    	return "App\Models\Books";
    }
    public static function getInstance(){
    	if(!self::$_instance){
    		self::$_instance = new BooksMapper();
    	}
    	return self::$_instance;
    }
    

	public static function getSelectCacheTag(){
        return 'users_select_item';
    }

    public function getBooks($authorId, $pageno, $n = 10){
    	return $this->get(array('authorid' => $authorId), [], $pageno, $n)['data'];

    }

    public function getBook($bookId){
    	return $this->getAll(['bookid' => $bookId])['data'][0];
    }
}