<?php

class Inventario_Form_CrearProductoTerminado extends Zend_Form
{

    public function init()
    {
        $parametroDAO = new Inventario_DAO_Parametro;		
		$subparametroDAO = new Sistema_DAO_Subparametro;
		
		$subparametros= $subparametroDAO->obtenerSubparametroMateria($idSubparametro = 2);		
			/*$elemento = new Zend_Form_Element_Select($subparametros->getIdParametro());
			$elemento->setLabel($subparametros->getParametro());
			$elemento->setRegisterInArrayValidator(FALSE);	
			$elemento->addMultiOption("0","Seleccione opcion");
			$elemento->setAttrib('required' , 'true');
			$elemento->setAttrib("class", "form-control");
				
			foreach ($subparametros as $subparametro){
				$elemento->addMultiOption($subparametro->getIdParametro(), $subparametro->getSubparametro());
			}*/
    }


}

