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
	
	private $hash;

    public function getHash() {
    	if(is_null($this->hash)) $this->setHash(Util_Secure::generateKey($this->toArray()));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function __construct(array $datos) {
    	if(array_key_exists("idCategoria", $datos)) $this->idCategoria = $datos["idCategoria"];
    	$this->categoria = $datos["categoria"];
		$this->descripcion = $datos["descripcion"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
		
	}
	
	public function toArray() {
		$datos = array();
		
		$datos["idCategoria"] = $this->idCategoria;
		$datos["categoria"] = $this->categoria;
		$datos["descripcion"] = $this->descripcion;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

