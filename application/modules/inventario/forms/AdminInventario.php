<?php

class Inventario_Form_AdminInventario extends Zend_Form
{

    public function init()
    {
   	
		$eMinimo = new Zend_Form_Element_Text('minimo');
		$eMinimo->setLabel('Minimo:');
		$eMinimo->setAttrib('class', 'form-control');
		
		$eMaximo = new Zend_Form_Element_Text("maximo");
		$eMaximo->setLabel("Maximo: ");
		$eMaximo->setAttrib("class", "form-control");
		
		$eCostoUnitario = new Zend_Form_Element_Text('costoUnitario');
		$eCostoUnitario->setLabel('Costo Unitario');
		$eCostoUnitario->setAttrib('class', 'form-control');
		
		$ePorcentajeGanancia = new Zend_Form_Element_Text('porcentajeGanancia');
		$ePorcentajeGanancia->setLabel('Porcentaje de Ganancia');
		$ePorcentajeGanancia->setAttrib('class','form-control');
		
		$eCantidadGanancia = new Zend_Form_Element_Text('cantidadGanancia');
		$eCantidadGanancia->setLabel('Cantidad de Ganancia');
		$eCantidadGanancia->setAttrib('class', 'form-control');
		$eCantidadGanancia->setAttrib('disabled', "true");
		
		$eCostoCliente = new  Zend_Form_Element_Text('costoCliente');
		$eCostoCliente->setLabel('Costo Cliente');
		$eCostoCliente->setAttrib('class','form-control');
		
		$eAgregar = new Zend_Form_Element_Submit('submit');
		$eAgregar->setLabel('Actualizar');
		$eAgregar->setAttrib("class", "btn btn-success");
		
		$this->addElement($eMinimo);
		$this->addElement($eMaximo);
		$this->addElement($eCostoUnitario);
		$this->addElement($ePorcentajeGanancia);
		$this->addElement($eCantidadGanancia);
		$this->addElement($eCostoCliente);
		$this->addElement($eAgregar);		
		
    }


}

