<?php

class Contabilidad_Form_Cobrofactura extends Zend_Form
{

    public function init()
    {
    	/*$columnas = array('idFiscales','razonSocial');
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
		$this->addElement($eFactura);*/
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Seleccionar Fecha:');
		$eFecha->setAttrib("class", "form-control");
		$eFecha->setAttrib("required","Seleccionar fecha");
		
		$ePago = new Zend_Form_Element_Text('pago');
		$ePago->setLabel('Pago $:');
		$ePago->setAttrib("class", "form-control");
		
		$eDivisa = new Zend_Form_Element_Select('idDivisa');
		$eDivisa->setLabel('Seleccione Divisa:');
		$eDivisa->setAttrib("class", "form-control");
		
		$tipoDivisaDAO = new Contabilidad_DAO_Divisa;
		$tiposDivisa = $tipoDivisaDAO->obtenerDivisas();
		
		foreach ($tiposDivisa as $tipoDivisa)
		{
			$eDivisa->addMultiOption($tipoDivisa->getIdDivisa(), $tipoDivisa->getDescripcion());		
		}
		
		$conceptoPago = Zend_Registry::get('conceptoPago');
		$eConceptoPago = new Zend_Form_Element_Select('conceptoPago');
		$eConceptoPago->setLabel('Concepto Pago:');
		$eConceptoPago->setAttrib("class", "form-control");
		$eConceptoPago->setMultiOptions($conceptoPago);
		
		$formaPago = Zend_Registry::get('formaPago');
		$eFormaPago = new Zend_Form_Element_Select('formaPago');
		$eFormaPago->setLabel('Forma Pago:');
		$eFormaPago->setAttrib("class", "form-control");
		$eFormaPago->setAttrib("required", "true");
		$eFormaPago->setMultiOptions($formaPago);
		
		$eBanco = new Zend_Form_Element_Select('idBanco');
		$eBanco->setLabel('Seleccionar Banco:');
		$eBanco->setAttrib("class", "form-control");
		
		$bancoDAO = new Contabilidad_DAO_Banco;
		$bancos = $bancoDAO->obtenerBancos();
		foreach($bancos as $banco)
		{
			$eBanco->addMultiOption($banco->getIdBanco(), $banco->getBanco());
		}			
		
		$eNumeroReferencia = new Zend_Form_Element_Text('numeroReferencia');
		$eNumeroReferencia->setLabel('Número de referencia:');
		$eNumeroReferencia->setAttrib("class", "form-control");
		$eNumeroReferencia->setAttrib("required", "true");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Aplica pago");
		$eSubmit->setAttrib("class", "btn btn-success");
		$this->addElement($eFecha);
		$this->addElement($ePago);
		$this->addElement($eDivisa);
		$this->addElement($eConceptoPago);
		$this->addElement($eFormaPago);
		$this->addElement($eBanco);
		$this->addElement($eNumeroReferencia);
		$this->addElement($eSubmit);
		
		

    }


}

