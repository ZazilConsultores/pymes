<?php

class Biblioteca_Model_Categoria
{

	private $idCategoria;
	
	public function getIdCategoria()
	{
		return $this->idCategoria;
	}
	
	public function setIdCategoria($idCategoria)
	{
		$this->idCategoria = $idCategoria;
	}
	
	private $materia;
	
	public function getMateria()
	{
		return $this->materia;
	}
	
	public function setMateria($materia)
	{
		$this->materia = $materia;
	}
	
	private $categoria;
	
	public function getCategoria()
	{
		return $this->categoria;
	}
	
	public function setCategoria($categoria)
	{
		$this->categoria = $categoria;
	}
	
	
	public function __construct($datos)
	{
	    if(array_key_exists("idCategoria", $datos)) $this->idCategoria = $datos["idCategoria"];
		$this->materia = $datos["materia"];
		$this->categoria = $datos["categoria"];
	}
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idCategoria"] = $this->idCategoria;
		$datos["materia"] = $this->materia;
		$datos["categoria"] = $this->categoria;
		
		
		return $datos;
	}
	
		
	

}

