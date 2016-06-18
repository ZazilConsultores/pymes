<?php

class Sistema_Form_AltaSucursal extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $decoratorsCategoria = array(
			//'Fieldset',
			'FormElements',
			//array(array('body' => 'HtmlTag'), array('tag' => 'tbody')),
			array(array('tabla' => 'HtmlTag'), array('tag' => 'table', 'class' => 'table table-striped table-condensed')),
			array('Fieldset', array('placement' => 'prepend')),
			//array(array('element' => 'HtmlTag'), array('tag' => 'td', 'colspan' => '2')),
			//array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		);
		
		$decoratorsElemento = array(
			'ViewHelper', //array('ViewHelper', array('class' => 'form-control') ), //'ViewHelper', 
			array(array('element' => 'HtmlTag'), array('tag' => 'td')), 
			array('label', array('tag' => 'td') ), 
			//array('Description', array('tag' => 'td', 'class' => 'label')), 
			array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		);
        
        $tipoEmpresa = Zend_Registry::get("tipoEmpresa");
		$estadoDAO = new Inventario_DAO_Estado;
		$empresaDAO = new Sistema_DAO_Empresa;
		
		$estados = $estadoDAO->obtenerEstados();
		$municipioDAO = new Inventario_DAO_Municipio;
        //   ===============================================================
        $subSucursal = new Zend_Form_SubForm();
		$subSucursal->setLegend("Datos de Sucursal");
		
		$eNombreSucursal = new Zend_Form_Element_Text("nombreSucursal");
		$eNombreSucursal->setLabel("Nombre Sucursal");
		$eNombreSucursal->setAttrib("class", "form-control");
		$eNombreSucursal->setAttrib("required", "true");
		
		$eTipoSucursal = new Zend_Form_Element_Select("tipoSucursal");
		$eTipoSucursal->setMultiOptions(Zend_Registry::get("tipoSucursal"));
		$eTipoSucursal->setLabel("Tipo Sucursal");
		$eTipoSucursal->setAttrib("class", "form-control");
		$eTipoSucursal->setAttrib("disabled", "true");
		//$eTipoSucursal->removeMultiOption("");
		//$eTipoSucursal->setMultiOptions($options)
		
        
        $subSucursal->addElements(array($eNombreSucursal,$eTipoSucursal));
		$subSucursal->setElementDecorators($decoratorsElemento);
		$subSucursal->setDecorators($decoratorsCategoria);
		//   ===============================================================
		$subDomicilio = new Zend_Form_SubForm();
		$subDomicilio->setLegend("Domicilio");
		
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
		//$eMunicipio->setMultiOptions(array("0"=>"Seleccione Estado"));
		
		$eCalle = new Zend_Form_Element_Text("calle");
		$eCalle->setLabel("Calle:");
		$eCalle->setAttrib("class", "form-control");
		$eCalle->setAttrib("required", "true");
		
		$eColonia = new Zend_Form_Element_Text("colonia");
		$eColonia->setLabel("Colonia");
		$eColonia->setAttrib("class", "form-control");
		$eColonia->setAttrib("required", "true");
		
		$eCP = new Zend_Form_Element_Text("codigoPostal");
		$eCP->setLabel("Codigo Postal");
		$eCP->setAttrib("class", "form-control");
		$eCP->setAttrib("required", "true");
		
		$eNumInterior = new Zend_Form_Element_Text("numeroInterior");
		$eNumInterior->setLabel("Numero Interior");
		$eNumInterior->setAttrib("class", "form-control");
		
		$eNumExterior = new Zend_Form_Element_Text("numeroExterior");
		$eNumExterior->setLabel("Numero Exterior");
		$eNumExterior->setAttrib("class", "form-control");
		$eNumExterior->setAttrib("required", "true");
		
		$subDomicilio->addElements(array($eEstado,$eMunicipio,$eCalle,$eNumInterior,$eNumExterior,$eColonia,$eCP));
		$subDomicilio->setElementDecorators($decoratorsElemento);
		$subDomicilio->setDecorators($decoratorsCategoria);
		//   ===============================================================
		$subTelefono = new Zend_Form_SubForm();
		$subTelefono->setLegend("Telefono");
		$tipoTelefono = Zend_Registry::get("tipoTelefono");
		
		$eLada	 = new Zend_Form_Element_Text("lada");
		$eLada->setLabel("Lada");
		$eLada->setAttrib("class", "form-control");
		
		$eTipoTelefono = new Zend_Form_Element_Select("tipo");
		$eTipoTelefono->setLabel("Tipo de Telefono: ");
		$eTipoTelefono->setAttrib("class", "form-control");
		$eTipoTelefono->setMultiOptions($tipoTelefono);
		
		$eTelefono = new Zend_Form_Element_Text("telefono");
		$eTelefono->setLabel("Telefono");
		$eTelefono->setAttrib("class", "form-control");
		$eTelefono->setAttrib("required", "true");
		
		$eExtensiones = new Zend_Form_Element_Text("extensiones");
		$eExtensiones->setLabel("Extension");
		$eExtensiones->setAttrib("class", "form-control");
		
		$eTelefonoDescripcion = new Zend_Form_Element_Textarea("descripcion");
		$eTelefonoDescripcion->setLabel("Descripcion: ");
		$eTelefonoDescripcion->setAttrib("class", "form-control");
		$eTelefonoDescripcion->setAttrib("rows", "2");
		
		$subTelefono->addElements(array($eLada,$eTipoTelefono,$eTelefono,$eTelefonoDescripcion,$eExtensiones));
		$subTelefono->setElementDecorators($decoratorsElemento);
		$subTelefono->setDecorators($decoratorsCategoria);
		//   ===============================================================
		$subEmail = new Zend_Form_SubForm();
		$subEmail->setLegend("Email");
		
		$eEmail = new Zend_Form_Element_Text("email");
		$eEmail->setLabel("Email");
		$eEmail->setAttrib("class","form-control");
		$eEmail->setAttrib("required", "true");
		
		$eEmailDescripcion = new Zend_Form_Element_Textarea("descripcion");
		$eEmailDescripcion->setLabel("Descripcion: ");
		$eEmailDescripcion->setAttrib("class", "form-control");
		$eEmailDescripcion->setAttrib("rows", "2");
		
		$subEmail->addElements(array($eEmail,$eEmailDescripcion));
		$subEmail->setElementDecorators($decoratorsElemento);
		$subEmail->setDecorators($decoratorsCategoria);
		//   ===============================================================
		$this->addSubForms(array($subSucursal,$subDomicilio,$subTelefono,$subEmail));
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear Sucursal");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eSubmit);
    }


}

