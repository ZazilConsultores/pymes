<?php

class Contabilidad_Form_NuevaNotaProveedor extends Zend_Form
{

    public function init()
    {
        /* Nueva nota Proveedor */
        $subEncabezado = new Zend_Form_SubForm;
		$subEncabezado->setLegend("Ingresar Datos");
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tiposMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();
		
		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Tipo de Movimiento');
		$eTipoMovto->setAttrib("class", "form-control");
		foreach ($tiposMovimientos as $tipoMovimiento)
		{
			$eTipoMovto->addMultiOption($tipoMovimiento->getIdTipoMovimiento(), $tipoMovimiento->getTipoMovimiento());		
		}
		
		$eNumeroFactura = new Zend_Form_Element_Text('numFactura');
		$eNumeroFactura->setLabel('Folio: ');
		$eNumeroFactura->setAttrib("class", "form-control");
		$eNumeroFactura->setAttrib("required","El folio no puede quedar vacio");
		
		
		$columnas = array('idFiscales','razonSocial');
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresas();
		
    	$eEmpresa =  new Zend_Form_Element_Select('idEmpresa');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$eProveedor = new Zend_Form_Element_Text('idProveedor');
		$eProveedor->setLabel('Seleccionar Proveedor');
		$eProveedor->setAttrib("class", "form-control");
		$eProveedor->setValue(1);
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Fecha:');
		$eFecha->setAttrib("class", "form-control");
		$eFecha->setAttrib("required", "TRUE");
		
		$eProyecto = new Zend_Form_Element_Text('idProyecto');
        $eProyecto->setLabel('Seleccionar Proyecto');
		$eProyecto->setAttrib("class", "form-control");
		$eProyecto->setValue(1);
		

		
		$eDivisa = new Zend_Form_Element_Hidden('idDivisa');
		$eDivisa->setLabel('Seleccionar Divisa');
		$eDivisa->setAttrib("class", "form-control");
		$eDivisa->setAttrib("value", "1");
		
		/*foreach ($divisas as $divisa){
			$eDivisa->addMultiOption($divisa->getIdDivisa(), $divisa->getDivisa());			
		}*/
		
		$eProductos = new Zend_Form_Element_hidden('productos');
		$eProductos->setAttrib("class", "form-control");
		
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-success");
		$eSubmit->setAttrib("disabled", "true");
		
		$subEncabezado->addElements(array($eTipoMovto,$eNumeroFactura,$eEmpresa,$eProveedor,$eFecha,$eProyecto,$eProductos));
		$this->addSubForm($subEncabezado, 'Encabezado');
		$this->addElement($eSubmit);
		
    }

}

