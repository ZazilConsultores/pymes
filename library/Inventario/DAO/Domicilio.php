<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
 class Inventario_DAO_Domicilio implements Inventario_Interfaces_IDomicilio {
	private $tablaDomicilio;
	
	public function __construct()
	{
		$this->tablaDomicilio = new Sistema_Model_DbTable_Domicilio;
	}
	
	public function obtenerDomiclio($idDomicilio){
		
		$tablaDomicilio = $this->tablaDomicilio;
		$select = $tablaDomicilio->select()->from($tablaDomicilio)->where("idDomicilio = ?", $idDomicilio);
		$rowDomicilio = $tablaDomicilio->fetchRow($select);
		
		$domicilioModel = new sistema_Model_Estado($rowDomicilio->toArray());
		$domicilioModel->setIdDomicilio($rowDomicilio->idDomicilio);
		
		return $domicilioModel;
		
	}
	public function obtenerDomicilios(){
		
	}
	public function obtenerMunicipio($idEstado,$idDomicilio){
		
	}
	public function obtenerEstado($idEstado,$idMunicipio, $idDomicilio){
		
	}
	public function crearDomicilio(Sistema_Model_Domicilio $domicilio){
		
	}
	public function editarDomicilio($idDomiclio, array $domicilio){
		
	}
	public function eliminarDomicilio($idDomiclio){
		
	}
 }