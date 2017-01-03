<?php
/**
 * 
 */
class App_Plugins_Acl extends Zend_Controller_Plugin_Abstract {
	
	private $aclObject;
	
	/**
	 * 
	 */
	function __construct($acl) {
		$this->aclObject = $acl;
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		$recurso = $request->getModuleName()."_".$request->getControllerName()."_".$request->getActionName();
		//print_r($recurso);
	}
}
