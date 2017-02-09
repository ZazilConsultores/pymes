<?php

class Contabilidad_Form_AgregarFondeo extends Zend_Form
{

    public function init()
    {
    	$decoratorsPresentacion = array(
    		'FormElements',
    		array(array('tabla'=>'Htmltag'),array('tag'=>'table','class'=>'table table-striped table-condensed')),
    		array('Fieldset', array('placement'=>'prepend'))
		);
		
		$decoratorsElemento = array(
			'ViewHelper',
			array(array('element'=>'HtmlTag'), array('tag'=>'td')),
			array('label',array('tag'=>'td')),
			array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
		);
		
		$subEncabezado = new Zend_Form_SubForm;
	
		$eTipoMovimiento = new Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovimiento->setLabel('Tipo Movimiento:');
		$eTipoMovimiento->setAttrib("class", "form-control");
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tipoMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();

		foreach($tipoMovimientos as $tipoMovimiento){
			if($tipoMovimiento->getIdTipoMovimiento()=="3"){
				$eTipoMovimiento->addMultiOption($tipoMovimiento->getIdTipoMovimiento(), $tipoMovimiento->getDescripcion());
			}
			
		}
		
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
    	$eEmpresa =  new Zend_Form_Element_Select('idEmpresas');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel('Sucursal:');
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setAttrib("required", "true");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Seleccionar fecha:');
		$eFecha->setAttrib("class", "form-control");
		$eFecha->setAttrib("required", "true");
		
		$eNumFolio = new Zend_Form_Element_Text('numFolio');
		$eNumFolio->setLabel('Ingresar número de Folio:');
		$eNumFolio->setAttrib("class", "form-control");
		$eNumFolio->setAttrib("required", "true");
		
		$eProducto = new Zend_Form_Element_Select('idProducto');
		$eProducto->setLabel('Seleccionar Producto:');
		$eProducto->setAttrib("class", "form-control");
		
		$productosDAO = new Inventario_DAO_Producto;
		$productos = $productosDAO->obtenerProductos();
		
		foreach ($productos as $producto){
			if($producto->getClaveProducto()=="VSSOOT"){
				$eProducto->addMultiOption($producto->getIdProducto(), $producto->getProducto());
			}
		}
		$subFondeo = new Zend_Form_SubForm;
			
		$formaFondeo = Zend_Registry::get('formaPago');
		$eFormaFondeo = new Zend_Form_Element_Select('formaPago');
		$eFormaFondeo->setLabel('Seleccionar Forma de Fondeo:');
		$eFormaFondeo->setAttrib("class", "form-control");
		$eFormaFondeo->setMultiOptions($formaFondeo);
	
		$eDivisa =  new Zend_Form_Element_Select('idDivisa');
		$eDivisa->setLabel('Seleccionar Divisa:');
		$eDivisa->setAttrib("class", "form-control");
		
		$divisaDAO = new Contabilidad_DAO_Divisa;
		$divisas = $divisaDAO->obtenerDivisas();
		
        foreach ($divisas as $fila) {
			$eDivisa->addMultiOption($fila->getIdDivisa(), $fila->getDescripcion());
		}
		
		//==============Obtener Bancos de las empresas
		$tablaBancosEmpresa = new Contabilidad_DAO_Fondeo;
		$rowset =$tablaBancosEmpresa->obtenerBancosEmpresas();
		
		$eBancoEntrada = new Zend_Form_Element_Select('idBancoE');
		$eBancoEntrada->setLabel('Seleccionar Banco Entrada');
		$eBancoEntrada->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila){
			$eBancoEntrada->addMultiOption($fila->idBancosEmpresas, $fila->banco);
		}
			
		$eBancoSalida = new Zend_Form_Element_Select('idBancoS');
		$eBancoSalida->setLabel('Seleccionar Banco Salida:');
		$eBancoSalida->setAttrib("class", "form-control");
		
		foreach($rowset as $fila){
			$eBancoSalida->addMultiOption($fila->idBancosEmpresas, $fila->banco);
			
		}
		
		$eImportePago = new Zend_Form_Element_Text('total');
		$eImportePago->setLabel('Importe:');
		$eImportePago->setAttrib("class", "form-control");
		$eImportePago->setAttrib("required","true");
		
			
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Agregar');
		$eSubmit->setAttrib("class", "btn btn-warning");
		
		$subEncabezado->addElements(array($eTipoMovimiento,$eEmpresa,$eSucursal,$eFecha,$eNumFolio));
		$subEncabezado->setElementDecorators($decoratorsElemento);
		$subEncabezado->setDecorators($decoratorsPresentacion);
		
		$subFondeo->addElements(array($eProducto,$eFormaFondeo,$eDivisa,$eBancoEntrada,$eBancoSalida,$eImportePago));
		$subFondeo->setElementDecorators($decoratorsElemento);
		$subFondeo->setDecorators($decoratorsPresentacion);
		
		$this->addSubForms(array($subEncabezado, $subFondeo));

		$this->addElement($eSubmit);
		
    }


}

