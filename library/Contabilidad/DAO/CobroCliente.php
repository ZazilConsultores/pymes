<?php
    class Contabilidad_DAO_CobroCliente implements Contabilidad_Interfaces_ICobroCliente{
    		
    	private $tablaFactura;
		private $tablaCuentasxc;
    	private $tablaClientes;
		private $tablaEmpresa;
		private $tablaFiscales;
		private $tablaBancos;
		private $tablaSucursal;
		private $tablaMovimientos;
		
		public function __construct(){
			$dbAdapter = Zend_Registry::get('dbmodgeneral');
			$this->tablaFactura = new Contabilidad_Model_DbTable_Factura(array('db'=>$dbAdapter));
			$this->tablaCuentasxc = new Contabilidad_Model_DbTable_Cuentasxc(array('db'=>$dbAdapter));
			$this->tablaClientes = new Sistema_Model_DbTable_Clientes(array('db'=>$dbAdapter));
			$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
			$this->tablaFiscales = new Sistema_Model_DbTable_Fiscales(array('db'=>$dbAdapter));
			$this->tablaBancos = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
			$this->tablaSucursal = new Sistema_Model_DbTable_Sucursal(array('db'=>$dbAdapter));
			$this->tablaMovimientos = new Contabilidad_Model_DbTable_Movimientos(array('db'=>$dbAdapter));
			
		}
		
		public function busca_Cuentasxc($idSucursal,$cl){
			//tipo Movimiento facturaCliente = 2
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idTipoMovimiento =?",2)->where("estatus <> ?", "C")
			->where("conceptoPago <>?","PUE")->where("idSucursal =?", $idSucursal)->where("idCoP = ?" ,$cl);
			$rowsFacturaxc = $tablaFactura->fetchAll($select)->toArray();
			return $rowsFacturaxc;
							
		}
		
		public function busca_RemisionClienteCafe($idSucursal,$cl){
		    //tipo Movimiento facturaCliente = 2
		    /*$tablaMovtos = $this->tablaMovimientos;
		    $select = $tablaMovtos->select()->from($tablaMovtos,new Zend_Db_Expr('SUM(Movimientos.totalImporte)as totalImporte'))->where("idTipoMovimiento =?",13)->where("estatus <> ?", "A")
		    ->where("idSucursal =?", $idSucursal)->where("idCoP = ?" ,$cl);
		    $rowsMovtos = $tablaMovtos->fetchAll($select)->toArray();
		   // print_r("$select");
		    //return $tablaMovtos;*/
		    
		    $tablaMovimientos  = $this->tablaMovimientos;
		    $select = $tablaMovimientos->select()->setIntegrityCheck(false)
		    ->from($tablaMovimientos, array('idMovimiento','idSucursal','idCoP', 'numeroFolio','fecha',new Zend_Db_Expr('SUM(totalImporte)as totalImporte')))
		    ->join('Clientes','Movimientos.idCoP = Clientes.idCliente')
		    ->join('Empresa','Clientes.idEmpresa = Empresa.idEmpresa')
		    ->join('Fiscales','Empresa.idFiscales = Fiscales.idFiscales',  array('razonSocial'))
		    ->where("idTipoMovimiento =?",13)->where("estatus <> ?", "A")
		    ->where("Movimientos.idSucursal =?", $idSucursal)->where("idCoP = ?" ,$cl)
		    ->group('numeroFolio')->group('fecha');
		   return $tablaMovimientos->fetchAll($select); 
		}
		
		public function busca_FacCli($idSucursal,$num){
			
			$tablaFactura = $this->tablaFactura;
			$select= $tablaFactura->select()
			->setIntegrityCheck(false)
			->from($tablaFactura)
			->join('Clientes','Factura.idCoP = Clientes.idCliente', array('idEmpresa'))
			->join('Empresa','Clientes.idEmpresa = Empresa.idEmpresa')
			->join('Fiscales','Empresa.idFiscales = Fiscales.idFiscales',  array('razonSocial'))->where('Factura.idTipoMovimiento = ?',2)
			->where("estatus <> ?", "C")->where("conceptoPago =?","PE")->where("idSucursal =?", $idSucursal)->where("numeroFactura = ?" ,$num);
			return $tablaFactura->fetchAll($select);				
		}
		
		public function aplica_Cobro ($idFactura, array $datos){
			$dbAdapter =  Zend_Registry::get('dbmodgeneral');	
			//$dbAdapter->beginTransaction();
			$dateIni = new Zend_Date($datos['fecha'],'YY-MM-dd');
			$stringIni = $dateIni->toString ('yyyy-MM-dd');
			
			try{
				
				$tablaCuentasxc = $this->tablaCuentasxc;
				$select = $tablaCuentasxc->select()->from($tablaCuentasxc)->where("idTipoMovimiento= ?",16)->where("idFactura=?", $idFactura)
				->order("secuencial DESC");
				$rowCuentasxc = $tablaCuentasxc->fetchRow($select);
				//print_r($select->__toString());
				
				if(!is_null($rowCuentasxc)){
					$secuencial= $rowCuentasxc->secuencial +1;
				}else{
					$secuencial = 1;	
				}
				
				//Valida que el importe no sea mayor al saldo, vacio ó  igual a cero.
				if($datos["pago"]== 0  || $datos["pago"] == " "){
					print_r("El monto del saldo es incorrecto");
				}else{
					$tablaFactura = $this->tablaFactura;
					$select= $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
					$rowFactura = $tablaFactura->fetchRow($select);
					//print_r($select->__toString());
					$mCuentasxc = array(
						'idTipoMovimiento'=>16,
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
					$dbAdapter->insert("Cuentasxc",$mCuentasxc);
					//GuardaIva em facturaImpuesto
					$tablaCuentasxc = $this->tablaCuentasxc;
					$select= $tablaCuentasxc->select()->from($tablaCuentasxc)->where("idFactura=?", $idFactura)->order("secuencial DESC");;
					$rowcxc = $tablaFactura->fetchRow($select);
					//print_r("$select");
					$mfImpuesto = array(
						'idTipoMovimiento'=>16,
						'idFactura'=>$rowFactura['idFactura'],
						'idImpuesto'=>4, //Iva
						'idCuentasxp'=>0,
						'importe'=>$datos["pago"]- $rowcxc->subtotal
					);
					//	print_r($mfImpuesto);
					$dbAdapter->insert("FacturaImpuesto", $mfImpuesto);
					//Al registrar el cobro, afecta registro factura, saldo banco y saldo Cliente.
					$actualizaRegistro = $this->actualiza_Saldo($idFactura, $datos);
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
		
        public function aplica_CobroRemisionCafe($idMovimiento, array $datos){
            
		    $dbAdapter =  Zend_Registry::get('dbmodgeneral');
		    //$dbAdapter->beginTransaction();
		    $dateIni = new Zend_Date($datos['fecha'],'YY-MM-dd');
		    $stringIni = $dateIni->toString ('yyyy-MM-dd');
		    
		    try{
		        $tablaMovtos = $this->tablaMovimientos;
		        $select = $tablaMovtos->select()->from($tablaMovtos)->where("idMovimiento= ?",$idMovimiento);
		        $rowMovimiento = $tablaMovtos->fetchRow($select);
		        
		        $tablaMovitos = $this->tablaMovimientos;
		        $select = $tablaMovtos->select()->from($tablaMovtos)->where("idSucursal= ?",$rowMovimiento['idSucursal'])->where("idCoP =?",$rowMovimiento['idCoP'])
		        ->where("numeroFolio= ?",$rowMovimiento['numeroFolio'])->where("fecha = ?",$rowMovimiento['fecha'])->where("estatus<>?","A");
		        $rowsMovto = $tablaMovtos->fetchAll($select);
		        print_r($rowsMovto);  
		        
		        
		        $tablaCuentasxc = $this->tablaCuentasxc;
		        $select = $tablaCuentasxc->select()->from($tablaCuentasxc)->where("idTipoMovimiento= ?",13)->where("idSucursal= ?",$rowMovimiento["idSucursal"])
		        ->where("idCoP= ?",$rowMovimiento["idCoP"])->where("numeroFolio= ?",$rowMovimiento["numeroFolio"])->order("secuencial DESC");
		        $rowCuentasxc = $tablaCuentasxc->fetchRow($select);
		        //print_r($select->__toString());
		        if(!is_null($rowCuentasxc)){
		            $secuencial= $rowCuentasxc->secuencial +1;
		        }else{
		            $secuencial = 1;
		        }
		        
		        //Valida que el importe no sea mayor al saldo, vacio ó  igual a cero.
		        if($datos["pago"]== 0  || $datos["pago"] == " "){
		            print_r("El monto del saldo es incorrecto");
		        }else{
		            $mCuentasxc = array(
		                'idTipoMovimiento'=>13,
		                'idSucursal'=>$rowMovimiento['idSucursal'],
		                'idCoP'=>$rowMovimiento['idCoP'],
		                //'idFactura'=>$rowFactura['idFactura'],
		                'idBanco'=>$datos['idBanco'],
		                'idDivisa'=>$datos['idDivisa'],
		                'numeroFolio'=>$rowMovimiento['numeroFolio'],
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
		            $dbAdapter->insert("Cuentasxc",$mCuentasxc);

		            //Al registrar el cobro, afecta registro factura, saldo banco y saldo Cliente.
		           $actualizaRegistro = $this->actualiza_Movimiento($idMovimiento, $datos);
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
			$select = $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
			$rowFactura = $tablaFactura->fetchRow($select);
			//print_r($select->__toString());
			if(is_null($rowFactura)) {
				//return null;
			}else{
				return $rowFactura;
			}
		}
		
		public function obtieneMovimiento($idMovimiento){
		    $tablaMovtos = $this->tablaMovimientos;
		    $select = $tablaMovtos->select()->from($tablaMovtos)->where("idMovimiento=?", $idMovimiento);
		    $rowMovto = $tablaMovtos->fetchRow($select);
		    //print_r($select->__toString());
		    if(is_null($rowMovto)) {
		        return null;
		    }else{
		        return $rowMovto;
		    }
		}
		
		public function obtieneFacturaParaAnticipoCliente($idSucursal,$idCoP){
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idSucursal=?", $idSucursal)->where("idCoP=?", $idCoP);
			$rowFactura = $tablaFactura->fetchAll($select);
			//print_r($select->__toString());
			if(is_null($rowFactura)) {
				//return null;
			}else{
				return $rowFactura;
			}
		}
		
		/*Obtiene clientes por idFactura*/
		public function obtenerClienteEmpresa($idFactura) {
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
			$tablaFactura = $tablaFactura->fetchRow($select);
			
	 		$tablaClientes = $this->tablaClientes;
			$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente=?", $tablaFactura->idCoP);
			$rowCliente = $tablaClientes->fetchRow($select);
		
			$tablaEmpresa = $this->tablaEmpresa;
			$select = $tablaEmpresa->select()->from($tablaEmpresa)->where("idEmpresa=?",$rowCliente->idEmpresa);
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
		public function busca_CobrosCXC ($idFactura){
			$tablaCuentasxc = $this->tablaCuentasxc;
			$select = $tablaCuentasxc->select()->from($tablaCuentasxc)->where("idTipoMovimiento= ?",16)->where("idFactura = ?", $idFactura);
			$rowCuentasxc = $tablaCuentasxc->fetchAll($select)->toArray();
			return $rowCuentasxc;
			
		}
	public function busca_AnticipoCliente($idSucursal,$cl){
		//tipo Movimiento facturaCliente = 2
		$tablaCuentasxc = $this->tablaCuentasxc;
		$select = $tablaCuentasxc->select()->from($tablaCuentasxc)->where("idTipoMovimiento =?",19)->where("estatus <> ?", "C")->where("idFactura IS NULL")
		->where("idSucursal =?", $idSucursal)->where("idCoP = ?" ,$cl);
		$rowsCuentasxc = $tablaCuentasxc->fetchAll($select)->toArray();
		//print_r("$select");
		return $rowsCuentasxc;
							
	}
		public function actualiza_Saldo($idFactura, array $datos){
			$dateIni = new Zend_Date($datos['fecha'],'YY-MM-dd');
			$stringIni = $dateIni->toString ('yyyy-MM-dd');
			//Actuliza saldoCliente
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
			$tablaFactura = $tablaFactura->fetchRow($select);
			
	 		$tablaClientes = $this->tablaClientes;
			$select = $tablaClientes->select()->from($tablaClientes)->where("idCliente=?", $tablaFactura->idCoP);
			$rowCliente = $tablaClientes->fetchRow($select);
			//print_r($select->__toString());
			$saldo = $rowCliente->saldo - $datos["pago"];
			$rowCliente->saldo = $saldo;
			$rowCliente->save();
			print_r("<br />");
			//Actuliza saldoBando
			$tablaBancos= $this->tablaBancos;
			$select = $tablaBancos->select()->from($tablaBancos)->where("idBanco = ?",$datos["idBanco"]);
			$rowBanco = $tablaBancos->fetchRow($select);
			//print_r("$select");
			$sBanco = $rowBanco->saldo + $datos["pago"];
			$rowBanco->saldo = $sBanco;
			$rowBanco->fecha = $stringIni;
			$rowBanco->save();
			//Actuliza saldoFactura
			$tablaFactura = $this->tablaFactura;
			$select = $tablaFactura->select()->from($tablaFactura)->where("idFactura=?", $idFactura);
			$rowFactura = $tablaFactura->fetchRow($select);
			//print_r("$select");
			$saldo = $rowFactura->saldo - $datos["pago"];
			//print_r($saldo);
			
			//Actualiza el importe pago 	
			$iFactura = $rowFactura->importePagado + $datos["pago"];
			$rowFactura->importePagado = $iFactura;
			if($saldo <= 0){
				$rowFactura->conceptoPago = "PUE";
			}else{
				$rowFactura->conceptoPago = "PPD";
			}
			$rowFactura->saldo = $saldo;
			$rowFactura->save();	
			
		}
	   
		public function actualiza_Movimiento($idMovimiento, array $datos){
		    $dateIni = new Zend_Date($datos['fecha'],'YY-MM-dd');
		    $stringIni = $dateIni->toString ('yyyy-MM-dd');
		    //Actuliza saldoCliente
		    $tablaMovto = $this->tablaMovimientos;
		    $select = $tablaMovto->select()->from($tablaMovto)->where("idMovimiento=?", $idMovimiento);
		    $rowMovto = $tablaMovto->fetchRow($select);
		    
		    $tablaClientes = $this->tablaClientes;
		    $select = $tablaClientes->select()->from($tablaClientes)->where("idCliente=?", $rowMovto->idCoP);
		    $rowCliente = $tablaClientes->fetchRow($select);
		    //print_r($select->__toString());
		    $saldo = $rowCliente->saldo - $datos["pago"];
		    $rowCliente->saldo = $saldo;
		    $rowCliente->save();
		    print_r("<br />");
		    //Actuliza saldoBando
		    $tablaBancos= $this->tablaBancos;
		    $select = $tablaBancos->select()->from($tablaBancos)->where("idBanco = ?",$datos["idBanco"]);
		    $rowBanco = $tablaBancos->fetchRow($select);
		    //print_r("$select");
		    $sBanco = $rowBanco->saldo + $datos["pago"];
		    $rowBanco->saldo = $sBanco;
		    $rowBanco->fecha = $stringIni;
		    $rowBanco->save();
		    //Actuliza estatus en Movimiento
		    $saldo = $rowMovto->totalImporte - $datos["pago"];
		    //print_r($saldo);
		    if($saldo <= 0){
		        $rowMovto->estatus = "A";
		    }else{
		        $rowMovto->estatus = "P";
		    }
		    $rowMovto->save();    
		}
    }

