<?php
   interface Sistema_Interface_IVendedores{
   	
	//public function obtenerVendedores();
	//public function obtenerVendedores($idVendedor);
	public function altaVendedor(array $datos);
	//public function editarImpuesto($idVendedor, array $datos);
	//public function generaComision();
	public function generarClaveVendedor(array $claves);
  
   }
?>