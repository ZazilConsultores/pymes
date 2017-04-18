<?php

class Contabilidad_Form_PagosProveedor extends Zend_Form
{

    public function init()
    {
    	$subBusqueda = new Zend_Form_SubForm();
		
    	$tablaFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablaFiscales->obtenerInformacionEmpresasIdFiscales();
		
		$eEmpresa = new Zend_Form_Element_Select('idEmpresas');     
    	$eEmpresa->setLabel('Seleccionar Empresa');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach($rowset as $fila){
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);	
		}
		
		$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel('Sucursal:');
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		$eSucursal->setAttrib("required", "true");
		
		$tablaEmpresa = new Contabilidad_DAO_NotaEntrada;
		$rowset = $tablaEmpresa->obtenerProveedores();
		
		$eProveedor = new Zend_Form_Element_Select('idCoP');
		$eProveedor->setLabel('Seleccionar Proveedor:');
		$eProveedor->setAttrib("class", "form-control");
		
		
		foreach ($rowset as $fila) {
			$eProveedor->addMultiOption($fila->idEmpresa, $fila->razonSocial);	
		}
		
		$eNumeroFactura = new Zend_Form_Element_Text('numFactura');
		$eNumeroFactura->setLabel('Ingresar Numero Factura');
		$eNumeroFactura->setAttrib("class", "form-control");
		$eNumeroFactura->setAttrib("required", "true");
		$eNumeroFactura->setAttrib("placeholder", "Numero Factura");

		$subBusqueda->addElements(array($eEmpresa, $eSucursal, $eProveedor, $eNumeroFactura));
	
		$subAplicar = new Zend_Form_SubForm();
				
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
		
		$bancoDAO = new Inventario_DAO_Banco;
		$bancos = $bancoDAO->obtenerBancos();
		foreach($bancos as $banco)
		{
			$eBanco->addMultiOption($banco->getIdBanco(), $banco->getCuenta());
		}			
		
		$eNumeroReferencia = new Zend_Form_Element_Text('numeroReferencia');
		$eNumeroReferencia->setLabel('Número de referencia:');
		$eNumeroReferencia->setAttrib("class", "form-control");
		$eNumeroReferencia->setAttrib("required", "true");
		
		$subAplicar->addElements(array($ePago, $eDivisa, $eConceptoPago, $eFormaPago, $eBanco, $eNumeroReferencia));
		$this->addElement($eFecha);
		$this->addSubForms(array($subBusqueda,$subAplicar));
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Buscar Empresa");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eSubmit);
		
    }


}

