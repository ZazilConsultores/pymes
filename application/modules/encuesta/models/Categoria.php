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
	
	private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function __construct(array $datos) {
    	if(array_key_exists("idCategoria", $datos)) $this->idCategoria = $datos["idCategoria"];
    	$this->categoria = $datos["categoria"];
		$this->descripcion = $datos["descripcion"];
		if(array_key_exists("fecha", $datos)) $this->fecha = $datos["fecha"];
		
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["idCategoria"] = $this->idCategoria;
		$datos["categoria"] = $this->categoria;
		$datos["descripcion"] = $this->descripcion;
		$datos["fecha"] = $this->fecha;
		
		return $datos;
	}
}

