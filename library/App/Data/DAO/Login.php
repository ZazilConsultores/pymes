<?php
/**
 * 
 * @author EnginnerRodriguez
 *
 */
class App_Data_DAO_Login {
    
    private $tableModulo;
    private $tableUsuario;
    private $tableSubscripcion;
    private $tableOrganizacion;
    
    
    public function __construct() {
        $config = array('db' => Zend_Registry::get('dbgenerale'));
        
        $this->tableModulo = new App_Data_DbTable_Modulo($config);
        $this->tableUsuario = new App_Data_DbTable_Usuario($config);
        $this->tableSubscripcion = new App_Data_DbTable_Subscripcion($config);
        $this->tableOrganizacion = new App_Data_DbTable_Organizacion($config);
    }
    
    /**
     * 
     * @param array $params
     */
    public function login($params) {
        $auth = Zend_Auth::getInstance();
        
        $dbAdapter = Zend_Registry::get('zgeneral');
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter, 'Usuario','nickname','password');
        $authAdapter->setIdentity($params['nickname'])->setCredential($params['password']);
        
        $resultado = $auth->authenticate($authAdapter);
        
        print_r($resultado);
    }
    
    /**
     * 
     * @param string $module
     * @param array $params
     */
    public function loginModule($module, $params) {
        
        $tM = $this->tableModulo;
        $select = $tM->select()->from($tM)->where('clave=?',$module);
        $rowM = $tM->fetchRow($select)->toArray();
        
        $auth = Zend_Auth::getInstance();
        
        $dbAdapter = Zend_Registry::get('zgeneral');
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter, 'Usuario','nickname','password');
        $authAdapter->setIdentity($params['nickname'])->setCredential($params['password']);
        
    }
    
    public function getOrganizacionByClave($clave){
        $tOrg = $this->tableOrganizacion;
        $select = $tOrg->select()->from($tOrg)->where('clave=?',$clave);
        $rowOrg = $tOrg->fetchRow($select);
        
        return $rowOrg->toArray();
    }
    
    
    
    
}