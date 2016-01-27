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
		$this->view->formulario = $formulario;
		if($request->isPost()) {
			if($formulario->isValid($request->getPost())){
				$cForm = $formulario->getValues();
				$datos = $cForm[0];
				$datos["idRol"] = $rol->getIdRol();
				
				$usuario = new Sistema_Model_Usuario($datos);
				$this->usuarioDAO->crearUsuario($usuario);
				
				$this->_helper->redirector->gotoSimple("index", "rol", "sistema");
			}
		}
    }


}



