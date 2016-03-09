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
	
	public function __construct()
	{
		$this->tablaEncuesta = new Encuesta_Model_DbTable_Encuesta;
		$this->tablaSeccion = new Encuesta_Model_DbTable_Seccion;
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta;
		$this->tablaEncuestaGrupo = new Encuesta_Model_DbTable_EncuestaGrupo;
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
		print_r($encuesta->toArray());
		$tablaEncuesta->insert($encuesta->toArray());
	}
	
	public function agregarEncuestaGrupo(array $registro){
		$tablaEncuestaGrupo = $this->tablaEncuestaGrupo;
		if(!empty($registro)){
			$tablaEncuestaGrupo->insert($registro);
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
	
}
