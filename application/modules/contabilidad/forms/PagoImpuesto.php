<?php

class Contabilidad_Form_PagoImpuesto extends Zend_Form
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
			
        $this->setAttrib("id", "pagoImpuesto");
        $subEncabezado = new Zend_Form_SubForm;
		$subEncabezado->setLegend("Pago de Impuesto");
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tiposMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();
		
		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Tipo Movimiento:');
		$eTipoMovto->setAttrib("class", "form-control");
		foreach ($tipoMovimientoDAO->obtenerTiposMovimientos() as $fila) {
			if ($fila->getIdTipoMovimiento() == "10") {
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
		$eSucursal->setAttrib("required","true");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		
		$eProyecto =  new Zend_Form_Element_Select('idProyecto');
        $eProyecto->setLabel("Seleccionar Proyecto:");
		$eProyecto->setAttrib("class", "form-control");
		$eProyecto->setRegisterInArrayValidator(FALSE);
		
		$tablasFiscales = new Sistema_DAO_Fiscales();
		$rowsEmpleado = $tablasFiscales->getEmpleadoProveedor();
		
		$eProveedor =  new Zend_Form_Element_Select('idCoP');
        $eProveedor->setLabel('Seleccionar Empleado: ');
		$eProveedor->setAttrib("class", "form-control");
		
		foreach ($rowsEmpleado as $rowEmpleado) {
			$eProveedor->addMultiOption($rowEmpleado->idProveedores, $rowEmpleado->razonSocial);
		}
		
		$subDatos = new Zend_Form_SubForm;
		
		$eNumeroFolio = new Zend_Form_Element_Text('numFolio');
		$eNumeroFolio->setLabel('Número Referencia: ');
		$eNumeroFolio->setAttrib("class", "form-control");
		$eNumeroFolio->setAttrib("required","true");
		
	
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Fecha:');
		$eFecha->setAttrib("class", "form-control");
		$eFecha->setAttrib("required","Seleccionar fecha");
		
		$tipoImpuestoDAO = new Contabilidad_DAO_Impuesto;
		$impuestos = $tipoImpuestoDAO->obtenerImpuestos();
		
		$eTipoImpuesto = new Zend_Form_Element_Select('idImpuesto');
		$eTipoImpuesto->setLabel('Impuesto: ');
		$eTipoImpuesto->setAttrib("class", "form-control");
		
		foreach ($impuestos as $impuesto) {
			$eTipoImpuesto->addMultiOption($impuesto->getIdImpuesto(), $impuesto->getDescripcion());	
		}
		
		$eTipoImpuestoE = new Zend_Form_Element_Select('idImpuestoE');
		$eTipoImpuestoE->setLabel('Impuesto: ');
		$eTipoImpuestoE->setAttrib("class", "form-control");
		
		foreach ($impuestos as $impuesto) {
			if ($impuesto->getIdImpuesto() == "9" or $impuesto->getIdImpuesto() == "8" or $impuesto->getIdImpuesto() == "5") {
				$eTipoImpuestoE->addMultiOption($impuesto->getIdImpuesto(), $impuesto->getDescripcion());
			}
			
		}
		
		$formaPago = Zend_Registry::get('formaPago');
		$eFormaProducto = new Zend_Form_Element_Select('formaLiquidar');
		$eFormaProducto->setLabel('Producto:');
		$eFormaProducto->setAttrib("class", "form-control");
		$eFormaProducto->setMultiOptions($formaPago);
		
		$eBancoSalida = new Zend_Form_Element_Select('idBancoS');
		$eBancoSalida->setLabel('Banco Salida:');
		$eBancoSalida->setAttrib("class", "form-control");
		$eBancoSalida->setRegisterInArrayValidator(FALSE);
		
		$eImporte = new Zend_Form_Element_Text('total');
		$eImporte->setLabel('Importe:');
		$eImporte->setAttrib("class", "form-control");
		$eImporte->setAttrib("required","true");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		
		$subEncabezado->addElements(array($eTipoMovto,$eEmpresa,$eSucursal, $eProveedor,$eProyecto,$eNumeroFolio, $eFecha));
		$subEncabezado->setElementDecorators($decoratorsElemento);
		$subEncabezado->setDecorators($decoratorsPresentacion);
		
		$subDatos->addElements(array($eTipoImpuesto,$eTipoImpuestoE,$eFormaProducto,$eBancoSalida, $eImporte));
		$subDatos->setElementDecorators($decoratorsElemento);
		$subDatos->setDecorators($decoratorsPresentacion);
		
		$this->addSubForms(array($subEncabezado, $subDatos));
		$this->addElement($eSubmit);
		
    }


}

