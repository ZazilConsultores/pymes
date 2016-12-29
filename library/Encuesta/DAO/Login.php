<?php
/**
 * Class Login
 * @author Hector Rodriguez
 * @copyright Zazil Consultores S.A. de C.V.
 */
class Encuesta_DAO_Login {

    private $tableOrganizacion;
    private $tableUsuario;
    private $tableSubscripcion;
    private $tableRol;

	function __construct() {
	    $dbBaseAdapter = Zend_Registry::get("dbbaseencuesta");
        
		$this->tableOrganizacion = new Encuesta_Model_DbTable_Organizacion(array('db'=>$dbBaseAdapter));
        $this->tableSubscripcion = new Encuesta_Model_DbTable_Subscripcion(array('db'=>$dbBaseAdapter));
        $this->tableRol = new Encuesta_Model_DbTable_Rol(array('db'=>$dbBaseAdapter));
        $this->tableUsuario = new Encuesta_Model_DbTable_Usuario(array('db'=>$dbBaseAdapter));
	}
    
    /**
     * 
     */
    public function getOrganizacionByClave($claveOrganizacion) {
       $tableOrganizacion = $this->tableOrganizacion;
       $where = $tableOrganizacion->getAdapter()->quoteInto("claveOrganizacion=?", $claveOrganizacion);
       $rowOrganizacion = $tableOrganizacion->fetchRow($where);
       
       if(!is_null($rowOrganizacion)) return $rowOrganizacion->toArray();
       else return null; 
    }
    
    /**
     * 
     */
    public function getSubscripcion($idOrganizacion) {
        $tableSubscription = $this->tableSubscripcion;
        $where = $tableSubscription->getAdapter()->quoteInto("idOrganizacion=?", $idOrganizacion);
        $rowSubscripcion = $tableSubscription->fetchRow($where);
        if (!is_null($rowSubscripcion)) return $rowSubscripcion->toArray();
        else return null;
    }
    
    
    /**
     * 
     */
    public function getRolbyId($idRol) {
       $tablaRol = $this->tableRol;
       $where = $tablaRol->getAdapter()->quoteInto("idRol=?", $idRol);
       $rowRol = $tablaRol->fetchRow($where);
       if (!is_null($rowRol)) return $rowRol->toArray();
        else return null; 
    }
    
    
}
