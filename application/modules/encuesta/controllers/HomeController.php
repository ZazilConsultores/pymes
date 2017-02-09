<?php

class Encuesta_HomeController extends Zend_Controller_Action
{

    private $service = null;

    private $loginDAO = null;

    private $identity = null;

    private $cicloDAO = null;

    private $docenteDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance();
        $dataIdentity = $auth->getIdentity();
        $this->identity = $dataIdentity;
        
        //print_r($this->identity["adapter"]);
        
        $this->service = new Encuesta_Util_Service;
        $this->loginDAO = new Encuesta_DAO_Login();
        //$this->cicloDAO = new Encuesta_DAO_Ciclo($this->identity["adapter"]);
        //$this->docenteDAO = new Encuesta_DAO_Registro($this->identity["adapter"]);
        $this->_helper->layout->setLayout('homeEncuesta');
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        $request = $this->getRequest();
        $loginDAO = $this->loginDAO;
        $this->_helper->layout->setLayout('emptyEncuesta');
        // action body
        if($request->isPost()){
            $datos = $request->getPost();
            $organizacion = $loginDAO->getOrganizacionByClave($datos["claveOrganizacion"]);
            
            /*
            print_r($datos);
            print_r("<br />");
            print_r($organizacion);
            print_r("<br />");
            print_r($subscripcion);
            print_r("<br />");
            $sha1Pass = sha1($datos["password"]);
            print_r($sha1Pass);
            */
            //echo hash("sha1", $datos["password"]);
            
            $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Registry::get('dbbaseencuesta'),"Usuario","nickname","password",'SHA1(?)');
            $authAdapter->setIdentity($datos["usuario"])->setCredential($datos["password"]);
            $auth = Zend_Auth::getInstance();
            $resultado = $auth->authenticate($authAdapter);
            //print_r($resultado->getMessages());
             
            
            if ($resultado->isValid()) {
                $data = $authAdapter->getResultRowObject(null,'password');
                $subscripcion = $loginDAO->getSubscripcion($organizacion["idOrganizacion"]);
                print_r($subscripcion);
                $adapter = $subscripcion["adapter"];
                //unset($subscripcion["adapter"]);
                // Creamos la conexion a la bd en la que vamos a operar
                $currentDbConnection = array();
                //$currentDbConnection["adapter"] = $subscripcion["adapter"];
                $currentDbConnection["host"] = $subscripcion["host"];
                $currentDbConnection["username"] = $subscripcion["username"];
                $currentDbConnection["password"] = $subscripcion["password"];
                $currentDbConnection["dbname"] = $subscripcion["dbname"];
                //$currentDbConnection["charset"] = $subscripcion["charset"];
                //$adapter = new Zend_Db_Adapter_Abstract($currentDbConnection);
                print_r("<br /><br />");
                print_r($currentDbConnection);
                print_r("<br /><br />");
                //Zend_Registry::set('dbmodencuesta', $adapter);
                //print_r(Zend_Registry::get('dbmodencuesta'));
                $db = Zend_Db::factory(strtoupper($adapter),$currentDbConnection);
                //Zend_Registry::set('dbmodencuesta', $db);
                //$dbAdapter = Zend_Registry::get('dbmodencuesta');
                print_r("<br /><br />");
                print_r($db);
                //print_r($data);
                $userInfo = array();
                $userInfo["user"] = $data;
                $userInfo["rol"] = $this->loginDAO->getRolbyId($data->idRol);
                $userInfo["organizacion"] = $organizacion;
                $userInfo["adapter"] = $db;
                //$userInfo["organizacion"] = $this->loginDAO->getOrganizacionByClave($datos["claveOrganizacion"]);
                $auth->getStorage()->write($userInfo);
                $this->_helper->redirector->gotoSimple("index", "dashboard", "encuesta");
            }else{
                $this->view->loginErrorMessages = $resultado->getMessages();
            }
            /*$namespace = $this->service->getNamespace($datos);
            $usuario = $this->loginDAO->getUsuario($datos);
            $userInfo = array();
            $userInfo["user"] = $usuario;
            $userInfo["rol"] = $this->loginDAO->getRolUsuario($usuario);
            $userInfo["organizacion"] = $this->loginDAO->getOrganizacionByClave($datos["claveOrganizacion"]); 
            //$userInfo["namespace"] = $namespace;
            //print_r($this->service->getNamespace($datos));
            
            $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Registry::get('dbmodencuesta'),"Usuario","nickname","password");
            $authAdapter->setIdentity($datos["usuario"])->setCredential($datos["password"]);
            $auth = Zend_Auth::getInstance();
            //$auth->setStorage(new Zend_Auth_Storage_Session($namespace));
            $resultado = $auth->authenticate($authAdapter);
            
            if($resultado->isValid()){
                $data = $authAdapter->getResultRowObject(null,'password');
                $auth->getStorage()->write($userInfo);
                $this->view->loginResultMessages = $resultado->getMessages();
                //Zend_Registry::set("userInfo", $userInfo);
                
                $this->_helper->redirector->gotoSimple("index", "dashboard", "encuesta");
            }else{
                $this->view->loginErrorMessages = $resultado->getMessages();
            }
            */
        }
        
    }

    public function requireAction()
    {
        // action body
        $request = $this->getRequest();
        if($request->isPost()){
            $datos = $request->getPost();
            print_r($datos);
        }
    }

    public function joinAction()
    {
        // action body
    }

    public function resultsAction()
    {
        // action body
        $request = $this->getRequest();
        $auth = Zend_Auth::getInstance();
        //print_r($request->getPost());
        //print_r("<br />");
        //print_r($this->identity);
        if ($request->isPost()) {
            $post = $request->getPost();
            $this->loginDAO->loginByClaveOrganizacion($post["claveOrganizacion"]);
            $identity = $auth->getIdentity();
            
            //$this->cicloDAO = new Encuesta_DAO_Ciclo($identity["adapter"]);
            //$this->docenteDAO = new Encuesta_DAO_Registro($identity["adapter"]);
            //print_r("Logueado");
        }
        //$auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            //print_r("Auth con identidad");
            $identity = $auth->getIdentity();
            //print_r($identity["adapter"]);
            //$this->cicloDAO = new Encuesta_DAO_Ciclo($identity["adapter"]);
            //$this->docenteDAO = new Encuesta_DAO_Registro($identity["adapter"]);
            $cicloDAO = new Encuesta_DAO_Ciclo($identity["adapter"]);
            $docenteDAO = new Encuesta_DAO_Registro($identity["adapter"]);
            
            $ciclosEscolares = $cicloDAO->getAllCiclos();
            $cicloEscolar = $cicloDAO->getCurrentCiclo();
            $docentes = $docenteDAO->getDocentesByIdCiclo($cicloEscolar->getIdCiclo());
            
            $this->view->ciclosEscolares = $ciclosEscolares;
            $this->view->docentes = $docentes;
        }
        
        
        
    }

    public function logoutAction()
    {
        // action body
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_helper->redirector->gotoSimple("results", "home", "encuesta");
    }


}











