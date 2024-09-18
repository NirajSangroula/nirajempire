<?php
require_once('../vendor/autoload.php');
use \App\Forms\EditBook;
class OurserviceController extends Saffron_AbstractController{
	public function indexAction(){
		$db = Zend_Db::factory('Pdo_Mysql', ['host' => 'nirajempire.com', 'username' => 'root', 'password' => '', 'dbname' => 'nirajempiredb']);
		$select = $db->select()
             ->from(array('u' => 'accounts'),
                    array(''))
             ->joinInner(array('h' => 'helpful'), 'u.id = h.userid', ['bookid','Books' => 'COUNT(bookid)'])
             ->group('bookid');
		echo $select;
		var_dump($db->fetchAll($select));
	}
}