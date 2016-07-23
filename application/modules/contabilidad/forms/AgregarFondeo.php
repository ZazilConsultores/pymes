<?php

class Contabilidad_Form_AgregarFondeo extends Zend_Form
{

    public function init()
    {
		$columnas = array('idFiscales', 'razonSocial');
		$tablaFiscales = new Contabilidad_Model_DbTable_Fiscales();
		$rowset = $tablaFiscales->obtenerColumnas($columnas);
		
		
		$eEmpresa = new Zend_Form_Element_Select('idEmpresa');
		$eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$eTipoMovimiento = new Zend_Form_Element_Select('idTipoMovimiento');
		$eTipoMovimiento->setLabel('Seleccionar Tipo de Movimiento');
		$eTipoMovimiento->setAttrib("class", "form-control");
		
		$tipoMovimientoDAO = new Contabilidad_DAO_TipoMovimiento;
		$tipoMovimientos = $tipoMovimientoDAO->obtenerTiposMovimientos();

		foreach($tipoMovimientos as $tipoMovimiento){
			$eTipoMovimiento->addMultiOption($tipoMovimiento->getIdTipoMovimiento(), $tipoMovimiento->getDescripcion());
		}

		$eFecha = new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Seleccionar fecha:');
		$eFecha->setAttrib("class", "form-control");
		
		$eNumFolio = new Zend_Form_Element_Text('numFolio');
		$eNumFolio->setLabel('Ingresar número de Folio');
		$eNumFolio->setAttrib("class", "form-control");
		
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
		
		$eIva = new Zend_Form_Element_Checkbox('iva');
		$eIva->setLabel('Iva:');
		//$eIva->setAttrib("class", "form-control");
		
		$eImportePago = new Zend_Form_Element_Text('total');
		$eImportePago->setLabel('Importe:');
		$eImportePago->setAttrib("class", "form-control");
		
		
		//==============Obtener Bancos de las empresas
		$bancosEmpresasDAO= new Contabilidad_DAO_Fondeo;
		$bancosDAO = new Inventario_DAO_Banco;
		
		$eBancoEntrada =new Zend_Form_Element_Select('idBancoE');
		$eBancoEntrada->setLabel('Banco de Entrada ');
		$eBancoEntrada->setAttrib("class", "form-control");
		
		$bancos = $bancosDAO->obtenerBancosEmpresasFondeo();
		
		foreach ($bancos as $banco){
			$bancosEmpresa = $bancosEmpresasDAO->obtenerBancosEmpresa($banco->getIdBanco());
			foreach($bancosEmpresa as $bancoEmpresa){
				$eBancoEntrada->addMultiOption($bancoEmpresa->getIdBancosEmpresas(), $banco->getBanco());
			}
		}
		
		$eBancoSalida = new Zend_Form_Element_Select('idBancoS');
		$eBancoSalida->setLabel('Seleccionar Banco Salida:');
		$eBancoSalida->setAttrib("class", "form-control");
		
		$bancos = $bancosDAO->obtenerBancos();
		
		foreach ($bancos as $banco){
			$bancosEmpresa = $bancosEmpresasDAO->obtenerBancosEmpresa($banco->getIdBanco());
			foreach($bancosEmpresa as $bancoEmpresa){
				$eBancoSalida->addMultiOption($bancoEmpresa->getIdBancosEmpresas(), $banco->getBanco());
			}
		}
		
		
		
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Agregar');
		$eSubmit->setAttrib("class", "btn btn-warning");
		
		
		$this->addElement($eEmpresa);
		$this->addElement($eTipoMovimiento);
		$this->addElement($eFecha);
		$this->addElement($eNumFolio);
		$this->addElement($eFormaFondeo);
		$this->addElement($eDivisa);
		$this->addElement($eIva);
		$this->addElement($eImportePago);
		$this->addElement($eBancoEntrada);
		$this->addElement($eBancoSalida);
		$this->addElement($eSubmit);
		
    }


}

