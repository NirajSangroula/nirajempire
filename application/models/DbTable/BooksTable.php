<?php namespace App\Models\DbTable;
class BooksTable extends \Zend_Db_Table_Abstract
{
	protected $_name = 'books';
	public function getName(){
		return $this->_name;
	}
}