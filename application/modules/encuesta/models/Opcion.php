<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Opcion
{
	private $idOpcion;

    public function getIdOpcion() {
        return $this->idOpcion;
    }
    
    public function setIdOpcion($idOpcion) {
        $this->idOpcion = $idOpcion;
    }

    private $idCategoria;

    public function getIdCategoria() {
        return $this->idCategoria;
    }
    
    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    private $opcion;

    public function getOpcion() {
        return $this->opcion;
    }
    
    public function setOpcion($opcion) {
        $this->opcion = $opcion;
    }

    private $orden;

    public function getOrden() {
        return $this->orden;
    }
    
    public function setOrden($orden) {
        $this->orden = $orden;
    }

    public function __construct(array $datos) {
    	
		//$this->idOpcion = $datos["idOpcion"];
		//$this->idCategoria = $datos["idCategoria"];
		$this->opcion = $datos["opcion"];
		$this->orden = $datos["orden"];
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["idOpcion"] = $this->idOpcion;
		$datos["idCategoria"] = $this->idCategoria;
		$datos["opcion"] = $this->opcion;
		$datos["orden"] = $this->orden;
		
		return $datos;
	}
}

