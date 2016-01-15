<?php

class Encuesta_GeneradorController extends Zend_Controller_Action
{
	private $encuestaDAO;
	private $seccionDAO;
	private $grupoDAO;
	private $preguntaDAO;
	private $categoriaDAO;
	private $opcionDAO;
	
	private $elementDecorators;
	private $elementButtonDecorators;
	private $subformDecorators;
	private $formDecorators;
	
	private $decoratorsPregunta;
	private $decoratorsGrupo;
	private $decoratorsSeccion;

    public function init()
    {
        /* Initialize action controller here */
        $this->encuestaDAO = new Encuesta_DAO_Encuesta;
		$this->seccionDAO = new Encuesta_DAO_Seccion;
		$this->grupoDAO = new Encuesta_DAO_Grupo;
		$this->preguntaDAO = new Encuesta_DAO_Pregunta;
		$this->categoriaDAO = new Encuesta_DAO_Categoria;
		$this->opcionDAO = new Encuesta_DAO_Opcion;
		
		$this->decoratorsPregunta = array(
			'ViewHelper', //array('ViewHelper', array('class' => 'form-control') ), //'ViewHelper', 
			array(array('element' => 'HtmlTag'), array('tag' => 'td')), 
			array('Label', array('tag' => 'td') ), 
			//array('Description', array('tag' => 'td', 'class' => 'label')), 
			array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		);
		
		$this->decoratorsGrupo = array(
			//'Fieldset',
			'FormElements',
			array(array('body' => 'HtmlTag'), array('tag' => 'tbody')),
			array(array('tabla' => 'HtmlTag'), array('tag' => 'table', 'class' => 'table table-striped table-condensed')),
			array('Fieldset', array('placement' => 'prepend')),
			array(array('element' => 'HtmlTag'), array('tag' => 'td', 'colspan' => '2')),
			array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		);
		
		$this->decoratorsSeccion = array(
			'FormElements',
			array(array('body' => 'HtmlTag'), array('tag' => 'tbody')),
			array(array('tabla' => 'HtmlTag'), array('tag' => 'table', 'class' => 'table table-striped table-condensed')),
			array('Fieldset', array('placement' => 'prepend')),
		);
		
		$this->formDecorators = array(
			'FormElements',
			//'Fieldset',
			'Form'
		);
    }

    public function indexAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
		$encuesta = $this->encuestaDAO->obtenerEncuesta($idEncuesta);
		$secciones = $this->seccionDAO->obtenerSecciones($idEncuesta);
		
		$formulario = new Zend_Form($encuesta->getHash());
		
		
		//============================================= Iteramos a traves de las secciones del grupo
		foreach ($secciones as $seccion) {
			//============================================= Cada seccion es una subforma
			$subFormSeccion = new Zend_Form_SubForm($seccion->getHash());
			$subFormSeccion->setLegend("Sección: " .$seccion->getNombre());
			//============================================= Obtenemos los elemntos de la seccion
			$elementos = $this->seccionDAO->obtenerElementos($seccion->getIdSeccion());
			foreach ($elementos as $elemento) {
				//============================================= Verificamos que tipo de elemento es
				if($elemento instanceof Encuesta_Model_Pregunta){
					//============================================= Aqui ya la agregamos a la seccion
					$this->agregarPregunta($subFormSeccion, $elemento);
				}elseif($elemento instanceof Encuesta_Model_Grupo){
					//============================================= un grupo es otra subform
					$subFormGrupo = new Zend_Form_SubForm($elemento->getHash());
					$subFormGrupo->setLegend("Grupo: " . $elemento->getNombre());
					$preguntasGrupo = $this->grupoDAO->obtenerPreguntas($elemento->getIdGrupo());
					foreach ($preguntasGrupo as $pregunta) {
						//============================================= Aqui ya la agregamos al grupo
						$this->agregarPregunta($subFormGrupo, $pregunta);
					}
					$subFormGrupo->setDecorators($this->decoratorsGrupo);
					$subFormSeccion->addSubForm($subFormGrupo, $elemento->getIdGrupo());
				}
			}
			$subFormSeccion->setDecorators($this->decoratorsSeccion);
			$formulario->addSubForm($subFormSeccion, $seccion->getIdSeccion());
			
		}
		$eSubmit = new Zend_Form_Element_Submit("submit");
		$eSubmit->setLabel("Enviar Encuesta");
		$eSubmit->setAttrib("class", "btn btn-success");
		
		$formulario->addElement($eSubmit);
		$formulario->setDecorators($this->formDecorators);
		$this->view->encuesta = $encuesta;
		$this->view->formulario = $formulario;		
    }

	public function altaAction() {
		$request = $this->getRequest();
		$idEncuesta = $this->getParam("idEncuesta");
		$post = $request->getPost();
		$this->view->post = $post;
	}
	
	public function agregarPregunta(Zend_Form $contenedor, Encuesta_Model_Pregunta $pregunta)
	{
		$ePregunta = null;
		if($pregunta->getTipo() == "AB"){
			$ePregunta = new Zend_Form_Element_Text($pregunta->getHash());
			$ePregunta->setLabel($pregunta->getPregunta());
		}else{
			//Obtenemos las Opciones
			$opciones = $this->opcionDAO->obtenerOpcionesPregunta($pregunta->getIdPregunta());
			if($pregunta->getTipo() == "SS"){
				$ePregunta = new Zend_Form_Element_Radio($pregunta->getHash());
			}elseif($pregunta->getTipo() == "MS"){
				$ePregunta = new Zend_Form_Element_MultiCheckbox();
			}
			foreach ($opciones as $opcion) {
				$ePregunta->addMultiOption($opcion->getIdOpcion(), $opcion->getOpcion());
			}
		}
		$ePregunta->setAttrib("class", "form-control");
		$ePregunta->setDecorators($this->decoratorsPregunta);
		$contenedor->addElement($ePregunta);
		
		return $contenedor;
	}	
}

