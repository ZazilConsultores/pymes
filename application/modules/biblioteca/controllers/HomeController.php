<?php

class Biblioteca_HomeController extends Zend_Controller_Action
{

    private $auth = null;

    private $loginDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->auth = Zend_Auth::getInstance();
        $this->loginDAO = new Biblioteca_DAO_Login();
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
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
            $temaDAO = new Biblioteca_DAO_Tema($identity["adapter"]);
            $coleccionDAO = new Biblioteca_DAO_Coleccion($identity["adapter"]);
            $clasificacionDAO = new Biblioteca_DAO_Clasificacion($identity["adapter"]);
            
            $temas = $temaDAO->getAllTemas();
            $colecciones = $coleccionDAO->getAllColecciones();
            $clasificaciones = $clasificacionDAO->getAllClasificaciones();
            
            $this->view->temas = $temas;
            $this->view->colecciones = $colecciones;
            $this->view->clasificaciones = $clasificaciones;
            $this->view->auth = $this->auth;
        }
    }

    public function logoutAction()
    {
        // action body
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_helper->redirector->gotoSimple("consulta", "home", "biblioteca");
    }


}







