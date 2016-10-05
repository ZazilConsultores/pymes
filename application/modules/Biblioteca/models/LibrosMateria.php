<?php

class Biblioteca_Model_LibrosMateria
{
	
	private $idLibrosMateria;
	
	public function getIdLibrosMateria(){
		return $this->idLibrosMateria;
	}
	
	public function setIdLibrosMateria($idLibrosMateria){
		$this->idLibrosMateria = $idLibrosMateria;
	}
	
	private $idMateria;
	
	public function getIdMateria(){
		return $this->idMateria;
	}
	
	public function setIdMateria($idMateria){
		$this->idMateria = $idMateria;
	}
	
	private $idsLibro;
	
	public function getIdsLibro(){
		return $this->idsLibro;
	}
		
	public function setIdsLibro($idsLibro){
		$this->idsLibro = $idsLibro;
	
	}
	
	
	public function __construct($datos){
		/*if(array_key_exists("idLibrosMateria", $datos)) $this->idLibrosMateria = $datos["idLibrosMateria"];
		$this->idMateria = $datos["idMateria"];
		$this->idsLibro = $datos["idsLibro"];*/
		if(array_key_exists("idLibrosMateria", $datos)) $this->idLibrosMateria= $datos["idLibrosMateria"];
		$this->idMateria = $datos["idMateria"];
		$this->idsLibro = $datos["idsLibro"];
	}
	
	
	public function toArray() {
		$datos = array();
		
		$datos["idLibrosMateria"] = $this->idLibrosMateria;
		$datos["idMateria"] = $this->idMateria;
		$datos["idsLibro"] = $this->idsLibro;
		
		return $datos;
	}

}

