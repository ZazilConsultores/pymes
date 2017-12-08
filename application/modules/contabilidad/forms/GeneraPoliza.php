<?php

class Contabilidad_Form_GeneraPoliza extends Zend_Form
{

    public function init()
    {
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
		$eEmpresa = new Zend_Form_Element_Select('idEmpresas');
		$eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idEmpresas, $fila->razonSocial);
		}
		
		$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel('Sucursal:');
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setAttrib("required", "true");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		
		$eFechaInicio = new Zend_Form_Element_Text('fechaInicial');
		$eFechaInicio->setLabel('Seleccionar fecha inicia:');
		$eFechaInicio->setAttrib("class", "form-control");
		$eFechaInicio->setAttrib("required","true");
		
		$eFechaFin = new Zend_Form_Element_Text('fechaFinal');
		$eFechaFin->setLabel('Seleccionar fecha fin:');
		$eFechaFin->setAttrib("class", "form-control");
		$eFechaFin->setAttrib("required","true");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Generar");
		$eSubmit->setAttrib("class", "btn btn-success");
	
		 
		$this->addElement($eEmpresa);
		$this->addElement($eSucursal);
		$this->addElement($eFechaInicio);
		$this->addElement($eFechaFin);
		$this->addElement($eSubmit);
		//$this->addElement($eFechaFin);
		
    }
}

