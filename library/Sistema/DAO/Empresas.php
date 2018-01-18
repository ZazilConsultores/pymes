
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
	        // Agrego Banco
	        $itemBanco['banco'] = $rowBanco; 
	       
	       
	        $select = $tCxC->select()->from($tCxC,array('totalEntradas'=>'SUM(total)'))
    	        ->where('idBanco = ?', $idBanco)
    	        ->where("date_format(fechaPago, '%m')= ?",$mes)
    	        ->where("date_format(fechaPago, '%Y')= ?",$anio);
	        
	        $rowTotalEntrada = $tCxC->fetchRow($select)->toArray();
	        
	        //print_r($select->__toString());	      
	       
	        // Agregamos Total de Entradas
	        $itemBanco['entradas'] = $rowTotalEntrada;
	        
	        $select = $tCxP->select()->from($tCxP,array('totalSalidas'=>'SUM(total)'))
	           ->where('idBanco = ?', $idBanco)
	           ->where("date_format(fechaPago, '%m')= ?",$mes)
	           ->where("date_format(fechaPago, '%Y')= ?",$anio);
	        
	        $rowTotalSalidas = $tCxP->fetchRow($select)->toArray();
	        $itemBanco['salidas'] = $rowTotalSalidas;
	        
	        $data = array(
	            'idBanco' => $idBanco,
	            'mes' => $mes,
	            'anio' => $anio,
	            'entradas' => $rowTotalEntrada['totalEntradas'],
	            'salidas' => $rowTotalSalidas['totalSalidas'],
	            'saldoIniMes' => '0.0',
	            'saldoFinMes' => '0.0'
	        );
	        
	        //print_r($itemBanco); print_r('<br />');
	        //break;
	        //$saldosBanco[] =$itemBanco;
	       
	        //Busca el saldo en tabla saldosEmpresa
	        $select = $tSB->select()->from($tSB, array('saldoFinMes','saldoIniMes'))->where('idBanco=?',$idBanco) ->where('mes = ?',$mes)->where('anio=?',$anio);
	        $rowSB = $tSB->fetchRow($select)->toArray();
	        $itemBanco['saldos'] = $rowSB;
	        //print_r($select->__toString());
	        $data['saldoIniMes'] = $rowSB['saldoIniMes'];
	        $data['saldoFinMes'] = $rowSB['saldoFinMes'];
	        
	        if(!is_null($rowSB)){
	            //print_r('update');
	            //return $rowsEditorial->toArray();
	        }else{
	           $select = $tSB->select()->from($tSB, array('saldoFinMes'))->where('idBanco=?',$idBanco) ->where('mes < ?',$mes)->where('anio=?',$anio)->order('mes desc');
	            $rowMesSA = $tSB->fetchRow($select)->toArray();
	            //$tSB->insert(array("idBanco"=>$idBanco,"mes"=>$mes,"anio"=>$anio,"entradas"=>0,"salidas"=>0,"saldoIniMes"=>0,"saldoFinMes"=>0));
	            $tSB->insert($data);
	           
	        }
	        //Agregamos saldoEmpresa
	        $itemBanco['saldo'] = $rowSB;
	        $saldosBanco[] =$itemBanco;
	    }
	    
	    return $saldosBanco;
	    
	}
	
	
	public function obtenerSaldoxBanco($idBanco){
	    $tB = $this->tablaBanco;
	    $tBE = $this->tablaBancosEmpresa;
	    $tSB = $this->tablaSaldosBancos;
	    
	    $select = $tB->select()->from($tB)->where('idBanco=?',$idBanco);
	    $rowBanco = $tB->fetchRow($select);
	    
	    $select = $tBE->select()->from($tBE)->where('idBanco=?',$rowBanco['']);
	    $rowBanco = $tB->fetchRow($select);
	    
	    print_r($select->__toString());
	}
}
