<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initView() {
		$view = new Zend_View();
		return $view;
	}
	
	protected function _initAutoloader() {
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Inventario_');
		$autoloader->registerNamespace('Encuesta_');
		$autoloader->registerNamespace('Sistema_');
		$autoloader->registerNamespace('Contabilidad_');
		$autoloader->registerNamespace('Util_');
		$autoloader->registerNamespace('My_');
	}
	
	protected function _initPlugins() {
		// =================================================================  >>>
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Util_Plugin_CheckAccess());
		// =================================================================  >>>
		$view = $this->getResource('view');
		
		$view->doctype('HTML5');
		
		$view->headTitle('General Application')->setSeparator(' :: ');
	}

}

