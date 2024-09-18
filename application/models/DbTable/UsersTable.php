<?php namespace App\Models\DbTable;
class UsersTable extends \Zend_Db_Table_Abstract
{
	protected $_name = "accounts";
	public function getName(){
		return $this->_name;
	}
}