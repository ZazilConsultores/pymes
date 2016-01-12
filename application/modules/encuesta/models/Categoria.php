<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Categoria
{
	private $idCategoria;

    function getIdCategoria() {
        return $this->idCategoria;
    }
    
    function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }
	
	private $categoria;

    public function getCategoria() {
        return $this->categoria;
    }
    
    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

	private $descripcion;

    function getDescripcion() {
        return $this->descripcion;
    }
    
    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    function __construct(array $datos) {
    	//$this->idCategoria = $datos["idCategoria"];
    	$this->categoria = $datos["categoria"];
		$this->descripcion = $datos["descripcion"];
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["idCategoria"] = $this->getIdCategoria();
		$datos["categoria"] = $this->getCategoria();
		$datos["descripcion"] = $this->getDescripcion();
		
		return $datos;
	}
}

