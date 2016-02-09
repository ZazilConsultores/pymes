<?php

class Contabilidad_Form_Cobrofactura extends Zend_Form
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
		
		// facturas sin co
		
		$eFactura =  new Zend_Form_Element_Select('factura');
        $eFactura->setLabel('Numero Factura: ');
		$eFactura->setAttrib("class", "form-control");
		
		$this->addElement($eEmpresa);
		$this->addElement($eCliente);
		$this->addElement($eFactura);
		

    }


}

