<?php

class Contabilidad_Form_AnticipoClientes extends Zend_Form
{

    public function init()
    {	
		$eTipoMovto = New Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovto->setLabel('Tipo Movimiento:');
		$eTipoMovto->setAttrib("class", "form-control");
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tiposMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();
		
		foreach ($tipoMovimientoDAO->obtenerTiposMovimientos() as $fila) {
			if ($fila->getIdTipoMovimiento() == "19") {
				$eTipoMovto->addMultiOption($fila->getIdTipoMovimiento(), $fila->getDescripcion());
			}
		
		}
		
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
		$eEmpresa =  new Zend_Form_Element_Select('idEmpresas');
        $eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idEmpresas, $fila->razonSocial);
		}
		
		$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel("Sucursal: ");
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setRegisterInArrayValidator(FALSE);
        $eSucursal->setAttrib("required","true");
		
        $tablaEmpresa = new Contabilidad_DAO_NotaSalida;
		$rowset = $tablaEmpresa->obtenerClientes();
		$eCliente = new Zend_Form_Element_Select('idCoP');
		$eCliente->setLabel('Seleccionar Cliente:');
		$eCliente->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eCliente->addMultiOption($fila->idCliente, $fila->razonSocial);
		}
		
		$eNumeroFolio = new Zend_Form_Element_Text('numeroFolio');
		$eNumeroFolio->setLabel('Número de Folio: ');
		$eNumeroFolio->setAttrib("class", "form-control");
		
		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Seleccionar Fecha:');
		$eFecha->setAttrib("class", "form-control");
		$eFecha->setAttrib("required","true");
		
		$eDivisa =  new Zend_Form_Element_Select('idDivisa');
		$eDivisa->setLabel('Seleccionar Divisa:');
		$eDivisa->setAttrib("class", "form-control");
		
		$divisaDAO = new Contabilidad_DAO_Divisa;
		$divisas = $divisaDAO->obtenerDivisas();
		
        foreach ($divisas as $fila) {
			$eDivisa->addMultiOption($fila->getIdDivisa(), $fila->getDescripcion());
		}
		
		$formaFondeo = Zend_Registry::get('formaPago');
		$eProducto = New Zend_Form_Element_Select('formaLiquidar');
		$eProducto->setLabel('Producto:');
		$eProducto->setAttrib("class", "form-control");
		$eProducto->setMultiOptions($formaFondeo);
		
		$eNumFolio = new Zend_Form_Element_Text('numeroReferencia');
		$eNumFolio->setLabel('Número referencia:');
		$eNumFolio->setAttrib("class", "form-control");
		$eNumFolio->setAttrib("required", "true");
		
		$eBanco = New Zend_Form_Element_Select('idBanco');
		$eBanco->setLabel('Banco Entrada:');
		$eBanco->setAttrib("class", "form-control");
		$eBanco->setRegisterInArrayValidator(FALSE);
		
		$eTotal = New Zend_Form_Element_Text('total');
		$eTotal->setLabel('Total:');
		$eTotal->setAttrib("class", "form-control");
		$eTotal->setAttrib("required","true");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eTipoMovto);
		$this->addElement($eEmpresa);
		$this->addElement($eSucursal);
		$this->addElement($eCliente);
		$this->addElement($eFecha);
		$this->addElement($eDivisa);
		$this->addElement($eProducto);
		$this->addElement($eNumFolio);
		$this->addElement($eBanco);
		$this->addElement($eTotal);
		$this->addElement($eSubmit);
	}


}

