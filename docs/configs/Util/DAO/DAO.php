<?php
/**
 * 
 */
class Util_DAO_DAO {
	
	private $instance;
	private $db;
	
	public function __construct() {
		$this->db = Zend_Db_Table::getDefaultAdapter();;
	}
	
	public static function getInstance()
	{
		if(is_null($this->instance)) $this->instance = new Util_DAO_DAO;
		return $this->instance; 
	}
	
	public function insertar($nombreTabla, array $columnas) {
		$db = $this->db;
		try{
			$db->insert($nombreTabla, $bind);
		}catch(Exception $ex){
			throw new Util_Exception_BussinessException("Error :" . $ex->getMessage(), 1);
		}
	}
	
	public function obtenerFilas($nombreTabla)
	{
		$db = $this->db;
		try{
			//$db->insert($nombreTabla, $bind);
			$db->select();
		}catch(Exception $ex){
			throw new Util_Exception_BussinessException("Error :" . $ex->getMessage(), 1);
		}
	}
	
	
}
