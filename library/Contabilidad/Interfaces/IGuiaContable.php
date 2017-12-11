<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Contabilidad_Interfaces_IGuiaContable{
		
	public function altaModulo($datos);
	public function altaTipoProvedor( $datos);
	public function obtenerModulo($idModulo);
	public function obtenerModulos();
	public function editarModulo($idModulo, $modulo);
	public function altaCuentaGuia(array $cta, $subparametro);
	public function obtenerCuentasGuia();
	public function obtieneCuentaGuia($idGuiaContable);
	public function actualizarGuiaContable($idGuiaContable, $datos);
}
