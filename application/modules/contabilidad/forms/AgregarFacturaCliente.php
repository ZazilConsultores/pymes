<?php

class Contabilidad_Form_AgregarFacturaCliente extends Zend_Form
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
		
    	$this->setAttrib("id", "agregarFacturaCliente");
		$subEncabezado = new Zend_Form_SubForm;
		$subEncabezado->setLegend('Nueva Factura Cliente');
		
		$tipoMovimiento = new Contabilidad_DAO_TipoMovimiento;
		$tiposMovimientos =$tipoMovimiento->obtenerTiposMovimientos();
		
		$eTipoMovto =  new Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel("Tipo Movimiento:");
		$eTipoMovto->setAttrib("class", "form-control");
		foreach($tiposMovimientos AS $movimiento){
			if($movimiento->getIdTipoMovimiento()=="2"){
				$eTipoMovto->addMultiOption($movimiento->getIdTipoMovimiento(),$movimiento->getDescripcion());
			}	
		}
    	
		$eNumFactura = new Zend_Form_Element_Text('numeroFactura');
		$eNumFactura->setLabel('Número de Factura: ');
		$eNumFactura->setAttrib("class", "form-control");
		$eNumFactura->setAttrib("enable","false");
		
		$eFolioFiscal = new Zend_Form_Element_Text('folioFiscal');
		$eFolioFiscal->setLabel('Folio Fiscal: ');
		$eFolioFiscal->setAttrib("minlength", "32");
		$eFolioFiscal->setAttrib("maxlength", "32" );
		$eFolioFiscal->setAttrib("class", "form-control");
		
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
		$eEmpresa = new Zend_Form_Element_Select('idEmpresas');
		$eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
    	$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel("Sucursal: ");
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		
		$eProyecto =  new Zend_Form_Element_Select('idProyecto');
        $eProyecto->setLabel("Seleccionar Proyecto:");
		$eProyecto->setAttrib("class", "form-control");
		$eProyecto->setRegisterInArrayValidator(FALSE);
		
    	$tablaEmpresa = new Contabilidad_DAO_NotaSalida;
		$rowset = $tablaEmpresa->obtenerClientes();
		
		$eCliente =  new Zend_Form_Element_Select('idCoP');
        $eCliente->setLabel('Seleccionar Cliente: ');
		$eCliente->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eCliente->addMultiOption($fila->idCliente, $fila->razonSocial);
		}
		
		$vendedorDAO = new Sistema_DAO_Vendedores;
		$vendedores = $vendedorDAO->obtenerVendedores();
			
		$eVendedor = new Zend_Form_Element_Select('vendedor');
        $eVendedor->setLabel('Seleccionar Vendedor:');
		$eVendedor->setAttrib("class", "form-control");
		
		foreach ($vendedores as $fila) {
			$eVendedor->addMultiOption($fila->getIdVendedor(),$fila->getNombre());
		}
		
		$eFecha =  new Zend_Form_Element_Text('fecha');
        $eFecha->setLabel('Seleccionar Fecha: ');
		$eFecha->setAttrib("class", "form-control");
		
		$eProducto = new Zend_Form_Element_Hidden('productos');
		$eProducto->setAttrib("class", "form-control");
		$eProducto->setAttrib("required","true");
		
		$subEncabezado->addElements(array($eTipoMovto,$eEmpresa,$eSucursal, $eProyecto,$eNumFactura,$eFolioFiscal,$eCliente,$eVendedor,$eFecha, $eProducto));
		$subEncabezado->setElementDecorators($decoratorsElemento);
		$subEncabezado->setDecorators($decoratorsPresentacion);
		
		$subFormaPago = new Zend_Form_SubForm;
		$subFormaPago->setLegend("Registrar un pago.");		
		
		$divisaDAO = new Contabilidad_DAO_Divisa;
		$divisas = $divisaDAO->obtenerDivisas();
				
		$eDivisa = new Zend_Form_Element_Select('divisa');
		$eDivisa->setLabel('Seleccionar Divisa: ');
		$eDivisa->setAttrib("class", "form-control");
		
		foreach ($divisas as $divisa) {
			$eDivisa->addMultiOption($divisa->getIdDivisa(), $divisa->getDescripcion());
		}
		
		$ePagada = new Zend_Form_Element_Checkbox('pagada');
		$ePagada->setLabel("Pagada en una sola exhibición:");
		$ePagada->setChecked('1');
		
		$ePagos = new Zend_Form_Element_Text('pagos');
		$ePagos->setLabel('Importe Pago:');
		$ePagos->setAttrib("class", "form-control");
		$ePagos->setAttrib("disabled"," true");
		
		$formaPago = Zend_Registry::get('formaPago');
		$eFormaLiquidar = new Zend_Form_Element_Select('formaLiquidar');
		$eFormaLiquidar->setLabel('Forma de Pago:');
		$eFormaLiquidar->setAttrib("class", "form-control");
		$eFormaLiquidar->setMultiOptions($formaPago);
		
		$eNumReferencia = new Zend_Form_Element_Text('numeroReferencia');
		$eNumReferencia->setLabel('Ingresar Número de Referencia:');
		$eNumReferencia->setAttrib("class", "form-control");
		
		$bancoDAO = new Inventario_DAO_Banco;
		$bancos = $bancoDAO->obtenerBancos();
		
		$eBanco = new Zend_Form_Element_Select('idBanco');
		$eBanco->setLabel('Seleccionar Banco');
		$eBanco->setAttrib("class", "form-control");
		
		foreach($bancos as $banco)
		{
			$eBanco->addMultiOption($banco->getIdBanco(), $banco->getBanco());
		}
		
		$eComentario = new Zend_Form_Element_Textarea('comentario');
		$eComentario->setLabel('Comentario');
		$eComentario->setAttrib('cols', '3');
		$eComentario->setAttrib('rows', '3');
		$eComentario->setAttrib("class","form-control");
		
		$eImportes = new Zend_Form_Element_Hidden('importes');
		$eImportes->setAttrib("class", "form-control");
		$eImportes->setAttrib("required","true");
		
		$impuestos = new Contabilidad_DAO_Impuesto;
		$tiposImpuestos =$impuestos->obtenerImpuestos();
		
		$subFormaPago->addElements(array($eDivisa,$ePagada,$ePagos,$eFormaLiquidar,$eBanco,$eNumReferencia,$eComentario, $eImportes));
		$subFormaPago->setElementDecorators($decoratorsElemento);
		$subFormaPago->setDecorators($decoratorsPresentacion);
				
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Agregar');
		$eSubmit->setAttrib("class", "btn btn-warning");
	
		//Condiciones de Pago
		$this->addSubForms(array($subEncabezado,$subFormaPago));
		$this->addElement($eSubmit);
	
    }


}

