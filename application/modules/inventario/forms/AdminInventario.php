<?php

class Inventario_Form_AdminInventario extends Zend_Form
{

    public function init()
    {
    	$divisaDAO = new Contabilidad_DAO_Divisa;
		$divisas = $divisaDAO->obtenerDivisas();
    	
        $eClaveProducto = new Zend_Form_Element_Text('claveProducto');
		$eClaveProducto->setLabel('Clave:');
		$eClaveProducto->setAttrib('class','form-control');
		
		$eProducto = new Zend_Form_Element_Text('producto');
		$eProducto->setLabel('Descripcion:');
		$eProducto->setAttrib('class', 'form-control');
		
		$eDivisa = new Zend_Form_Element_Select("idDivisa");
		$eDivisa->setLabel("Seleccione Divisa: ");
		$eDivisa->setAttrib("class", "form-control");
		
		foreach ($divisas as $divisa)
		{
			$eDivisa->addMultiOption($divisa->getIdDivisa(), $divisa->getDivisa());		
		}
		$eExistencia = new Zend_Form_Element_Text('existencia');
		$eExistencia->setLabel('Existencia');
		$eExistencia->setAttrib('class', 'form-control');
		
		$eMaximo = new Zend_Form_Text('maximo');
		$eMaximo->setLabel('Maximo');
		$eMaximo->setAttrib('class','form-control');
		
		$eMinimo = new Zend_Form_Element('minimo');
		$eMinimo->setLabel('Minimo');
		$eMinimo->setAttrib('class', 'form-control');
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Fecha de Adquisicion');
		$eFecha->setAttrib('class', 'form-control');
		
		$eCostoUnitario = Zend_Form_Element_Text('costoUnitario');
		$eCostoUnitario->setLabel('Costo Unitario');
		$eCostoUnitario->setAttrib('class','form-control');
		
		$ePorcentajeGanancia = Zend_Form_Element_Text('porcentajeGanancia');
		$ePorcentajeGanancia->setLabel('Porcentaje de Ganancia');
		$ePorcentajeGanancia->setAttrib('class','form-control');
		
		$eCantidadGanancia = Zend_Form_Element_Text('cantidadGanancia');
		$eCantidadGanancia->setLabel('Cantidad de Ganancia');
		$eCantidadGanancia->setAttrib('class', 'form-control');
		
		$eCostoCliente = Zend_Form_Element_Text('costoCliente');
		$eCostoCliente->setLabel('Costo Cliente');
		$eCostoCliente->setAttrib('class','form-control');
		
		
		
		
    }


}

