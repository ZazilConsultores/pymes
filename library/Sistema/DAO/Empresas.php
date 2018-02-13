
<?php
/**
 * 
 */
class Sistema_DAO_Empresas implements Sistema_Interfaces_IEmpresas {
	
	private $tablaEmpresa;
	private $tablaFiscales;
	private $tablaBanco;
	private $tablaCuentasxp;
	private $tablaCuentasxc;
	private $tablaSaldosBancos;
	
	private $tablaEmpresas;
	private $tablaClientes;
	private $tablaProveedores;
	
	private $tablaClientesEmpresa;
	private $tablaProveedoresEmpresa;
	
	private $tablaTipoProveedor;
	
	private $tablaDomicilio;
	private $tablaDomiciliosFiscales;
	private $tablaTelefono;
	private $tablaTelefonosFiscales;
	private $tablaEmail;
	private $tablaEmailFiscales;
	
	private $tablaSucursal;
	private $tablaBancosEmpresa;
	
	public function __construct() {
	    $adapter =Zend_Registry::get('dbmodgeneral');
	    $this->db = $adapter;
		$dbAdapter = Zend_Registry::get('dbmodgeneral');
		$config = array('db' => $dbAdapter);
		
		$this->tablaEmpresa = new Sistema_Model_DbTable_Empresa(array('db'=>$dbAdapter));
		
		$this->tablaEmpresas = new Sistema_Model_DbTable_Empresas(array('db'=>$dbAdapter));
		$this->tablaClientes = new Sistema_Model_DbTable_Clientes(array('db'=>$dbAdapter));
		$this->tablaProveedores = new Sistema_Model_DbTable_Proveedores(array('db'=>$dbAdapter));
		
		$this->tablaClientesEmpresa = new Sistema_Model_DbTable_ClientesEmpresa(array('db'=>$dbAdapter));
		$this->tablaProveedoresEmpresa = new Sistema_Model_DbTable_ProveedoresEmpresa(array('db'=>$dbAdapter));
		
		$this->tablaTipoProveedor = new Sistema_Model_DbTable_TipoProveedor(array('db'=>$dbAdapter));
		$this->tablaSucursal = new Sistema_Model_DbTable_Sucursal(array('db'=>$dbAdapter));
		
		$this->tablaTelefono = new Sistema_Model_DbTable_Telefono(array('db'=>$dbAdapter));
		
		$this->tablaFiscales = new Sistema_Model_DbTable_Fiscales(array('db'=>$dbAdapter));
		
		$this->tablaDomicilio = new Sistema_Model_DbTable_Domicilio(array('db'=>$dbAdapter));
		$this->tablaBanco = new Contabilidad_Model_DbTable_Banco(array('db'=>$dbAdapter));
		$this->tablaCuentasxp = new Contabilidad_Model_DbTable_Cuentasxp(array('db'=>$dbAdapter));
		$this->tablaCuentasxc = new Contabilidad_Model_DbTable_Cuentasxc(array('db'=>$dbAdapter));
		
	
		
		$this->tablaBancosEmpresa = new Contabilidad_Model_DbTable_BancosEmpresa($config);
		$this->tablaSaldosBancos = new Sistema_Model_DbTable_SaldosBancos($config);
	}
	
	/**
	 * Este metodo crea una empresa, el valor almacenado en $datos[0]["tipo"], 
	 * puede ser
	 */
	public function obtenerSaldoEmpresasPorMes($mes, $anio){
	    $tB = $this->tablaBanco;
	    $tBE = $this->tablaBancosEmpresa;
	    $tSB = $this->tablaSaldosBancos;
	    $tCxC = $this->tablaCuentasxc;
	    $tCxP = $this->tablaCuentasxp;
	    
	    $rowsBE = $tBE->fetchAll()->toArray();
	    
	    $idsBanco = array();
	    foreach ($rowsBE as $rowBE) {
	        $ids = explode(',', $rowBE['idBanco']);
	        foreach ($ids as $id){
	            $idsBanco[] = $id;
	        }
	    }
	    
	    // Variable Contenedor General
	    $saldosBanco = array();
	    
	    foreach ($idsBanco as $idBanco){
	        // Variable Item
	        $itemBanco = array();
	        
	        $select = $tB->select()->from($tB,array('idBanco','banco'))->where('idBanco=?',$idBanco)->order('banco');
	        $rowBanco = $tB->fetchRow($select)->toArray();
	        //print_r($select->__toString());// Agrego Banco
	        $itemBanco['banco'] = $rowBanco;
	        
	        $select = $tCxC->select()->from($tCxC,array('totalEntradas'=>'SUM(total)'))->where('idBanco = ?', $idBanco)
	        ->where("date_format(fechaPago, '%m')= ?",$mes)->where("date_format(fechaPago, '%Y')= ?",$anio);
	        $rowTotalEntrada = $tCxC->fetchRow($select)->toArray();
	        //print_r($select->__toString());// Agregamos Total de Entradas
	        $itemBanco['entradas'] = $rowTotalEntrada;
	        
	        $select = $tCxP->select()->from($tCxP,array('totalSalidas'=>'SUM(total)'))->where('idBanco = ?', $idBanco)
	        ->where("date_format(fechaPago, '%m')= ?",$mes)->where("date_format(fechaPago, '%Y')= ?",$anio);
	        $rowTotalSalidas = $tCxP->fetchRow($select)->toArray();
	        // Agregamos Total de Salidas
	        $itemBanco['salidas'] = $rowTotalSalidas;
	        
	        //Busca el saldo en tabla saldosEmpresa
	        $select = $tSB->select()->from($tSB)->where('idBanco=?',$idBanco)->where('mes = ?',$mes)->where('anio=?',$anio);
	        $rowSB = $tSB->fetchRow($select);
	        
	        if(!is_null($rowSB)){
	            $rowsSB = $tSB->fetchRow($select)->toArray();
	            //print_r($select->__toString());print_r("<br />");
	            //Si el registro ya existe, verificamos que el saldo de banco en cxc 
	            $select = $tCxC->select()->from($tCxC,array('idBanco','totalEntradas'=>'SUM(total)'))->where('idBanco = ?', $rowsSB['idBanco'])
	            ->where("date_format(fechaPago, '%m')= ?",$mes)->where("date_format(fechaPago, '%Y')= ?",$anio);
	            $rowTotalE = $tCxC->fetchRow($select)->toArray();
	           
	            if($rowsSB['entradas']  !==  $rowTotalE['totalEntradas'] && $rowsSB['mes']<>05 &&  !is_null($rowTotalE['totalEntradas'])){
	                //si la entrada se ha modificado, buscado en la tabla saldo Bancos, el registro del banco print_r("Se Ha MODIFICADO");print_r("<br />");
	                //print_r("La cantidad ha cambiado");print_r("<br />");
	                $select = $tSB->select()->from($tSB)->where('idBanco=?', $rowsSB['idBanco'])->where('mes = ?',$mes)->where('anio=?',$anio);
	                $rowSaldoA = $tSB->fetchRow($select)->toArray();
	                //print_r($select->__toString());print_r("<br />");
	               
	                $select = $tSB->select()->from($tSB, array('saldoFinMes'))->where('idBanco=?',$rowSaldoA['idBanco']) ->where('mes < ?',$mes)->where('anio=?',$anio)->order('mes desc');
	                $rowMesASA = $tSB->fetchRow($select);
	                $saldoAIniAMesE = $rowMesASA['saldoFinMes'];
	                $saldoAFinMes = $rowTotalE['totalEntradas'] + $saldoIniAMes - $rowSaldoA['salidas'];
	                
	                //print_r($saldoAAIniMes);print_r("<br />");print_r($saldoAFinMes);print_r("<br />");
	                $data = array(
	                    "entradas" => $rowTotalE['totalEntradas'], 
	                    "saldoIniMes" => $saldoAIniAMesE,
	                    "saldoFinMes" => $saldoAFinMes
	                );
	                $where = array(
	                    'idBanco = ?' => $rowSaldoA['idBanco'],
	                    'mes = ?' =>  $rowSaldoA['mes'],
	                    'anio = ?' => $rowSaldoA['anio']
	                );
	              
	                $tSB->update($data, $where);
	            }
	            
	            
	            $itemBanco['saldos'] = $rowsSB;
	            //Si el registro ya existe, verificamos que el saldo de banco en cxp
	            $select = $tCxP->select()->from($tCxP,array('idBanco','totalSalidas'=>'SUM(total)'))->where('idBanco = ?', $rowsSB['idBanco'])
	            ->where("date_format(fechaPago, '%m')= ?",$mes)->where("date_format(fechaPago, '%Y')= ?",$anio);
	            $rowTotalS = $tCxP->fetchRow($select)->toArray();
	            //print_r($select->__toString());print_r("<br />");
	           
	           if($rowsSB['salidas']  !==  $rowTotalS['totalSalidas'] && $rowsSB['mes']<>05 &&  !is_null($rowTotalS['totalSalidas'])){
	                //si la entrada se ha modificado, buscado en la tabla saldo Bancos, el registro del banco print_r("Se Ha MODIFICADO");print_r("<br />");
	                $select = $tSB->select()->from($tSB)->where('idBanco=?', $rowsSB['idBanco'])->where('mes = ?',$mes)->where('anio=?',$anio);
	                $rowSaldoA = $tSB->fetchRow($select)->toArray();
	                //print_r($select->__toString());print_r("<br />");
	                
	                $select = $tSB->select()->from($tSB, array('saldoFinMes'))->where('idBanco=?',$rowSaldoA['idBanco']) ->where('mes < ?',$mes)->where('anio=?',$anio)->order('mes desc');
	                $rowMesASA = $tSB->fetchRow($select);
	                $saldoIniAMes = $rowMesASA['saldoFinMes'];
	                //print_r($select->__toString());print_r("<br />");print_r($saldoIniAMes);print_r("<br />");
	                
	                $saldoAFinMes = $rowTotalE['totalEntradas'] + $saldoIniAMes - $rowTotalS['totalSalidas'];
	                //print_r($saldoAFinMes);print_r("<br />");
	                
	                $data = array(
	                    "entradas" => $rowTotalE['totalEntradas'],
	                    "saldoIniMes" => $saldoIniAMes,
	                    "saldoFinMes" => $saldoAFinMes
	                );
	                $where = array(
	                    'idBanco = ?' => $rowSaldoA['idBanco'],
	                    'mes = ?' =>  $rowSaldoA['mes'],
	                    'anio = ?' => $rowSaldoA['anio']
	                );
	                
	                $tSB->update($data, $where);
	            }
	            $itemBanco['saldos'] = $rowsSB;
	        }else{
	            $select = $tSB->select()->from($tSB, array('saldoFinMes'))->where('idBanco=?',$idBanco) ->where('mes < ?',$mes)->where('anio=?',$anio)->order('mes desc');
	            $rowMesSA = $tSB->fetchRow($select);
	            $saldoIniMes = $rowMesSA['saldoFinMes'];
	            $totalEntradas = is_null($rowTotalEntrada['totalEntradas']) ? '0.0' : $rowTotalEntrada['totalEntradas'] ;
	            $totalSalidas = is_null($rowTotalSalidas['totalSalidas']) ? '0.0' : $rowTotalSalidas['totalSalidas'] ;
	            $saldoFinMes = $totalEntradas + $saldoIniMes - $totalSalidas;
	            $data = array(
	                'idBanco' => $idBanco,
	                'mes' => $mes,
	                'anio' => $anio,
	                'entradas' => $totalEntradas,
	                'salidas' => $totalSalidas,
	                'saldoIniMes' => $saldoIniMes,
	                'saldoFinMes' => $saldoFinMes
	            );
	            $tSB->insert($data);
	            //$itemBanco['saldos'] = $rowsSB;
	           
	        }
	        
	        //Agregamos saldoEmpresa
	        //$itemBanco['saldo'] = $rowSB;
	        $saldosBanco[] =$itemBanco;
	        
	    }
	    return $saldosBanco;
	}
	
	
	public function obtenerSaldoxBanco($idEmpresa,$idBanco){
	    $tB = $this->tablaBanco;
	    $tBE = $this->tablaBancosEmpresa;
	    $tSB = $this->tablaSaldosBancos;
	    
	    $select = $tBE->select()->from($tBE)->where('idEmpresa = ?',$idEmpresa);
	    $rowtBE = $tBE->fetchRow($select);
	    $ids = explode(',', $rowtBE['idBanco']);
	    foreach ($ids as $id){
	       if($idBanco == $id){
	           $select = $tB->select()->from($tB)->where('idBanco = ?',$idBanco);
	           $rowtB =$tB->fetchRow($select);
	           
	           $select = $tSB->select()->from($tSB)->where('idBanco = ?', $rowtB['idBanco']);
	           $rowtSB =$tSB->fetchAll($select);
	           //print_r($select->__toString());
	           return $rowtSB->toArray();
	       }
	    }
	}
}
