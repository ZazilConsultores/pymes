<?php

class Contabilidad_Form_AltaBanco extends Zend_Form
{

    public function init()
    {
     	$eNumCuenta = new Zend_Form_Element_Text('cuenta');
		$eNumCuenta->setLabel('Numero de Cuenta: ');
		$eNumCuenta->setAttrib("class", "form-control");
		
		$eBanco = new Zend_Form_Element_Text('banco');
		$eBanco->setLabel('Nombre Banco: ');
		$eBanco->setAttrib("class", "form-control");
		
		/*Divisa*/
		$columnas = array('idDivisa', 'divisa');
		$tablaDivisa = new Contabilidad_Model_DbTable_Divisa();
		$rowset = $tablaDivisa->obtenerColumnas($columnas);
		
		
		$eDivisa = new Zend_Form_Element_Select('divisa');
		$eDivisa->setLabel('Divisa: ');
		$eDivisa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eDivisa->addMultiOption($fila->idDivisa, $fila->divisa);
		}
		
		
		$eTipoBanco= new Zend_Form_Element_Select('tipo');
		$eTipoBanco->setLabel('Tipo Banco:');
		$eTipoBanco->setAttrib("class", "form-control");
			
		
		$etTipoBanco = array(
			'CA' => 'Caja',
			'IN' => 'Inversiones',
			'OP' => 'Operacion'
		);
		
		$eCuentaContable= new Zend_Form_Element_Text('cuentaContable');
		$eCuentaContable->setLabel('Cuenta Contable:');
		$eCuentaContable->setAttrib("class", "form-control");
		
		$eTipoBanco->setMultiOptions($etTipoBanco);
		
		$eFecha= new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Fecha:');
		$eFecha->setAttrib("class", "form-control");
		
		$eSaldo = new Zend_Form_Element_Text('saldo');
		$eSaldo->setLabel('Saldo:');
		$eSaldo->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Agregar');
		$eSubmit->setAttrib("class", "btn btn-warning");
		
		$this->addElement($eNumCuenta);
		$this->addElement($eBanco);
		$this->addElement($eDivisa);
		$this->addElement($eCuentaContable);
		$this->addElement($eTipoBanco);
		$this->addElement($eFecha);
		$this->addElement($eSaldo);
		$this->addElement($eSubmit);	
    }


}
