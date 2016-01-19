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
    }

    public function graficaAction()
    {
        // action body
        $idEncuesta = $this->getParam("idEncuesta");
		$encuesta = $this->encuestaDAO->obtenerEncuesta($idEncuesta);
		// Obtenemos los usuarios que han contestado la encuesta
		$clavesUsuarios = $this->respuestaDAO->obtenerIdRegistroEncuesta($idEncuesta);
		$preferencia = array();
		foreach ($clavesUsuarios as $index => $idRegistro) {
			print_r($idRegistro);
			print_r("<br />");
			$respuestasUsuario = $this->respuestaDAO->obtenerRespuestasEncuestaUsuario($idEncuesta, $idRegistro);
			//iteramos a traves de las respuestas y solo si es de seleccion guardamos la preferencia
			foreach ($respuestasUsuario as $respuestaUsuario) {
				//obtenemos la pregunta
				$pregunta = $this->preguntaDAO->obtenerPregunta($respuestaUsuario->getIdPregunta());
				
				if($pregunta->getTipo() != "AB") {
					$opciones = $this->opcionDAO->obtenerOpcionesPregunta($respuestaUsuario->getIdPregunta());
					foreach ($opciones as $opcion) {
						if($pregunta->getPregunta() == $respuestaUsuario->getRespuesta()){
							
						}
					}
					
					
					foreach ($opciones as $key => $value) {
						
					}
					$preferencia[$pregunta->getIdPregunta()] = array();
					//$preferencia[$pregunta->getIdPregunta()] = $opciones;
				}
			}
		}
		
		print_r("<br />");
		print_r("<br />");
		print_r("<br />");
		$this->view->encuesta = $encuesta;
		//print_r($respuestas);
    }


}



