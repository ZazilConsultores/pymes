<?php

require_once 'Zend/Registry.php';

/**
 * 
 */
class MainConfig {
	/**
	 * Aqui toda la configuracion de la aplicacion
	 */
	function __construct() {
		setlocale(LC_ALL, 'es_MX.UTF-8');
		date_default_timezone_set('America/Mexico_City');
		
		$tipo = array('AB' => 'ABIERTAS', 'SS' => 'SIMPLE SELECCION', 'MS' => 'MULTIPLE SELECCION');
		Zend_Registry::set('tipo', $tipo);
		$tipoInventario = array('1'=>'PEPS');
		Zend_Registry::set('tipoInventario',$tipoInventario);
		$formaPago = array('CH'=>'CHEQUE','DE'=>'DEPOSITO','EF'=>'EFECTIVO','SP'=>'SPEI', 'DO'=>'DOCUMENTO');
		Zend_Registry::set('formaPago', $formaPago);
		$conceptoPago = array('AN'=>'ANTICIPO','LI'=>'LIQUIDACION','PA'=>'PAGO','PE'=>'PENDIENTE DE PAGO');
		Zend_Registry::set('conceptoPago', $conceptoPago);
		$padre = array('G' => 'GRUPO', 'S' => 'SECCION');
		Zend_Registry::set('padre', $padre);
		$estatus = array('A' => 'ACTIVO', 'C' => 'CANCELADO');
		Zend_Registry::set('estatus', $estatus);
		$tUsuario = array('AL' => 'Alumna', 'DO' => 'Docente', 'MA' => 'Mantenimiento', 'LI' => 'Limpieza', 'SI' => 'Sistemas','AD' => 'Administrativo');
		Zend_Registry::set('tUsuario', $tUsuario);
		$tipoEmpresa = array("EM"=>"Empresa","CL"=>"Cliente","PR"=>"Proveedor");
		Zend_Registry::set('tipoEmpresa', $tipoEmpresa);
		$tipoBanco = array("CA" => "Caja","IN" => "Inversiones","OP" => "Operacion");
		Zend_Registry::set('tipoBanco', $tipoBanco);
		$tipoTelefono = array("OF"=>"Oficina","CL"=>"Celular");
		Zend_Registry::set('tipoTelefono', $tipoTelefono);
		$tipoSucursal = array("SE"=>"Sucursal Empresa","SC"=>"Sucursal Cliente", "SP" => "Sucursal Proveedor");
		Zend_Registry::set('tipoSucursal', $tipoSucursal);
		//$tipoEmail = array("OF"=>"Oficina","CS"=>"Casa","PR"=>"Proveedor");
		$tipoMantenimiento = array("MH"=>"Mantenimiento Hardware","MS"=>"Mantenimiento Software","AV"=>"Antivirus","RO"=>"Registro Observaciones");
		
		$gradosEscolares = array(1=>"1°",2=>"2°",3=>"3°",4=>"4°",5=>"5°",6=>"6°",7=>"7°",8=>"8°",9=>"9°");
		Zend_Registry::set('gradosEscolares', $gradosEscolares);
		
		$subCuenta = array('banco' => '2', 'cliente' => '2', 'proveedor' => '2', 'producto' => '2' );
		Zend_Registry::set('subCuenta', $subCuenta);
		
		$mascara = array('cta' => '4', 'sub1' => '3', 'sub2' => '3', 'sub3' => '0', 'sub4' => '0', 'sub5' => '0' );
		Zend_Registry::set('mascara', $mascara);
		
		$origen = array('S' => 'Subtotal', 'I' => 'Iva', 'T' => 'Total');
		Zend_Registry::set('origen', $origen);
	}
}
