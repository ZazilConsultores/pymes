<?php

class Encuesta_ResultadoController extends Zend_Controller_Action
{
	private $encuestaDAO;
	private $preguntaDAO;
	private $opcionDAO;
	private $respuestaDAO;

    public function init()
    {
        /* Initialize action controller here */
        $this->respuestaDAO = new Encuesta_DAO_Respuesta;
		$this->encuestaDAO = new Encuesta_DAO_Encuesta;
		$this->preguntaDAO = new Encuesta_DAO_Pregunta;
		$this->opcionDAO = new Encuesta_DAO_Opcion;
    }

    public function indexAction()
    {
        // action body
        $this->view->encuestas = $this->encuestaDAO->obtenerEncuestas();
    }

    public function graficaAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
		$encuesta = $this->encuestaDAO->obtenerEncuesta($idEncuesta);
		$this->view->encuesta = $encuesta;
		Encuesta_Util_Normalize::normalizePreguntasSS($idEncuesta);
		
		
    }


}



