<?php
require_once("functions.php");
require_once('../vendor/autoload.php');
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected $_docRoot;

	protected function _initPath()
	{
		$this->_docRoot = realpath(APPLICATION_PATH . '/../');
		Zend_Registry::set('docRoot', $this->_docRoot);
	}

	protected function _initLoaderResource()
	{
		$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
				'basePath' => $this->_docRoot . '/application',
				'namespace' => 'Saffron'
			));
		$resourceLoader->addResourceTypes(array(
			'model' => array(
				'namespace' => 'Model',
				'path' => 'models'
			)
		));
	}

	protected function _initHeadsection () {
		$this->bootstrap('View');
		$view = $this->getResource('View');
		$view->placeholder('sidebar');
	}

	protected function _initTopbar () {
		$this->bootstrap('View');
		$view = $this->getResource('View');
		$view->placeholder('topbar');
	}

	protected function _initRightmenubar () {
		$this->bootstrap('View');
		$view = $this->getResource('View');
		$view->placeholder('rightmenubar');
	}

	// protected function _initFooter () {
	// 	$this->bootstrap('View');
	// 	$view = $this->getResource('View');
	// 	$view->placeholder('footer');
	// }

	protected function _initLog()
	{
		$writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/error.log');
		return new Zend_Log($writer);
	}

	protected function _initView()
	{
		$view = new Zend_View();
		return $view;
	}

	protected function __initDisplayErrors(){
		if(isAdminLoggedIn()){
			ini_set('display_errors',true);
			error_reporting(E_ALL);
		}
	}

}