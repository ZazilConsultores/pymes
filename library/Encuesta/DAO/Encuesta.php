<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_DAO_Encuesta implements Encuesta_Interfaces_IEncuesta {
	
	private $tablaEncuesta;
	private $tablaSeccion;
	private $tablaEncuestaGrupo;
	private $tablaPregunta;
	private $tablaERealizadas;
	private $tablaPreferenciaS;
	
	public function __construct()
	{
		$this->tablaEncuesta = new Encuesta_Model_DbTable_Encuesta;
		$this->tablaSeccion = new Encuesta_Model_DbTable_Seccion;
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta;
		$this->tablaEncuestaGrupo = new Encuesta_Model_DbTable_EncuestaGrupo;
		$this->tablaERealizadas = new Encuesta_Model_DbTable_ERealizadas;
		$this->tablaPreferenciaS = new Encuesta_Model_DbTable_PreferenciaSimple;
	}
	
	// =====================================================================================>>>   Buscar
	// ============================================================= Simple elemento
	/**
	 * @method obtenerEncuestaId Obtiene una encuesta en base a un id proporcionado.
	 * @param int $idEncuesta
	 * @return Encuesta_Model_Encuesta $encuestaM
	 */
	public function obtenerEncuesta($idEncuesta)
	{
		$tablaEncuesta = $this->tablaEncuesta;
		$select = $tablaEncuesta->select()->from($tablaEncuesta)->where("idEncuesta = ?", $idEncuesta);
		$rowEncuesta = $tablaEncuesta->fetchRow($select);
		if(is_null($rowEncuesta)){
			throw new Util_Exception_BussinessException("Error: No se encontro Encuesta con id: <strong>".$idEncuesta."</strong>.");
		}
		$modelEncuesta = new Encuesta_Model_Encuesta($rowEncuesta->toArray());
		
		return $modelEncuesta;
	}
	
	public function obtenerEncuestaHash($hash)
	{
		$tablaEncuesta = $this->tablaEncuesta;
		$select = $tablaEncuesta->select()->from($tablaEncuesta)->where("hash = ?", $hash);
		$rowEncuesta = $tablaEncuesta->fetchRow($select);
		
		$modelEncuesta = new Encuesta_Model_Encuesta($rowEncuesta->toArray());
		
		return $modelEncuesta;
	}
	// ============================================================= Conjunto de elementos
	/**
	 * @method obtenerEncuestas Obtiene todas las encuestas existentes.
	 * @return array Encuesta_Model_Encuesta
	 */
	public function obtenerEncuestas() {
		$tablaEncuesta = $this->tablaEncuesta;
		$rowsEncuestas = $tablaEncuesta->fetchAll();
		$modelEncuestas = array();
		if(!is_null($rowsEncuestas)){
			foreach ($rowsEncuestas as $rowEncuesta) {
				$modelEncuesta = new Encuesta_Model_Encuesta($rowEncuesta->toArray());
				if($rowEncuesta->estatus != 2) $modelEncuestas[] = $modelEncuesta;
			}
		}
		
		return $modelEncuestas;
	}
	
	public function obtenerEncuestasGrupo($idGrupo){
		$tablaEncuestaGrupo = $this->tablaEncuestaGrupo;
		$select = $tablaEncuestaGrupo->select()->from($tablaEncuestaGrupo)->where("idGrupo=?",$idGrupo);
		$rowsEncuestaG = $tablaEncuestaGrupo->fetchAll($select);
		$modelEncuestas = array();
		foreach ($rowsEncuestaG as $row) {
			$modelEncuesta = $this->obtenerEncuesta($row->idEncuesta);
			$modelEncuestas[] = $modelEncuesta;
		}
		return $modelEncuestas;
	}
	
	public function obtenerSecciones($idEncuesta) {
		$tablaSeccion = $this->tablaSeccion;
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idEncuesta = ?", $idEncuesta);
		$rowsSecciones = $tablaSeccion->fetchAll($select);
		$modelSecciones = array();
		
		if(!is_null($rowsSecciones)){
			foreach ($rowsSecciones as $row) {
				$modelSeccion = new Encuesta_Model_Seccion($row->toArray());
				$modelSecciones[] = $modelSeccion;
			}
		}
		
		return $modelSecciones;
	}
	
	public function obtenerPreguntas($idEncuesta){
		$tablaPregunta = $this->tablaPregunta;
		$select = $tablaPregunta->select()->from($tablaPregunta)->where("idEncuesta = ?", $idEncuesta);
		
		$rowsPregunta = $tablaPregunta->fetchAll($select);
		$modelPreguntas = array();
		
		foreach ($rowsPregunta as $row) {
			$modelPregunta = new Encuesta_Model_Pregunta($row->toArray());
			$modelPreguntas[] = $modelPregunta;
		}
		
		return $modelPreguntas;
	}
	
	/**
	 * Obtiene el numero de encuestas realizadas para una asignacion (grupo,materia,profesor) dada
	 */
	public function obtenerNumeroEncuestasRealizadas($idEncuesta, $idAsignacion){
		$tablaERealizadas = $this->tablaERealizadas;
		$select = $tablaERealizadas->select()->from($tablaERealizadas)->where("idEncuesta=?",$idEncuesta)->where("idAsignacion=?",$idAsignacion);
		//print_r($select->__toString());
		$row = $tablaERealizadas->fetchRow($select);
		
		if(is_null($row)){
			return 0;
		}else{
			return $row->realizadas;
		}
	}
	
	/**
	 * Obtiene un numero indicador de encuesta, es como un turno en una fila de encuestas 
	 */
	public function obtenerNumeroConjuntoAsignacion($idEncuesta, $idAsignacion){
		$tablaERealizadas = $this->tablaERealizadas;
		$select = $tablaERealizadas->select()->from($tablaERealizadas)->where("idEncuesta=?",$idEncuesta)->where("idAsignacion=?",$idAsignacion);
		$row = $tablaERealizadas->fetchRow($select);
		$conjunto = 0;
		if(!is_null($row)){
			if(is_null($row->requeridas)){
				$conjunto = $row->realizadas;
			}else{
				$row->requeridas++;
				$conjunto = $row->requeridas;
				$row->save();
			}
		}
		
	}
	
	public function obtenerEncuestaRealizadaPorAsignacion($idAsignacion){
		$tablaERealizadas = $this->tablaERealizadas;
		$select = $tablaERealizadas->select()->from($tablaERealizadas)->where("idAsignacion=?",$idAsignacion);
		$erealizadas = $tablaERealizadas->fetchRow($select);
		if(is_null($erealizadas)) throw new Util_Exception_BussinessException("Error: No hay ", 1);
		
		return $erealizadas->toArray();
	}
	
	public function obtenerEncuestasRealizadasPorAsignacion($idAsignacion){
		$tablaERealizadas = $this->tablaERealizadas;
		$select = $tablaERealizadas->select()->from($tablaERealizadas)->where("idAsignacion=?",$idAsignacion);
		$erealizadas = $tablaERealizadas->fetchAll($select);
		if(is_null($erealizadas)) throw new Util_Exception_BussinessException("Error: No hay ", 1);
		
		return $erealizadas->toArray();
	}
	
	/**
	 * Obtiene todas las encuestas realizadas que aun esten vigentes.
	 * Una encuesta esta vigente si el grupo que evalua pertenece al ciclo escolar actual.
	 * Este metodo no hace tal comprobación, solo trae los registros que se encuentren en la tabla.
	 */
	public function obtenerEncuestasVigentesRealizadas(){
		$tablaERealizadas = $this->tablaERealizadas;
		// 1.- Obtenemos todas las Encuestas Realizadas de profesores.
		$select = $tablaERealizadas->select()->from($tablaERealizadas)->where("vigente=?","S");
		$encuestasRealizadas = $tablaERealizadas->fetchAll($select);
		
		return $encuestasRealizadas->toArray();
	}
	
	public function obtenerGruposEncuesta($idEncuesta){
		$secciones = $this->obtenerSecciones($idEncuesta);
		$tablaGrupo = new Encuesta_Model_DbTable_Grupo;
		$grupos = array();
		foreach ($secciones as $seccion) {
			$select = $tablaGrupo->select()->from($tablaGrupo)->where("idSeccion=?",$seccion->getIdSeccion());
			$gruposSeccion = $tablaGrupo->fetchAll($select);
			$grupos[$seccion->getIdSeccion()] = $gruposSeccion;
		}
		
		
	}
	// =====================================================================================>>>   Insertar
	/**
	 * @method crearEncuesta Crea una encuesta pasandole un model.
	 * @param Encuesta_Model_Encuesta $encuesta
	 */
	public function crearEncuesta(Encuesta_Model_Encuesta $encuesta)
	{
		$tablaEncuesta = $this->tablaEncuesta;
		$encuesta->setHash($encuesta->getHash());
		$encuesta->setFecha(date("Y-m-d H:i:s", time()));
		//print_r($encuesta->toArray());
		$tablaEncuesta->insert($encuesta->toArray());
	}
	
	public function agregarEncuestaGrupo(array $registro){
		$tablaERealizadas = $this->tablaERealizadas;
		$registro["realizadas"] = 0;
		//$tablaEncuestaGrupo = $this->tablaEncuestaGrupo;
		//$select = $tablaEncuestaGrupo->select()->from($tablaEncuestaGrupo)->where("idGrupo=?",$registro["idGrupo"])->where("idEncuesta=?",$registro["idEncuesta"]);
		//$row = $tablaEncuestaGrupo->fetchRow($select);
		try{
			$tablaERealizadas->insert($registro);
		}catch(Exception $ex){
			throw new Util_Exception_BussinessException("Error: " . $ex->getMessage());
		}
	}
	
	public function agregarEncuestaRealizada(array $registro){
		$tablaERealizadas = $this->tablaERealizadas;
		$select = $tablaERealizadas->select()->from($tablaERealizadas)->where("idEncuesta=?",$registro["idEncuesta"])->where("idRegistro=?",$registro["idRegistro"])->where("idGrupo=?",$registro["idGrupo"]);
		$row = $tablaERealizadas->fetchRow($select);
		if(!is_null($row)){
			$row->realizadas++;
			$row->save();
		}else{
			$registro["realizadas"] = 1;
			$tablaERealizadas->insert($registro);
		}
		
	}
	//          =========================================================================   >>>   Actualizar
	public function editarEncuesta($idEncuesta, array $encuesta)
	{
		$tablaEncuesta = $this->tablaEncuesta;
		$where = $tablaEncuesta->getAdapter()->quoteInto("idEncuesta = ?", $idEncuesta);

		$tablaEncuesta->update($encuesta, $where);
	}
	//          =========================================================================   >>>   Eliminar
	public function eliminarEncuesta($idEncuesta)
	{
		$tablaEncuesta = $this->tablaEncuesta;
		$where = $tablaEncuesta->getAdapter()->quoteInto("idEncuesta = ?", $idEncuesta);

		$tablaEncuesta->delete($where);
	}
	
	public function normalizarPreferenciaAsignacion($idEncuesta, $idAsignacion){
		$tablaEncuesta = $this->tablaEncuesta;
		$tablaPreferenciaS = $this->tablaPreferenciaS;
		//Obtenemos preguntas de la encuesta
		$preguntaDAO = new Encuesta_DAO_Pregunta;
		$respuestaDAO = new Encuesta_DAO_Respuesta;
		$preferenciaDAO = new Encuesta_DAO_Preferencia;
		$preguntas = $preguntaDAO->obtenerPreguntasEncuesta($idEncuesta);
		foreach ($preguntas as $pregunta) {
			if($pregunta->getTipo() == "SS"){
				//Obtengo respuestas de tabla respuesta
				$respuestas = $respuestaDAO->obtenerRespuestasPreguntaAsignacion($idEncuesta, $idAsignacion, $pregunta->getIdPregunta());
				foreach ($respuestas as $respuesta) {
					$preferenciaDAO;
				}
				
				print_r($respuestas);
			}
			break;
		}
		
		
		
	}
}
