<?php

/**
 * 
 */
class Encuesta_Util_Normalize {
	
	private $tablaPreferenciaSimple;
	private $tablePregunta;
	private $tableRespuesta;
	
	function __construct($argument) {
		$this->tablaPreferenciaSimple = new Encuesta_Model_DbTable_PreferenciaSimple;
		$this->tablePregunta = new Encuesta_Model_DbTable_Pregunta;
		$this->tableRespuesta = new Encuesta_Model_DbTable_Respuesta;
	}
	
	public static function nomalizePreguntasSeccion($idSeccion) {
		
	}
	
	public static function normalizePreguntasSS($idEncuesta) {
		$tablaPregunta = new Encuesta_Model_DbTable_Pregunta;
		$tablaRespuesta = new Encuesta_Model_DbTable_Respuesta;
		$tablaPreferenciaSimple = new Encuesta_Model_DbTable_PreferenciaSimple;
		
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("tipo = ?", "SS");
		//Tenemos todas las preguntas
		$rowsPreguntas = $tablaPregunta->fetchAll($select);
		//recorremos todas las preguntas
		foreach ($rowsPreguntas as $rowP) {
			//Obtenemos los id's de las opciones de la pregunta
			$idOpciones = explode(",", $rowP->opciones);
			print_r("idOpciones Pregunta: ");
			print_r($rowP->pregunta);
			print_r("<br />");
			print_r($idOpciones);	//idOpciones ordenadas de 0 a N 
			print_r("<br />");
			//Obtenemos todas las respuestas de la pregunta
			$select = $tablaRespuesta->select()->from($tablaRespuesta)->where("idPregunta = ?", $rowP->idPregunta);
			$rowsRP = $tablaRespuesta->fetchAll($select);
			
			$preferencia = array();
			
			foreach ($idOpciones as $idOpcion) {
				$preferencia[$idOpcion] = 0;
			}
			//print_r($rowsRP->toArray());
			print_r("<br />");
			foreach ($rowsRP as $rowRP) {
				//De las respuestas que trajimos filtramos por opcion seleccionada
				//print_r($rowRP->toArray());
				$idOpcion = $rowRP->respuesta; 
				print_r($idOpcion);
				print_r("<br />");
				foreach ($preferencia as $id => $numero) {
					
					if($id == $idOpcion){
						//$numero++;
						//$preferencia[$id] = $numero;
						$preferencia[$id]++;
					}
					
					print_r($id);
					print_r(" --- ");
					print_r($numero);
					print_r("<br />");
				}
				
				
				
				/*
				$preferencia[$rowRP->respuesta]++;
				print_r($preferencia[$rowRP->respuesta]);
				print_r("<br />");*/
				/*
				foreach ($preferencia as $idOpcion => $veces) {
					if($idOpcion == $rowRP->respuesta) {
						$preferencia[$idOpcion] = $veces++;
					}
				}
				*/
			}
			/* Aqui ya preferencia tiene */
			
			print_r("Preferencia");
			print_r("<br />");
			print_r($preferencia);
			print_r("<br />");
			print_r("===================================================");
			print_r("<br />");
		}
	}
}
