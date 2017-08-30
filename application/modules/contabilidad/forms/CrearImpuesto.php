<?php

class Contabilidad_Form_CrearImpuesto extends Zend_Form
{

    public function init()
    {
    	$this->setAttrib("id", "impuestos");
    	$eAbreviatura = new Zend_Form_Element_Text('abreviatura');
		$eAbreviatura->setLabel('Abrevitura:');
		$eAbreviatura->setAttrib("class", "form-control");
		$eAbreviatura->setAttrib("required", "true");
		
		$eDescripcion = new Zend_Form_Element_Text('descripcion');
		$eDescripcion->setLabel('Descripción:');
		$eDescripcion->setAttrib("class", "form-control");
		
		$impuestosDAO = new Contabilidad_DAO_Impuesto;
		$impuestos = $impuestosDAO->obtenerImpuestos();
		
		$eIdImpuesto = new Zend_Form_Element_Select('idImpuesto');
		$eIdImpuesto->setLabel('Seleccione Impuesto:');
		$eIdImpuesto->setAttrib("class", "form-control");
		
		foreach($impuestosDAO->obtenerImpuestos() as $impuesto){
			$eIdImpuesto->addMultiOption($impuesto->getIdImpuesto(), $impuesto->getAbreviatura());	
		}	
		
		$productosDAO = new Inventario_DAO_Producto;
		$productos = $productosDAO->obtenerProductos();
		
		$eIdProducto = new Zend_Form_Element_Select('idProducto');
		$eIdProducto->setLabel('Seleccione Producto:');
		$eIdProducto->setAttrib("class", "form-control");
		foreach($productosDAO->obtenerProductos()  as $producto){
			$eIdProducto->addMultiOption($producto->getIdProducto(), $producto->getProducto());	
		}
		
		$eImporte = new Zend_Form_Element_Text('importe');
		$eImporte->setLabel('Ingrese Importe:');
		$eImporte->setAttrib("class", "form-control");
		
		$ePorcentaje = new Zend_Form_Element_Text('porcentaje');
		$ePorcentaje->setLabel('Ingrese Porcententaje:');
		$ePorcentaje->setAttrib("class", "form-control");
		
		$eEstatus = new Zend_Form_Element_Text('estatus');
		$eEstatus->setLabel('Estatus:');
		$eEstatus->setAttrib("class", "form-control");
		
		$eFechaPublicion = new Zend_Form_Element_Hidden('fechaPublicacion');
		$eFechaPublicion->setAttrib("class", "form-control");
	
		
		$eSubmit = new Zend_Form_Element_Submit('idEnlazarImpuesto');
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eAbreviatura);
		$this->addElement($eDescripcion);
		$this->addElement($eIdImpuesto);
		$this->addElement($eIdProducto);
		$this->addElement($eImporte);	
		$this->addElement($ePorcentaje);
		$this->addElement($eEstatus);
		$this->addElement($eFechaPublicion);
		$this->addElement($eSubmit);
        
    }


}

