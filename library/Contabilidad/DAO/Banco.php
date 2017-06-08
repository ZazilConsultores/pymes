<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
 class Contabilidad_DAO_Banco implements Contabilidad_Interfaces_IBanco {
 
	private $tablaEmpresas;
	private $tablaBanco;
	private $tablaBancosEmpresa;
	
	public function __construct() {
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaEmpresas = new Sistema_Model_DbTable_Empresas(array('db'=>$dbAdapter));
		$this->tablaBanco = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
		$this->tablaBancosEmpresa = new Contabilidad_Model_DbTable_BancosEmpresa(array('db'=>$dbAdapter));
	}
	public function obtenerBancos()
	{
		$tablaBanco = $this->tablaBanco;
		$select = $tablaBanco->select()->from($tablaBanco)->order("banco");
		$rowBancos = $tablaBanco->fetchAll($select);
		//$rowBancos = $tablaBanco->fetchAll()->order("banco");
		
		$modelBancos = array();
		foreach ($rowBancos as $rowBanco) {
			$modelBanco = new  Contabilidad_Model_Banco($rowBanco->toArray());
			$modelBanco->setIdBanco($rowBanco->idBanco);
			
			$modelBancos[] = $modelBanco;
		}
		
		return $modelBancos;
	}
	public function obtenerBancosEmpresas($idEmpresa)
	{
		//Seleccionamos idEmpresa de la tabla BancosEmpresa
		$tablaBancosEmpresa = $this->tablaBancosEmpresa;
		$select = $tablaBancosEmpresa->select()->from($tablaBancosEmpresa)->where("idEmpresas=?",$idEmpresa);
		$rowBancosEmp = $tablaBancosEmpresa->fetchRow($select);
		$idsBancos = explode(",", $rowBancosEmp->idBanco);
		if(!is_null($idsBancos)){
			$tablaBanco = $this->tablaBanco;
			$select = $tablaBanco->select()->from($tablaBanco)->where("idBanco IN (?)", $idsBancos);
			$rowsBancos= $tablaBanco->fetchAll($select);
			print_r("select");
			
			/*$idsEmpresa = array();
			foreach ($rowsClientes as $rowCliente) {
				$idsEmpresa[] = $rowCliente->idEmpresa;
			}*/
			
		}
		
		
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
		//Obtenemos fila de bancosEmpresa por empresa
		$tableBcosEmp = $this->tablaBancosEmpresa;
		$select = $tableBcosEmp->select()->from($tableBcosEmp)->where("idEmpresa=?",$idEmpresa);
		$rowsBcosEmp = $tableBcosEmp->fetchRow($select);
		
		$idsBanco= explode(",", $rowsBcosEmp->idBanco);
		if(! is_null($rowsBcosEmp->idBanco) && ! empty($idsBanco)) {
			$tableBanco = $this->tablaBanco;
			$select = $tableBanco->select()->from($tableBanco)->where("idBanco IN (?)",$idsBanco);
			$rowsBancos = $tableBanco->fetchAll($select)->toArray();
			return $rowsBancos;
		}
		
		
		//return $rowsBancos;
		
		}
		
		public function altaBancoEmpresa( $idEmpresa, $idBanco){
			
			$tablaBancosEmp = $this->tablaBancosEmpresa;
			$select = $tablaBancosEmp->select()->from($tablaBancosEmp)->where("idEmpresa=?",$idEmpresa);
			$rowBancoEmp = $tablaBancosEmp->fetchRow($select);	
			if(! is_null($rowBancoEmp)){
				$idsBanco = explode(",", $rowBancoEmp->idBanco);
		
				if(! in_array($idBanco, $idsBanco)){
					$idsBanco[] = $idBanco;
					$ids = implode(",", $idsBanco);
					
					$rowBancoEmp->idBanco = $ids;
					$rowBancoEmp->save();
				}
			}else{
				$tablaBancosEmp->insert(array("idEmpresa"=>$idEmpresa, "idBanco"=> implode(",",array( $idBanco))));
			}
		}
 }