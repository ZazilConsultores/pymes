<?php

class Contabilidad_NotaclienteController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->notaSalidaDAO = new Contabilidad_DAO_NotaSalida;
    }

    public function indexAction()
    {
        // action body
    }

    public function nuevaAction()
    {
       $request = $this->getRequest();
       $formulario = new Contabilidad_Form_NuevaNotaCliente;
		if($request->isGet()){
			$this->view->formulario = $formulario;
			
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$notaSalidaDAO = new Contabilidad_DAO_NotaSalida;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$productos = json_decode($encabezado['productos'],TRUE);
				$contador=0;
				foreach ($productos as $producto){
					$notaSDAO->agregarProducto($encabezado, $producto);
					$contador++;
					
				}
				//print_r($datos)		
				//print_r('<br />');
				//print_r($productos);
				//print_r(json_decode($datos[0]['productos']));
				//$notaentrada = new Contabilidad_Model_Movimientos($datos);
				//$this->notaEntradaDAO->crearNotaEntrada($datos);
			}
					
			//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
    	}
    }

}





