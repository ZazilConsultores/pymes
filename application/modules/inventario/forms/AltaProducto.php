<?php

class Inventario_Form_AltaProducto extends Zend_Form
{

    public function init()
    {
        //===================================================================================>>>>
		$subForm = new Zend_Form_SubForm();
		$subForm->setLegend("Alta de Producto");
		
		$parametroDAO = new Inventario_DAO_Parametro;
		$subparametroDAO = new Sistema_DAO_Subparametro;
		
		$parametros = $parametroDAO->obtenerParametros();
		
		foreach ($parametros as $parametro) {
			$subparametros = $subparametroDAO->obtenerSubparametros($parametro->getIdParametro());
			$elemento = new Zend_Form_Element_Select($parametro->getIdParametro());
			$elemento->setLabel($parametro->getParametro());
			$elemento->setAttrib("class", "form-control");
			$elemento->addMultiOption("0","Seleccione opcion");
			foreach ($subparametros as $subparametro) {
				$elemento->addMultiOption($subparametro->getIdSubparametro(),$subparametro->getSubparametro());
			}
			$subForm->addElement($elemento);
		}
        /*
		$eTipoArticulo = new Zend_Form_Element_Select('tipoArticulo');
		$eTipoArticulo->setLabel('Tipo articulo: ');
		$eTipoArticulo->setAttrib('class','form-control');
		$eTipoArticulo->addMultiOption("", "Seleccionar...");
		*/
		/* Subtipo */
		/*		
		$eSubtipo = new Zend_Form_Element_Select('subtipo');
		$eSubtipo->setLabel('Subtipo: ');
		$eSubtipo->setAttrib('class','form-control');
		$eSubtipo->addMultiOption("", "Seleccionar...");
		*/
		/* Marcas */
		/*
		$eMarcas = new Zend_Form_Element_Select('marcas');
		$eMarcas->setLabel('Marca: ');
		$eMarcas->setAttrib('class','form-control');
		$eMarcas->addMultiOption("", "Seleccionar...");
		*/
			
		/* medidas */
		/*
		$eMedidas = new Zend_Form_Element_Select('medidas');
		$eMedidas->setLabel('Medidas: ');
		$eMedidas->setAttrib('class','form-control');
		$eMedidas->addMultiOption("", "Seleccionar...");
		*/	
		/* colores */
		/*
		$eColores = new Zend_Form_Element_Select('colores');
		$eColores->setLabel('Colores: ');
		$eColores->setAttrib('class','form-control');
		$eColores->addMultiOption("", "Seleccionar...");
		*/
		/* modelo */
		/*
		$eModelo = new Zend_Form_Element_Select('modelo');
		$eModelo->setLabel('Modelo: ');
		$eModelo->setAttrib('class','form-control');
		$eModelo->addMultiOption("", "Seleccionar...");
		*/
		/* largo */
		/*
		$eLargo = new Zend_Form_Element_Select('largo');
		$eLargo->setLabel('Largo: ');
		$eLargo->setAttrib('class','form-control');
		$eLargo->addMultiOption("", "Seleccionar...");
		*/
		/*Descripcion */
		/*
		$eProducto = new Zend_Form_Element_Text('producto');
		$eProducto->setLabel('Descripcion:');
		$eProducto->setAttrib('class','form-control');
		
		$eClaveProducto = new Zend_Form_Element_Text('claveProducto');
		$eClaveProducto->setLabel('Clave Producto:');
		$eClaveProducto->setAttrib('class','form-control');
	
		$eCodigoBarras = new Zend_Form_Element_Text('codigoBarras');
		$eCodigoBarras->setLabel('Codigo de Barras:');
		$eCodigoBarras->setValue('-');
		$eCodigoBarras->setAttrib('class','form-control');
		
		
		*/
		$eAgregar = new Zend_Form_Element_Submit('agregar');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		//$subForm->addElements(array($eTipoArticulo, $eSubtipo,$eMarcas, $eMedidas,$eColores,$eModelo,$eLargo,$eProducto,$eClaveProducto,$eCodigoBarras,$eAgregar));
	
		$this->addSubForms(array($subForm));
		//$this->addElement($eEstado);
		$this->addElement($eAgregar);
		//$this->addElements(array($eTipoArticulo, $eSubtipo, $eMarcas,$eMedidas,$eColores,$eModelo,$eLargo,$eProducto,$eClaveProducto, $eCodigoBarras,$eAgregar));

		
	}
		
}

