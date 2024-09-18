<?php namespace App\Models;
class CommentMapper extends \Saffron_BaseModel
{
	private $tableGateway;
	static private $_instance;
	static public function getInstance(){
		if(!self::$_instance){
			self::$_instance = new CommentMapper();
		}
		return self::$_instance;
	}
	public function getDbTable(){
		if($this->tableGateway == NULL){
			$this->setDbTable(new \App\Models\DbTable\CommentTable());
		}
		return $this->tableGateway;
	}

	public function setDbTable($val){
		$this->tableGateway = $val;
	}
	public function getModelName(){
    	return "App\Models\Comment";
    }
    public static function getSelectCacheTag(){
        return 'users_select_item';
    }
    public function hasCommented($arr){
    	if(count($this->getAll(['userid' => $arr['userid'], 'bookid' => $arr['bookid']])['data']) > 0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    public function getCommentCount($bookId){
    	return count($this->getAll(['bookid' => $bookId])['data']);
    }
    public function getUserList($bookId){
    	$arr = [];
    	$res = $this->getAll(['bookid' => $bookId])['data'];
    	foreach($res as $value){
    		$arr[] = $value->getUserId();
    	}
    	return $arr;
    }
    public function getComments($bookId, $page = 1, $items = 10){
        return $this->get(['bookid' => $bookId], ['createdon desc'])['data'];
    }
}