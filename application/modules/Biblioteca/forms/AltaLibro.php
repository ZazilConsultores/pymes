<?php

class Biblioteca_Form_AltaLibro extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttrib("id", "altaLibro");
		
		$eTitulo = new Zend_Form_Element_Text("titulo");
		$eTitulo->setLabel("Titulo del libro");
		$eTitulo->setAttrib("class","form-control");
		$eTitulo->setAttrib("required","required");
		
		$eAutor = new Zend_Form_Element_Text("autor");
		$eAutor->setLabel("Autor(es) del libro");
		$eAutor->setAttrib("class", "form-control");
		$eAutor->setAttrib("required","required");
		
		$eEditorial = new Zend_Form_Element_Text("editorial");
		$eEditorial->setLabel("Editorial del libro");
		$eEditorial->setAttrib("class", "form-control");
		$eEditorial->setAttrib("required", "required");
		
		$ePublicacion = new Zend_Form_Element_Text("publicado");
		$ePublicacion->setLabel("Año de publicación");
		$ePublicacion->setAttrib("class", "form-control");
		$ePublicacion->setAttrib("maxlenght", "4");
		$ePublicacion->setAttrib("minlenght", "4");
		$ePublicacion->setAttrib("required", "required");
		
		$ePaginas = new Zend_Form_Element_Text("paginas");
		$ePaginas->setLabel("Número de paginas");
		$ePaginas->setAttrib("class", "form-control");
		$ePaginas->setAttrib("required", "required");
		
		$eIsbn = new Zend_Form_Element_Text("isbn");
		$eIsbn->setLabel("ISBN (Número Estándar Internacional de Libros)");
		$eIsbn->setAttrib("maxlenght", "17");
		$eIsbn->setAttrib("class", "form-control");
		$eIsbn->setAttrib("required", "required");
		
		$eCodigoBarras = new Zend_Form_Element_Text("codigoBarras>");
		$eCodigoBarras->setLabel("Ingresa el código de bararras (Máximo 13 digítos)");
		$eCodigoBarras->setAttrib("class", "form-control");
		$eCodigoBarras->setAttrib("maxlenght", "13");
		//$eCodigoBarras->setAttrib("required", "required");
		
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Guardar Libro");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$this->addElement($eTitulo);
		$this->addElement($eAutor);
		$this->addElement($eEditorial);
		$this->addElement($ePublicacion);
		$this->addElement($ePaginas);
		$this->addElement($eIsbn);
		$this->addElement($eCodigoBarras);
		
		$this->addElement($eSubmit);
    }


}

