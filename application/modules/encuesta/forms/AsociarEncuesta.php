<?php

class Encuesta_Form_AsociarEncuesta extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $encuestaDAO = new Encuesta_DAO_Encuesta;
		$encuestas = $encuestaDAO->obtenerEncuestas();
		
		$eGrupo = new Zend_Form_Element_Select("id");
		
		$eEncuesta = new Zend_Form_Element_Select("idEncuesta");
		$eEncuesta->setLabel("Encuestas Disponibles: ");
		$eEncuesta->setAttrib("class", "form-control");
		
		foreach ($encuestas as $encuesta) {
			$eEncuesta->addMultiOption($encuesta->getIdEncuesta(),$encuesta->getNombre());
		}
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Registrar Encuesta");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElements(array($eEncuesta,$eSubmit));
    }


}

