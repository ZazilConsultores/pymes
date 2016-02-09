<?php

class Contabilidad_Form_AgregarRemisionCliente extends Zend_Form
{

    public function init()
    {
    	$etipo = new Zend_Form_Element_Select('tipoMovto');
		$etipo->setLabel('Seleccionar Tipo de Remision: ');
		$etipo->setAttrib("class", "form-control");
		
    	//foreach ($rowset as $fila) {
			//$etipo->addMultiOption($fila->idFiscales, $fila->razonSocial);
		//}
		
		$eFolio = new Zend_Form_Element_Text('folio');
		$eFolio->setLabel('Folio: ');
		$eFolio->setAttrib("class", "form-control");
		
		$eFecfac = new Zend_Form_Element_Text('fecfac');
		$eFecfac->setLabel('Fecha Remision: ');
		$eFecfac->setAttrib("class", "form-control");
		
		$columnas = array('idFiscales','razonSocial');
		$tablasFiscales = new Contabilidad_Model_DbTable_Fiscales();
		$rowset = $tablasFiscales->obtenerColumnas($columnas);
		
    	$eEmpresa =  new Zend_Form_Element_Select('empresa');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$eCliente =  new Zend_Form_Element_Select('cliente');
        $eCliente->setLabel('Seleccionar Cliente: ');
		$eCliente->setAttrib("class", "form-control");
		
		//foreach ($rowset as $fila) {
			
		//}
		$eProyecto =  new Zend_Form_Element_Select('proyecto');
        $eProyecto->setLabel('Seleccionar Proyecto: ');
		$eProyecto->setAttrib("class", "form-control");
		
		//foreach ($rowset as $fila) {
			
		//}
		$columnas=array('claveDivisa','descripcion');
		$tablaDivisa = new Contabilidad_Model_DbTable_Divisa();
		$rowset = $tablaDivisa->obtenerColumnas($columnas);
		
		$eDivisa =  new Zend_Form_Element_Select('divisa');
        $eDivisa->setLabel('Seleccionar Divisa: ');
		$eDivisa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eDivisa->addMultiOption($fila->claveDivisa, $fila->descripcion);
			
		}
		
		$eClave =  new Zend_Form_Element_Text('clave');
        $eClave->setLabel('Clave: ');
		$eClave->setAttrib("class", "form-control");
		
		
		$eCodigoBarra =  new Zend_Form_Element_Text('codigoBarra');
        $eCodigoBarra->setLabel('Codigo de Barra: ');
		$eCodigoBarra->setAttrib("class", "form-control");
		
		$eDescripcion =  new Zend_Form_Element_Text('descripcion');
        $eDescripcion->setLabel('Descripcion: ');
		$eDescripcion->setAttrib("class", "form-control");
		
		$ePresentacion =  new Zend_Form_Element_Text('presentacion');
        $ePresentacion->setLabel('Presentacion: ');
		$ePresentacion->setAttrib("class", "form-control");
		
		$eCantidad =  new Zend_Form_Element_Text('cantidad');
        $eCantidad->setLabel('Cantidad: ');
		$eCantidad->setAttrib("class", "form-control");
		
		$ePrecioUni = new Zend_Form_Element_Text('precioUnitario');
		$ePrecioUni->setLabel('Precio Unitario: ');
		$ePrecioUni->setAttrib("class", "form-control");
		
		$eImporte = new Zend_Form_Element_Text('importe');
		$eImporte->setLabel('Importe: ');
		$eImporte->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Agregar');
		$eSubmit->setAttrib("class", "btn btn-warning");
		
		//Encabezado
		$this->addElement($etipo);
		$this->addElement($eFolio);
		$this->addElement($eFecfac);
		$this->addElement($eEmpresa);
		$this->addElement($eCliente);
		$this->addElement($eProyecto);
		$this->addElement($eDivisa);

		
		//Cuerpo
		$this->addElement($eClave);
		$this->addElement($eCodigoBarra);
		$this->addElement($eDescripcion);
		$this->addElement($ePresentacion);
		$this->addElement($eCantidad);
		$this->addElement($ePrecioUni);
		$this->addElement($eImporte);
		
		//Condiciones de Pago
		
		$this->addElement($eSubmit);
	
    }


}

