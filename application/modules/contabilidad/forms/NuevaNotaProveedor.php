<?php

class Contabilidad_Form_NuevaNotaProveedor extends Zend_Form
{

    public function init()
    {
        /* Encabezado nueva nota de entrada ... */
        $subEncabezado = new Zend_Form_SubForm;
		$subEncabezado->setLegend("Ingresar Datos");
		
        $eNumeroFactura = new Zend_Form_Element_Text('numFactura');
		$eNumeroFactura->setLabel('Folio: ');
		$eNumeroFactura->setAttrib("class", "form-control");

		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Tipo de Movimiento');
		$eTipoMovto->setAttrib("class", "form-control");
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tiposMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();
		
		foreach ($tiposMovimientos as $tipoMovimiento)
		{
			$eTipoMovto->addMultiOption($tipoMovimiento->getIdTipoMovimiento(), $tipoMovimiento->getTipoMovimiento());		
		}
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Fecha:');
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
		
	
		$eDivisa = New Zend_Form_Element_Hidden('idDivisa');
		$eDivisa->setAttrib("class", "form-control");
		$eDivisa->setValue(1);
		
		/*$tipoDivisaDAO = new Contabilidad_DAO_Divisa;
		$tiposDivisa = $tipoDivisaDAO->obtenerDivisas();
		
		foreach ($tiposDivisa as $tipoDivisa)
		{
			$eDivisa->addMultiOption($tipoDivisa->getIdDivisa(), $tipoDivisa->getDivisa());		
		}*/
		
		$eProducto = new Zend_Form_Element_Hidden('productos');
		$eProducto->setAttrib("class", "form-control");
		$eProducto->setAttrib("required", "true");
		//$eProducto->setAttrib("class", "hidden");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-success");
		/*foreach ($divisas as $divisa){
			$eDivisa->addMultiOption($divisa->getIdDivisa(), $divisa->getDivisa());			
		}*/			
		//Agregamos los elementos correspondientes a la subformaEncabezado
		$subEncabezado->addElements(array($eNumeroFactura, $eTipoMovto,$eFecha,$eEmpresa,$eDivisa,$eProveedor,$eProyecto,$eProducto));
     	$this->addSubForms(array($subEncabezado))  ; 
		$this->addElement($eSubmit);
		

	}
}


