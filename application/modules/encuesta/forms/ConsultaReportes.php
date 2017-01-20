<?php

class Encuesta_Form_ConsultaReportes extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $auth = Zend_Auth::getInstance();
        $dataIdentity = $auth->getIdentity();
        
        $cicloDAO = new Encuesta_DAO_Ciclo($dataIdentity["adapter"]);
        $ciclosEscolares = $cicloDAO->getAllCiclos();
        
        $eCicloEscolar = new Zend_Form_Element_Select('idCiclos');
        $eCicloEscolar->setLabel("Ciclos Escolares");
        
        foreach ($ciclosEscolares as $cicloEscolar) {
            $eCicloEscolar->addMultiOption($cicloEscolar["idCicloEscolar"],$cicloEscolar["cicloEscolar"]);
        }
        
        $this->addElement($eCicloEscolar);
        
        
    }


}

