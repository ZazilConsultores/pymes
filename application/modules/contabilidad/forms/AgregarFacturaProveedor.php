<?php

class Contabilidad_Form_AgregarFacturaProveedor extends Zend_Form

{
    public function init()
    {

    	$decoratorsPresentacion = array(
			'FormElements',
			array(array('tabla'=>'Htmltag'),array('tag'=>'table', 'class'=>'table table-striped table-condensed')),
			array('Fieldset', array('placement'=>'prepend'))

		);

		$decoratorsElemento =array(
			/*Decoradores*/
			'ViewHelper',
			array(array('element'=>'HtmlTag'), array('tag'=>'td')),
			array('label', array('tag'=>'td')),
			array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

		);

		$this->setAttrib("id", "agregarFacturaProveedor");
		$subEncabezado = new Zend_Form_SubForm;
		$subEncabezado->setLegend("Nueva Factura Proveedor");


		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tiposMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();

		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Tipo Movimiento:');
		$eTipoMovto->setAttrib("class", "form-control");

	

		foreach ($tipoMovimientoDAO->obtenerTiposMovimientos() as $fila) {

			if ($fila->getIdTipoMovimiento() == "4") {

				$eTipoMovto->addMultiOption($fila->getIdTipoMovimiento(), $fila->getDescripcion());

			}

		

		}

		

		$eNumeroFactura = new Zend_Form_Element_Text('numeroFactura');

		$eNumeroFactura->setLabel('Número de Factura: ');

		$eNumeroFactura->setAttrib("class", "form-control");

		$eNumeroFactura->setAttrib("required", "true");

		

		$eFolioFiscal = new Zend_Form_Element_Text('folioFiscal');

		$eFolioFiscal->setLabel('Folio Fiscal: ');
		$eFolioFiscal->setAttrib("minlength", "32");
		$eFolioFiscal->setAttrib("maxlength", "32" );
		$eFolioFiscal->setAttrib("class", "form-control");
		
		$eFolioFiscal->setAttrib("required", "true");
		

		

		$tablasFiscales = new Inventario_DAO_Empresa();

		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();

		

    	$eEmpresa =  new Zend_Form_Element_Select('idEmpresas');

        $eEmpresa->setLabel('Seleccionar Empresa: ');

		$eEmpresa->setAttrib("class", "form-control");

		

		foreach ($rowset as $fila) {

			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);

		}

		

		$eSucursal = new Zend_Form_Element_Select('idSucursal');

		$eSucursal->setLabel("Sucursal: ");

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

		

		$eProyecto = new Zend_Form_Element_Select('idProyecto');

        $eProyecto->setLabel('Seleccionar Proyecto:');

		$eProyecto->setAttrib("class", "form-control");

		$eProyecto->setRegisterInArrayValidator(FALSE);

		$eProyecto->setAttrib("required", "true");

			

		$tablaEmpresa = new Contabilidad_DAO_NotaEntrada;

		$rowset = $tablaEmpresa->obtenerProveedores();

		

		$eProveedor = new Zend_Form_Element_Select('idCoP');

		$eProveedor->setLabel('Seleccionar Proveedor:');

		$eProveedor->setAttrib("class", "form-control");

		

		foreach ($rowset as $fila) {

			$eProveedor->addMultiOption($fila->idEmpresa, $fila->razonSocial);

		}

		

		$eFecha = new Zend_Form_Element_Text('fecha');

		$eFecha->setLabel('Seleccionar Fecha:');

		$eFecha->setAttrib("class", "form-control");

		$eFecha->setAttrib("required","Seleccionar fecha");

		

		$eProducto = new Zend_Form_Element_Hidden('productos');

		$eProducto->setAttrib("class", "form-control");

		$eProducto->setAttrib("required","true");
		
		
		
		/*idProducto*/
		$eidProducto = new Zend_Form_Element_Hidden('idProducto');
		$eidProducto->setAttrib("class", "form-control");
		$eidProducto->setAttrib("required","true");
		

		$subEncabezado->addElements(array($eTipoMovto,$eNumeroFactura,$eFolioFiscal,$eEmpresa,$eSucursal,$eProyecto,$eProveedor,$eFecha, $eProducto,$eidProducto));

		//$subEncabezado->setElementDecorators($decoratorsElementoEncabezado);

		$subEncabezado->setElementDecorators($decoratorsElemento);

		$subEncabezado->setDecorators($decoratorsPresentacion);

		

		//=========================================================================>>

		$subFormaPago = new Zend_Form_SubForm;

		$subFormaPago->setLegend("Forma de Pago");

		$eImporte = new Zend_Form_Element_Hidden('importes');
		$eImporte->setAttrib("class", "form-control");
		$eImporte->setAttrib("required","true");

		$tipoDivisaDAO = new Contabilidad_DAO_Divisa;

		$tiposDivisas = $tipoDivisaDAO->obtenerDivisas();

		

		$eDivisa = New Zend_Form_Element_Select('idDivisa');

		$eDivisa->setLabel('Seleccionar Divisa:');

		$eDivisa->setAttrib("class", "form-control");

		foreach ($tiposDivisas as $tipoDivisa) {

			$eDivisa->addMultiOption($tipoDivisa->getIdDivisa(), $tipoDivisa->getDescripcion());

		}

		

		$ePagada = new Zend_Form_Element_Checkbox('Pagada');

		$ePagada->setLabel("Pagada en una sola exhibición:");
		//$ePagada->setAttrib("", $value);
		//print_r($expression)
		/*$ePagada->setOptions(array(

		'multiOptions' => array(

		'0'=>'SI',

		'1'=>'NO')));

		$ePagada->setOptions(array(

		'0'=>'0','1'=>'1'));*/

		

	   	$eIva =  new Zend_Form_Element_Text('iva');

        $eIva->setLabel('Editar Iva: ');

		$eIva->setAttrib("class", "form-control");

		$eIva->setAttrib("required", "true");

		

		$ePagos = new Zend_Form_Element_Text('pagos');

		$ePagos->setLabel('Importe Pago:');
	

		$ePagos->setAttrib("class", "form-control");

		//$ePagos->setAttrib("required", "true");

		//$ePagos->setAttrib("disabled", "true");

		

		/*$conceptoPago = Zend_Registry::get('conceptoPago');

		$eConceptoPago = new Zend_Form_Element_Select('conceptoPago');

		$eConceptoPago->setLabel("Seleccionar Forma Pago: ");

		$eConceptoPago->setAttrib("class", "form-control");

		$eConceptoPago->setMultiOptions($conceptoPago);

		$eConceptoPago->setAttrib("required", "true");*/

		

		

		$eCondicionesPago = new Zend_Form_Element_Select('condiconesPago');

		$eCondicionesPago->setLabel('Condiciones Pago');

		$eCondicionesPago->setAttrib("class", "form-control");

		

		$formaPago = Zend_Registry::get('formaPago');

		$eFormaPago = new Zend_Form_Element_Select('formaLiquidar');

		$eFormaPago->setLabel('FormaPago:');

		$eFormaPago->setAttrib("class", "form-control");

		$eFormaPago->setMultiOptions($formaPago);

		

		

		$eNumReferencia = new Zend_Form_Element_Text('numeroReferencia');

		$eNumReferencia->setLabel('Ingresar Número de Referencia:');

		$eNumReferencia->setAttrib("class", "form-control");

		$eNumReferencia->setAttrib("required", "true");

		

		$bancoDAO = new Inventario_DAO_Banco;

		$bancos = $bancoDAO->obtenerBancos();

		

		$eBanco = new Zend_Form_Element_Select('idBanco');

		$eBanco->setLabel('Seleccionar Banco:');

		$eBanco->setAttrib("class", "form-control");

		

		foreach($bancos as $banco)

		{

			$eBanco->addMultiOption($banco->getIdBanco(), $banco->getCuenta());

		}

		
		

		$subFormaPago->addElements(array($eDivisa,$ePagada,$ePagos,/*$eConceptoPago,*/$eFormaPago,$eBanco,$eNumReferencia,$eImporte));

		$subFormaPago->setElementDecorators($decoratorsElemento);

		$subFormaPago->setDecorators($decoratorsPresentacion);

		

		/* SubForm impuestos*/

		$subImpuestos = new Zend_Form_SubForm;

		$subImpuestos->setLegend("Impuestos");

		

        

        $eIva = new Zend_Form_Element_Text('ivaImp');

		$eIva->setLabel('IVA:');

		$eIva->setAttrib("class", "form-control");

		$eIva->setAttrib("required","true");

		

		$eISH = new Zend_Form_Element_Text('ish');

		$eISH->setLabel('ISH:');

		$eISH->setAttrib("class", "form-control");

		$eISH->setAttrib("required","true");

		

		$eISR = new Zend_Form_Element('isr');  

		$eISR->setLabel('ISR:');

		$eISR->setAttrib("class", "form-control");

		$eISR->setAttrib("required","true");

		

		$eIEPS = new Zend_Form_Element_Text('ieps');

		$eIEPS->setLabel('IEPS:');

		$eIEPS->setAttrib("class", "form-control");

		$eIEPS->setAttrib("required","true");

		

		$eDescuento = new Zend_Form_Element_Text('descuento');

		$eDescuento->setLabel('Descuento:');

		$eDescuento->setAttrib("class", "form-control");

		$eDescuento->setAttrib("required","true");

		

		$eSubtotal = new Zend_Form_Element_Text('subtotal');

		$eSubtotal->setLabel('Subtotal:');

		$eSubtotal->setAttrib("class", "form-control");

		$eSubtotal->setAttrib("required","true");

		

		$eTotal = new Zend_Form_Element_Text('total');

		$eTotal->setLabel('Total:');

		$eTotal->setAttrib("class", "form-control");

		$eTotal->setAttrib("required","true");

		

		$subImpuestos->addElements(array($eIva,$eISH,$eISR,$eIEPS,$eDescuento,$eSubtotal,$eTotal));

		$subImpuestos->setElementDecorators($decoratorsElemento);

		$subImpuestos->setDecorators($decoratorsPresentacion);

		$eSubmit =  new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");

		$eSubmit->setAttrib("class","btn btn-success");

		

		$this->addSubForms(array($subEncabezado, $subFormaPago));

		

		$this->addElement($eSubmit); 

			

    }

}





