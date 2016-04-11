<?php

class Encuesta_Form_ConsultaGrupos extends Zend_Form
{
	
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $elementDecorators = array(
			'ViewHelper', //array('ViewHelper', array('class' => 'form-control') ), //'ViewHelper',
			array('Label', array("class"=>"control-label") ),
			array('HtmlTag', array("class"=>"form-group"))
			//array(array('element' => 'HtmlTag'), array('tag' => 'td')),
			//array('Label', array('tag' => 'td') ), 
			//array('Description', array('tag' => 'td', 'class' => 'label')), 
			//array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		);
		
		$elementButtonDecorators = array(
			'ViewHelper', //array('ViewHelper', array('class' => 'form-control') ), //'ViewHelper',
			//array('Label', array("class"=>"control-label") ),
			array('HtmlTag', array("class"=>"form-group"))
			//array(array('element' => 'HtmlTag'), array('tag' => 'td')),
			//array('Label', array('tag' => 'td') ), 
			//array('Description', array('tag' => 'td', 'class' => 'label')), 
			//array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		);
		
		$this->setLegend("Consulta de Grupos");
		
		$planDAO = new Encuesta_DAO_Plan;
		$plan = $planDAO->obtenerPlanEstudiosVigente();
        
        $cicloDAO = new Encuesta_DAO_Ciclo;
		$ciclos = $cicloDAO->obtenerCiclos($plan["idPlanE"]);
		
        $eCicloEscolar = new Zend_Form_Element_Select("ciclo");
        $eCicloEscolar->setLabel("Ciclo Escolar: ");
		$eCicloEscolar->setAttrib("class", "form-control");
		
		foreach ($ciclos as $ciclo) {
			$eCicloEscolar->addMultiOption($ciclo->getIdCiclo(),$ciclo->getCiclo()); 
		}
		
		$nivelDAO = new Encuesta_DAO_Nivel;
		$niveles = $nivelDAO->obtenerNiveles();
		
		$eNivel = new Zend_Form_Element_Select("nivel");
		$eNivel->setLabel("Nivel Educativo: ");
		$eNivel->setAttrib("class", "form-control");
		
		foreach ($niveles as $nivel) {
			$eNivel->addMultiOption($nivel->getIdNivel(),$nivel->getNivel());
		}
		
		$idNivel = $eNivel->getId();
		
		$gradosDAO = new Encuesta_DAO_Grado;
		$grados = $gradosDAO->obtenerGrados(1);
		$eGradoEscolar = new Zend_Form_Element_Select("grado");
		$eGradoEscolar->setLabel("Grado");
		$eGradoEscolar->setAttrib("class", "form-control");
		//$eGradoEscolar->addMultiOption("0","Seleccione Nivel Educativo");
		if(!is_null($grados)){
			foreach ($grados as $grado) {
				$eGradoEscolar->addMultiOption($grado->getIdGrado(),$grado->getGrado());
			}
		}
		//$eGradoEscolar->clearMultiOptions();
		$eCicloEscolar->setDecorators($elementDecorators);
		$eNivel->setDecorators($elementDecorators);
		$eGradoEscolar->setDecorators($elementDecorators);
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Consultar Grupos");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$eSubmit->setDecorators($elementButtonDecorators);
        
        $this->addElements(array($eCicloEscolar,$eNivel,$eGradoEscolar,$eSubmit));
		$this->setAttrib("class", "form-inline");
		//$this->setAttrib("class", "form-horizontal");
    }


}

