<?php

class Contabilidad_Form_NotaCredito extends Zend_Form
{

    public function init()
    {
       $decoratorsPresentacion = array(
			'FormElements',
			array(array('tabla'=>'Htmltag'),array('tag'=>'table','class'=>'table table-striped table-condensed')),
    		array('Fieldset', array('placement'=>'prepend'))
		);
		$decoratorsElemento=array(
			'ViewHelper',
			array(array('element'=>'HtmlTag'), array('tag'=>'td')),
			array('label',array('tag'=>'td')),
			array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
			
		);
			
        $this->setAttrib("id", "nuevaNotaCliente");
        $subEncabezado = new Zend_Form_SubForm;
		$subEncabezado->setLegend("Nueva Nota de Crédito");
		
		$eNumeroFolio = new Zend_Form_Element_Text('numFolio');
		$eNumeroFolio->setLabel('Número Factura: ');
		$eNumeroFolio->setAttrib("class", "form-control");
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tiposMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();
		
		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Tipo Movimiento:');
		$eTipoMovto->setAttrib("class", "form-control");
		foreach ($tipoMovimientoDAO->obtenerTiposMovimientos() as $fila) {
			if ($fila->getIdTipoMovimiento() == "17") {
				$eTipoMovto->addMultiOption($fila->getIdTipoMovimiento(), $fila->getDescripcion());
			}
		
		}
		
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
    	$eEmpresa =  new Zend_Form_Element_Select('idEmpresas');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idEmpresas, $fila->razonSocial);
		}
		
		$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel("Sucursal: ");
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		
		$eProyecto =  new Zend_Form_Element_Select('idProyecto');
        $eProyecto->setLabel("Seleccionar Proyecto:");
		$eProyecto->setAttrib("class", "form-control");
		$eProyecto->setRegisterInArrayValidator(FALSE);
		
		$eFolioFiscal = new Zend_Form_Element_Text('folioFiscal');
		$eFolioFiscal->setLabel('Folio Fiscal: ');
		$eFolioFiscal->setAttrib("minlength", "32");
		$eFolioFiscal->setAttrib("maxlength", "32" );
		$eFolioFiscal->setAttrib("class", "form-control");
		
		$columnas = array('idEmpresa','razonSocial');
		$tablaEmpresa = new Contabilidad_DAO_NotaSalida;
		$rowset = $tablaEmpresa->obtenerClientes();
		
		$eCliente = new Zend_Form_Element_Select('idCoP');
		$eCliente->setLabel('Seleccionar Cliente:');
		$eCliente->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eCliente->addMultiOption($fila->idCliente, $fila->razonSocial);
		}
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Seleccionar Fecha:');
		$eFecha->setAttrib("class", "form-control");
		$eFecha->setAttrib("required","Seleccionar fecha");
		
		$eDivisa = New Zend_Form_Element_Hidden('idDivisa');
		$eDivisa->setAttrib("class", "form-control");
		$eDivisa->setValue(1);
		
		$eProducto = new Zend_Form_Element_Hidden('productos');
		$eProducto->setAttrib("required","true");
		
		$eImportes = new Zend_Form_Element_Hidden('importes');
		$eImportes->setAttrib("required","true");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-success");
		$eSubmit->setAttrib("disabled","true");
		
		$subEncabezado->addElements(array($eTipoMovto,$eEmpresa,$eSucursal,$eProyecto,$eNumeroFolio, $eFolioFiscal,$eCliente,$eFecha,$eProducto,$eImportes));
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
		//$ePagada->setChecked('1');
		
		$ePagos = new Zend_Form_Element_Text('pagos');
		$ePagos->setLabel('Importe Pago:');
		$ePagos->setAttrib("class", "form-control");
		$ePagos->setValue(0);
		
		$formaPago = Zend_Registry::get('formaPago');
		$eFormaLiquidar = new Zend_Form_Element_Select('formaLiquidar');
		$eFormaLiquidar->setLabel('Forma de Pago:');
		$eFormaLiquidar->setAttrib("class", "form-control");
		$eFormaLiquidar->setMultiOptions($formaPago);
		
		$eNumReferencia = new Zend_Form_Element_Text('numeroReferencia');
		$eNumReferencia->setLabel('Ingresar Número de Referencia:');
		$eNumReferencia->setAttrib("class", "form-control");
		
		$bancoDAO = new Contabilidad_DAO_Banco;
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
			
		$impuestos = new Contabilidad_DAO_Impuesto;
		$tiposImpuestos =$impuestos->obtenerImpuestos();
		
		$subFormaPago->addElements(array($eDivisa,$ePagada,$ePagos,$eFormaLiquidar,$eBanco,$eNumReferencia,$eComentario));
		$subFormaPago->setElementDecorators($decoratorsElemento);
		$subFormaPago->setDecorators($decoratorsPresentacion);
				
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Agregar');
		$eSubmit->setAttrib("class", "btn btn-warning");
	
		$this->addSubForms(array($subEncabezado,$subFormaPago));
		$this->addElement($eSubmit);
		
    }


}

