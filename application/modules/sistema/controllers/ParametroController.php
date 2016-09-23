<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */

class Sistema_ParametroController extends Zend_Controller_Action
{

    private $parametroDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->parametroDAO = new Sistema_DAO_Parametro();
    }

    public function indexAction()
    {
        // action body
        $parametros = $this->parametroDAO->obtenerParametros();
        $this->view->parametros = $parametros;
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
		$formulario = new Sistema_Form_AltaParametro;
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				$parametro = new Sistema_Model_Parametro($datos[0]);
				//$parametro->setHash($parametro->getHash());
				
				try{
					$this->parametroDAO->crearParametro($parametro);
					$mensaje = "Parametro <strong>" . $parametro->getParametro() . "</strong> creado exitosamente";
					$this->view->messageSuccess = $mensaje;
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
				$this->_helper->redirector->gotoSimple("index", "parametro", "sistema", array("idParametro"=>$idParametro));
			}
		}
    }

    public function adminAction()
    {
        // action body
        $idParametro = $this->getParam("idParametro");
		$parametro = $this->parametroDAO->obtenerParametro($idParametro);
        $formulario = new Sistema_Form_AltaParametro;
		$formulario->getSubForm("0")->getElement("parametro")->setValue($parametro->getParametro());
        $formulario->getSubForm("0")->getElement("descripcion")->setValue($parametro->getDescripcion());
		$formulario->getElement("submit")->setLabel("Actualizar Parametro");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		$this->view->formulario = $formulario;
		$this->view->parametro = $parametro;
    }

    public function editaAction()
    {
        // action body
        $idParametro = $this->getParam("idParametro");
		$datos = $this->getRequest()->getPost();
		unset($datos["submit"]);
		
		$this->parametroDAO->editarParametro($idParametro, $datos);
		//print_r($datos);
		$this->_helper->redirector->gotoSimple("admin", "parametro", "sistema", array("idParametro"=>$idParametro));
    }

    public function bajaAction()
    {
        // action body
    }


}

