<?php

class Contabilidad_Form_AltaProyecto extends Zend_Form
{

    public function init()
    {
    	$this->setAttrib("id", "altaProyecto");
    	$empresaDAO = new Sistema_DAO_Empresa;
    	$bancoDAO = new Contabilidad_DAO_Banco;
    	
    	$eNumFolio = new Zend_Form_Element_Text('numeroFolio');
		$eNumFolio->setLabel('Ingresar número de Folio:');
		$eNumFolio->setAttrib("class", "form-control");
		
    	$tablasFiscales = new Inventario_DAO_Empresa();
    	$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales(); 

    	$eEmpresa = new Zend_Form_Element_Select('idEmpresas');
		$eEmpresa->setLabel("Seleccionar Empresa:");
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idEmpresas, $fila->razonSocial);
		}
		
		$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel("Sucursal:");
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
	
		$eCliente = new Zend_Form_Element_Select('idCliente');
		$eCliente->setLabel('Seleccionar Cliente:');
		$eCliente->setAttrib("class", "form-control");

		$tablaEmpresa = new Contabilidad_DAO_NotaSalida();
		$rowset = $tablaEmpresa->obtenerClientes();
		
		foreach($rowset as $fila){
			$eCliente->addMultiOption($fila->idCliente,$fila->razonSocial);
		}
					
    	$eNombreProyecto =  new Zend_Form_Element_Text('descripcion');
        $eNombreProyecto->setLabel('Ingresar Nombre Proyecto: ');
		$eNombreProyecto->setAttrib("class", "form-control");
		
	
		$eFechaApertura = new Zend_Form_Element_Text('fechaApertura');
		$eFechaApertura->setLabel('Seleccionar Fecha Inicia Proyecto:');
		$eFechaApertura->setAttrib("class", "form-control");
		
		$eFechaCierre = new Zend_Form_Element_Text('fechaCierre');
		$eFechaCierre->setLabel('Seleccionar Fecha Cierre Proyecto:');
		$eFechaCierre->setAttrib("class", "form-control");
		
				
		$eCostoInicio = new Zend_Form_Element_Text('costoInicial');
		$eCostoInicio->setLabel('Ingresar Costo Inicial:');
		$eCostoInicio->setAttrib("class", "form-control");
		$eCostoInicio->setValue("0");
		
		$eCostoFinal = new Zend_Form_Element_Text('costoFinal');
		$eCostoFinal->setLabel('Ingresar Costo Final:');
		$eCostoFinal->setAttrib("class", "form-control");
		$eCostoFinal->setValue("0");
		
		$eGanancia = new Zend_Form_Element_Text('ganancia');
		$eGanancia->setLabel('Total de Ganancia:');
		$eGanancia->setAttrib("class", "form-control");
		$eGanancia->setValue("0");
		
		$subBusqueda = new Zend_Form_SubForm;
		
		$eProyecto =  new Zend_Form_Element_Select('idProyecto');
        $eProyecto->setLabel("Seleccionar Proyecto:");
		$eProyecto->setAttrib("class", "form-control");
		$eProyecto->setRegisterInArrayValidator(FALSE);
		
		$eTipoProv =  new Zend_Form_Element_Select('idTipoProv');
		$eTipoProv->setLabel("Seleccionar Tipo Proveedor:");
		$eTipoProv->setAttrib("class", "form-control");
		$rTiposProveedor = $empresaDAO->obtenerTipoProveedor();
		foreach ($rTiposProveedor as $rTipoProveedor) {
		    $eTipoProv->addMultiOption($rTipoProveedor["idTipoProveedor"], $rTipoProveedor["descripcion"]);
		}
		
		$eBanco =  new Zend_Form_Element_Select('idBanco');
		$eBanco->setLabel("Seleccionar Banco:");
		$eBanco->setAttrib("class", "form-control");
		$eBanco->setRegisterInArrayValidator(FALSE);
		
		$eFechaInicio =  new Zend_Form_Element_Text('fechaInicial');
        $eFechaInicio->setLabel('Seleccionar Fecha Inicio: ');
		$eFechaInicio->setAttrib("class", "form-control");
		
		$eFechaFin =  new Zend_Form_Element_Text('fechaFinal');
        $eFechaFin->setLabel('Seleccionar Fecha Fin:');
		$eFechaFin->setAttrib("class", "form-control");
		
		$eBoton =  new Zend_Form_Element_Button('button');
        $eBoton->setLabel('Buscar');
		$eBoton->setAttrib("class", "btn btn-warning");
		
		
		$subBusqueda->addElements(array($eProyecto,$eTipoProv, $eBanco, $eFechaInicio,$eFechaFin, $eBoton));
		$subBusqueda->setName("busqueda");
		
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Agregar');
		$eSubmit->setAttrib("class", "btn btn-warning");
		
		$this->addElement($eNumFolio);
		$this->addElement($eEmpresa);
		$this->addElement($eSucursal);
		$this->addElement($eCliente);
		
		
		$this->addElement($eNombreProyecto);
		
		$this->addElement($eCliente);
		$this->addElement($eFechaApertura);
		$this->addElement($eFechaCierre);
		$this->addElement($eCostoInicio);
		$this->addElement($eCostoFinal);
		$this->addElement($eGanancia);
		
		$this->addSubForms(array($subBusqueda));
		
		$this->addElement($eSubmit);
		
    }
    
}
