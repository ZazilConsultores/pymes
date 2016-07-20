<?php

class IndexController extends Zend_Controller_Action
{

    private $usuarioDAO = null;

    private $rolDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->usuarioDAO = new Sistema_DAO_Usuario;
		$this->rolDAO = new Sistema_DAO_Rol;
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Application_Form_Login;
		$this->view->formulario = $formulario;
		
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
			
			$values = $formulario->getValues();
 			
            // Creamos un adaptador de Zend_Auth para consultar una tabla de la base de datos
            $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
            $authAdapter ->setTableName('Usuario')              // Nombre de la tabla
                         ->setIdentityColumn('usuario')             // Campo de identificación
                         ->setCredentialColumn('password')       // Campo de contraseña
                         ->setIdentity($values['usuario'])          // Valor de identificación
                         ->setCredential($values['password']);   // Valor de contraseña
 			
            // Recogemos Zend_Auth
            $auth = Zend_Auth::getInstance();
            // Realiza la comprobación con el adaptador que hemos creado
            $result = $auth->authenticate($authAdapter);
 			
            // Si la autentificación es válida
            if ($result->isValid()) {
                // Recoge los valores de las columnas del registro de la Base de Datos y
                // los almacena como identidad en Zend_Auth, para un uso posterior
                $data = $authAdapter->getResultRowObject(null,'password');
				//$data["rol"] = $this->rolDAO->obtenerRol($data["idRol"]);
				//$data["rol"] = $this->usuarioDAO->
                $auth->getStorage()->write($data);
				
 				//print_r($data);
				$this->view->result = $result->getMessages();
                //$this->_redirect('/');
                //Zend_Registry::set('currentModule', $data["rol"]);
				//Zend_Registry::set('currentUser', $data["usuario"]);
            } else {
                $this->view->loginError = $result->getMessages();
            }
				
				//print_r($formulario->getValues());
				
				
			}
		}
    }

    public function normalizeAction()
    {
        // action body
    }

    public function logoutAction()
    {
        // action body
        $auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()){
			$auth->clearIdentity();
		}
		$this->redirect("/");
    }


}







