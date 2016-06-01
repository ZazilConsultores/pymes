
<?php

class Contabilidad_Form_NotaEntradaProveedor extends Zend_Form
{

    public function init()
    {
    	$productoDAO = new Inventario_DAO_Producto;
		$productos = $productoDAO->obtenerProductos();
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tiposMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();
		
        /* Encabezado, detalle de remision y forma de pago ... */
        //$subEncabezado = new Zend_Form_SubForm;
		//$subEncabezado->setLegend("Ingresar Datos");
		
		$eNumeroFactura = new Zend_Form_Element_Text('numFactura');
		$eNumeroFactura->setLabel('Folio: ');
		$eNumeroFactura->setAttrib("class", "form-control");

		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Tipo de Movimiento');
		$eTipoMovto->setAttrib("class", "form-control");
		
		foreach ($tiposMovimientos as $tipoMovimiento)
		{
			$eTipoMovto->addMultiOption($tipoMovimiento->getIdTipoMovimiento(), $tipoMovimiento->getTipoMovimiento());		
		}
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Fecha:');
		$eFecha->setAttrib("required", "TRUE");
		$eFecha->setAttrib("class", "form-control");
		
		
		
		
		$columnas = array('idFiscales','razonSocial');
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresas();
		
    	$eEmpresa =  new Zend_Form_Element_Select('idEmpresa');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$eProyecto = new Zend_Form_Element_Text('idProyecto');
        $eProyecto->setLabel('Seleccionar Proyecto');
		$eProyecto->setAttrib("class", "form-control");
		$eProyecto->setValue(1);
		
		$eProveedor = new Zend_Form_Element_Text('idProveedor');
		$eProveedor->setLabel('Seleccionar Proveedor');
		$eProveedor->setAttrib("class", "form-control");
		$eProveedor->setValue(1);
		
	
		$divisaDAO = new Contabilidad_DAO_Divisa;
		$divisas=$divisaDAO->obtenerDivisas();
		
		$eDivisa = new Zend_Form_Element_Select('idDivisa');
		$eDivisa->setLabel('Seleccionar Divisa');
		$eDivisa->setAttrib("class", "form-control");
		
		foreach ($divisas as $divisa){
			$eDivisa->addMultiOption($divisa->getIdDivisa(), $divisa->getDivisa());			
		}
		
		//$subCuerpo = new Zend_Form_SubForm;
		//$subCuerpo->setLegend("Seleccionar Productos");
		
		$eCantidad = new Zend_Form_Element_Text('cantidad');
		$eCantidad->setLabel('Cantidad');
		$eCantidad->setAttrib("class", "form-control");
		//$eCantidad->setAttrib("class", "prinft('%.2f')");
		
		
		$eProducto = new Zend_Form_Element_Select('idProducto');
		$eProducto->setLabel('Seleccione Producto: ');
		$eProducto->setAttrib("class", "form-control");
		
		foreach ($productos as $producto)
		{
			$eProducto->addMultiOption($producto->getIdProducto(), $producto->getProducto());		
		}
		
	
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
		
		$ePrecioU = new Zend_Form_Element_Text('costoUnitario');
		$ePrecioU->setLabel('Precio Unitario');
		$ePrecioU->setAttrib("class", "form-control");
		$ePrecioU->setAttrib("class", "prinft('%.2f')");
		
		$eImporte = new Zend_Form_Element_Text('totalImporte');
		$eImporte->setLabel('Total Importe');
		$eImporte->setAttrib("class", "form-control");
		$eImporte->setAttrib("class", "prinft('%.2f')");
		
		/*$eSecuencial = new Zend_Form_Element_Text('secuencial');
		$eSecuencial->setLabel("Secuencial");
		$eSecuencial->setAttrib("class", "form-control");
		$eSecuencial->setValue(1);*/
		
	
		
		$eEsOrigen = new Zend_Form_Element_Hidden('esOrigen');
		$eEsOrigen->setLabel("Es Origen");
		$eEsOrigen->setAttrib("class", "form-control");
		$eEsOrigen->setValue(1);
		
	
		
		//$subFormaPago = new Zend_Form_SubForm;
		//$subFormaPago->setLegend("Forma de Pago");
		
		//$eAgregar = new Zend_Form_Element_Submit('guardar');
		//$eAgregar->setLabel('Agregar');
		//$eAgregar->setAttrib("class", "btn btn-success");		
		
		//$subEncabezado->addElements(array($eNumeroFactura, $eTipoMovto,$eFecha,$eEmpresa));
		//$eProveedor, $eProyecto,$eCantidad,$eProducto, $eUnidad, $eCodigoBarras, $eDescripcion, $ePrecioU, $eImporte, $ePoliza,$eDivisa
        //$subCuerpo->addElements(array($eCantidad,$eProducto, $eUnidad, $eCodigoBarras, $eDescripcion, $ePrecioU, $eImporte, $ePoliza));
		//$subFormaPago->addElements(array($eDivisa)); 
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear");
		$eSubmit->setAttrib("class", "btn btn-success");
		
	    //$this->addSubForm($subEncabezado, $encabezado); //$subCuerpo))
	     $this->addElement($eNumeroFactura);
		 $this->addElement($eTipoMovto);
		 $this->addElement($eFecha);
		 $this->addElement($eEmpresa);
		 $this->addElement($eProveedor);
		 $this->addElement($eProyecto);
		 $this->addElement($eCantidad);
		 $this->addElement($eProducto);
		 $this->addElement($eUnidad);
		 $this->addElement($eCodigoBarras);
		 $this->addElement($eDescripcion);
		 $this->addElement($ePrecioU);
		 $this->addElement($eImporte);
		 
		 //$this->addElement($eSecuencial);
	
		 $this->addElement($eEsOrigen);
		
		 $this->addElement($eDivisa);
		 
        $this->addElement($eSubmit);
         
 
    }
}

