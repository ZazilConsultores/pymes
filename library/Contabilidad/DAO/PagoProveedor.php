<?php
    class Contabilidad_DAO_PagoProveedor implements Contabilidad_Interfaces_IPagoProveedor{
    		
    	private $tablaFactura;
		private $tablaCuentasxp;
		
		public function __construct(){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
			$this->tablaCuentasxp = new Contabilidad_Model_DbTable_Cuentasxp(array('db'=>$dbAdapter));
		}
		public function obtieneFacturaProveedor($idSucursal, $idCoP, $numeroFactura){
			$tablaCuentasxp = $this->tablaCuentasxp;
			$select = $tablaCuentasxp->select()->from($tablaCuentasxp)
			->where("idCoP = ?",$idCoP)
			->where ("idSucursal = ?",$idSucursal)
			->where("numeroFolio = ?",$numeroFactura)
			->where("estatus <> ?", "C")
			->where("conceptoPago <> ?","LI")
			->where("idTipoMovimiento =?", 4);
			$rowFacturas = $tablaCuentasxp->fetchAll($select);
		
			print_r("$select");
			/*if (is_null($rowFacturas)){
				return null;
			}else{
				return $rowFacturas->toArray();
			}*/
		}
		
		public function obtenerFactura(){
				
			$secuencial = 0;	
			$tablaCuentasxp = $this->tablaCuentasxp;
			$select = $tablaCuentasxp->select()->from($tablaCuentasxp)->where("idTipoMovimiento=?",4)->where("idSucursal=?",nuevo)->where("idCoP=?",NUEVO)->where("numeroFolio")
			->order("secuencial DESC");
			$rowCuentaxp = $tablaCuentasxp->fetchRow($select); 
				
				if(!is_null($rowMovimiento)){
					$secuencial= $rowMovimiento->secuencial +1;
					//print_r($secuencial);
				}else{
					$secuencial = 1;	
					//print_r($secuencial);
				}
			
		}
		
		public function obtenerProveedorFactura(){
			$tablaFactura = $this->tablaFactura;
		}
		
		public function busca_facturap($idCoP){
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idCoP=?",$idCoP)->where("idTipoMovimiento=?",4)->where("estatus=?","P");
			$rowsFacturap = $tablaFactura->fetchAll($select);
			
			if(is_null($rowsFacturap)){
				return null;
			}else{
				return $rowsFacturap->toArray();
			}
		
		}
		
		public function busca_Cuentasxp($idSucursal, $idCoP,$numeroFolio){
				
			$tablaCuentasxp = $this->tablaCuentasxp;
			$select = $tablaCuentasxp->select()->from($tablaCuentasxp)->where("idTipoMovimiento=?",4)->where("idSucursal=?",$idSucursal)->where("idCoP=?",$idCoP)->where("numeroFolio=?",$numeroFolio);
			$rowCuentaxp = $tablaCuentasxp->fetchRow($select);
			//print_r("$select");
			
			if(!is_null($rowCuentaxp)){
					$secuencial= $rowCuentaxp->secuencial +1;
					//print_r($secuencial);
				}else{
					$secuencial = 1;	
					print_r($secuencial);
				}
			/*if(is_null($rowFacturap)){
				return null;
			}else{
				return $rowFacturap->toArray();
			}	*/		
		}
    }
?>