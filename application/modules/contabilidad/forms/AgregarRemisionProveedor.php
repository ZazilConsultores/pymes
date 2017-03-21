<?php

class Contabilidad_Form_AgregarRemisionProveedor extends Zend_Form
{
    public function init()
    {
    	$decoratorsPresentacion = array(
			'FormElements',
			array(array('tabla'=>'Htmltag'),array('tag'=>'table','class'=>'table table-striped table-condensed')),
			array('Fieldset', array('placement'=>'prepend'))
		);
		$decoratorsElemento = array(
			'ViewHelper',
			array(array('element'=>'Htmltag'),array('tag'=>'td')),
			array('label',array('tag'=>'td')),
			array(array('row'=>'HtmlTag'), array('tag'=>'tr'))
		);
		
        $this->setAttrib("id", "nuevaRemisionProveedor");
        
        $subEncabezado = new Zend_Form_SubForm;
		$subEncabezado->setLegend("Nueva Remisión Proveedor");
		
		//$tipoInventario = Zend_Registry::get("tipoInventario");	
	
		/*$eTipoInventario = new Zend_Form_Element_hidden("tipoInventario");
		$eTipoInventario->setValue("PEPS");*/
		
		$eNumeroFolio = new Zend_Form_Element_Text('numFolio');
		$eNumeroFolio->setLabel('Número de Folio: ');
		$eNumeroFolio->setAttrib("class", "form-control");
		$eNumeroFolio->setAttrib("required", "true");
		
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tiposMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();
		
		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Tipo  Movimiento:');
		$eTipoMovto->setAttrib("class", "form-control");
		
		foreach ($tipoMovimientoDAO->obtenerTiposMovimientos()as $fila)
		{
			if ($fila->getIdTipoMovimiento()==12){
				$eTipoMovto->addMultiOption($fila->getIdTipoMovimiento(),$fila->getDescripcion());		
			}
		}
			
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Seleccionar Fecha:');
		$eFecha->setAttrib("class", "form-control");
		$eFecha->setAttrib("required","Seleccionar fecha");
		$eFecha->setAttrib("required", "true");
		
		$columnas = array('idFiscales','razonSocial');
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
    	$eEmpresa =  new Zend_Form_Element_Select('idEmpresas');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$eSucursal =  new Zend_Form_Element_Select('idSucursal');
        $eSucursal->setLabel('Sucursal: ');
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		$eSucursal->setAttrib("required", "true");
		
	
		$tablaEmpresa = new Contabilidad_DAO_NotaEntrada;
		$rowset = $tablaEmpresa->obtenerProveedores();
		
		$eProveedor = new Zend_Form_Element_Select('idCoP');
		$eProveedor->setLabel('Seleccionar Proveedor:');
		$eProveedor->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eProveedor->addMultiOption($fila->idProveedores, $fila->razonSocial);
		}
		
		/*$eDivisa = New Zend_Form_Element_Hidden('idDivisa');
		$eDivisa->setAttrib("class", "form-control");
		$eDivisa->setValue(1);*/
		
		/*$tipoDivisaDAO = new Contabilidad_DAO_Divisa;
		$tiposDivisa = $tipoDivisaDAO->obtenerDivisas();
		
		foreach ($tiposDivisa as $tipoDivisa)
		{
			$eDivisa->addMultiOption($tipoDivisa->getIdDivisa(), $tipoDivisa->getDivisa());		
		}*/
		$eProducto = new Zend_Form_Element_Hidden('productos');
		$eProducto->setAttrib("class", "form-control");
		$eProducto->setAttrib("required","true");
			
		$eProyecto = new Zend_Form_Element_Select('idProyecto');
        $eProyecto->setLabel('Seleccionar Proyecto:');
		$eProyecto->setAttrib("class", "form-control");
		$eProyecto->setRegisterInArrayValidator(FALSE);
		$eProyecto->setAttrib("required", "true");
			
		//===============================================================
		$subFormaPago = new Zend_Form_SubForm;
		$subFormaPago->setLegend("Registrar un pago en:");
		
		$eDivisa = New Zend_Form_Element_Select('idDivisa');
		$eDivisa->setLabel('Seleccionar Divisa:');
		$eDivisa->setAttrib("class", "form-control");
		
		$tipoDivisaDAO = new Contabilidad_DAO_Divisa;
		$tiposDivisa = $tipoDivisaDAO->obtenerDivisas();
		
		foreach ($tiposDivisa as $tipoDivisa)
		{
			$eDivisa->addMultiOption($tipoDivisa->getIdDivisa(), $tipoDivisa->getDivisa());		
		}
		//==================Forma de pago
		$formaPago = Zend_Registry::get('formaPago');
		$eFormaPago = new Zend_Form_Element_Select('formaLiquidar');
		$eFormaPago->setLabel('Seleccionar Forma de Pago:');
		$eFormaPago->setAttrib("class", "form-control");
		$eFormaPago->setMultiOptions($formaPago);
		
		//==================Concepto pago
		//$conceptoPago = Zend_Registry::get('conceptoPago');
		
		$eConceptoPago = new Zend_Form_Element_Select('conceptoPago');
		$eConceptoPago->setLabel('Seleccionar Concepto Pago:');
		$eConceptoPago->setAttrib("class", "form-control");
		//$eConceptoPago->setMultiOptions($conceptoPago);
		
		$conceptoPago = array(
			'LI' => 'LIQUIDACION'
		);
		foreach ($conceptoPago as $key => $value) {
			$eConceptoPago->addMultiOption($key, $value);
		}
		
		$eImportePago = new Zend_Form_Element_Text('importePago');
		$eImportePago->setLabel('Importe Pago:');
		$eImportePago->setAttrib("class", "form-control");
		$eImportePago->setAttrib("disabled", "true");
		$eImportePago->setAttrib("required", "true");
		
		$bancoDAO = new Inventario_DAO_Banco;
		$bancos = $bancoDAO->obtenerBancos();
		
		$eBanco = new Zend_Form_Element_Select('idBanco');
		$eBanco->setLabel('Seleccionar Banco:');
		$eBanco->setAttrib("class", "form-control");
		
		foreach($bancos as $banco)
		{
			$eBanco->addMultiOption($banco->getIdBanco(), $banco->getCuenta());
		}
			
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-success");
		$eSubmit->setAttrib("disabled","true");
		
		$subEncabezado->addElements(array($eNumeroFolio, $eTipoMovto,$eFecha,$eEmpresa,$eSucursal,$eProyecto,$eProveedor,$eProducto));
	
		
		$subFormaPago->addElements(array($eBanco,$eDivisa,$eConceptoPago,$eFormaPago,$eImportePago));
		$subFormaPago->setElementDecorators($decoratorsElemento);
		$subFormaPago->setDecorators($decoratorsPresentacion);
		
		$this->addSubForms(array($subEncabezado,$subFormaPago));
		$this->addElement($eSubmit);
    }
}
   


