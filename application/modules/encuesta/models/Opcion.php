<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Opcion
{
	private $idOpcion;

    function getIdOpcion() {
        return $this->idOpcion;
    }
    
    function setIdOpcion($idOpcion) {
        $this->idOpcion = $idOpcion;
    }
	
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
    
	private $orden;

    function getOrden() {
        return $this->orden;
    }
    
    function setOrden($orden) {
        $this->orden = $orden;
    }
	
    function __construct(array $datos) {
    	$this->setIdCategoria($datos["idCategoria"]);
		$this->setNombre($datos["nombre"]);
		if(array_key_exists("idOpcion", $datos)){
			$this->setIdOpcion($datos["idCategoria"]);
		}else{
			$this->setIdOpcion(hash("adler32", $datos["idCategoria"] . $datos["nombre"]));
		}
		
		if(array_key_exists("orden", $datos)) $this->setOrden($datos["orden"]);
		
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["idOpcion"] = $this->getIdOpcion();
		$datos["idCategoria"] = $this->getIdCategoria();
		$datos["nombre"] = $this->getNombre();
		$datos["orden"] = $this->getOrden();
		
		return $datos;
	}
}

