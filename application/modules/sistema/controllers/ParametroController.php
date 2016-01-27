<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_ParametroController extends Zend_Controller_Action
{
	private $parametroDAO;
	
    public function init()
    {
        /* Initialize action controller here */
        $this->parametroDAO = new Inventario_DAO_Parametro;
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
				$parametro->setHash($parametro->getHash());
				
				try{
					$this->parametroDAO->crearParametro($parametro);
					$mensaje = "Parametro <strong>" . $parametro->getParametro() . "</strong> creado exitosamente";
					$this->view->messageSuccess = $mensaje;
				}catch(Util_Exception_BussinessException $ex){
					$this->view->messageFail = $ex->getMessage();
				}
			}
		}
    }


}



