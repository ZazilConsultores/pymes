<?php
class Contabilidad_Form_NuevaNotaProveedor extends Zend_Form
{

    public function init()
    {
    	$this->setAttrib("id", "nuevaNotaProveedor");
        $subEncabezado = new Zend_Form_SubForm;
		$subEncabezado->setLegend("Nueva Nota Proveedor");
		
        $eNumeroFactura = new Zend_Form_Element_Text('numFolio');
		$eNumeroFactura->setLabel('Numero de Folio: ');
		$eNumeroFactura->setAttrib("class", "form-control");
		
		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Selecccionar Tipo de Movimiento:');
		$eTipoMovto->setAttrib("class", "form-control");
		//$eTipoMovto->setAttrib("disabled", "true");
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		foreach ($tipoMovimientoDAO->obtenerTiposMovimientos() as $fila) {
			if ($fila->getIdTipoMovimiento() == "7") {
				$eTipoMovto->addMultiOption($fila->getIdTipoMovimiento(), $fila->getDescripcion());
			}
		
		}
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Fecha:');
		$eFecha->setAttrib("class", "form-control");
				
		$columnas = array('idFiscales','razonSocial');
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
    	$eEmpresa =  new Zend_Form_Element_Select('idEmpresa');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel("Sucursal: ");
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		
		$proyectoDAO = new Contabilidad_DAO_Proyecto;
		$proyectos = $proyectoDAO->obtenerProyecto();
		
		$eProyecto = new Zend_Form_Element_Select('idProyecto');
        $eProyecto->setLabel('Seleccionar Proyecto:');
		$eProyecto->setAttrib("class", "form-control");
		$eProyecto->setRegisterInArrayValidator(FALSE);
	
		//$columnas = array('idEmpresa','razonSocial');
		$tablaEmpresa = new Contabilidad_DAO_NotaEntrada();  
		$rowset = $tablaEmpresa->obtenerProveedores();
		
		$eProveedor = new Zend_Form_Element_Select('idCoP');
		$eProveedor->setLabel('Seleccionar Proveedor:');
		$eProveedor->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eProveedor->addMultiOption($fila->idEmpresa, $fila->razonSocial);
		}
		
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
		$eProducto->setAttrib("required","true");

		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-success");
		$eSubmit->setAttrib("disabled", "true");

		//Agregamos los elementos correspondientes a la subformaEncabezado
		$subEncabezado->addElements(array($eNumeroFactura, $eTipoMovto,$eFecha,$eEmpresa,$eSucursal,$eDivisa,$eProveedor, $eProyecto,$eProducto));
     	$this->addSubForms(array($subEncabezado)); 
		$this->addElement($eSubmit);
		
	}
}




