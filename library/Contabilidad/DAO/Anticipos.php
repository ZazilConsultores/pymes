<?php
/**
 * @author Areli Morales Palma
 * @copyright 2017, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Contabilidad_DAO_Anticipos implements Contabilidad_Interfaces_IAnticipos{
	private $tablaBancosEmpresa;
	private $tablaBanco;
	private $tablaCuentasxp;
	private $tablaCuentasxc;
	
	public function __construct(){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$this->tablaBancosEmpresa = new Contabilidad_Model_DbTable_BancosEmpresa(array('db'=>$dbAdapter));
		$this->tablaBanco =  new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
		$this->tablaCuentasxp = new Contabilidad_Model_DbTable_Cuentasxp(array('db'=>$dbAdapter));
		$this->tablaCuentasxc = new Contabilidad_Model_DbTable_Cuentasxc(array('db'=>$dbAdapter));
	}
	
	
	public function guardarAnticipoCliente(array $datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
			
		$fechaA =  new Zend_Date($datos['fecha'],'YY-MM-dd');
		$stringfecha = $fechaA->toString('yyyy-MM-dd');
		$fecha = date('Y-m-d h:i:s', time());
			
		try{
			unset($datos["idEmpresas"]);
			$anticipo = $datos;
			
			$anticipo['fecha'] = $stringfecha;
			$anticipo['numeroFolio'] = $anticipo['numeroReferencia'];
			$anticipo['comentario'] ="-";
			$anticipo['fechaPago'] =$fecha;
			$anticipo['estatus'] ="A";
			$anticipo['conceptoPago'] ="LI";
			$anticipo['subtotal'] = 0;
			$tablaCXC = $this->tablaCuentasxc;
			$select = $tablaCXC->select()->from($tablaCXC)->where("idCoP=?",$anticipo['idCoP'])->where("idSucursal=?",$anticipo['idSucursal'])->where("fecha=?", $anticipo['fecha'])->order("secuencial DESC");
			$rowCXC = $tablaCXC->fetchRow($select); 
			if(!is_null($rowCXC)){
				$secuencial= $rowCXC->secuencial + 1;
			}else{
				$secuencial = 1;	
			}
			$anticipo['secuencial'] = $secuencial;
			print_r("<br />");
			print_r($datos);
			$dbAdapter->insert("Cuentasxc", $anticipo);		
			
			//Actuliza saldo en Bancos
			$tablaBanco = $this->tablaBanco;
			$select = $tablaBanco->select()->from($tablaBanco)->where("idBanco=?",$anticipo['idBanco']);
			$rowBanco = $tablaBanco->fetchRow($select);
			
			$saldo = $rowBanco["saldo"] + $anticipo['total'];
			print($saldo);
			$rowBanco->saldo = $saldo;
			$rowBanco->save();
			$dbAdapter->commit();
		}catch(exception $ex){
			print_r("<br />");
			print_r("==========");
			print_r("Excepcion Lanzada");
			print_r("<br />");
			print_r("==========");
			print_r("<br />");
			print_r($ex->getMessage());
			print_r("<br />");
			print_r("<br />");
			$dbAdapter->rollBack();
		}
		
	}

	public function guardaAnticipoProveedor(array $datos){
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$dbAdapter->beginTransaction();
			
		$fechaA =  new Zend_Date($datos['fecha'],'YY-MM-dd');
		$stringfecha = $fechaA->toString('yyyy-MM-dd');
		$fecha = date('Y-m-d h:i:s', time());
			
		try{
			unset($datos["idEmpresas"]);
			$anticipo = $datos;
			
			$anticipo['fecha'] = $stringfecha;
			$anticipo['numeroFolio'] = $anticipo['numeroReferencia'];
			$anticipo['comentario'] ="-";
			$anticipo['fechaPago'] =$fecha;
			$anticipo['estatus'] ="A";
			$anticipo['conceptoPago'] ="LI";
			$anticipo['subtotal'] = 0;
			$tablaCXP = $this->tablaCuentasxp;
			$select = $tablaCXP->select()->from($tablaCXP)->where("idCoP=?",$anticipo['idCoP'])->where("idSucursal=?",$anticipo['idSucursal'])->where("fecha=?", $anticipo['fecha'])->order("secuencial DESC");
			$rowCXP = $tablaCXP->fetchRow($select); 
			if(!is_null($rowCXP)){
				$secuencial= $rowCXP->secuencial + 1;
			}else{
				$secuencial = 1;	
			}
			$anticipo['secuencial'] = $secuencial;
			print_r("<br />");
			print_r($datos);
			$dbAdapter->insert("Cuentasxp", $anticipo);		
			
			//Actuliza saldo en Bancos
			$tablaBanco = $this->tablaBanco;
			$select = $tablaBanco->select()->from($tablaBanco)->where("idBanco=?",$anticipo['idBanco']);
			$rowBanco = $tablaBanco->fetchRow($select);
			
			$saldo = $rowBanco["saldo"] - $anticipo['total'];
			print($saldo);
			$rowBanco->saldo = $saldo;
			$rowBanco->save();
			$dbAdapter->commit();
		}catch(exception $ex){
			print_r("<br />");
			print_r("==========");
			print_r("Excepcion Lanzada");
			print_r("<br />");
			print_r("==========");
			print_r("<br />");
			print_r($ex->getMessage());
			print_r("<br />");
			print_r("<br />");
			$dbAdapter->rollBack();
		}
		
	}
	
}
