<?php

class Sistema_UsuarioController extends Zend_Controller_Action
{
	private $rolDAO;
	private $usuarioDAO;
	
    public function init()
    {
        /* Initialize action controller here */
        $this->rolDAO = new Sistema_DAO_Rol;
        $this->usuarioDAO = new Sistema_DAO_Usuario;
    }

    public function indexAction() {
        // action body
        $idRol = $this->getParam("idRol");
		$rol = $this->rolDAO->obtenerRol($idRol);
        $usuarios = $this->usuarioDAO->obtenerUsuarios($idRol);
		$this->view->rol = $rol;
		$this->view->usuarios = $usuarios;
		
    }

    public function altaAction() {
        // action body
        $idRol = $this->getParam("idRol");
		$rol = $this->rolDAO->obtenerRol($idRol);
        $request = $this->getRequest();
        $formulario = new Sistema_Form_AltaUsuario;
		$this->view->rol = $rol;
		$this->view->formulario = $formulario;
		if($request->isPost()) {
			if($formulario->isValid($request->getPost())){
				$cForm = $formulario->getValues();
				$datos = $cForm[0];
				$datos["idRol"] = $rol->getIdRol();
				
				$usuario = new Sistema_Model_Usuario($datos);
				try{
					$this->usuarioDAO->crearUsuario($usuario);
					$this->view->messageSuccess = "Usuario: <strong>" . $usuario->getUsuario() ."</strong> dado de alta exitosamente.";
				}catch(Exception $ex){
					$this->view->messageFail = "El usuario: <strong>" . $usuario->getUsuario() ."</strong> no pudo agregarse al sistema. Error: <strong>".$ex->getMessage()."</strong>";
				}
				//$this->_helper->redirector->gotoSimple("index", "rol", "sistema");
			}
		}
    }
	
	public function usuariosAction() {
		$idRol = $this->getParam("idRol");
		//print_r($idRol);
		$rol = $this->rolDAO->obtenerRol($idRol);
        $usuarios = $this->usuarioDAO->obtenerUsuarios($idRol);
		$this->view->rol = $rol;
		$this->view->usuarios = $usuarios;
	}


}



