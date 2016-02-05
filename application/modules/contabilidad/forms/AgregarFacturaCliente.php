<?php

class Contabilidad_Form_AgregarFacturaCliente extends Zend_Form
{

    public function init()
    {
        $eCantidad = new Zend_Form_Element_Text('cliente');
		$eCantidad->setLabel('Cantidad: ');
		$eCantidad->setAttrib("class", "form-control");
		
		$ePrecioUni = new Zend_Form_Element_Text('precioUnitario');
		$ePrecioUni->setLabel('Precio Unitario: ');
		$ePrecioUni->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Agregar');
		$eSubmit->setAttrib("class", "btn btn-warning");
		
		$this->addElement($eCantidad);
		$this->addElement($ePrecioUni);
		
		$this->addElement($eSubmit);
	
    }


}

