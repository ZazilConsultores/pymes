<?php
/**
 * 
 */
class Encuesta_Util_Generator {
	//DAOS para guardar los resultados de encuesta
	private $encuestaDAO;
	private $seccionDAO;
	private $grupoDAO;
	private $preguntaDAO;
	private $categoriaDAO;
	private $opcionDAO;
	private $registroDAO;
	private $respuestaDAO;
	private $preferenciaDAO;
	
	private $materiaDAO;
	private $gruposDAO;
	private $gradoDAO;
	private $nivelDAO;
	
	private $formDecorators;
	private $decoratorsSeccion;
	private $decoratorsGrupo;
	private $decoratorsPregunta;
	
	public function __construct() {
		$this->encuestaDAO = new Encuesta_DAO_Encuesta;
		$this->seccionDAO = new Encuesta_DAO_Seccion;
		$this->grupoDAO = new Encuesta_DAO_Grupo;
		$this->preguntaDAO = new Encuesta_DAO_Pregunta;
		$this->categoriaDAO = new Encuesta_DAO_Categoria;
		$this->opcionDAO = new Encuesta_DAO_Opcion;
		$this->registroDAO = new Encuesta_DAO_Registro;
		$this->respuestaDAO = new Encuesta_DAO_Respuesta;
		$this->preferenciaDAO = new Encuesta_DAO_Preferencia;
		
		$this->materiaDAO = new Encuesta_DAO_Materia;
		$this->gruposDAO = new Encuesta_DAO_Grupos;
		$this->gradoDAO = new Encuesta_DAO_Grado;
		$this->nivelDAO = new Encuesta_DAO_Nivel;
		
		$this->formDecorators = array(
			'FormElements',
			//'Fieldset',
			'Form'
		);
		
		$this->decoratorsSeccion = array(
			'FormElements',
			array(array('body' => 'HtmlTag'), array('tag' => 'tbody')),
			array(array('tabla' => 'HtmlTag'), array('tag' => 'table', 'class' => 'table table-striped table-condensed')),
			array('Fieldset', array('placement' => 'prepend')),
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
		
		$this->decoratorsPregunta = array(
			'ViewHelper', //array('ViewHelper', array('class' => 'form-control') ), //'ViewHelper', 
			array(array('element' => 'HtmlTag'), array('tag' => 'td')), 
			array('Label', array('tag' => 'td') ), 
			//array('Description', array('tag' => 'td', 'class' => 'label')), 
			array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		);
	}
	
	public function generarFormulario($idEncuesta, $idGrupo, $idDocente, $idMateria)
	{
		$encuesta = $this->encuestaDAO->obtenerEncuesta($idEncuesta);
		$secciones = $this->seccionDAO->obtenerSecciones($idEncuesta);
		
		$grupoe = $this->gruposDAO->obtenerGrupo($idGrupo);
		$grado = $this->gradoDAO->obtenerGrado($grupoe->getIdGrado());
		$nivel = $this->nivelDAO->obtenerNivel($grado->getIdNivel());
		$docente = $this->registroDAO->obtenerRegistro($idDocente);
		$materia = $this->materiaDAO->obtenerMateria($idMateria);
		
		$formulario = new Zend_Form($encuesta->getHash());
		
		$eSubCabecera = new Zend_Form_SubForm();
		$eSubCabecera->setLegend("Evaluación de Habilidades del Docente");
		
		$eEncuesta = new Zend_Form_Element_Select("idEncuesta");
		$eEncuesta->setLabel("Encuesta: ");
		$eEncuesta->setDecorators($this->decoratorsPregunta);
		$eEncuesta->setAttrib("disabled", "disabled");
		$eEncuesta->setAttrib("class", "form-control");
		$eEncuesta->addMultiOption($encuesta->getIdEncuesta(),$encuesta->getNombre());
		
		//$eLogo = new Zend_Form_Element_Image("logo");
		//$eLogo->setImage($this->view->baseUrl() . "/images/Logo.png");
		//$eLogo->setDecorators($this->decoratorsPregunta);
		//$formulario->addElement($eLogo);
		
		$eNivel = new Zend_Form_Element_Select("idNivel");
		$eNivel->setLabel("Nivel: ");
		$eNivel->setAttrib("class", "form-control");
		$eNivel->setAttrib("disabled", "disabled");
		$eNivel->addMultiOption($nivel->getIdNivel(),$nivel->getNivel());
		$eNivel->setDecorators($this->decoratorsPregunta);
		
		$eGrado = new Zend_Form_Element_Select("idGrado");
		$eGrado->setLabel("Grado: ");
		$eGrado->setAttrib("class", "form-control");
		$eGrado->setAttrib("disabled", "disabled");
		$eGrado->addMultiOption($grado->getIdGrado(),$grado->getGrado());
		$eGrado->setDecorators($this->decoratorsPregunta);
		
		$eReferencia = new Zend_Form_Element_Select("idRegistro");
		$eReferencia->setLabel("Docente : ");
		$eReferencia->addMultiOption($docente->getIdRegistro(),$docente->getApellidos().", ".$docente->getNombres());
		//$eReferencia->setValue($docente->getApellidos().", ".$docente->getNombres());
		$eReferencia->setAttrib("class", "form-control");
		$eReferencia->setAttrib("disabled", "disabled");
		$eReferencia->setDecorators($this->decoratorsPregunta);
		
		$eMateria = new Zend_Form_Element_Select("materia");
		$eMateria->setLabel("Materia: ");
		$eMateria->setAttrib("class", "form-control");
		$eMateria->setAttrib("disabled", "disabled");
		$eMateria->addMultiOption($materia->getIdMateria(),$materia->getMateria());
		//$eMateria->setValue($materia->getMateria());
		$eMateria->setDecorators($this->decoratorsPregunta);
		
		$eSubCabecera->addElements(array($eEncuesta,$eNivel,$eGrado,$eMateria,$eReferencia));
		$eSubCabecera->setDecorators($this->decoratorsSeccion);
		
		$formulario->addSubForm($eSubCabecera, "referencia");
		
		//============================================= Iteramos a traves de las secciones del grupo
		foreach ($secciones as $seccion) {
			//============================================= Cada seccion es una subforma
			$subFormSeccion = new Zend_Form_SubForm($seccion->getHash());
			//$subFormSeccion->setLegend("Sección: " .$seccion->getNombre());
			//============================================= Obtenemos los elementos de la seccion
			$grupos = $this->seccionDAO->obtenerGrupos($seccion->getIdSeccion());
			$preguntas = $this->seccionDAO->obtenerPreguntas($seccion->getIdSeccion());
			
			$elementos = array();
			
			foreach ($grupos as $grupo) {
				$elementos[$grupo->getOrden()] = $grupo;
			}
			
			foreach ($preguntas as $pregunta) {
				$elementos[$pregunta->getOrden()] = $pregunta;
			}
			
			ksort($elementos);
			
			foreach ($elementos as $elemento) {
				//============================================= Verificamos que tipo de elemento es
				if($elemento instanceof Encuesta_Model_Pregunta){
					//============================================= Aqui ya la agregamos a la seccion
					$this->agregarPregunta($subFormSeccion, $elemento);
				}elseif($elemento instanceof Encuesta_Model_Grupo){
					//============================================= un grupo es otra subform
					$subFormGrupo = new Zend_Form_SubForm($elemento->getHash());
					//$subFormGrupo->setLegend("Grupo: " . $elemento->getNombre());
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
		//$eSubmit->setAttrib("disabled", "disabled");
		
		$formulario->addElement($eSubmit);
		$formulario->setDecorators($this->formDecorators);
		
		return $formulario;
	}

	public function procesarFormulario($idEncuesta,$idDocente,$post)
	{
		//print_r($post);
		$registro = $this->registroDAO->obtenerRegistro($idDocente);
		
		$preguntaDAO = $this->preguntaDAO;
		$numContenedores = count($post);
		$numContenedores--;
		//print_r("numContenedores: ".$numContenedores);
		//print_r("<br />");
		//print_r("secciones: <br />");
		$secciones = array_values($post);
		//print_r($secciones);
		//print_r("<br />");
		//$encabezado = $secciones[0];
		//$idEncuesta = $encabezado["idEncuesta"];
		//$registro = $docente;//$this->registroDAO->obtenerRegistroReferencia($encabezado["referencia"]);
			
		//Recorremos todas las secciones
		//print_r("<br />");
		//print_r("====================");
		//print_r("<br />");
			for ($index = 1; $index < $numContenedores; $index++) {
				//tomamos una seccion
				$seccion = $secciones[$index];
				//print_r($seccion);
				//print_r("<br />");
				//print_r("====================");
				foreach ($seccion as $preguntas) {
					foreach ($preguntas as $idPregunta => $idRespuesta) {
						
						$pregunta = $preguntaDAO->obtenerPregunta($idPregunta);
						
						$respuesta = array();
						
						$respuesta["idEncuesta"] = $idEncuesta;
						$respuesta["idRegistro"] = $registro->getIdRegistro();
						$respuesta["idPregunta"] = $idPregunta;
						$respuesta["respuesta"] = $idRespuesta;
						
						$modelRespuesta = new Encuesta_Model_Respuesta($respuesta);
						$mRespuesta = $this->respuestaDAO->crearRespuesta($idEncuesta, $modelRespuesta);
						//print_r($respuesta);
						//print_r("<br />");
						//Insertamos en la tabla PreferenciaSimple
						/*
						if($pregunta->getTipo() != "AB"){
							if($pregunta->getTipo() == "SS"){
								//Quiza sea el primer registro, quiza sea un registro secundario
								$this->preferenciaDAO->agregarPreferenciaPregunta($idPregunta, $idRespuesta);
								
							}
						}
						*/
					}
				}
				//print_r("<br />");
				//print_r("====================");
				/*
				foreach ($seccion as $idPregunta => $resp) {
					$pregunta = $this->preguntaDAO->obtenerPregunta($idPregunta);
					
					$respuesta = array();
					
					$respuesta["idRegistro"] = $registro->getIdRegistro();
					$respuesta["idEncuesta"] = $idEncuesta;
					$respuesta["idPregunta"] = $idPregunta;
					$respuesta["respuesta"] = implode(",", $resp);
					
					$modelRespuesta = new Encuesta_Model_Respuesta($respuesta);
					//$modelRespuesta->setHash($modelRespuesta->getHash());
					//$modelRespuesta->setFecha(date("Y-m-d H:i:s", time()));
					
					$this->respuestaDAO->crearRespuesta($idEncuesta, $modelRespuesta);
				}
				*/
			}	
	}
	
	private function agregarPregunta(Zend_Form $contenedor, Encuesta_Model_Pregunta $pregunta)
	{
		$ePregunta = null;
		if($pregunta->getTipo() == "AB"){
			$ePregunta = new Zend_Form_Element_Textarea($pregunta->getIdPregunta());
			$ePregunta->setAttrib("class", "form-control");
			$ePregunta->setAttrib("rows", "2");
		}else{
			//Obtenemos las Opciones
			$opciones = $this->opcionDAO->obtenerOpcionesPregunta($pregunta->getIdPregunta());
			if($pregunta->getTipo() == "SS"){
				$ePregunta = new Zend_Form_Element_Radio($pregunta->getIdPregunta());
				
			}elseif($pregunta->getTipo() == "MS"){
				$ePregunta = new Zend_Form_Element_MultiCheckbox($pregunta->getIdPregunta());
			}
			
			foreach ($opciones as $opcion) {
				$ePregunta->addMultiOption($opcion->getIdOpcion(), $opcion->getOpcion());//->setSeparator("");
			}
		}
		$ePregunta->setLabel($pregunta->getPregunta());
		//$ePregunta->setAttrib("class", "form-control");
		$ePregunta->setDecorators($this->decoratorsPregunta);
		$contenedor->addElement($ePregunta);
		
		return $contenedor;
	}
}

?>