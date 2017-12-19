<?php
/**
 * 
 * @author EnginnerRodriguez
 *
 */
class IndexController extends Zend_Controller_Action
{
    private $appDAO = null;

    // private $usuarioDAO = null;
    // private $rolDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->setLayout('homePymes');
        
        $this->appDAO = new App_Data_DAO_Login();
        
        // $this->usuarioDAO = new Sistema_DAO_Usuario;
		// $this->rolDAO = new Sistema_DAO_Rol;
    }

    public function indexAction()
    {
        // action body
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $datos = $request->getPost();
            print_r($datos);
            
            $this->appDAO->login($datos);
        }
    }

    public function loginAction()
    {
        // action body
        $request = $this->getRequest();
        //$formulario = new Application_Form_Login;
		//$this->view->formulario = $formulario;
		
        if ($request->isPost()) {
            $datos = $request->getPost();
            print_r($datos);
            
            $this->appDAO->login($datos);
        }
        
        /*
		if($request->isPost()){
		    $post = $request->getPost();
            //print_r($post);
            
            $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Registry::get('dbmodgeneral'));
            $authAdapter ->setTableName('Usuario')              // Nombre de la tabla
                         ->setIdentityColumn('usuario')             // Campo de identificación
                         ->setCredentialColumn('password')       // Campo de contraseña
                         ->setIdentity($post['usuario'])          // Valor de identificación
                         ->setCredential($post['password']);   // Valor de contraseña
            // Recogemos Zend_Auth
            $auth = Zend_Auth::getInstance();
            // Realiza la comprobación con el adaptador que hemos creado
            $result = $auth->authenticate($authAdapter);
            
            if ($result->isValid()) {
                // Recoge los valores de las columnas del registro de la Base de Datos y
                // los almacena como identidad en Zend_Auth, para un uso posterior
                $data = $authAdapter->getResultRowObject(null,'password');
                //$data["rol"] = $this->rolDAO->obtenerRol($data["idRol"]);
                //$data["rol"] = $this->usuarioDAO->
                $auth->getStorage()->write($data);
                
                //print_r($data);
                $this->view->result = $result->getMessages();
                //$this->forward("perfil","usuario","default",array("usr"=>$auth->getStorage()->read()->idUsuario));
                $this->_helper->redirector->gotoSimple("perfil", "usuario", "default");
                //$this->_redirect('/');
                //Zend_Registry::set('currentModule', $data["rol"]);
                //Zend_Registry::set('currentUser', $data["usuario"]);
            } else {
                //$this->view->loginError = $result->getMessages();
                $this->_helper->redirector->gotoSimple("index", "index", "default");
            }
		}else{
		    //LogOut and Redirect to Main Page
		    $this->_helper->redirector->gotoSimple("index", "index", "default");
		}
		*/
    }

    public function normalizeAction()
    {
        // action body
    }
    
}
