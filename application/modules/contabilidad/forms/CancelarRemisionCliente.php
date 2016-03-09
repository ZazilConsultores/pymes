<?php

class Contabilidad_Form_CancelarRemisionCliente extends Zend_Form
{

    public function init()
    {
    	$columnas = array('idFiscales','razonSocial');
		$tablaFiscales = new Contabilidad_Model_DbTable_Fiscales();
		$rowset = $tablaFiscales->obtenerColumnas($columnas);
        $eEmpresa =  new Zend_Form_Element_Select('empresa');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$eCliente =  new Zend_Form_Element_Select('cliente');
        $eCliente->setLabel('Seleccionar Cliente: ');
		$eCliente->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			
		}
		
		$eFactura =  new Zend_Form_Element_Text('factura');
        $eFactura->setLabel('Seleccionar Factura: ');
		$eFactura->setAttrib("class", "form-control");
		
    	$this->addElement($eEmpresa);
		$this->addElement($eCliente);
		$this->addElement($eFactura);
	}

}

