<?php 
namespace App\Models;
class PostsMapper extends \Saffron_BaseModel
{
	private static $_instance = NULL;
	private $tableGateway;
	public function getDbTable(){
		if($this->tableGateway == NULL){
			$this->setDbTable(new \App\Models\DbTable\PostsTable());
		}
		return $this->tableGateway;
	}

	public function setDbTable($val){
		$this->tableGateway = $val;
	}
	public function getModelName(){
    	return "App\Models\Posts";
    }
    public static function getInstance(){
    	if(!self::$_instance){
    		self::$_instance = new PostsMapper();
    	}
    	return self::$_instance;
    }

	public static function getSelectCacheTag(){
        return 'users_select_item';
    }

    public function existsPageNumber($arr){
    	if(count($this->getAll($arr)['data']) > 0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    public function getPages($author, $pageno = null, $pagenumber, $n = 5){
        if($pageno !== NULL){
            return $this->get(array('authorid' => $author, 'pageno' => $pageno), [], $pagenumber, $n)['data'];
        }
    }
    public function getAllPages($author, $pagenumber, $n = 5, $order=[]){
            return $this->get(array('authorid' => $author), $order, $pagenumber, $n)['data'];
    }

    public function getPage($author, $bookId, $pageNo, $order){
            $res = $this->getAll(array('authorid' => $author, 'bookid' => $bookId, 'pageno' => $pageNo), $order)['data'];
            if(count($res) == 0){
                $arr[0] = new \App\Posts();
                return $arr;
            }
            else{
                return $res;
            }

    }

    public function getPageNo($pageId){
        return $this->getAll(['Pid' => $pageId])['data'][0]->getPageNo();
    }
    
}