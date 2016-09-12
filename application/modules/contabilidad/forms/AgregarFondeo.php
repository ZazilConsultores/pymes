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
		$subEncabezado->setLegend("Nuevo Fondeo");

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
		$eSucursal->setRegisterInArrayValidator(FALSE);
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Seleccionar fecha:');
		$eFecha->setAttrib("class", "form-control");
		
		$eNumFolio = new Zend_Form_Element_Text('numFolio');
		$eNumFolio->setLabel('Ingresar número de Folio:');
		$eNumFolio->setAttrib("class", "form-control");
		
		
		
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
		$fondeoDAO = new Contabilidad_DAO_Fondeo;
		$bancoEmpresas = $fondeoDAO->obtenerBancosEmpresas();
		$bancosDAO = new Inventario_DAO_Banco;
		//$banco = $bancosDAO->obtenerBanco($idBanco);
		 
		$eBancoEntrada =new Zend_Form_Element_Select('idBancoE');
		$eBancoEntrada->setLabel('Seleccionar Banco de Entrada: ');
		$eBancoEntrada->setAttrib("class", "form-control");
	
		foreach($bancoEmpresas as $bancoEmpresa){
			$banco = $bancosDAO->obtenerBanco($bancoEmpresa->getIdBanco());
			$eBancoEntrada->addMultiOption($bancoEmpresa->getIdEmpresa(), $banco->getCuenta());
			
		}	
			
		$eBancoSalida = new Zend_Form_Element_Select('idBancoS');
		$eBancoSalida->setLabel('Seleccionar Banco Salida:');
		$eBancoSalida->setAttrib("class", "form-control");
		
		foreach($bancoEmpresas as $bancoEmpresa){
			$banco = $bancosDAO->obtenerBanco($bancoEmpresa->getIdBanco());
			$eBancoSalida->addMultiOption($bancoEmpresa->getIdEmpresa(), $banco->getCuenta());
			
		}
		
		$eIva = new Zend_Form_Element_Checkbox('iva');
		$eIva->setLabel('Iva:');
		//$eIva->setAttrib("class", "form-control");
		
		$eImportePago = new Zend_Form_Element_Text('total');
		$eImportePago->setLabel('Importe:');
		$eImportePago->setAttrib("class", "form-control");
		
			
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Agregar');
		$eSubmit->setAttrib("class", "btn btn-warning");
		
		$subEncabezado->addElements(array($eTipoMovimiento,$eEmpresa,$eSucursal,$eFecha,$eNumFolio));
		$subEncabezado->setElementDecorators($decoratorsElemento);
		$subEncabezado->setDecorators($decoratorsPresentacion);
		
		$this->addSubForms(array($subEncabezado));
		
		$this->addElement($eProducto);
		$this->addElement($eDivisa);
		$this->addElement($eFormaFondeo);
		
		
		$this->addElement($eBancoEntrada);
		$this->addElement($eBancoSalida);
		$this->addElement($eIva);
		$this->addElement($eImportePago);
		
		$this->addElement($eSubmit);
		
    }


}

