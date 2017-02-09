<?php

class Contabilidad_Form_GeneraPoliza extends Zend_Form
{

    public function init()
    {
        $decoratorsPresentacion = array(
			'FormElements',
			array(array('tabla'=>'Htmltag'), array('tag'=>'table','class'=>'table table-striped table-condensed')),
			array('Fieldset', array('placement'=>'prepend'))
		);
		
		$decoratorsElemento = array(
			'ViewHelper',
			array(array('element'=>'HtmlTag'),array('tag'=>'td')),
			array('label',array('tag'=>'td')),
			array(array('row'=>'HtmlTag'), array('tag'=>'tr'))
		);
		
		$subDatos = new Zend_Form_SubForm();
		$subDatos->setLegend("Poliza");
		
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
		$eEmpresa = new Zend_Form_Element_Select('idEmpresas');
		$eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel('Sucursal:');
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		
		$eFechaInicio = new Zend_Form_Element_Text('fechaInicial');
		$eFechaInicio->setLabel('Seleccionar fecha inicia:');
		$eFechaInicio->setAttrib("class", "form-control");
		$eFechaInicio->setAttrib("required","true");
		
		$eFechaFin = new Zend_Form_Element_Text('fechaFinal');
		$eFechaFin->setLabel('Seleccionar fecha fin:');
		$eFechaFin->setAttrib("class", "form-control");
		$eFechaFin->setAttrib("required","true");
		
		$subDatos->addElements(array($eEmpresa,$eSucursal,$eFechaInicio,$eFechaFin));
		$subDatos->setElementDecorators($decoratorsElemento);
		$subDatos->setDecorators($decoratorsPresentacion);
	
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Generar");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addSubForm($subDatos,'poliza');
		$this->addElement($eSubmit);
    }
}

