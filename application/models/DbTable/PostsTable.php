<?php namespace App\Models\DbTable;
class PostsTable extends \Zend_Db_Table_Abstract
{
	protected $_name = 'posts';
	public function getName(){
		return $this->_name;
	}
}