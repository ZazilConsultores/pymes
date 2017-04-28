<?php
/**
 * @author Areli Morales Palma
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Contabilidad_Interfaces_IGuiaContable{
		
	public function altaModulo( Contabilidad_Model_Modelo $modulo);
	public function obtenerModulo($idModulo);
	public function odtenerModulos();
	public function editarModulo();
	public function altaCuentaGuia();
	public function obtenerCuentasGuia();
	public function editarCuentaGuia();
	

	
}
