<?php namespace App\Models;
class HelpfulMapper extends \Saffron_BaseModel
{
	private $tableGateway;
	static private $_instance;
	static public function getInstance(){
		if(!self::$_instance){
			self::$_instance = new HelpfulMapper();
		}
		return self::$_instance;
	}
	public function getDbTable(){
		if($this->tableGateway == NULL){
			$this->setDbTable(new \App\Models\DbTable\HelpfulTable());
		}
		return $this->tableGateway;
	}

	public function setDbTable($val){
		$this->tableGateway = $val;
	}
	public function getModelName(){
    	return "App\Models\Helpful";
    }
    public static function getSelectCacheTag(){
        return 'users_select_item';
    }
    public function hasHelped($arr){
    	if(count($this->getAll(['userid' => $arr['userid'], 'bookid' => $arr['bookid']])['data']) > 0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    public function getHelpfulCount($bookId){
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
}