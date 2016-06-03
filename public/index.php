<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
// Define application pdf directory
defined('PDF_PATH')
    || define('PDF_PATH', realpath(dirname(__FILE__) .'/pdf' ));
// Define application images directory
defined('IMAGES_PATH')
    || define('IMAGES_PATH', realpath(dirname(__FILE__) .'/images' ));
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
		'username' => 'zazil',
		'password' => 'admin',
		'dbname' => 'General',
	);
 $connlocaldos = array(
		'host' => 'localhost',
		'username' => 'zazil',
		'password' => 'admin',
		'dbname' => 'GeneralDos',
	);
$connserver = array(
		'host' => '192.168.1.5',
		'username' => 'zazil',
		'password' => 'admin',
		//'dbname' => 'General',
		'dbname' => 'GeneralSagrado',
	);
$connlocaltres = array(
		'host' => 'localhost',
		'username' => 'zazil',
		'password' => 'admin',
		//'dbname' => 'General',
		'dbname' => 'GeneralEncuestas',
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
//Zend_Registry::set('connserver', $connserver);
//Zend_Registry::set('connnancy', $connnancy);
//Zend_Registry::set('connlocalorigen', $connlocalOrigen);
//============================================================== >>> Fijamos una conexion directa a localhost
//$db = Zend_Db::factory('PDO_MYSQL', $connlocalOrigen);

$db = Zend_Db::factory('PDO_MYSQL', $connlocal);
//$db = Zend_Db::factory('PDO_MYSQL', $connnancy);
//$db = Zend_Db::factory('PDO_MYSQL', $connlocaldos);
//$db = Zend_Db::factory('PDO_MYSQL', $connserver);

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
$formaPago = array('CH'=>'CHEQUE','DE'=>'DEPOSITO','EF'=>'EFECTIVO','SP'=>'SPEI');
$padre = array('G' => 'GRUPO', 'S' => 'SECCION');
$estatus = array('A' => 'ACTIVO', 'C' => 'CANCELADO');
$tUsuario = array('AL' => 'Alumna', 'DO' => 'Docente', 'MA' => 'Mantenimiento', 'LI' => 'Limpieza', 'SI' => 'Sistemas','AD' => 'Administrativo');
$tipoEmpresa = array("EM"=>"Empresa","CL"=>"Cliente","PR"=>"Proveedor");
$tipoBanco = array("CA" => "Caja","IN" => "Inversiones","OP" => "Operacion");
$tipoTelefono = array("OF"=>"Oficina","CL"=>"Celular");
//$tipoEmail = array("OF"=>"Oficina","CS"=>"Casa","PR"=>"Proveedor");
$tipoMantenimiento = array("MH"=>"Mantenimiento Hardware","MS"=>"Mantenimiento Software","AV"=>"Antivirus","RO"=>"Registro Observaciones");
$gradosEscolares = array(1=>"1°",2=>"2°",3=>"3°",4=>"4°",5=>"5°",6=>"6°",7=>"7°",8=>"8°",9=>"9°");
//Zend_Registry::set('estatusEncuesta', $estatusEncuesta);
//============================================================================ DECORATORS
//text form element table decorators
$textFETDecorators = array(
	'ViewHelper',//array('ViewHelper', array('tag' => 'td')),
	'Errors',
	array(array('data'=>'HtmlTag'), array('tag'=>'td', "class"=>"element")),
	array('Label', array('tag'=>'td')),
	array(array('row'=>'HtmlTag'), array('tag'=>'tr'))
);
//button form element table decorators
$buttonFETDecorators = array(
	'ViewHelper',//array('ViewHelper', array('tag' => 'td')),
	array(array('data'=>'HtmlTag'), array('tag'=>'td', "class"=>"element")),
	array('Label', array('tag'=>'td','placement'=>'prepend')),
	array(array('row'=>'HtmlTag'), array('tag'=>'tr'))
);
//text subform element table decorators
$textSETDecorators = array(
	array('ViewHelper', array('tag' => 'td')),
	array('Label', array('tag'=>'td')),
	array('HtmlTag', array('tag'=>'tr'))
);
//subform table decorators
$subformTDecorators = array(
	'FormElements',
	array('HtmlTag',array('tag'=>'tr')),

);
//form table decorators
$formTDecorators = array(
	'FormElements',
	array('HtmlTag',array('tag'=>'table','class'=>'table table-striped table-condensed')),
	'Form'
);
//============================================================================ CONSTANTES GENERALES
Zend_Registry::set('tipo', $tipo);
Zend_Registry::set('tUsuario', $tUsuario);
Zend_Registry::set('padre', $padre);
Zend_Registry::set('estatus', $estatus);
Zend_Registry::set('tipoEmpresa', $tipoEmpresa);
Zend_Registry::set('tipoTelefono', $tipoTelefono);
Zend_Registry::set('tipoBanco', $tipoBanco);
Zend_Registry::set('gradosEscolares', $gradosEscolares);
Zend_Registry::set('formaPago', $formaPago);
$application->bootstrap()
            ->run();
