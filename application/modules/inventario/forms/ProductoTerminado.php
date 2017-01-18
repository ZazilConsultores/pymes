<?php

class Inventario_Form_ProductoTerminado extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $eBuscar = new Zend_Form_Element_Text('Buscar');
		$eBuscar->setLabel('Buscar Producto Terminado');
		$eBuscar->setAttrib("class", "form-control");
		
		//$eProductoTerminado = new Zend_Form_Element_Button;
		$eProducto = new Zend_Form_Element_Image('my-image');
		$eProducto->setAttrib('src','C:/xampp/htdocs/General/public/images/my-image.JPEG');
		//$eProducto->setLabel('Buscar Producto Terminado');
		
		$ptDAO = new Inventario_DAO_Productoterminado;
		$pts = $ptDAO->obtenerProductoTerminado();
		
		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Tipo  Movimiento:');
		$eTipoMovto->setAttrib("class", "form-control");
		
		foreach ($ptDAO->obtenerProducto()as $fila)
		{
				$eTipoMovto->addMultiOption($fila->claveProducto, $fila->producto);
		
			
		}
		
		$this->addElement($eBuscar);
		$this->addElement($eTipoMovto);
		$this->addElement($eProducto);
		
		
    }


}

