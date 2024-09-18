<?php namespace App\Models\DbTable;
class CommentTable extends \Zend_Db_Table_Abstract
{
	protected $_name = 'comment';
	public function getName(){
		return $this->$_name;
	}
}