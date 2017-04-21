<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
 class Inventario_DAO_Banco implements Inventario_Interfaces_IBanco {
 

	private $tablaBanco;
	private $tablaBancosEmpresa;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		
		$this->tablaBanco = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
		$this->tablaBancosEmpresa = new Contabilidad_Model_DbTable_BancosEmpresa(array('db'=>$dbAdapter));
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
	public function obtenerBancosEmpresasFondeo(Contabilidad_Model_Banco $banco)
	{
		$tablaBanco = $this->tablaBanco;
		$select = $tablaBanco->select()->from($tablaBanco)->where('tipo = "IN"');
		$rowBanco = $tablaBanco->fetchRow($select);
		$modelBanco = new Contabilidad_Model_Banco($rowBanco->toArray());
		
		return $modelBanco;
		
	}
	
	public function obtenerBanco($idBanco){
		$tablaBanco = $this->tablaBanco;
		$select = $tablaBanco->select()->from($tablaBanco)->where("idBanco = ?", $idBanco);
		$rowBanco = $tablaBanco->fetchRow($select);
		$modelBanco = new Contabilidad_Model_Banco($rowBanco->toArray());
		
		return $modelBanco;
	}
	
	public function crearBanco(array $datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		//$dbAdapter->beginTransaction();
		
		$dbAdapter->insert("BancosEmpresa", array("idEmpresa"=>$datos["idEmpresas"],"idBanco"=>$datos["idSucursal"]));
		if($datos["idEmpresas"] <> 0){

			$fecha= date("Y-m-d h:i:s",time());
			unset($datos["idEmpresas"]);
			unset($datos["idSucursal"]);
			$datos['fecha']=$fecha;
			$tablaBanco = $this->tablaBanco;
			$dbAdapter->insert("Banco", $datos);
		}
		
	}
		
	

	public function editarBanco($idBanco, array $banco){
		$tablaBanco = $this->tablaBanco;
		$where = $tablaBanco->getAdapter()->quoteInto("idBanco= ?", $idBanco);
		$tablaBanco->update($banco, $where);
	}
	
	public function eliminarBanco($idBanco){
		
	}
	
	public function bancosEmpresa($idEmpresa) {
		
		$tablaBancosEmpresa = $this->tablaBancosEmpresa;
		$select = $tablaBancosEmpresa->select()->from($tablaBancosEmpresa)->where ("idEmpresa = ?", $idEmpresa);
		$rowBancosEmpresa = $tablaBancosEmpresa->fetchAll($select);
		//print_r("$select");
		$idsBancos = array();
		
		foreach ($rowBancosEmpresa as $rowBancoEmpresa) {
			$idsBancos[] = $rowBancoEmpresa->idEmpresa;
			
		}
	
		if(!is_null($rowBancosEmpresa) && ! empty($idsBancos)){
			//Obtenemos los productos
			$tablaBancosEmpresa =$this->tablaBancosEmpresa;
			$select = $tablaBancosEmpresa->select()
			->setIntegrityCheck(false)
			->from($tablaBancosEmpresa)
			->join('Empresa', 'BancosEmpresa.idEmpresa = Empresa.idEmpresa')
			->join('Banco', 'BancosEmpresa.idBanco = Banco.idBanco', array('banco'));
			return $tablaBancosEmpresa->fetchAll($select);
			
		}
		
		}

 }