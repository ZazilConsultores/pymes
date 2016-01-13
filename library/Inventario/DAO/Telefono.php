<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Inventario_DAO_Telefono implements Inventario_Interfaces_ITelefono {
	private $tablaEstado;
	
	public function __construct()
	{
		$this->tablaEstado = new Application_Model_DbTable_Estado;
	}
	
	public function obtenerTelefono($idTelefono){
		$tablaTelefono = $this->tablaTelefono;
		$select = $tablaTelefono->select()->from($tablaTelefono)->where("idTelefono = ?", $idTelefono);
		$rowTelefono = $tablaTelefono->fetchRow($select);
	
		$telefonoModel = new Application_Model_Telefono($rowEstado->toArray());
		$telefonoModel->setIdTelefono($rowTelefono->idTelefono);
		
		return $telefonoModel;
	}
	
}
