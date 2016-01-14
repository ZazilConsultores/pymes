<?php

class Encuesta_Form_AltaOpcion extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $tablaCategorias = new Encuesta_Model_DbTable_Categoria;
		$categorias = $tablaCategorias->fetchAll();
        //$categorias = null;
        
        $eOpcion = new Zend_Form_Element_Text("opcion");
        $eOpcion->setLabel("Opcion: ");
		$eOpcion->setAttrib("class", "form-control");
		
		$eCategoria = new Zend_Form_Element_Select("idCategoria");
		$eCategoria->setLabel("Seleccione Categoria: ");
		$eCategoria->setAttrib("class", "form-control");
		
		if(count($categorias) < 1 || is_null($categorias)){
			$eCategoria->addMultiOption("0", "No hay categorias");
			$eCategoria->setAttrib("disabled", "");
		}else{
			foreach ($categorias as $categoria) {
				$eCategoria->addMultiOption($categoria->idCategoria, $categoria->categoria);
			}
		}
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Guardar Opcion");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElements(array($eOpcion, $eCategoria, $eSubmit));
    }


}

