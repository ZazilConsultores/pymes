<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initView() {
		$view = new Zend_View();
		
		$view->doctype('HTML5');
		$view->headTitle('General Application')->setSeparator(' :: ');
		
		return $view;
	}
	
	/**
	 * Aqui se registran los namespaces de los modulos complementarios
	 */
	protected function _initAutoloader() {
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Inventario_');
		$autoloader->registerNamespace('Encuesta_');
		$autoloader->registerNamespace('Sistema_');
		$autoloader->registerNamespace('Contabilidad_');
		$autoloader->registerNamespace('Util_');
		$autoloader->registerNamespace('My_');
		$autoloader->registerNamespace('Biblioteca_');
	}
	
	/**
	 * Aqui registramos los db adapters y los mandamos al registro de Zend
	 */
	protected function _initDb() {
		$this->bootstrap('multidb');
		$resource = $this->getPluginResource('multidb');
		
		Zend_Registry::set('multidb', $resource);
		Zend_Registry::set('dbmodgeneral', $resource->getDb('dbmodgeneral'));
		Zend_Registry::set('dbmodencuesta', $resource->getDb('dbmodencuesta'));
	}
	
	/**
	 * Aqui se inicializa el plugin de seguridad y el de control de acceso de usuarios
	 */
	protected function _initPlugins() {
		// =================================================================  >>>
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Util_Plugin_CheckAccess());
		
	}
	
	

}

