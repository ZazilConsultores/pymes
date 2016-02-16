<?php

class Inventario_Form_AltaProducto extends Zend_Form
{

    public function init()
    {
        //===================================================================================>>>>
		$subEncabezado = new Zend_Form_SubForm();
        //$subEncabezado->setLegend('Seleccionar Parametro:');
		
		$this->setAttrib("id", "altaProducto");
		$subEncabezado->setAttrib('title', 'Elegir parametros');
	
        //$columnas = array('Clave', 'Descripcion');
		//$tablaTipoArticulo = new Inventario_Model_DbTable_TipoArticulo();
		//$rowset = $tablaTipoArticulo->obtenerColumnas($columnas);
		
		$eTipoArticulo = new Zend_Form_Element_Select('tipoArticulo');
		$eTipoArticulo->setLabel('Tipo articulo: ');
		$eTipoArticulo->setAttrib('id', 'tipo');
		$eTipoArticulo->setAttrib('class','form-control');
		$eTipoArticulo->addMultiOption("", "Seleccionar...");
		//foreach ($rowset as $fila) {
			//$eTipoArticulo->addMultiOption($fila->Clave, $fila->Descripcion);
		//}
		
		/* Subtipo */
		$columnas = array('Clave', 'Descripcion');
		//$tablaSubtipo = new Inventario_Model_DbTable_Subtipo();
		//$rowset = $tablaSubtipo->obtenerColumnas($columnas);
		
		$eSubtipo = new Zend_Form_Element_Select('subtipo');
		$eSubtipo->setLabel('Subtipo: ');
		$eSubtipo->setAttrib('class','form-control');
		$eSubtipo->addMultiOption("", "Seleccionar...");
		
		
		//foreach ($rowset as $fila) {
			//$eSubtipo->addMultiOption($fila->Clave, $fila->Descripcion);
		//}
				/* Marcas */
		
		$columnas = array('Clave', 'Descripcion');
		//$tablaMarcas = new Inventario_Model_DbTable_Marcas();
		//$rowset = $tablaMarcas->obtenerColumnas($columnas);
		
		$eMarcas = new Zend_Form_Element_Select('marcas');
		$eMarcas->setLabel('Marca: ');
		$eMarcas->setAttrib('class','form-control');
		$eMarcas->addMultiOption("", "Seleccionar...");
		
		//foreach ($rowset as $fila) {
			//$eMarcas->addMultiOption($fila->Clave, $fila->Descripcion);
		//}
		
				/* medidas */
		$columnas = array('Clave', 'Descripcion');
		//$tablaMedidas = new Inventario_Model_DbTable_Medidas();
		//$rowset = $tablaMedidas->obtenerColumnas($columnas);
		
		$eMedidas = new Zend_Form_Element_Select('medidas');
		$eMedidas->setLabel('Medidas: ');
		$eMedidas->setAttrib('class','form-control');
		$eMedidas->addMultiOption("", "Seleccionar...");
		
		//foreach ($rowset as $fila) {
			//$eMedidas->addMultiOption($fila->Clave, $fila->Descripcion);
		//}
				/* colores */
		$columnas = array('Clave', 'Descripcion');
		//$tablaColores = new Inventario_Model_DbTable_Colores();
		//$rowset = $tablaColores->obtenerColumnas($columnas);
		
		$eColores = new Zend_Form_Element_Select('colores');
		$eColores->setLabel('Colores: ');
		$eColores->setAttrib('class','form-control');
		$eColores->addMultiOption("", "Seleccionar...");
		
		//foreach ($rowset as $fila) {
			//$eColores->addMultiOption($fila->Clave, $fila->Descripcion);
		//}
				/* modelo */
		$columnas = array('Clave', 'Descripcion');
		//$tablaModelo = new Inventario_Model_DbTable_Modelo();
		//$rowset = $tablaModelo->obtenerColumnas($columnas);
		
		$eModelo = new Zend_Form_Element_Select('modelo');
		$eModelo->setLabel('Modelo: ');
		$eModelo->setAttrib('class','form-control');
		$eModelo->addMultiOption("", "Seleccionar...");
		
		//foreach ($rowset as $fila) {
			//$eModelo->addMultiOption($fila->Clave, $fila->Descripcion);
		//}
				/* largo */
		$columnas = array('Clave', 'Descripcion');
		//$tablaLargo = new Inventario_Model_DbTable_Largo();
		//$rowset = $tablaLargo->obtenerColumnas($columnas);
		
		$eLargo = new Zend_Form_Element_Select('largo');
		$eLargo->setLabel('Largo: ');
		$eLargo->setAttrib('class','form-control');
		$eLargo->addMultiOption("", "Seleccionar...");
		
		
		//===========array de encabezado========================================================
		$subEncabezado->addElements(array($eTipoArticulo,$eSubtipo,$eMarcas,$eMedidas,$eColores,$eModelo,$eLargo));
		//===================================================================================>>>>
		$subDescripcion = new Zend_Form_SubForm();
		$subDescripcion->setAttrib('title', 'Descripcion');
	
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
		//===========array Descripcion========================================================
		$subDescripcion->addElements(array($eProducto,$eClaveProducto, $eCodigoBarras));
		
		
		$this->addSubForms(array($subEncabezado, $subDescripcion));
		
	}
		
}

