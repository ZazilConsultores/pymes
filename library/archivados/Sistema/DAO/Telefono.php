<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Sistema_DAO_Telefono implements Sistema_Interfaces_ITelefono {
	
	private $tablaTelefono;
	private $tablaFiscal;
	
	public function __construct() {
		$this->tablaTelefono = new Sistema_Model_DbTable_Telefono;
		$this->tablaFiscal = new Sistema_Model_DbTable_Fiscales;
	}
	
	public function obtenerTelefono($idTelefono) {
		$tablaTelefono = $this->tablaTelefono;
		$select = $tablaTelefono->select()->from($tablaTelefono)->where("idTelefono = ?",$idTelefono);
		$rowTelefono = $tablaTelefono->fetchRow($select);
		$modelTelefono = new Sistema_Model_Telefono($rowTelefono->toArray());
		
		return $modelTelefono;
	}
	
	public function obtenerTelefonos() {
		$tablaTelefono = $this->tablaTelefono;
		$rowsTelefonos = $tablaTelefono->fetchAll();
		
		$modelTelefonos = array();
		foreach ($rowsTelefonos as $row) {
			$modelTelefono = new Sistema_Model_Telefono($row->toArray());
			$modelTelefonos[] = $modelTelefono;
		}
		
		return $modelTelefonos;
	}
	/**
	 * @method crearTelefono - Inserta un telefono en la tabla de la base de datos.
	 */
	public function crearTelefono(Sistema_Model_Telefono $telefono) {
		$tablaTelefono = $this->tablaTelefono;
		$telefono->setHash($telefono->getHash());
		$telefono->setFecha(date("Y-m-d H:i:s", time()));
		
		$tablaTelefono->insert($telefono->toArray());
		//regresamos las referencias
		$select = $tablaTelefono->select()->from($tablaTelefono)->where("hash = ?", $telefono->getHash());
		$rowTelefono = $tablaTelefono->fetchRow($select);
		
		$modelTelefono = new Sistema_Model_Telefono($rowTelefono->toArray());
		
		return $modelTelefono;
	}
	
	public function crearTelefonoFiscal($idFiscal, Sistema_Model_Telefono $telefono) {
		$tablaTelefono = $this->tablaTelefono;
		$telefono->setHash($telefono->getHash());
		$telefono->setFecha(date("Y-m-d H:i:s", time()));
		
		$tablaTelefono->insert($telefono->toArray());
		$select = $tablaTelefono->select()->from($tablaTelefono)->where("hash = ?", $telefono->getHash());
		$rowTelefono = $tablaTelefono->fetchRow($select);
		
		$tablaFiscal = $this->tablaFiscal;
		$select = $tablaFiscal->select()->from($tablaFiscal)->where("idFiscales = ?", $idFiscal);
		$rowFiscal = $tablaFiscal->fetchRow($select);
		
		$idsTelefonos = explode(",", $rowFiscal->idsTelefonos);
		if(!array_key_exists($rowTelefono->idTelefono, $idsTelefonos)) $rowFiscal->idsTelefonos .= $rowTelefono->idTelefono;
		$rowFiscal->save();
	}
	
	public function editarTelefono($idTelefono, array $telefono){}
	public function eliminarTelefono($idTelefono){}
}
