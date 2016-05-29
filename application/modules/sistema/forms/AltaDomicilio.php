<?php

class Sistema_Form_AltaDomicilio extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $estadoDAO = new Inventario_DAO_Estado;
		$municipioDAO = new Inventario_DAO_Municipio;
		$estados = $estadoDAO->obtenerEstados();
		
        $eEstado = new Zend_Form_Element_Select("idEstado");
		$eEstado->setLabel("Seleccione Estado: ");
		$eEstado->setAttrib("class", "form-control");
		$eEstado->setRegisterInArrayValidator(FALSE);
		foreach ($estados as $estado) {
			$eEstado->addMultiOption($estado->getIdEstado(),$estado->getEstado());
		}
		$eEstado->setValue("9");
		
		$municipios = $municipioDAO->obtenerMunicipios("9");
		
		$eMunicipio = new Zend_Form_Element_Select("idMunicipio");
		$eMunicipio->setLabel("Seleccione Municipio: ");
		$eMunicipio->setAttrib("class", "form-control");
		$eMunicipio->setRegisterInArrayValidator(FALSE);
		foreach ($municipios as $municipio) {
			$eMunicipio->addMultiOption($municipio->getIdMunicipio(),$municipio->getMunicipio());
		}
		//$eMunicipio->clearMultiOptions();
        
		$eColonia = new Zend_Form_Element_Text('colonia');
		$eColonia->setLabel('Colonia:');
		$eColonia->setAttrib("class", "form-control");
		
		$eCP = new Zend_Form_Element_Text('codigoPostal');
		$eCP->setLabel('Codigo Postal:');
		$eCP->setAttrib("class", "form-control");
		
        $eCalle = new Zend_Form_Element_Text('calle');
		$eCalle->setLabel('Calle:');
		$eCalle->setAttrib("class", "form-control");
		
		$eNumeroInterior = new Zend_Form_Element_Text('numeroInterior');
		$eNumeroInterior->setLabel('Numero Interior:');
		$eNumeroInterior->setAttrib("class", "form-control");
		
		$eNumeroExterior = new Zend_Form_Element_Text('numeroExterior');
		$eNumeroExterior->setLabel('Numero Exterior:');
		$eNumeroExterior->setAttrib("class", "form-control");
		
		$eAgregar = new Zend_Form_Element_Submit('submit');
		$eAgregar->setLabel('Agregar');
		$eAgregar->setAttrib("class", "btn btn-primary");
		
		$this->addElement($eEstado);
		$this->addElement($eMunicipio);
		$this->addElement($eColonia);
		$this->addElement($eCalle);
		$this->addElement($eCP);
		$this->addElement($eNumeroInterior);
		$this->addElement($eNumeroExterior);
		$this->addElement($eAgregar);
    }


}

