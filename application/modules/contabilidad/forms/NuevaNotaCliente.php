<?php

class Contabilidad_Form_NuevaNotaCliente extends Zend_Form
{

    public function init()
    {
        /* Encabezado nueva nota salida proveedor */
        $subEncabezado = new Zend_Form_SubForm;
		$subEncabezado->setLegend("Ingresar Datos");
		
		$eNumeroFactura = new Zend_Form_Element_Text('numFactura');
		$eNumeroFactura->setLabel('Folio: ');
		$eNumeroFactura->setAttrib("class", "form-control");
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tiposMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();
		
		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Tipo de Movimiento');
		$eTipoMovto->setAttrib("class", "form-control");
		foreach ($tiposMovimientos as $tipoMovimiento)
		{
			$eTipoMovto->addMultiOption($tipoMovimiento->getIdTipoMovimiento(), $tipoMovimiento->getTipoMovimiento());		
		}
		
		$columnas = array('idFiscales','razonSocial');
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresas();
		
    	$eEmpresa =  new Zend_Form_Element_Select('idEmpresa');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		$eCliente = new Zend_Form_Element_Text('idCliente');
		$eCliente->setLabel('Seleccionar Cliente');
		$eCliente->setAttrib("class", "form-control");
		$eCliente->setValue(1);
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Fecha');
		$eFecha->setAttrib("class", "form-control");
		$eFecha->setAttrib("required", "La fecha no puede quedar vacia");
		
		$divisaDAO = new Contabilidad_DAO_Divisa;
		$divisas=$divisaDAO->obtenerDivisas();
		
		$eProyecto = new Zend_Form_Element_Text('idProyecto');
        $eProyecto->setLabel('Seleccionar Proyecto');
		$eProyecto->setAttrib("class", "form-control");
		$eProyecto->setValue(1);
		
		$eDivisa = new Zend_Form_Element_Select('idDivisa');
		$eDivisa->setLabel('Seleccionar Divisa');
		$eDivisa->setAttrib("class", "form-control");
		
		foreach ($divisas as $divisa){
			$eDivisa->addMultiOption($divisa->getIdDivisa(), $divisa->getDivisa());			
		}
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$subEncabezado->addElements(array($eTipoMovto,$eNumeroFactura, $eEmpresa, $eCliente, $eFecha));
		$this->addSubForm($subEncabezado, 'Encabezado');
		$this->addElement($eSubmit);
    }


}

