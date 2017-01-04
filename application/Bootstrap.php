<?php
/**
 * 
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	
	
	protected function _initAclControl() {
    	$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/acl.ini", "production");
        //$resources = $this->bootstrap('acl')->getResource('acl');
        Zend_Registry::set('acl', $config);
    }
	
	/**
	 * Aqui se registran los namespaces de los modulos complementarios
	 */
	protected function _initAutoloader() {
		$autoloader = Zend_Loader_Autoloader::getInstance();
		
		$autoloader->registerNamespace('Zend_');
		$autoloader->registerNamespace('App_');
		$autoloader->registerNamespace('My_');
		$autoloader->registerNamespace('Modules_');
		
		$autoloader->registerNamespace('Biblioteca_');
		$autoloader->registerNamespace('Contabilidad_');
        $autoloader->registerNamespace('Encuesta_');
        $autoloader->registerNamespace('Inventario_');
		$autoloader->registerNamespace('Sistema_');
		//$autoloader->registerNamespace('Util_');
	}
	
	/**
	 * Aqui registramos los db adapters y los mandamos al registro de Zend
	 */
	protected function _initDb() {
		$this->bootstrap('multidb');
		$resource = $this->getPluginResource('multidb');

		Zend_Registry::set('multidb', $resource);
		Zend_Registry::set('dbgenerale', $resource->getDb('dbgenerale'));
		Zend_Registry::set('dbmodgeneral', $resource->getDb('dbmodgeneral'));
		//Zend_Registry::set('dbmodencuesta', $resource->getDb('dbmodencuesta'));
        Zend_Registry::set('dbbaseencuesta', $resource->getDb('dbbaseencuesta')); //dbgenerale
	}
	
	/**
	 * Aqui se inicializa el plugin de seguridad y el de control de acceso de usuarios
	 */
	protected function _initPlugins() {
		// =================================================================  >>>
		$front = Zend_Controller_Front::getInstance();
		// Instanciamos el Plugin de Layouts
		$moduleNames = array('biblioteca','encuesta','inventario','contabilidad','sistema');
		$front->registerPlugin(new App_Plugins_Layout($moduleNames));
		// Instanciamos el plugin ACL
		$recursos = new App_Security_Recurso();
		//$front->registerPlugin(new App_Plugins_Acl($recursos->getAcl()));
		//$front->registerPlugin(new Modules_Controller_Plugin_RequestedModuleLayoutLoader());
		//$front->registerPlugin(new Encuesta_Plugin_Acl($recursos->getAcl()));
	}
	
	/**
     * Aqui se inicializa una session por default, posteriormente validaremos al usuario
     */
    protected function _initSession(){
        Zend_Session::start();
    }
	
	protected function _initView() {
		$view = new Zend_View();

		$view->doctype('HTML5');
		$view->headTitle('General Application')->setSeparator(' :: ');

		return $view;
	}
	
	
}
