<?php

class Inventario_Form_AltaMultiplos extends Zend_Form
{

    public function init()
    {
		$unidadDAO = new Inventario_DAO_Unidad;
		$unidades = $unidadDAO->obtenerUnidades();
		
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
		
		$eAgregar = new Zend_Form_Element_Submit('submit');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		
		$this->addElement($eCantidad);
		$this->addElement($eUnidad);
		$this->addElement($eAgregar);
		
		
		
    }


}

