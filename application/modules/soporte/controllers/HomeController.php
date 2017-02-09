<?php

class Soporte_HomeController extends Zend_Controller_Action
{
    private $auth = null;
    private $loginDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->auth = Zend_Auth::getInstance();
        $this->loginDAO = new Soporte_DAO_Login();
    }

    public function indexAction()
    {
        // action body
    }

    public function consultaAction()
    {
        // action body
        $request = $this->getRequest();
        //$this->view->auth = $this->auth;
        
        if($request->isPost()){
            $post = $request->getPost();
            $this->loginDAO->loginByClaveorganizacion($post["claveOrganizacion"]);
            //if(is_null($var))
        }
        // Si auth no es null y tiene identity
        if (!is_null($this->auth) && $this->auth->hasIdentity()) {
            $identity = $this->auth->getIdentity();
            
            $equipoDAO = new Soporte_DAO_Equipo($identity["adapter"]);
            $ubicaciones = $equipoDAO->getUbicaciones();
            $usuarios = $equipoDAO->getUsuarios();
            
            $this->view->ubicaciones = $ubicaciones;
            $this->view->usuarios = $usuarios;
            $this->view->auth = $this->auth;
        }
    }

    public function logoutAction()
    {
        // action body
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_helper->redirector->gotoSimple("consulta", "home", "soporte");
    }

    public function loginAction()
    {
        // action body
    }


}







