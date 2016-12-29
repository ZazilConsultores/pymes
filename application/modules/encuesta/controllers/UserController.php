<?php

class Encuesta_UserController extends Zend_Controller_Action
{
    private $auth = null;

    public function init()
    {
        /* Initialize action controller here */
        //$this->_helper->layout->setLayout('empty');
        $this->auth = Zend_Auth::getInstance();
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        // action body
    }

    public function profileAction()
    {
        // action body
    }

    public function logoutAction()
    {
        // action body
        $this->auth->clearIdentity();
        $this->_helper->redirector->gotoSimple("index", "home", "encuesta");
    }
}
