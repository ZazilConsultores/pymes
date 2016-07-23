<?php

class Contabilidad_Form_AgregarNomina extends Zend_Form
{

    public function init()
    {
        $columnas = array('idFiscales', 'razonSocial');
		$tablaFiscales = new Contabilidad_Model_DbTable_Fiscales();
		$rowset = $tablaFiscales->obtenerColumnas($columnas);
		
		
		$eEmpresa = new Zend_Form_Element_Select('empresa');
		$eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
		$columnas = array('idEmpresa','razonSocial');
		$tablaEmpresa = new Contabilidad_DAO_NotaEntrada;
		$rowset = $tablaEmpresa->obtenerProveedores();
		
		$eProveedor = new Zend_Form_Element_Select('idCoP');
		$eProveedor->setLabel('Seleccionar Empleado:');
		$eProveedor->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eProveedor->addMultiOption($fila->idEmpresa, $fila->razonSocial);
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
		
		$eSueldo = new Zend_Form_Element_Text('sueldo');
		$eSueldo->setLabel('Sueldos y Salarios:');
		$eSueldo->setAttrib("class", "form-control");
		
		$eSubsidio =  new Zend_Form_Element_Text('subsidio');
		$eSubsidio->setLabel('Subsidio / Importe Exento:');
		$eSubsidio->setAttrib("class", "form-control");
		
		$eIMSS = new Zend_Form_Element_Text('imss');
		$eIMSS->setLabel('IMSS:');
		$eIMSS->setAttrib("class", "form-control");
		
		$eISPT = new Zend_Form_Element_Text('ispt');
		$eISPT->setLabel('ISPT / ISR:');
		$eISPT->setAttrib("class", "form-control");
		
		$eNominaxPagar = new Zend_Form_Element_Text('nominaxpagar');
		$eNominaxPagar->setLabel("Nomina por Pagar:");
		$eNominaxPagar->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Agregar');
		$eSubmit->setAttrib("class", "btn btn-warning");
		
		$this->addElement($eEmpresa);
		$this->addElement($eProveedor);
		$this->addElement($eTipoMovimiento);
		$this->addElement($eFecha);
		$this->addElement($eNumFolio);
		$this->addElement($eSueldo);
		$this->addElement($eSubsidio);
		$this->addElement($eIMSS);
		$this->addElement($eISPT);
		$this->addElement($eNominaxPagar);
		$this->addElement($eSubmit);
    }


}

