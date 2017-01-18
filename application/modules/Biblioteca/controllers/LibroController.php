<?php

class Biblioteca_LibroController extends Zend_Controller_Action
{

    private $libroDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->libroDAO = new Biblioteca_DAO_Libro;
    }

    public function indexAction()
    {
        // action body
        
        $decorator = new Util_Html_Form_Decorator_HtmlHeader();
		$headerDecorator = new Util_Html_Form_Decorator_HtmlHeader();
		/*$element   = new Zend_Form_Element('foo', array(
    	'label'      => 'Información Básica',
   		'decorators' => array($decorator),
		));*/
        
        
        $formSteps = new Biblioteca_Forms_FormSteps;
		$formSteps->setAttrib("id", "altaLibro");
		//Creando primera subforma
		$subUno = new Zend_Form_SubForm('basico');
		$subUno->setLegend('Información Básica');
		
		// ==================================================
		// agregando elementos a primer subforma
		$eTitulo = new Zend_Form_Element_Text('titulo');
		$eTitulo->setLabel("Titulo: ");
		$eTitulo->setAttrib("autofocus", "");
		$eTitulo->setAttrib("class", "form-control");
		$eTitulo->setAttrib("required", "required");
		//===================================================
		$eAutor = new Zend_Form_Element_Text('autor');
		$eAutor->setLabel("Autor: ");
		$eAutor->setAttrib("class", "form-control");
		$eAutor->setAttrib("required", "required");
		//===================================================
		$eEditorial = new Zend_Form_Element_Text('editorial');
		$eEditorial->setLabel('Editorial: ');
		$eEditorial->setAttrib("class", "form-control");
		$eEditorial->setAttrib("required", "required");
		//===================================================
		$ePublicado = new Zend_Form_Element_Text('publicado');
		$ePublicado->setLabel('Año de publicación: ');
		$ePublicado->setAttrib("class", "form-control");
		$ePublicado->setAttrib("required", "required");
		
		//=================================================
		$eIdPais = new Zend_Form_Element_Text('idPaisPub');
		$eIdPais->setLabel('Pais de publicación');
		$eIdPais->setAttrib("class", "form-control");
		$eIdPais->setAttrib("required", "required");
	
		//===================================================
		
		// agregando elementos a subforma uno
		$subUno->addElements(array($eTitulo,$eAutor,$eEditorial,$ePublicado,$eIdPais));
		$subUno->setElementDecorators($formSteps->getMTextElementDecorators());
		$subUno->setDecorators($formSteps->getMSubFormDecorators());
		
		//Creando segunda subforma
		$subDos = new Zend_Form_SubForm('clasf1');
		$subDos->setLegend("Atributos");
		
		$eIdClasificacion = new Zend_Form_Element_Text('idClasificacion');
		$eIdClasificacion->setLabel('Clasificación: ');
		$eIdClasificacion->setAttrib("class", "form-control");
		$eIdClasificacion->setAttrib("required", "required");
	    //===================================================
		$eNoClasif = new Zend_Form_Element_Text('noClasif');
		$eNoClasif->setLabel("Clasificación");
		$eNoClasif->setAttrib("class", "form-control");
		$eNoClasif->setAttrib("required", "required");
	    // ==================================================
	    $eNoItem = new Zend_Form_Element_Text('noItem');
		$eNoItem->setLabel("Número de ITEM");
		$eNoItem->setAttrib("class", "form-control");
		$eNoItem->setAttrib("required", "required");
	    //===================================================
	    $eNoEdicion = new Zend_Form_Element_Text('noEdicion');
		$eNoEdicion->setLabel('Número de edición');
		$eNoEdicion->setAttrib("class", "form-control");
		$eNoEdicion->setAttrib("required", "required");
	    //==================================================
	    $eIsbn = new Zend_Form_Element_Text("isbn");
		$eIsbn->setLabel("ISBN: ");
		$eIsbn->setAttrib("class", "form-control");
		$eIsbn->setAttrib("required", "required");
		//===================================================
		$eIssn = new Zend_Form_Element_Text('issn');
		$eIssn->setLabel("ISSN");
		$eIssn->setAttrib("class", "form-control");
		$eIssn->setAttrib("required", "required");
	    //===================================================
	    
	    // agregando elementos a subforma dos
		$subDos->addElements(array($eIdClasificacion,$eNoClasif,$eNoItem,$eNoEdicion,$eIsbn,$eIssn));
		$subDos->setElementDecorators($formSteps->getMTextElementDecorators());
		$subDos->setDecorators($formSteps->getMSubFormDecorators());
	    
		//Creando tercer subforma
		$subTres = new Zend_Form_SubForm('clasf2');
		$subTres->setLegend("Caracteristicas");
		
		// ==================================================
		// agregando elementos a la tercera subforma
		
		$eIdColeccion = new Zend_Form_Element_Text("idColecion");
		$eIdColeccion->setLabel("Colección");
		$eIdColeccion->setAttrib("class", "form-control");
		$eIdColeccion->setAttrib("required", "required");
		//=================================================
		$eVolumen = new Zend_Form_Element_Text('volumen');
		$eVolumen->setLabel("Volumen");
		$eVolumen->setAttrib("class", "form-control");
		$eVolumen->setAttrib("required", "required");
		//===================================================
		$eIdMaterial = new Zend_Form_Element_Text('idMaterial');
		$eIdMaterial->setLabel("Material");
		$eIdMaterial->setAttrib("class", "form-control");
		$eIdMaterial->setAttrib("required", "required");
	
		//=================================================
		$eDimension = new Zend_Form_Element_Text('dimension');
		$eDimension->setLabel("Dimensiones");
		$eDimension->setAttrib("class","form-control");
		$eDimension->setAttrib("required", "required");
		//=================================================
	    $eSerie = new Zend_Form_Element_Text('serie');
		$eSerie->setLabel('Serie');
		$eSerie->setAttrib("class", "form-control");
		$eSerie->setAttrib("required", "required");
		//=================================================
		$ePaginas = new Zend_Form_Element_Text('paginas');
		$ePaginas->setLabel('Número de paginas: ');
		$ePaginas->setAttrib("class", "form-control");
		$ePaginas->setAttrib("required", "required");
		//=================================================
		
		// agregando elementos a subforma tres
		
		$subTres->addElements(array($eIdColeccion,$eVolumen,$eIdMaterial,$eDimension,$eSerie,$ePaginas));
		$subTres->setElementDecorators($formSteps->getMTextElementDecorators());
		$subTres->setDecorators($formSteps->getMSubFormDecorators());
		
		//Creando cuarta subforma
		$subCuatro= new Zend_Form_SubForm('clasf3');
		$subCuatro->setLegend("Etiquetas");
	    
		//=================================================
		$eAsientoPrin = new Zend_Form_Element_Text('asientoPrin');
		$eAsientoPrin->setLabel("Asiento Print");
		$eAsientoPrin->setAttrib("class", "form-control");
		$eAsientoPrin->setAttrib("required", "required");
		
		//=================================================
		$eEti008 = new Zend_Form_Element_Text('eti008');
		$eEti008->setLabel("Etiqueta 008");
		$eEti008->setAttrib("class", "form-control");
		$eEti008->setAttrib("required", "required");
		//=================================================
		$eEtiLDR = new Zend_Form_Element_Text('etiLDR');
		$eEtiLDR->setLabel("Etiqueta LDR: ");
		$eEtiLDR->setAttrib("class", "form-control");
		$eEtiLDR->setAttrib("required", "required");
		//=================================================
		$eEtiqueta = new Zend_Form_Element_Text('etiqueta');
		$eEtiqueta->setLabel("Etiqueta :");
		$eEtiqueta->setAttrib("class", "form-control");
		$eEtiqueta->setAttrib("required", "required");
		
		//================================================
		
		// agregando elementos a subforma cuatro
		
		$subCuatro->addElements(array($eAsientoPrin,$eEti008,$eEtiLDR,$eEtiqueta));
		$subCuatro->setElementDecorators($formSteps->getMTextElementDecorators());
		$subCuatro->setDecorators($formSteps->getMSubFormDecorators());
		
		
		$eSubmit = new Zend_Form_Element_Text('submit');
		$eSubmit->setLabel("Guardar");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		
		// agregar subformas a formulario
		//$formSteps->addSubForm($subUno);
		$formSteps->addSubForms(array($subUno,$subDos,$subTres,$subCuatro));
		$this->view->formSteps = $formSteps;
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
		
        $formulario = new Biblioteca_Form_AltaLibro();
		//$this->view->formulario = $formulario;
		//print_r($request->getPost());
		if ( $request->isGet() ) {
			$this->view->formulario = $formulario;
		} elseif ($request->isPost()) {
			if ($formulario->isValid($request->getPost())) {
				$datos = $formulario->getValues();
				
				$libro = new Biblioteca_Model_Libro($datos);
				
				try{
					$this->libroDAO->agregarLibro($libro);
					$this->view->messageSuccess = "El libro: <strong>".$libro->getTitulo()."</strong> ha sido agregada ";
				}catch(Exception $ex){
					$this->view->messageFail = "El libro: <strong>".$libro->getTitulo()."</strong> no ha sido agregada. Error: <strong>".$ex->getMessage()."<strong>";
				}
				
			}
			
		}
    }

    public function consultaAction()
    {
        // action body
    }

    public function adminAction()
    {
        // action body
        $idLibro = $this->getParam("idLibro");
		$libro = $this->libroDAO->obtenerLibro($idLibro);
		
        $formulario = new Biblioteca_Form_AltaLibro;
		$formulario->getElement("titulo")->setValue($libro->getTitulo());
		$formulario->getElement("autor")->setValue($libro->getAutor());
		$formulario->getElement("editorial")->setValue($libro->getEditorial());
		$formulario->getElement("publicado")->setValue($libro->getPublicado());
		$formulario->getElement("paginas")->setValue($libro->getPaginas());
		$formulario->getElement("paginas")->setValue($libro->getPaginas());
		$formulario->getElement("isbn")->setValue($libro->getIsbn());
			$formulario->getElement("codigoBarras")->setValue($libro->getCodigoBarras());
		
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		$formulario->getElement("submit")->setLabel("Actualizar Libro");
		
		$this->view->libro = $libro;
		$this->view->formulario = $formulario;
    }

    public function editaAction()
    {
        // action body
        $idLibro = $this->getParam("idLibro");
        $request = $this->getRequest();
		
		if($request->isPost()){
			$datos = $request->getPost();
			unset($datos["submit"]);
			try{
				$this->libroDAO->actualizarLibro($idLibro, $datos);
				$this->_helper->redirector->gotoSimple('admin','libro','Biblioteca', array("idLibro"=>$idLibro));
				//$this->_helper('redirector')->gotoSimple('admin','libro','Biblioteca', array("idLibro"=>$idLibro));
				//$this->view->messageSuccess = "El libro: <strong>".$datos["titulo"]."</strong> ha sido actualizado correctamente ";
			}catch(Exception $ex){
				//$this->view->messageFail = "El libro: <strong>".$datos["titulo"]."</strong> no ha sido actualizado. Error: <strong>".$ex->getMessage()."<strong>";
			}
			
			//print_r($datos);
		}
    }


}









