<?php

class Contabilidad_Form_Cuentasxp extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
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
		
		$subBusqueda = new Zend_Form_SubForm;
		$subBusqueda->setLegend("Cuentas por pagar");
		
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
		$eEmpresa =  new Zend_Form_Element_Select('idEmpresas');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$eCoP = new Zend_Form_Element_Select('idCoP');
		
		$eNumFac = new Zend_Form_Element_Text('numeroFactura');
		$eNumFac->setLabel('Factura');
		$eNumFac->setAttrib('placeHolder', "Ingrese el número de la Factura");
		$eNumFac->setAttrib("class", "form-control");
		
		$subBusqueda->addElements(array($eEmpresa,$eNumFac));
		$subBusqueda->setElementDecorators($decoratorsElemento);
		$subBusqueda->setDecorators($decoratorsPresentacion);
		
		
		$subDatos = new Zend_Form_SubForm;
		$subDatos->setLegend("Datos");
		
		$subNotaCredito = new Zend_Form_SubForm;
		$subNotaCredito->setLegend("Registrar una nota de credito");
		
		$subPago = new Zend_Form_SubForm;
		$subPago->setLegend("Regirtrar un pago");
		
		$subRelacionPagos = new Zend_Form_SubForm;
		$subRelacionPagos->setLegend("Relación de pagos");
		
		$this->addSubForms(array($subBusqueda,$subDatos,$subNotaCredito,$subPago,$subRelacionPagos));
    }


}

