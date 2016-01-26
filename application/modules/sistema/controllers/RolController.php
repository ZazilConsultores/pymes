<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_RolController extends Zend_Controller_Action
{
	private $rolDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->rolDAO = new Sistema_DAO_Rol;
    }

    public function indexAction()
    {
        // action body
        $roles = $this->rolDAO->obtenerRoles();
		$this->view->roles = $roles;
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Sistema_Form_AltaRol;
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$rol = new Sistema_Model_Rol($datos[0]);
				$this->rolDAO->crearRol($rol);
			}
		}
    }


}



