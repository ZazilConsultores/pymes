<?php

class Contabilidad_Form_AltaBanco extends Zend_Form
{

    public function init()
    {
    	$divisaDAO = new Contabilidad_DAO_Divisa;
		$divisas = $divisaDAO->obtenerDivisas();
		
		$bancoDAO = new Contabilidad_DAO_Banco;
		$bancos = $bancoDAO->obtenerBancos();
		
		$tablasFiscales = new Inventario_DAO_Empresa();
		$rowset = $tablasFiscales->obtenerInformacionEmpresasIdFiscales();
		
		$eEmpresa = new Zend_Form_Element_Select('idEmpresa');
		$eEmpresa->setLabel('Seleccionar Empresa: ');
		$eEmpresa->setAttrib("class", "form-control");
		
		foreach ($rowset as $fila) {
			$eEmpresa->addMultiOption($fila->idFiscales, $fila->razonSocial);
		}
		
    	$eSucursal = new Zend_Form_Element_Select('idSucursal');
		$eSucursal->setLabel("Sucursal: ");
		$eSucursal->setAttrib("class", "form-control");
		$eSucursal->setRegisterInArrayValidator(FALSE);
		
		$eIdBanco = new Zend_Form_Element_Select('idBanco');
		$eIdBanco->setLabel("Banco: ");
		$eIdBanco->setAttrib("class", "form-control");
		foreach ($bancos as $fila) {
			$eIdBanco->addMultiOption($fila->getIdBanco(), $fila->getBanco());
		}
    		
     	$eNumCuenta = new Zend_Form_Element_Text('cuenta');
		$eNumCuenta->setLabel('Número de Cuenta: ');
		$eNumCuenta->setAttrib("class", "form-control");
		
		$eBanco = new Zend_Form_Element_Text('banco');
		$eBanco->setLabel('Nombre Banco: ');
		$eBanco->setAttrib("class", "form-control");
			
		$eDivisa = new Zend_Form_Element_Select("idDivisa");
		$eDivisa->setLabel("Seleccione Divisa: ");
		$eDivisa->setAttrib("class", "form-control");
		
		foreach ($divisas as $divisa)
		{
			$eDivisa->addMultiOption($divisa->getIdDivisa(), $divisa->getDescripcion());		
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
		$eCuentaContable->setAttrib("maxlength", "4");
		
		
		$eFecha= new Zend_Form_Element_Text('fecha');
		$eFecha->setLabel('Fecha:');
		$eFecha->setAttrib("class", "form-control");
		
		$eSaldo  = new Zend_Form_Element_Text('saldo');
		$eSaldo->setLabel('Saldo $:');
		$eSaldo->setAttrib("class", "form-control");
		
		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit->setLabel('Agregar');
		$eSubmit->setAttrib("class", "btn btn-warning");
		
		$this->addElement($eEmpresa);
		$this->addElement($eSucursal);
		$this->addElement($eIdBanco);
		$this->addElement($eNumCuenta);
		$this->addElement($eBanco);
		$this->addElement($eDivisa);
		$this->addElement($eCuentaContable);
		$this->addElement($eTipoBanco);
		//$this->addElement($eFecha);
		$this->addElement($eSaldo);
		$this->addElement($eSubmit);	
    }

}

