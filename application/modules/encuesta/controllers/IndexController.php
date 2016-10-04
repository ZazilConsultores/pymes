<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */

class Encuesta_IndexController extends Zend_Controller_Action
{

    private $gruposDAO = null;
    private $grupoDAO = null;
    private $gradoDAO = null;
    private $cicloDAO = null;
    private $nivelDAO = null;
    private $encuestaDAO = null;
    private $seccionDAO = null;
    private $generador = null;
    private $preguntaDAO = null;
    private $registroDAO = null;
    private $respuestaDAO = null;
    private $preferenciaDAO = null;
    private $reporteDAO = null;
	private $materiaDAO = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->encuestaDAO = new Encuesta_DAO_Encuesta;
		$this->seccionDAO = new Encuesta_DAO_Seccion;
		$this->grupoDAO = new Encuesta_DAO_Grupo;
		$this->preguntaDAO = new Encuesta_DAO_Pregunta;
		
		$this->registroDAO = new Encuesta_DAO_Registro;
		
		$this->gradoDAO = new Encuesta_DAO_Grado;
		$this->nivelDAO = new Encuesta_DAO_Nivel;
		$this->cicloDAO = new Encuesta_DAO_Ciclo;
		$this->gruposDAO = new Encuesta_DAO_Grupos;
		
		$this->respuestaDAO = new Encuesta_DAO_Respuesta;
		$this->preferenciaDAO = new Encuesta_DAO_Preferencia;
		
		$this->reporteDAO = new Encuesta_DAO_Reporte;
		
		$this->generador = new Encuesta_Util_Generator();
		
		$this->materiaDAO = new Encuesta_DAO_Materia;
    }

    public function indexAction()
    {
        // action body
        $this->view->encuestas = $this->encuestaDAO->getAllEncuestas();
    }

    public function adminAction()
    {
        // action body
        $request = $this->getRequest();
		$idEncuesta = $this->getParam("idEncuesta");
		$encuesta = $this->encuestaDAO->getEncuestaById($idEncuesta);
		
		$this->view->encuesta = $encuesta;
		//$this->view->secciones = $this->seccionDAO->obtenerSecciones($idEncuesta);
		
		$formulario = new Encuesta_Form_AltaEncuesta;
		$formulario->getElement("nombre")->setValue($encuesta->getNombre());
		$formulario->getElement("nombreClave")->setValue($encuesta->getNombreClave());
		$formulario->getElement("descripcion")->setValue($encuesta->getDescripcion());
		$formulario->getElement("estatus")->setValue($encuesta->getEstatus());
		$formulario->getElement("submit")->setLabel("Actualizar Encuesta");
		$formulario->getElement("submit")->setAttrib("class", "btn btn-warning");
		
		$this->view->formulario = $formulario;
		
    }

    public function altaAction()
    {
        // action body
        $request = $this->getRequest();
        $formulario = new Encuesta_Form_AltaEncuesta;
		
		$this->view->formulario = $formulario;
		if($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				
				$encuesta = new Encuesta_Models_Encuesta($datos);
				try{
					$this->encuestaDAO->addEncuesta($encuesta);
				}catch(Exception $ex){
					print_r($ex->getMessage());
				}
			}
		}
    }

    public function editaAction()
    {
        // action body
        $request = $this->getRequest();
		$idEncuesta = $this->getParam("idEncuesta");
		$post = $request->getPost();
		//$fInicio = new Zend_Date($post["fechaInicio"], 'yyyy-MM-dd hh-mm-ss');
		//$fFin = new Zend_Date($post["fechaFin"], 'yyyy-MM-dd hh-mm-ss');
		//$post['fechaInicio'] = $fInicio->toString('yyyy-MM-dd hh-mm-ss');
		//$post['fechaFin'] = $fFin->toString('yyyy-MM-dd hh-mm-ss');
		unset($post["submit"]);
		
		$this->encuestaDAO->editarEncuesta($idEncuesta, $post);
		$this->_helper->redirector->gotoSimple("admin", "index", "encuesta", array("idEncuesta" => $idEncuesta));
    }

    public function bajaAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
		$this->encuestaDAO->eliminarEncuesta($idEncuesta);
		$this->_helper->redirector->gotoSimple("index", "index", "encuesta");
    }

    public function seccionesAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
		$encuesta = $this->encuestaDAO->getEncuestaById($idEncuesta);
		$secciones = $this->seccionDAO->getSeccionesByIdEncuesta($idEncuesta);
		$this->view->secciones = $secciones;
		$this->view->encuesta = $encuesta;
    }

    public function tiposAction()
    {
        // action body
    }

    public function altaeAction()
    {
        // action body
        $request = $this->getRequest();
		$idGrupo = $this->getParam("idGrupo");
		$formulario = new Encuesta_Form_AltaEncuestaEvaluativa;
		if(!is_null($idGrupo)){
			//$grupo = $this->gruposDAO->obtenerGrupo($idGrupo);
			//$formulario->getElement("")->clearMultiOptions();
			
		}
		$this->view->formulario = $formulario;
		
		
    }

    public function altasAction()
    {
        // action body
    }

    public function encuestaAction()
    {
        // action body
        $request = $this->getRequest();
		$generador = $this->generador;
		
		$idEncuesta = $this->getParam("idEncuesta");
		$idAsignacion = $this->getParam("idAsignacion");
		
		$asignacion = $this->gruposDAO->obtenerAsignacion($idAsignacion);
		
		$formulario = $generador->generarFormulario($idEncuesta, $idAsignacion);
		
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}
		
		if ($request->isPost()) {
			$post = $request->getPost();
			
			try{
				$generador->procesarFormulario($idEncuesta,$idAsignacion,$post);
				$this->view->messageSuccess = "Encuesta registrada correctamente";
			}catch(Exception $ex){
				$this->view->messageFail = "Error al Registrar la encuesta: " . $ex->getMessage();
			}
			
		}
		
    }

    public function resultadoAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
		$idAsignacion = $this->getParam("idAsignacion");
		$asignacion = $this->gruposDAO->obtenerAsignacion($idAsignacion);
		
		$idRegistro = $asignacion["idRegistro"];
		$idMateria = $asignacion["idMateriaEscolar"];
		$idGrupo = $asignacion["idGrupoEscolar"];
		
		$grupo = $this->gruposDAO->obtenerGrupo($idGrupo);
		$encuesta = $this->encuestaDAO->getEncuestaById($idEncuesta);//->obtenerEncuesta($idEncuesta);
		$registro = $this->registroDAO->obtenerRegistro($idRegistro);
		
		$preguntas = $this->preguntaDAO->getPreguntasByIdEncuesta($idEncuesta);//->obtenerPreguntasEncuesta($idEncuesta);
		$this->view->asignacion = $asignacion;
		$this->view->grupo = $grupo;
		$this->view->docente = $registro;
		$this->view->encuesta = $encuesta;
		$this->view->preguntas = $preguntas;
		
    }
	
	public function resgrupalAction()
    {
    	// action body
        $request = $this->getRequest();
        
        $idEncuesta = $this->getParam("idEncuesta");
		$idAsignacion = $this->getParam("idAsignacion");
		//$asignacion = $this->gruposDAO->obtenerAsignacion($idAsignacion);
		$this->view->asignacion = $this->gruposDAO->obtenerAsignacion($idAsignacion);
		$this->view->encuesta = $this->encuestaDAO->obtenerEncuesta($idEncuesta);
		
		$this->view->encuestaDAO = $this->encuestaDAO;
		$this->view->seccionDAO = $this->seccionDAO;
		$this->view->grupoDAO = $this->grupoDAO;
		$this->view->preguntaDAO = $this->preguntaDAO;
		
		$this->view->registroDAO = $this->registroDAO;
		/*
		$idRegistro = $asignacion["idRegistro"];
		$idGrupo = $asignacion["idGrupo"];
		$idMateria = $asignacion["idMateria"];
		
		$encuesta = $this->encuestaDAO->obtenerEncuesta($idEncuesta);
		$registro = $this->registroDAO->obtenerRegistro($idRegistro);
		$grupo = $this->gruposDAO->obtenerGrupo($idGrupo);
		$materia = $this->materiaDAO->obtenerMateria($idMateria);
		
		$this->view->encuesta = $encuesta;
		$this->view->registro = $registro;
		$this->view->grupo = $grupo;
		$this->view->materia = $materia;
        $this->view->asignacion = $asignacion;
		//=========================================================================
		// Reporte
		$fecha = date('d-m-Y', time());
		$nombreArchivo = $grupo->getGrupo() . "-" . str_replace(' ', '', $materia->getMateria()) . str_replace(' ', '', $encuesta->getNombre()) . '.pdf';
		$this->view->nombreArchivo = $nombreArchivo; //Mandado a la vista lo tomamos en un link y al dar clic vamos a vista del reporte
		$pdf = new My_Pdf_Document($nombreArchivo, PDF_PATH . '/reports/encuesta/');
		$page = $pdf->createPage(Zend_Pdf_Page::SIZE_LETTER);
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER);
		$font2 = Zend_Pdf_Font::fontWithPath(PDF_PATH . "/fonts/ubuntu/UbuntuMono-R.ttf");
		$font3 = Zend_Pdf_Font::fontWithPath(PDF_PATH . "/fonts/microsoft/GOTHIC.TTF");
		//$page->setFont($font, 10);
		//$page->setFont($font2, 12);
		$page->setFont($font3, 10);
		
		$this->view->page = $page;
		$this->view->pdf = $pdf;
		
		
		//$pdf->addPage($page);
		//$pdf->save();
		 */
    }

    public function resumenAction()
    {
        // action body
        $request = $this->getRequest();
        
        $idEncuesta = $this->getParam("idEncuesta");
		$idAsignacion = $this->getParam("idAsignacion");
		$asignacion = $this->gruposDAO->obtenerAsignacion($idAsignacion);
		
		$idRegistro = $asignacion["idRegistro"];
		$idGrupo = $asignacion["idGrupo"];
		$idMateria = $asignacion["idMateria"];
		
		$encuesta = $this->encuestaDAO->obtenerEncuesta($idEncuesta);
		$registro = $this->registroDAO->obtenerRegistro($idRegistro);
		$grupo = $this->gruposDAO->obtenerGrupo($idGrupo);
		$materia = $this->materiaDAO->obtenerMateria($idMateria);
		
		$this->view->encuesta = $encuesta;
		$this->view->registro = $registro;
		$this->view->grupo = $grupo;
		$this->view->materia = $materia;
        $this->view->asignacion = $asignacion;
		//=========================================================================
		// Reporte
		$fecha = date('d-m-Y', time());
		$nombreArchivo = $grupo->getGrupo() . "-" . str_replace(' ', '', $materia->getMateria()) . str_replace(' ', '', $encuesta->getNombre()) . '.pdf';
		$this->view->nombreArchivo = $nombreArchivo; //Mandado a la vista lo tomamos en un link y al dar clic vamos a vista del reporte
		$pdf = new My_Pdf_Document($nombreArchivo, PDF_PATH . '/reports/encuesta/');
		$page = $pdf->createPage(Zend_Pdf_Page::SIZE_LETTER);
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER);
		$font2 = Zend_Pdf_Font::fontWithPath(PDF_PATH . "/fonts/ubuntu/UbuntuMono-R.ttf");
		$font3 = Zend_Pdf_Font::fontWithPath(PDF_PATH . "/fonts/microsoft/GOTHIC.TTF");
		//$page->setFont($font, 10);
		//$page->setFont($font2, 12);
		$page->setFont($font3, 10);
		
		$this->view->page = $page;
		$this->view->pdf = $pdf;
		
		
		//$pdf->addPage($page);
		//$pdf->save();
    }

	public function recalcularprefAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
		$idAsignacion = $this->getParam("idAsignacion");
		try{
			//$this->encuestaDAO->normalizarPreferenciaAsignacion($idEncuesta, $idAsignacion);
			$this->encuestaDAO->normalizarPreferenciasEncuestaAsignacion($idEncuesta, $idAsignacion);
		}catch(Exception $ex){
			print_r($ex->getMessage());
		}
		
    }

    public function rpreferenciaAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
		$idAsignacion = $this->getParam("idAsignacion");
		try{
			//$this->encuestaDAO->normalizarPreferenciaAsignacion($idEncuesta, $idAsignacion);
			$this->encuestaDAO->normalizarPreferenciasEncuestaAsignacion($idEncuesta, $idAsignacion);
		}catch(Exception $ex){
			print_r($ex->getMessage());
		}
		
    }

    public function repgrupalAction()
    {
        // action body
        $idReporte = $this->getParam("idReporte");
		$nombreReporte = $this->reporteDAO->obtenerReporte($idReporte);
        /*
        $reporte = new Zend_Pdf();
		$paginaUno = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_LETTER);
		$paginaUno->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
		//$paginaUno->setFont(Zend_Pdf_Font::FONT_HELVETICA, 12);
		$paginaUno->drawText("Reporte Evaluacion Docente", 50, 750, 'UTF-8');
		
		//$reporte->pages[] = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_LETTER);
		//$reporte->pages[] = $reporte->newPage(Zend_Pdf_Page::SIZE_LETTER);
		$reporte->pages[] = $paginaUno;
		$reporte->save("test.pdf");
		*/
		$this->view->nombreReporte = $nombreReporte;
		
		//$this->view->nombreReporte = $reporte["nombreReporte"];
    }

    public function reppabiertasAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
		$idAsignacion = $this->getParam("idAsignacion");
		$asignacion = $this->gruposDAO->obtenerAsignacion($idAsignacion);
		
		$idRegistro = $asignacion["idRegistro"];
		$idGrupo = $asignacion["idGrupo"];
		
		$encuesta = $this->encuestaDAO->obtenerEncuesta($idEncuesta);
		$registro = $this->registroDAO->obtenerRegistro($idRegistro);
		$grupo = $this->gruposDAO->obtenerGrupo($idGrupo);
		
		$this->view->encuesta = $encuesta;
		$this->view->registro = $registro;
		$this->view->grupo = $grupo;
        $this->view->asignacion = $asignacion;
		
		$preguntasAbiertas = $this->preguntaDAO->obtenerPreguntasAbiertasEncuesta($idEncuesta);
		
		//$this->view->encuesta = $encuesta;
		//$this->view->asignacion = $asignacion;
		$this->view->preguntasAbiertas = $preguntasAbiertas;
		//========================================================================= Reporte
		$fecha = date('d-m-Y', time());
		$nombreArchivo = 'pa/' . str_replace(' ', '', $encuesta->getNombre())."-PA-".$grupo->getGrupo(). $fecha.'.pdf';
		$this->view->nombreArchivo = $nombreArchivo; //Mandado a la vista lo tomamos en un link y al dar clic vamos a vista del reporte
		$pdf = new My_Pdf_Document($nombreArchivo, PDF_PATH . '/reports/encuesta/');
		$page = $pdf->createPage(Zend_Pdf_Page::SIZE_LETTER);
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER);
		$font2 = Zend_Pdf_Font::fontWithPath(PDF_PATH . "/fonts/ubuntu/UbuntuMono-R.ttf");
		$font3 = Zend_Pdf_Font::fontWithPath(PDF_PATH . "/fonts/microsoft/GOTHIC.TTF");
		$this->view->font = $font3;
		//$page->setFont($font, 10);
		//$page->setFont($font2, 12);
		$page->setFont($font3, 10);
		
		$this->view->page = $page;
		$this->view->pdf = $pdf;
		
    }

    public function repgeneralAction()
    {
        // action body
        $idDocente = $this->getParam("idDocente");
		$idEncuesta = $this->getParam("idEncuesta");
		
		$encuesta = $this->encuestaDAO->obtenerEncuesta($idEncuesta);
		$docente = $this->registroDAO->obtenerRegistro($idDocente);
		
		$this->view->idDocente = $idDocente;
		$this->view->idEncuesta = $idEncuesta;
		// =============================================
		$this->view->encuestaDAO = $this->encuestaDAO;
		$this->view->seccionDAO = $this->seccionDAO;
		$this->view->grupoDAO = $this->grupoDAO;
		$this->view->registroDAO = $this->registroDAO;
		$this->view->gruposDAO = $this->gruposDAO;
		// ============================================= Reporte
		
		$nombreArchivo = 'general/' . str_replace(' ', '', $encuesta->getNombre())."-GENERAL-".str_replace(' ', '', $docente->getApellidos()).",".str_replace(' ', '', $docente->getNombres()).'.pdf';
		//Mandado a la vista lo tomamos en un link y al dar clic vamos a vista del reporte
		//print_r("<br />");
		//print_r("NombreArchivo: ".$nombreArchivo);
		//print_r("<br />");
		$this->view->nombreArchivo = $nombreArchivo;
		$pdf = new My_Pdf_Document($nombreArchivo, PDF_PATH . '/reports/encuesta/');
		$page = $pdf->createPage(Zend_Pdf_Page::SIZE_LETTER);
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER);
		$font2 = Zend_Pdf_Font::fontWithPath(PDF_PATH . "/fonts/ubuntu/UbuntuMono-R.ttf");
		$font3 = Zend_Pdf_Font::fontWithPath(PDF_PATH . "/fonts/microsoft/GOTHIC.TTF");
		$this->view->font = $font3;
		//$page->setFont($font, 10);
		//$page->setFont($font2, 12);
		$page->setFont($font3, 10);
		
		$this->view->page = $page;
		$this->view->pdf = $pdf;
    }


}

