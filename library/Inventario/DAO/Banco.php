<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
 class Inventario_DAO_Banco implements Inventario_Interfaces_IBanco {

	private $tablaBanco;
	
	public function __construct()
	{
		$this->tablaBanco = new Contabilidad_Model_DbTable_Banco;
	}
	public function obtenerBancos()
	{
		$tablaBanco = $this->tablaBanco;
		$rowBancos = $tablaBanco->fetchAll();
		
		$modelBancos = array();
		foreach ($rowBancos as $rowBanco) {
			$modelBanco = new  Contabilidad_Model_Banco($rowBanco->toArray());
			$modelBanco->setIdBanco($rowBanco->idBanco);
			
			$modelBancos[] = $modelBanco;
		}
		
		return $modelBancos;
	}
	
	
	public function crearBanco(Contabilidad_Model_Banco $banco){
		$tablaBanco = $this->tablaBanco;
		$tablaBanco->insert($banco->toArray());
	}
	
	public function editarBanco($idBanco){
		
	}
	public function eliminarBanco($idBanco){
		
	}

 }