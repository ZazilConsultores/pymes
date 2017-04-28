<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
 class Contabilidad_DAO_Banco implements Contabilidad_Interfaces_IBanco {
 

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
		/*$tablaBanco = $this->tablaBanco;
		$select = $tablaBanco->select()->from($tablaBanco)->where('tipo = "IN"');
		$rowBanco = $tablaBanco->fetchRow($select);
		$modelBanco = new Contabilidad_Model_Banco($rowBanco->toArray());
		
		return $modelBanco;*/
		
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
	
			$fecha= date("Y-m-d h:i:s",time());
			unset($datos["idEmpresas"]);
			unset($datos["idSucursal"]);
			$datos['fecha']=$fecha;
		
			$dbAdapter->insert("Banco", $datos);
			
	}
		
	

	public function editarBanco($idBanco, array $banco){
		$tablaBanco = $this->tablaBanco;
		$where = $tablaBanco->getAdapter()->quoteInto("idBanco= ?", $idBanco);
		$tablaBanco->update($banco, $where);
	}
	
	public function eliminarBanco($idBanco){
		
	}
	
	public function obtenerBancosEmpresa($idEmpresa) {
		$tableBanco = $this->tablaBanco;
		$tableBcosEmp = $this->tablaBancosEmpresa;
		$select = $tableBcosEmp->select()->from($tableBcosEmp)->where("idEmpresa=?",$idEmpresa);
		$rowsBcosEmp = $tableBcosEmp->fetchAll($select);
		
		$idsBancos = array();
		
		foreach ($rowsBcosEmp as $rowBcoEmpresa) {
			$idsBancos[] = $rowBcoEmpresa->idBanco;
		}
		
		//print_r($idsBancos);
		
		$select = $tableBanco->select()->from($tableBanco)->where("idBanco IN (?)",$idsBancos);
		$rowsBancos = $tableBanco->fetchAll($select)->toArray();
		
		return $rowsBancos;
		
		}
		
		public function altaBancoEmpresa($idEmpresa, $idBanco){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			
			$tablaBcosEmp = $this->tablaBancosEmpresa;
			$select = $tablaBcosEmp->select()->from($tablaBcosEmp)->where("idEmpresa = ?", $idEmpresa);
			$rowBcosEmp = $tablaBcosEmp->fetchRow($select);
			print_r("$select");
			
			if(!is_null($rowBcosEmp)){
				$idsBanco = explode ("," , $rowBcosEmp->idBanco);
				if(in_array($idBanco, $idsBanco)){
					print_r("Ya esta asociado el banco");
				}else{
					$idsBanco[] = $idBanco;
					$ids = implode(",", $idsBanco);
					$where = $tablaBcosEmp->getAdapter()->quoteInto("idEmpresa = ?", $idEmpresa);
					$tablaBcosEmp->update(array("idBanco" => $ids), $where);
				}
			}else{
				$tablaBcosEmp->insert(array("idEmpresa" =>  $idEmpresa, "idBanco" => implode(",", array($idBanco))));
			}
			
		}
 }