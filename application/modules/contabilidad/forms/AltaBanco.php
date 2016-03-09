<?php

class Contabilidad_Form_AltaBanco extends Zend_Form
{

    public function init()
    {
    	$divisaDAO = new Contabilidad_DAO_Divisa;
		$divisas = $divisaDAO->obtenerDivisas();
    		
     	$eNumCuenta = new Zend_Form_Element_Text('cuenta');
		$eNumCuenta->setLabel('Numero de Cuenta: ');
		$eNumCuenta->setAttrib("class", "form-control");
		
		$eBanco = new Zend_Form_Element_Text('banco');
		$eBanco->setLabel('Nombre Banco: ');
		$eBanco->setAttrib("class", "form-control");
			
		$eDivisa = new Zend_Form_Element_Select("idDivisa");
		$eDivisa->setLabel("Seleccione Divisa: ");
		$eDivisa->setAttrib("class", "form-control");
		
		foreach ($divisas as $divisa)
		{
			$eDivisa->addMultiOption($divisa->getIdDivisa(), $divisa->getDivisa());		
		}
	

		//tipoBanco
		$tipoBanco = Zend_Registry::get("tipoBanco");	
		//$tipoBanco = Zend_Registry::get(tipoBanco);
		$eTipoBanco = new Zend_Form_Element_Select("tipo");
		$eTipoBanco->setLabel("Tipo Banco: ");
		$eTipoBanco->setAttrib("class", "form-control");
		$eTipoBanco->setMultiOptions($tipoBanco);
		
		
		$eCuentaContable= new Zend_Form_Element_Text('cuentaContable');
		$eCuentaContable->setLabel('Cuenta Contable:');
		$eCuentaContable->setAttrib("class", "form-control");
		
		
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

