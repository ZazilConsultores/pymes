<?php

class Contabilidad_Form_NotaEntradaProveedor extends Zend_Form
{

    public function init()
    {
        /* Encabezado, detalle de remision y forma de pago ... */
        $subEncabezado = new Zend_Form_SubForm;
		$subEncabezado->setLegend("Ingresar Datos");
		
		$eNumeroFactura = new Zend_Form_Element_Text('factura');
		$eNumeroFactura->setLabel('Folio: ');
		$eNumeroFactura->setAttrib("class", "form-control");

		$eTipoMovto = New Zend_Form_Element_Text('TipoMovto');
		$eTipoMovto->setLabel('Tipo de Movimiento');
		$eTipoMovto->setAttrib("class", "form-control");
		$eTipoMovto->setValue('NE');
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Fecha:');
		$eFecha->setAttrib("class", "form-control");
		
		$columnas = array('idFiscales','razonSocial');
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresas();
		
    	$eEmpresa =  new Zend_Form_Element_Select('empresa');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$eProyecto = new Zend_Form_Element_Select('proyecto');
        $eProyecto->setLabel('Seleccionar Proyecto');
		$eProyecto->setAttrib("class", "form-control");
		
		
		$eProveedor = new Zend_Form_Element_Select('idProveedor');
		$eProveedor->setLabel('Seleccionar Proveedor');
		$eProveedor->setAttrib("class", "form-control");
		
		$divisaDAO = new Contabilidad_DAO_Divisa;
		$divisas=$divisaDAO->obtenerDivisas();
		
		$eDivisa = new Zend_Form_Element_Select('idDivisa');
		$eDivisa->setLabel('Seleccionar Divisa');
		$eDivisa->setAttrib("class", "form-control");
		
		foreach ($divisas as $divisa){
			$eDivisa->addMultiOption($divisa->getIdDivisa(), $divisa->getDivisa());			
		}
		
		$subCuerpo = new Zend_Form_SubForm;
		$subCuerpo->setLegend("Seleccionar Productos");
		
		$eCantidad = new Zend_Form_Element_Text('cantidad');
		$eCantidad->setLabel('Cantidad');
		$eCantidad->setAttrib("class", "form-control");
		
		
		$eProducto = new Zend_Form_Element_Select('producto');
		$eProducto->setLabel('Seleccionar Producto');
		$eProducto->setAttrib("class", "form-control");
		
		$eUnidad = new Zend_Form_Element_Select('idunidad');
		$eUnidad->setLabel('Seleccionar Unidad');
		$eUnidad->setAttrib("class", "form-control");
		
		$unidadesDAO =new Inventario_DAO_Unidad;
		$unidades=$unidadesDAO->obtenerUnidades();
		
		foreach ($unidades as $unidad){
			$eUnidad->addMultiOption($unidad->getIdUnidad(),$unidad->getUnidad());
		}
		
		$eCodigoBarras = new Zend_Form_Element_Text('codigoBarras');
		$eCodigoBarras->setLabel('Codigo de Barras');
		$eCodigoBarras->setAttrib("class", "form-control");	
		
		$eDescripcion = new Zend_Form_Element_Text('descripcion');
		$eDescripcion->setLabel('Descripcion');
		$eDescripcion->setAttrib("class", "form-control");
		
		$ePrecioU = new Zend_Form_Element_Text('pUnitario');
		$ePrecioU->setLabel('Precio Unitario');
		$ePrecioU->setAttrib("class", "form-control");
		
		$eImporte = new Zend_Form_Element_Text('importe');
		$eImporte->setLabel('Importe');
		$eImporte->setAttrib("class", "form-control");
		
		$subFormaPago = new Zend_Form_SubForm;
		$subFormaPago->setLegend("Forma de Pago");
		
		$eAgregar = new Zend_Form_Element_Submit('guardar');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-success");		
		
		$subEncabezado->addElements(array($eNumeroFactura, $eTipoMovto,$eFecha,$eEmpresa, $eProveedor, $eProyecto));
        $subCuerpo->addElements(array($eCantidad,$eProducto, $eUnidad, $eCodigoBarras, $eDescripcion, $ePrecioU, $eImporte, $eAgregar));
		$subFormaPago->addElements(array($eDivisa)); 
		
		$eGuardar = new Zend_Form_Element_Submit('guardar');
		$eGuardar->setLabel('Guardar');
		$eGuardar->setAttrib("class", "btn btn-warning");		
		 
	    $this->addSubForms(array($subEncabezado,$subCuerpo));
        $this->addElement($eGuardar);
         
 
    }
}

