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
	
	private $nombre;

    function getNombre() {
        return $this->nombre;
    }
    
    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
	
	private $descripcion;

    function getDescripcion() {
        return $this->descripcion;
    }
    
    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    function __construct(array $datos) {
		$this->setNombre($datos["nombre"]);
		$this->setDescripcion($datos["descripcion"]);
		if(array_key_exists("idCategoria", $datos)){
			$this->setIdCategoria($datos["idCategoria"]);
		}else{
			$this->setIdCategoria(hash("adler32", $datos["nombre"]));
		}
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["idCategoria"] = $this->getIdCategoria();
		$datos["nombre"] = $this->getNombre();
		$datos["descripcion"] = $this->getDescripcion();
		
		return $datos;
	}
}

