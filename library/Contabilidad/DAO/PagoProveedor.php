<?php
    class Contabilidad_DAO_PagoProveedor implements Contabilidad_Interfaces_IPagoProveedor{
    		
    	private $tablaFactura;
		private $tablaCuentasxp;
		
		public function __construct(){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
			$this->tablaCuentasxp = new Contabilidad_Model_DbTable_Cuentasxp(array('db'=>$dbAdapter));
		}
		public function busca_Facturasxp(){
			//Buscamos facturasxp, facturaProveedor = 4
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idTipoMovimiento =?",4)->where("estatus <> ?", "C")->where("conceptoPago <>?","LI");
			$rowsFacturaxp = $tablaFactura->fetchAll($select);
		
			$modelFacturas = array();
		
		foreach ($rowsFacturaxp as $rowFacturaxp) {
			$modelFactura = new Contabilidad_Model_Factura($rowFacturaxp->toArray());
			$modelFactura->setIdFactura($rowFacturaxp->idFactura);
			
			$modelFacturas[] = $modelFactura;
			
		}
		return $modelFacturas;
		}
		public function aplica_Pago ($idFactura, $pago){
			//Valida que no exista ningun pago.
			$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
			//$dbAdapter->beginTransaction();
			
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
			}
			$tablaFactura = $this->tablaFactura;
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
				$dbAdapter->insert("Cuentasxp",$mCuentasxp);
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
		
		public function busca_Cuentasxp($idSucursal,$pr){
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idTipoMovimiento =?",4)->where("estatus <> ?", "C")
			->where("conceptoPago <>?","LI")->where("idSucursal =?", $idSucursal)->where("idCoP = ?" ,$pr);
			$rowsFacturaxp = $tablaFactura->fetchAll($select)->toArray();
			
			return $rowsFacturaxp;
			/*$modelFacturas = array();
			
			foreach ($rowsFacturaxp as $rowFacturaxp) {
				$modelFactura = new Contabilidad_Model_Factura($rowFacturaxp->toArray());
				$modelFactura->setIdFactura($rowFacturaxp->idFactura);
				$modelFacturas[] = $modelFactura;
			
			}
			return $modelFacturas;*/
				
		
							
		}
		public function guardacxp ($idFactura, $idBanco, $idDivisa, $fecha,$referencia, $total)
		{
			//tipoMovimiento facaturaProveedor = 4
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idTipoMovimiento=?",4)->where("estatus=?","A")
			->where("conceptoPago <>?", "LI")->where("idFactura =?",$idFactura);
			$rowFacturap = $tablaFactura->fetchAll($select);
			print_r($select);
			if(!is_null($rowFacturap))
			{
				print_r("Guardara pago en cuentasxp");
			}
			//Registra pago en cuentasxp
			/*$mCuentasxp = array(
						'idTipoMovimiento'=>4,
						'idSucursal'=>$idSucursal,
						//'idFactura'=>32,
						'idCoP'=>$idCoP,
						'idBanco'=>$valores['banco'], //vista idBanco
						'idDivisa'=>$valores['divisa'],
						'numeroFolio'=>1, //numero de la factura
						'secuencial'=>$secuencial, //$varible
						'fechaCaptura'=>date("Y-m-d H:i:s", time()),
						'fechaPago'=>$stringFecha,//vista fecha Factura
						'estatus'=>"A",
						'numeroReferencia'=>$valores['referencia'], //numero Referencia,
						'conceptoPago'=>$valores['pago'], //conceptoPago
						'formaLiquidar'=>$valores['formaLiquidar'], //formaPago
						'subTotal'=>0,
						'total'=>0
					
					);
					print_r($mCuentasxp);*/
		}

		
    }
?>