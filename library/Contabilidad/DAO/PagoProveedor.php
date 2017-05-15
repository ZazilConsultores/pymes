<?php
    class Contabilidad_DAO_PagoProveedor implements Contabilidad_Interfaces_IPagoProveedor{
    		
    	private $tablaFactura;
		private $tablaCuentasxp;
    	private $tablaProveedores;
		private $tablaEmpresa;
		private $tablaFiscales;
		private $tablaBancos;
		private $tablaSucursal;
		
		public function __construct(){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
			$this->tablaCuentasxp = new Contabilidad_Model_DbTable_Cuentasxp(array('db'=>$dbAdapter));
			$this->tablaProveedores = new Sistema_Model_DbTable_Proveedores(array('db'=>$dbAdapter));
			$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
			$this->tablaFiscales = new Sistema_Model_DbTable_Fiscales(array('db'=>$dbAdapter));
			$this->tablaBancos = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
			$this->tablaSucursal = new Sistema_Model_DbTable_Sucursal(array('db'=>$dbAdapter));
			
		}
		
		public function busca_Cuentasxp($idSucursal,$pr){
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idTipoMovimiento =?",4)->where("estatus <> ?", "C")
			->where("conceptoPago <>?","LI")->where("idSucursal =?", $idSucursal)->where("idCoP = ?" ,$pr);
			$rowsFacturaxp = $tablaFactura->fetchAll($select)->toArray();
			
			return $rowsFacturaxp;
							
		}
		
		public function aplica_Pago ($idFactura, array $datos){
			$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
			//$dbAdapter->beginTransaction();
			$dateIni = new Zend_Date($datos['fecha'],'YY-MM-dd');
			$stringIni = $dateIni->toString ('yyyy-MM-dd');
			
			try{
				$secuencial;
				$tablaCuentasxp = $this->tablaCuentasxp;
				$select = $tablaCuentasxp->select()->from($tablaCuentasxp)->where("idTipoMovimiento= ?",4)->where("idFactura=?", $idFactura);
				$rowCuentasxp = $tablaCuentasxp->fetchAll($select);
			
				if(is_null($rowCuentasxp)){
					$secuencial = 1;
				}else{
					foreach ($rowCuentasxp as$rowCuentaxp) {
						$secuencial = $rowCuentaxp["secuencial"];
					}
				}
				//Valida que el importe no sea mayor al saldo, vacio ó  igual a cero.
				if($datos["pago"]==0  || $datos["pago"] == " "){
					print_r("El monto del saldo es incorrecto");
				}else{
					$tablaFactura = $this->tablaFactura;
					$select= $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
					$rowFactura = $tablaFactura->fetchRow($select);
					//print_r($select->__toString());
				
					if($datos["pago"] >= $rowFactura["total"] ){
						echo "El importe no puede ser mayor al total de la factura";
					}else{
						//Aplicamos movimiento en cuentasxp;
						$mCuentasxp = array(
							'idTipoMovimiento'=>15,
							'idSucursal'=>$rowFactura['idSucursal'],
							'idCoP'=>$rowFactura['idCoP'],
							'idFactura'=>$rowFactura['idFactura'],
							'idBanco'=>$datos['idBanco'],
							'idDivisa'=>$datos['idDivisa'],
							'numeroFolio'=>$rowFactura['numeroFactura'],
							'numeroReferencia'=>$datos['numeroReferencia'],
							'secuencial'=>1,
							'estatus'=>"A",
							'fechaPago'=>$stringIni,
							'fechaCaptura'=>date('Y-m-d h:i:s', time()),
							'formaLiquidar'=>$datos['formaPago'],
							'conceptoPago'=>$datos['conceptoPago'],
							'subTotal'=>$datos["pago"] / ((16/100) +1) ,
							'total'=>$datos["pago"]
						);
						//print_r("Agrega movimiento a cuentasxp");   
						//print_r($mCuentasxp);
						//$dbAdapter->insert("Cuentasxp",$mCuentasxp);
					}	
				}	
			}catch(exception $ex){
			print_r("<br />");
			print_r("================");
			print_r("<br />");
			print_r("Excepcion Lanzada");
			print_r("<br />");
			print_r("================");
			print_r("<br />");
			print_r($ex->getMessage());
			print_r("<br />");
			print_r("<br />");
			$dbAdapter->rollBack();
			}				
		
		}
		
		public function obtiene_Factura ($idFactura){
			$tablaFactura = $this->tablaFactura;
			$select= $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
			$rowFactura = $tablaFactura->fetchRow($select);
			//print_r($select->__toString());
			return $rowFactura;
		}
		/*Obtiene proveedor por idFactura*/
		public function obtenerProveedoresEmpresa($idFactura) {
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
			$tablaFactura = $tablaFactura->fetchRow($select);
			
	 		$tablaProveedores = $this->tablaProveedores;
			$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores=?", $tablaFactura->idCoP);
			$rowProveedor = $tablaProveedores->fetchRow($select);
		
			$tablaEmpresa = $this->tablaEmpresa;
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa=?",$rowProveedor->idEmpresa);
			$rowEmpresa = $tablaEmpresa->fetchRow($select);
		
			$tablaFiscales = $this->tablaFiscales;
			$select = $tablaFiscales->select()->from($tablaFiscales)->where("idFiscales=?", $rowEmpresa->idFiscales);
			$rowFiscales = $tablaFiscales->fetchRow($select)->toArray();
			//print_r($select->__toString());
			
			if(is_null($rowFiscales)) {
				//return null;
			}else{
				return $rowFiscales;
			}
	 	}
		
		/*Obtiene sucursal por idFactura*/
		public function obtenerSucursal($idFactura) {
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
			$tablaFactura = $tablaFactura->fetchRow($select);
			
	 		$tablaSucursal = $this->tablaSucursal;
			$select = $tablaSucursal->select()->from($tablaSucursal)->where("idSucursal=?", $tablaFactura->idSucursal);
			$rowSucursal = $tablaSucursal->fetchRow($select);

			if(is_null($rowSucursal)) {
				return null;
			}else{
				return $rowSucursal;
			}
		
	 	}
		public function busca_PagosCXP ($idFactura){
			$tablaCuentasxp = $this->tablaCuentasxp;
			$select = $tablaCuentasxp->select()->from($tablaCuentasxp)->where("idTipoMovimiento= ?",15)->where("idFactura = ?", $idFactura);
			$rowCuentasxp = $tablaCuentasxp->fetchAll($select)->toArray();
			return $rowCuentasxp;
			
		}
		public function actualiza_Saldo($idFactura, array $datos){
			$dateIni = new Zend_Date($datos['fecha'],'YY-MM-dd');
			$stringIni = $dateIni->toString ('yyyy-MM-dd');
			//Actuliza saldoProveedor
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
			$tablaFactura = $tablaFactura->fetchRow($select);
			
	 		$tablaProveedores = $this->tablaProveedores;
			$select = $tablaProveedores->select()->from($tablaProveedores)->where("idProveedores=?", $tablaFactura->idCoP);
			$rowProveedor = $tablaProveedores->fetchRow($select);
			//print_r($select->__toString());
			$saldo = $rowProveedor->saldo - $datos["pago"];
			$rowProveedor->saldo = $saldo;
			$rowProveedor->save();
			print_r("<br />");
			//Actuliza saldoBando
			$tablaBancos= $this->tablaBancos;
			$select = $tablaBancos;
			$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco =?",$datos["idBanco"]);
			$rowBanco = $tablaBancos->fetchRow($select);
			$sBanco = $rowBanco->saldo -  $datos["pago"];
			$rowBanco->saldo = $sBanco;
			$rowBanco->fecha = $stringIni;
			$rowBanco->save();
			//Actuliza saldoFactura
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
			$rowFactura = $tablaFactura->fetchRow($select);
			$saldo = $rowFactura->saldo - $datos["pago"];
			//if($rowFactura->saldo - $datos["pago"]){
				/*echo "El monto de la factura se cubre con";*/
			//}else{
				/*$rowFactura = $tablaFactura->fetchRow($select);
				$sFactura = $rowFactura->saldo - $datos["pago"];
				$rowFactura->saldo = $sFactura;
				//Actualiza el importe pago
				$iFactura = $rowFactura->importePagado + $datos["pago"];
				$rowFactura->importePagado = $iFactura;
				$rowFactura->save();*/	
			//}
			
		}
    }
?>