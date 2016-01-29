<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
/**
 * Agregamos variables al registro de Zend, 
 * este se mantendra en memoria: no acepta objetos, solo variables y arrays.
 */
 //============================================================== >>> Arrays de conexion a bd: usados para las clases de Zend_Db
 $connlocal = array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => 'zazil',
		'dbname' => 'general',
	);
 $connlocaldos = array(
		'host' => 'localhost',
		'username' => 'zazil',
		'password' => 'admin',
		'dbname' => 'generaldos',
	);
$connserver = array(
		'host' => '192.168.1.5',
		'username' => 'inventario',
		'password' => 'inventario',
		'dbname' => 'inventarior',
	);
$connnancy = array(
		'host' => '192.168.1.240',
		'username' => 'areli',
		'password' => 'zazil',
		'dbname' => 'inventario',
	);
$connlocalOrigen = array(
		'host' => 'localhost',
		'username' => 'inventario',
		'password' => 'inventario',
		'dbname' => 'inventario',
	);

Zend_Registry::set('connlocal', $connlocal);
Zend_Registry::set('connserver', $connserver);
Zend_Registry::set('connnancy', $connnancy);
Zend_Registry::set('connlocalorigen', $connlocalOrigen);
//============================================================== >>> Fijamos una conexion directa a localhost
//$db = Zend_Db::factory('PDO_MYSQL', $connlocalOrigen);
$db = Zend_Db::factory('PDO_MYSQL', $connlocaldos);
$db->query("SET NAMES 'utf8'");
$db->query("SET CHARACTER SET 'utf8'");
Zend_Db_Table_Abstract::setDefaultAdapter($db);

//$dbServer = Zend_Db::factory('PDO_MYSQL', $connlocalOrigen);
//Zend_Registry::set('dbInventarioLocal', $dbServer);

date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'es_MX.UTF-8');
//============================================================================ CONSTANTES GENERALES
//$estatusEncuesta = array('0' => 'CREADO', '1' => 'PUBLICADO', '2' => 'ACTIVO', '3' => 'FINALIZADO');
$tipo = array('AB' => 'ABIERTAS', 'SS' => 'SIMPLE SELECCION', 'MS' => 'MULTIPLE SELECCION');
$padre = array('G' => 'GRUPO', 'S' => 'SECCION');
$estatus = array('0' => 'CREADO', '1' => 'ACTIVO', '2' => 'FINALIZADO');
$tUsuario = array('AL' => 'Alumna', 'DO' => 'Docente', 'MA' => 'Mantenimiento', 'LI' => 'Limpieza', 'SI' => 'Sistemas','AD' => 'Administrativo');
$tipoEmpresa = array("EM"=>"Empresa","CL"=>"Cliente","PR"=>"Proveedor");
$tipoMantenimiento = array("MH"=>"Mantenimiento Hardware","MS"=>"Mantenimiento Software","AV"=>"Antivirus","RO"=>"Registro Observaciones");
//Zend_Registry::set('estatusEncuesta', $estatusEncuesta);
Zend_Registry::set('tipo', $tipo);
Zend_Registry::set('tUsuario', $tUsuario);
Zend_Registry::set('padre', $padre);
Zend_Registry::set('estatus', $estatus);
Zend_Registry::set('tipoEmpresa', $tipoEmpresa);

$application->bootstrap()
            ->run();