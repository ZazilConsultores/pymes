<?php

class Contabilidad_Form_NuevaNotaCliente extends Zend_Form
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
		$subEncabezado->setLegend("Nueva Nota Cliente");
		
		$eNumeroFolio = new Zend_Form_Element_Text('numFolio');
		$eNumeroFolio->setLabel('Número de Folio: ');
		$eNumeroFolio->setAttrib("class", "form-control");
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tiposMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();
		
		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Tipo Movimiento:');
		$eTipoMovto->setAttrib("class", "form-control");
		foreach ($tipoMovimientoDAO->obtenerTiposMovimientos() as $fila) {
			if ($fila->getIdTipoMovimiento() == "8") {
				$eTipoMovto->addMultiOption($fila->getIdTipoMovimiento(), $fila->getDescripcion());
			}
		
		}
		
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
		
		/*$tipoDivisaDAO = new Contabilidad_DAO_Divisa;
		$tiposDivisa = $tipoDivisaDAO->obtenerDivisas();
		
		foreach ($tiposDivisa as $tipoDivisa)
		{
			$eDivisa->addMultiOption($tipoDivisa->getIdDivisa(), $tipoDivisa->getDivisa());		
		}*/
		$eProducto = new Zend_Form_Element_Hidden('productos');
		//$eProducto->setAttrib("class", "form-control");
		$eProducto->setAttrib("required","true");
		
		/*$eProyecto = new Zend_Form_Element_Select('idProyecto');
        $eProyecto->setLabel('Seleccionar Proyecto:');
		$eProyecto->setAttrib("class", "form-control");
		$eProyecto->setRegisterInArrayValidator(FALSE);*/
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-success");
		$eSubmit->setAttrib("disabled","true");
		
		$subEncabezado->addElements(array($eNumeroFolio, $eTipoMovto,$eFecha,$eEmpresa,$eSucursal,$eDivisa,$eCliente,/*$eProyecto*/$eProducto));
		$subEncabezado->setElementDecorators($decoratorsElemento);
		$subEncabezado->setDecorators($decoratorsPresentacion);
		$this->addSubForms(array($subEncabezado));
		$this->addElement($eSubmit);
    }
}



