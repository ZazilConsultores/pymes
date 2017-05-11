<?php
    class Contabilidad_DAO_PagoProveedor implements Contabilidad_Interfaces_IPagoProveedor{
    		
    	private $tablaFactura;
		private $tablaCuentasxp;
		
		public function __construct(){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
			$this->tablaCuentasxp = new Contabilidad_Model_DbTable_Cuentasxp(array('db'=>$dbAdapter));
		}
		
		public function busca_Cuentasxp($idSucursal,$pr){
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idTipoMovimiento =?",4)->where("estatus <> ?", "C")
			->where("conceptoPago <>?","LI")->where("idSucursal =?", $idSucursal)->where("idCoP = ?" ,$pr);
			$rowsFacturaxp = $tablaFactura->fetchAll($select)->toArray();
			
			return $rowsFacturaxp;
							
		}
		
		public function aplica_Pago ($idFactura, array $datos){
			
			$tablaCuentasxp = $this->tablaCuentasxp;
			$select = $tablaCuentasxp->select()->from($tablaCuentasxp)->where("idTipoMovimiento= ?",4)->where("idFactura=?", $idFactura);
			$rowCuentasxp = $tablaCuentasxp->fetchAll($select);
			print_r("$select");
			
			if(is_null($rowCuentasxp)){
				$secuencial = 1;
			}else{
				foreach ($rowCuentasxp as$rowCuentaxp) {
					$secuencial = $rowCuentaxp["secuencial"];
			}
			//Valida que el importe no sea mayor al saldo, vacio ó  igual a cero.
			if($datos["pago"]==0  || $datos["pago"] == " "){
				print_r("El monto del saldo es incorrecto");
			}else{
				$tablaFactura = $this->tablaFactura;
				$select= $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
				$rowFactura = $tablaFactura->fetchRow($select);
				print_r($select->__toString());
				
				if($datos["pago"]>= $rowFactura["total"] ){
					echo "El importe de pago no puede ser mayor que el importe de la factura";
				}
			}				
		}
			 /*w$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idFactura =?", $idFactura);
			$rowFactura = $tablaFactura->fetchRow($select);
			print_r("$select");
			
			if($pago["pago"]<> ""){
				if($rowFactura["total"] < $pago["pago"]){
					echo "La cantidad se cubre con:" . number_format($rowFactura["total"], 2, '.', '')  ;	
				}
				
			}
			$mCuentasxp = array(
					'idTipoMovimiento'=>4,
					'idSucursal'=>2,
					'idCoP'=>3,
					'idFactura'=>$idFactura,
					'idBanco'=>$pago['idBanco'],
					'idDivisa'=>$pago['idDivisa'],
					'numeroFolio'=>123,
					'numeroReferencia'=>$pago['numeroReferencia'],
					'secuencial'=>1,
					'estatus'=>"A",
					'fechaPago'=>date('Y-m-d h:i:s', time()),
					'fechaCaptura'=>date('Y-m-d h:i:s', time()),
					'formaLiquidar'=>$pago['formaPago'],
					'conceptoPago'=>$pago['conceptoPago'],
					'subTotal'=>0,
					'total'=>$pago['pago']
				);   
				
				//print_r($mCuentasxp);
				$dbAdapter->insert("Cuentasxp",$mCuentasxp);*/
		}
		
		public function actualiza_Saldo(){
			//Actuliza saldoProveedor
			//Actuliza saldoBando
			//Actuliza saldoFactura
		}
    }
?>