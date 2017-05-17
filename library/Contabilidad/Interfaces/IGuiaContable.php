<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Contabilidad_Interfaces_IGuiaContable{
		
	public function altaModulo($datos);
	public function altaTipoProvedor(array $tipoProveedor);
	public function obtenerModulo($idModulo);
	public function obtenerModulos();
	public function editarModulo();
	public function altaCuentaGuia(Contabilidad_Model_GuiaContable $cta, $subparametro);
	public function obtenerCuentasGuia();
	public function editarCuentaGuia();
	
}
