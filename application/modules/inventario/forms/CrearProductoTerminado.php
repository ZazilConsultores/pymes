<?php

class Inventario_Form_CrearProductoTerminado extends Zend_Form
{

    public function init()
    {
    	$eNumFactura = new Zend_Form_Element_Text('numeroFactura');
		$eNumFactura->setLabel('Número de Factura: ');
		$eNumFactura->setAttrib("class", "form-control");
		
		$eDatos = new Zend_Form_Element_Hidden('datos');
		$eDatos->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class","btn btn-success");
	
		$this->addElement($eNumFactura);
		$this->addElement($eDatos);
		$this->addElement($eSubmit); 
		
    }


}

