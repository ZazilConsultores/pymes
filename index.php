<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . './application'));
// Define path of application modules
defined('MODULES_PATH')
        || define('MODULES_PATH', realpath(dirname(__FILE__) . './application/modules'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
// Define application pdf directory
defined('PDF_PATH')
    || define('PDF_PATH', realpath(dirname(__FILE__) .'/public/pdf' ));
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
    APPLICATION_PATH . './configs/application.ini'
);
/**
 * Agregamos variables al registro de Zend,
 * este se mantendra en memoria: no acepta objetos, solo variables y arrays.
 */
//setlocale(LC_MONETARY, 'es_MX.UTF-8');
setlocale(LC_ALL, 'es_MX.UTF-8');
//============================================================================ CONSTANTES GENERALES
//$estatusEncuesta = array('0' => 'CREADO', '1' => 'PUBLICADO', '2' => 'ACTIVO', '3' => 'FINALIZADO');

$tipo = array('AB' => 'ABIERTAS', 'SS' => 'SIMPLE SELECCION', 'MS' => 'MULTIPLE SELECCION');
$formaPago = array('CH'=>'CHEQUE','DE'=>'DEPOSITO','DO'=>'DOCUMENTO','EF'=>'EFECTIVO','SP'=>'SPEI','TR'=>'TRANSFERENCIA');
$padre = array('G' => 'GRUPO', 'S' => 'SECCION');
$estatus = array('A' => 'ACTIVO', 'C' => 'CANCELADO');
$tUsuario = array('AL' => 'Alumna', 'DO' => 'Docente', 'MA' => 'Mantenimiento', 'LI' => 'Limpieza', 'SI' => 'Sistemas','AD' => 'Administrativo');
$tipoEmpresa = array("EM"=>"Empresa","CL"=>"Cliente","PR"=>"Proveedor");
$tipoBanco = array("CA" => "Caja","IN" => "Inversiones","OP" => "Operacion");
$tipoTelefono = array("OF"=>"Oficina","CL"=>"Celular");
$tipoSucursal = array("SE"=>"Sucursal Empresa","SC"=>"Sucursal Cliente", "SP" => "Sucursal Proveedor");
$tiposValores = array("EN" => "Entero", "TX" => "Texto", "DC" => "Decimal");
$conceptoPago = array('AN'=>'Anticipo', 'LI'=>'Liquidacion', 'PA'=>'Pago');
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
/*
$modEncuesta = array(
	'host' => '192.168.1.69',
	'username' => 'dospesos_general',
	'password' => 'Sgeneral2016/+',
	'dbname' => 'dospesos_mod_encuesta',
);
*/
//============================================================================ CONSTANTES GENERALES
Zend_Registry::set('tipo', $tipo);
Zend_Registry::set('tUsuario', $tUsuario);
Zend_Registry::set('padre', $padre);
Zend_Registry::set('estatus', $estatus);
Zend_Registry::set('tipoEmpresa', $tipoEmpresa);
Zend_Registry::set('tipoTelefono', $tipoTelefono);
Zend_Registry::set('tipoSucursal', $tipoSucursal);
Zend_Registry::set('tipoBanco', $tipoBanco);
Zend_Registry::set('gradosEscolares', $gradosEscolares);
Zend_Registry::set('formaPago', $formaPago);
Zend_Registry::set('conceptoPago', $conceptoPago);
Zend_Registry::set('tiposValores', $tiposValores);
//Zend_Registry::set('dbconfigmodencuesta', $modEncuesta);

$application->bootstrap()
            ->run();
