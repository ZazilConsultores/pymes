<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_DAO_Usuario implements Sistema_Interfaces_IUsuario {
	
	private $tablaUsuario;
	
	function __construct($argument) {
		$this->tablaUsuario = new Sistema_Model_DbTable_Usuario;
	}
	
	public function obtenerUsuarios($idRol){
		$select = $this->tablaUsuario->select()->from($this->tablaUsuario)->where("idRol = ?", $idRol);
		$rowsUsuarios = $this->tablaUsuario->fetchAll($select);
		$modelUsuarios = array();
		foreach ($rowsUsuarios as $row) {
			$modelUsuario = new Sistema_Model_Usuario($row->toArray());
			$modelUsuarios[] = $modelUsuario;
		}
		
		return $modelUsuarios;
	}
	
	public function crearUsuario(Sistema_Model_Usuario $usuario){
		$usuario->setHash($usuario->getHash());
		$usuario->setFecha(date("Y-m-d H:i:s", time()));
		
		$this->tablaUsuario->insert($usuario->toArray());
	}
}
