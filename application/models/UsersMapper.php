<?php namespace App\Models;
use DbTable\UsersTable;
use Users as UsersObj;
class UsersMapper extends \Saffron_BaseModel{
	private static $_instance = NULL;
	private $tableGateway;

	public function getDbTable(){
		return $this->getTableGateway();
	}
    public function setDbTable($dbTable){
    	$this->setTableGateway($dbTable);
    }
    public function getModelName(){
    	return "App\Models\Users";
    }

	public static function getInstance(){
		if(self::$_instance == NULL){
			self::$_instance = new UsersMapper;
		}
		return self::$_instance;
	}

	public function setTableGateway(\Zend_Db_Table_Abstract $var){
		$this->tableGateway = $var;
		$this->_dbTable = $var;
	}

	public function getTableGateway(){
		if($this->tableGateway == NULL){
			$this->setTableGateway(new \App\Models\DbTable\UsersTable());
		}
		return $this->tableGateway;
	}
	public function existsUserId($id){
		$ret = false;
		$results = $this->getTableGateway()->fetchAll()->toArray();
		foreach($results as $key => $res){
			if($res['userid'] == $id){
				$ret = true;
			}
		}
		return $ret;
	}

	public function insertRecord(\App\Models\Users $obj){
		$arr = array('name' => $obj->getName(),
						'email' => $obj->getEmail(),
						'password' => $obj->getPassword(),
						'contactNo' => $obj->getContactNo(),
						'dateOfBirth' => $obj->getDateOfBirth(),
						'accountType' => $obj->getAccountType()
					);
		try{
			$this->getTableGateway()->insert($arr);
		}
		catch(\Zend_Db_Adapter_Exception $e){
			throw new Exception($e->getMessage());
		}
		
	}

	public function recordExists($obj){

		if(count($this->getAll(array('email' => $obj->getEmail(), 'password' => $obj->getPassword()))['data']) === 1){
			return true;
		}
		else{
			return false;
		}


	}

	public function getAccountType($obj){
		return $this->getAll(array('email' => $obj->getEmail(), 'password' => $obj->getPassword()))['data'][0]->getAccountType();
	}

	public static function getSelectCacheTag(){
        return 'users_select_item';
    }

    public function updateSession($obj){
    	var_dump($obj);die;
    	$this->getDbTable()->update(['session' => $obj->getSession()],array('email' => $obj->getEmail(), 'password' => $obj->getPassword()));

    }


    public function getARow($obj){
    	return $this->getAll(['email' => $obj->getEmail(), 'password' => $obj->getPassword()])['data'][0];
    }
    
    public function getUserName($arr){
    	return $this->getAll($arr)['data'][0]->getName();
    }

}