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
		
		public function busca_Nominasxp($idSucursal,$pr){
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idTipoMovimiento =?",20)->where("estatus <> ?", "C")
			->where("conceptoPago <>?","LI")->where("idSucursal =?", $idSucursal)->where("idCoP = ?" ,$pr);
			$rowsFacturaxp = $tablaFactura->fetchAll($select)->toArray();
			//print_r("$select");
			return $rowsFacturaxp;
							
		}
		
		public function aplica_Pago ($idFactura, array $datos){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$dateIni = new Zend_Date($datos['fecha'],'YY-MM-dd');
			$stringIni = $dateIni->toString ('yyyy-MM-dd');
			
			try{
				$tablaCuentasxp = $this->tablaCuentasxp;
				$select = $tablaCuentasxp->select()->from($tablaCuentasxp)->where("idTipoMovimiento= ?",15)->where("idFactura=?", $idFactura)
				->order("secuencial DESC");
				$rowCuentasxp = $tablaCuentasxp->fetchRow($select);
				//print_r($select->__toString());
				
				if(!is_null($rowCuentasxp)){
					$secuencial= $rowCuentasxp->secuencial +1;
				}else{
					$secuencial = 1;	
				}
				//Valida que el importe no sea mayor al saldo, vacio ó  igual a cero.
				if($datos["pago"]==0  || $datos["pago"] == " "){
					print_r("El monto del saldo es incorrecto");
				}else{
					$tablaFactura = $this->tablaFactura;
					$select= $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
					$rowFactura = $tablaFactura->fetchRow($select);
					//print_r($select->__toString());
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
						'secuencial'=>$secuencial,
						'estatus'=>"A",
						'fechaPago'=>$stringIni,
						'fecha'=>date('Y-m-d h:i:s', time()),
						'formaLiquidar'=>$datos['formaPago'],
						'conceptoPago'=>$datos['conceptoPago'],
						'subTotal'=>$datos["pago"] / ((16/100) +1) ,
						'total'=>$datos["pago"]
					);
					$dbAdapter->insert("Cuentasxp",$mCuentasxp);
					//GuardaIva em facturaImpuesto
					$tablaCuentasxp = $this->tablaCuentasxp;
					$select = $tablaCuentasxp->select()->from($tablaCuentasxp)->where("idFactura=?", $idFactura)->order("secuencial DESC");
					$rowcxp = $tablaFactura->fetchRow($select);
					//print_r("$select");
					$mfImpuesto = array(
						'idTipoMovimiento'=>15,
						'idFactura'=>$rowFactura['idFactura'],
						'idImpuesto'=>4, //Iva
						'idCuentasxp'=>0,	
						'importe'=>$datos["pago"]- $rowcxp->subtotal
					);
					//print_r($mfImpuesto);
					$dbAdapter->insert("FacturaImpuesto", $mfImpuesto);
					//Al registrar el pago, afecta registro factura, saldo banco y saldo Proveedor.
					$actualizaRegistro = $this->actualiza_Saldo($idFactura, $datos);
				}		
			}catch(Exception $ex){
				$dbAdapter->rollBack();
				print_r($ex->getMessage());
				throw new Util_Exception_BussinessException("Error al registrar pago");
			}
							
		}

	
		
		public function obtiene_Factura ($idFactura){
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
			$rowFactura = $tablaFactura->fetchRow($select);
			//print_r($select->__toString());
			if(is_null($rowFactura)) {
				return null;
			}else{
				return $rowFactura;
			}
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
			
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
			$tablaFactura = $tablaFactura->fetchRow($select);
			//Actuliza saldoProveedor
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
			//print_r($saldo);	
			//Actualiza el importe pago 	
			$iFactura = $rowFactura->importePagado + $datos["pago"];
			$rowFactura->importePagado = $iFactura;
			if($saldo <= 0){
				$rowFactura->conceptoPago = "LI";
			}else{
				$rowFactura->conceptoPago = "PA";
			}
			$rowFactura->saldo = $saldo;
			$rowFactura->save();	
			
		}
    }
?>