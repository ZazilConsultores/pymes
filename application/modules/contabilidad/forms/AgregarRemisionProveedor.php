<?php

class Contabilidad_Form_AgregarRemisionProveedor extends Zend_Form
{
    public function init()
    {
        /* Encabezado nueva nota salida proveedor */
        $subEncabezado = new Zend_Form_SubForm;
		$subEncabezado->setLegend("Ingresar Datos");
		
		//$tipoInventario = Zend_Registry::get("tipoInventario");	
	
		$eTipoInventario = new Zend_Form_Element_hidden("tipoInventario");
		$eTipoInventario->setValue("UPSP");
		
		$eNumeroFactura = new Zend_Form_Element_Text('numFactura');
		$eNumeroFactura->setLabel('Folio: ');
		$eNumeroFactura->setAttrib("class", "form-control");
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tiposMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();
		
		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Seleccionar Tipo de Movimiento');
		$eTipoMovto->setAttrib("class", "form-control");
		
		foreach ($tiposMovimientos as $tipoMovimiento)
		{
			$eTipoMovto->addMultiOption($tipoMovimiento->getIdTipoMovimiento(), $tipoMovimiento->getDescripcion());		
		}
		
		$columnas = array('idFiscales','razonSocial');
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
    	$eEmpresa =  new Zend_Form_Element_Select('idEmpresa');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$columnas = array('idEmpresa','razonSocial');
		$tablaEmpresa = new Contabilidad_DAO_NotaEntrada;
		$rowset = $tablaEmpresa->obtenerProveedores();
		
		$eProveedor = new Zend_Form_Element_Select('idCoP');
		$eProveedor->setLabel('Seleccionar Proveedor');
		$eProveedor->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eProveedor->addMultiOption($fila->idEmpresa, $fila->razonSocial);
		}
		
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Fecha:');
		$eFecha->setAttrib("class", "form-control");
		$eFecha->setAttrib("required","Seleccionar fecha");
		
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
			
		$eProyecto = new Zend_Form_Element_Text('idProyecto');
        $eProyecto->setLabel('Seleccionar Proyecto');
		$eProyecto->setAttrib("class", "form-control");
		$eProyecto->setValue(1);
		
		//===============================================================
		$subFormaPago = new Zend_Form_SubForm;
		$subFormaPago->setLegend("Registrar un pago en:");
		
		$eDivisa = New Zend_Form_Element_Select('idDivisa');
		$eDivisa->setLabel('Seleccionar Divisa');
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
		
		$eImportePago = new Zend_Form_Element_Text('total');
		$eImportePago->setLabel('Importe Pago:');
		$eImportePago->setAttrib("class", "form-control");
		
		$bancoDAO = new Inventario_DAO_Banco;
		$bancos = $bancoDAO->obtenerBancos();
		
		$eBanco = new Zend_Form_Element_Select('idBanco');
		$eBanco->setLabel('Seleccionar Banco');
		$eBanco->setAttrib("class", "form-control");
		
		foreach($bancos as $banco)
		{
			$eBanco->addMultiOption($banco->getIdBanco(), $banco->getBanco());
		}
			
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-success");
		$eSubmit->setAttrib("disabled","true");
		
		$subEncabezado->addElements(array($eNumeroFactura, $eTipoMovto,$eFecha,$eEmpresa,$eProveedor,$eProyecto,$eProducto, $eTipoInventario));
		$subFormaPago->addElements(array($eBanco,$eDivisa,$eFormaPago,$eImportePago));
		$this->addSubForms(array($subEncabezado,$subFormaPago));
		//$this->addElement($eTipoInventario);
		$this->addElement($eSubmit);
    }
}
   


