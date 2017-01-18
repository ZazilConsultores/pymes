<?php
/**
 * 
 */
class App_Plugins_Acl extends Zend_Controller_Plugin_Abstract {
	
	protected $_auth;
	protected $_acl;
	protected $_action;
	protected $_controller;
	protected $_module;
	protected $_currentRole;
	
	/**
	 * 
	 */
	function __construct($acl) {
		$this->_auth = Zend_Auth::getInstance();
		$this->_acl = $acl;
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		//$this->_module = $request->getModuleName();
		//$this->_controller = $request->getControllerName();
		//$this->_action = $request->getActionName();
		$this->_init($request);
		print_r($this->_currentRole);
		if($this->_module != 'default'){
			$recurso = $request->getModuleName()."_".$request->getControllerName()."_".$request->getActionName();
			//print_r($recurso);
			
			$recursoAllControllers = $request->getModuleName();
	        $recursoAllActions = $recursoAllControllers."_".$request->getControllerName();
	        
			$recursos = $this->_acl->getResources();
	        $module = "default";
	        $loginController = "user";
	        $loginAction = "login";
	        $errorController = "error";
	        $noauthAction = "noauth";
	        $notfoundAction = "notfound";
	        
	        switch ($request->getModuleName()) {
	            case 'encuesta':
	                $module = $request->getModuleName();
	                $loginController = "home";
	                $loginAction = "index";
                    
	            	break;
				case 'default':
					
					break;
	        }
			
			if (in_array($recursoAllControllers, $recursos)) {
	            //print_r("recurso all controllers disponible");
	            if (!$this->_acl->isAllowed($this->_currentRole, $recursoAllControllers, $this->_action)) {
	                // Si el usuario con rol no esta autorizado, enviar a pagina de login para cambiar de rol
	                if('defaultGuest' == $this->_currentRole){
	                    $request->setModuleName($module);
	                    $request->setControllerName($loginController); // controller = home
	                    $request->setActionName($loginAction); // action = login
	                }else{
	                    $request->setModuleName($request->getModuleName());
	                    $request->setControllerName($errorController);
	                    $request->setActionName($noauthAction);
	                }
	            }
	        }elseif(in_array($recursoAllActions, $recursos)){
	            // Tiene acceso a todas las acciones disponibles del recurso (No hay redireccion)
	            //print_r("recurso all actions disponible: <strong>".$recursoAllActions."</strong> <br />");
	            if (!$this->_acl->isAllowed($this->_currentRole, $recursoAllActions, $this->_action)) {
	                //print_r("Usuario con rol: <strong>".$this->_currentRole."</strong> no permitido!!");
	                //print_r("<br />");
	                $request->setModuleName($module);
	                $request->setControllerName($loginController);
	                $request->setActionName($loginAction);
	            }else{
	                //print_r("Usuario con rol: <strong>".$this->_currentRole."</strong> permitido!!");
	                //print_r("<br />");
	            }
	        }
		}
		
		
	}

	protected function _init(Zend_Controller_Request_Abstract $request) {
        $this->_action = $request->getActionName();
        $this->_controller = $request->getControllerName();
        $this->_module = $request->getModuleName();
        $this->_currentRole = $this->_getCurrentUserRole();
        
    }
	
	protected function _getCurrentUserRole() {
        $role = 'defaultGuest';
        
        if ($this->_auth->hasIdentity()) {
            $authData = $this->_auth->getIdentity();
            //print_r($authData["rol"]);
            $role = isset($authData["rol"]["rol"]) ? $authData["rol"]["rol"] : 'defaultGuest';
        }
        
        return $role;
    }
}
