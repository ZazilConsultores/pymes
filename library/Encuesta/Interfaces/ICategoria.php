<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
interface Encuesta_Interfaces_ICategoria{
	// =====================================================================================>>>   Buscar
	public function obtenerCategoriaId($idCategoria);
	public function obtenerOpciones($idCategoria);
	public function obtenerCategorias();
	// =====================================================================================>>>   Insertar
	public function crearCategoria(Zazil_Model_Categoria $categoria);
	// =====================================================================================>>>   Actualizar
	public function editarCategoria($idCategoria, Zazil_Model_Categoria $categoria);
	// =====================================================================================>>>   Eliminar
	public function eliminarCategoria($idCategoria);
}
