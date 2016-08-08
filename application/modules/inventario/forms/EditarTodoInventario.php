<?php

class Inventario_Form_EditarTodoInventario extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eMinimo = new Zend_Form_Element_Text('minimo');
		$eMinimo->setLabel('Minimo:');
		$eMinimo->setAttrib('class', 'form-control');
		
		$eMaximo = new Zend_Form_Element_Text("maximo");
		$eMaximo->setLabel("Maximo: ");
		$eMaximo->setAttrib("class", "form-control");
		
		$ePorcentajeGanancia = new Zend_Form_Element_Text('porcentajeGanancia');
		$ePorcentajeGanancia->setLabel('Porcentaje de Ganancia');
		$ePorcentajeGanancia->setAttrib('class','form-control');
		
		
		$eAgregar = new Zend_Form_Element_Submit('submit');
		$eAgregar->setLabel('Actualizar');
		$eAgregar->setAttrib("class", "btn btn-success");
		
		$this->addElement($eMinimo);
		$this->addElement($eMaximo);
		$this->addElement($ePorcentajeGanancia);
		$this->addElement($eAgregar);		
        
    }


}

