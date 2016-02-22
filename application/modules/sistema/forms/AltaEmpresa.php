<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_Form_AltaEmpresa extends Zend_Form
{
    public function init()

    {
        /* Form Elements & Other Definitions Here ... */
        $tipoEmpresa = Zend_Registry::get("tipoEmpresa");
		$estadoDAO = new Inventario_DAO_Estado;
		$estados = $estadoDAO->obtenerEstados();
		$municipioDAO = new Inventario_DAO_Municipio;
        
        $subFiscales = new Zend_Form_SubForm();
		$subFiscales->setLegend("Datos Fiscales");

        //   ===============================================================
        $eRazonSocial = new Zend_Form_Element_Text("razonSocial");
		$eRazonSocial->setLabel("Razon Social: ");
		$eRazonSocial->setAttrib("class", "form-control");
        
        $eRFC = new Zend_Form_Element_Text("rfc");
		$eRFC->setLabel("R.F.C.");
		$eRFC->setAttrib("class", "form-control");
		
		$eTipoEmpresa = new Zend_Form_Element_Select("tipo");
		$eTipoEmpresa->setLabel("Tipo de Empresa: ");
		$eTipoEmpresa->setAttrib("class", "form-control");
		$eTipoEmpresa->setMultiOptions($tipoEmpresa);
        
        $subFiscales->addElements(array($eRazonSocial,$eRFC,$eTipoEmpresa));
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
		
		$eColonia = new Zend_Form_Element_Text("colonia");
		$eColonia->setLabel("Colonia");
		$eColonia->setAttrib("class", "form-control");
		
		$eCP = new Zend_Form_Element_Text("codigoPostal");
		$eCP->setLabel("Codigo Postal");
		$eCP->setAttrib("class", "form-control");
		
		$eNumInterior = new Zend_Form_Element_Text("numeroInterior");
		$eNumInterior->setLabel("Numero Interior");
		$eNumInterior->setAttrib("class", "form-control");
		
		$eNumExterior = new Zend_Form_Element_Text("numeroExterior");
		$eNumExterior->setLabel("Numero Exterior");
		$eNumExterior->setAttrib("class", "form-control");
		
		$subDomicilio->addElements(array($eEstado,$eMunicipio,$eCalle,$eNumInterior,$eNumExterior,$eColonia,$eCP));
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
		
		$eExtensiones = new Zend_Form_Element_Text("extensiones");
		$eExtensiones->setLabel("Extension");
		$eExtensiones->setAttrib("class", "form-control");
		
		$eTelefonoDescripcion = new Zend_Form_Element_Textarea("descripcion");
		$eTelefonoDescripcion->setLabel("Descripcion: ");
		$eTelefonoDescripcion->setAttrib("class", "form-control");
		$eTelefonoDescripcion->setAttrib("rows", "2");
		
		$subTelefono->addElements(array($eLada,$eTipoTelefono,$eTelefono,$eTelefonoDescripcion,$eExtensiones));
		//   ===============================================================
		$subEmail = new Zend_Form_SubForm();
		$subEmail->setLegend("Email");
		
		$eEmail = new Zend_Form_Element_Text("email");
		$eEmail->setLabel("Email");
		$eEmail->setAttrib("class","form-control");
		
		$eEmailDescripcion = new Zend_Form_Element_Textarea("descripcion");
		$eEmailDescripcion->setLabel("Descripcion: ");
		$eEmailDescripcion->setAttrib("class", "form-control");
		$eEmailDescripcion->setAttrib("rows", "2");
		
		$subEmail->addElements(array($eEmail,$eEmailDescripcion));
		
		//   ===============================================================
		$this->addSubForms(array($subFiscales,$subDomicilio,$subTelefono,$subEmail));
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Crear Empresa");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eSubmit);
    }


}

