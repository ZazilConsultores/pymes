<?php

class Consulta_Form_EmpresasClientesFR extends Zend_Form
{

    public function init()
    {
    	        $this->setMethod('post');
		
		$eEmpresa = new Zend_Form_Element_Select('empresa');
		$eEmpresa->setLabel('Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		$columnas = array('idFiscales', 'razonSocial');
		$tablaFiscales = new Contabilidad_Model_DbTable_Fiscales();
		$rowset = $tablaFiscales->obtenerColumnas($columnas);
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}

		
		$eCliente = new Zend_Form_Element_Select('cliente');
		$eCliente->setLabel('Cliente: ');
		$eCliente->setAttrib("class", "form-control");
		
		
		$eTipo = new Zend_Form_Element_Select('tipo');
		$eTipo->setLabel('Tipo de movimiento: ');
		$eTipo->setAttrib("class", "form-control");
		
		$optTipoMovimiento = array(
			'FC' => 'Factura Cliente',
			'RS' => 'Remision Cliente'
		);		
		foreach ($optTipoMovimiento as $key => $value) {
			$eTipo->addMultiOption($key, $value);
		}
		
		$eEstatus = new Zend_Form_Element_Select('estatus');
		$eEstatus->setLabel('Estatus: ');
		$eEstatus->setAttrib("class", "form-control");
		
		$optEstatusMovimiento = array('C' => 'Cancelada', 'V' => 'Vigente');
		foreach ($optEstatusMovimiento as $key => $value) {
			$eEstatus->addMultiOption($key, $value);
		}
		
		$eFechaInicial = new Zend_Form_Element_Text('fechaInicial');
		$eFechaInicial->setLabel('Fecha de Inicio: ');
		$eFechaInicial->setAttrib("class", "form-control");
		
		$eFechaFinal = new Zend_Form_Element_Text('fechaFinal');
		$eFechaFinal->setLabel('Fecha final: ');
		$eFechaFinal->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Procesar');
		$eSubmit->setAttrib("class", "btn btn-warning");
		
		$this->addElement($eTipo);
		$this->addElement($eEstatus);
		$this->addElement($eFechaInicial);
		$this->addElement($eFechaFinal);
		
		$this->addElement($eSubmit);
		
    }


}

