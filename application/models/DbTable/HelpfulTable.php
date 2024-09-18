<?php namespace App\Models\DbTable;
class HelpfulTable extends \Zend_Db_Table_Abstract
{
	protected $_name = 'helpful';
	public function getName(){
		return $this->$_name;
	}
}