<?php

class Inventario_Form_AltaMultiplos extends Zend_Form
{

    public function init()
    {
		$unidadDAO = new Inventario_DAO_Unidad;
		$unidades = $unidadDAO->obtenerUnidades();
//$multiplo->setIdUnidad($unidad->generarClaveProducto($datos['Configuracion']));
       	$subUno = new Zend_Form_SubForm();
		$subUno->setLegend("Alta de Multiplos");
		
		$eCantidad = new Zend_Form_Element_Text('cantidad');
		$eCantidad->setLabel('Cantidad: ');
		$eCantidad->setAttrib('class','form-control');
		
		$eUnidad = new Zend_Form_Element_Select('idUnidad');
		$eUnidad->setLabel('Unidad: ');
		$eUnidad->setAttrib('class','form-control');
		
		foreach ($unidades as $unidad)
		{
			$eUnidad->addMultiOption($unidad->getIdUnidad(), $unidad->getUnidad());		
		}
		
		$subUno->addElements(array($eCantidad,$eUnidad));
		
		$eAgregar = new Zend_Form_Element_Submit('submit');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		$this->addSubForms(array($subUno));
		$this->addElement($eAgregar);
		
		
		
    }


}

