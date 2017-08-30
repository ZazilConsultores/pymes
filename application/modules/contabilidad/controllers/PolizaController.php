<?php

class Contabilidad_PolizaController extends Zend_Controller_Action
{
	private $polizaDAO = null;
    public function init()
    {
        $this->polizaDAO = new Contabilidad_DAO_Poliza;
	}
    public function indexAction()
    {
        $request = $this->getRequest();
		$formulario = new Contabilidad_Form_GeneraPoliza;
		$this->view->$formulario = $formulario;   
		if($request->isGet()){$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				try{
					//$this->polizaDAO->eliminarPoliza();
					/*$this->polizaDAO->generaGruposFacturaCliente($datos);
					$this->polizaDAO->generaGruposFacturaProveedor($datos);
					$this->polizaDAO->generacxc($datos);
					$this->polizaDAO->generacxp($datos);
					$this->polizaDAO->generacxp_Fo($datos);
					$this->polizaDAO->generacxc_Fo($datos);
					$this->polizaDAO->generacxpRemisiones($datos);
					$this->polizaDAO->genera_Cuentasxp_PagoImpuesto($datos);*/
					//$this->polizaDAO->genera_ProvisionNomina($datos);
					/*$this->polizaDAO->generaGruposNotaCredito($datos);*/
					/*$this->polizaDAO->genera_Anticipo_Clientes($datos);*/
					$this->polizaDAO->genera_Anticipo_Proveedores($datos);
					
					$this->view->messageSuccess = "Póliza generada exitosamente!!";
				}catch(exception $ex){
					
				}
			}
		}
    }

    public function generarAction()
    {
		//$this->view->formulario = $formulario;
		$request = $this->getRequest();
		$formulario = new Contabilidad_Form_GeneraPoliza;
		$this->view->$formulario = $formulario;   
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				//print_r($datos);
				try{
					//$this->polizaDAO->generacxp($datos);
					//$buscaTipoProv = $this->polizaDAO->buscaTipoProveedor($Persona,$Empresa);
					//$Persona =0;
					//$Empresa;
					//$this->polizaDAO->generaGruposFactura($datos);
					//$this->polizaDAO->generaGruposFacturaProveedor($datos);
					//$this->polizaDAO->generaGruposFacturaCliente($datos);
					//$this->polizaDAO->busca_Tipo('31', 'P');
					//es la buebaprint_r($this->polizaDAO->generaGruposFacturaProveedor($datos));
					
					//La siguiente FONDEO $this->polizaDAO->generacxp_Fo($datos);
					//$this->polizaDAO->generaGruposFacturaProveedor($datos);
					/*$this->polizaDAO->generaGruposFacturaCliente($datos);
					//$this->polizaDAO->generacxp($datos);
					$this->polizaDAO->generacxc($datos);
					/*$this->polizaDAO->generaGruposFacturaProveedor($datos);*/
					//$this->polizaDAO->generacxpRemisiones($datos);
					//$this->polizaDAO->generacxp_Fo($datos);
					//$this->polizaDAO->generacxc_Fo($datos);
					/*$this->polizaDAO->crear_Texto();
					//$buscaTipoProv = $this->polizaDAO->Busca_Tipo($Persona, $Empresa);
					//$this->polizaDAO->busca_SubCuenta($persona, $origen);
					//$this->polizaDAO->genera_Poliza_F();
					*/
				}catch(exception $ex){
					
				}
			}
		}
    }


}



