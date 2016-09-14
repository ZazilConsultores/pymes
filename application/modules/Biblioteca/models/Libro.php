<?php

class Biblioteca_Model_Libro
{
	private $idLibro;

    public function getIdLibro() {
        return $this->idLibro;
    }
    
    public function setIdLibro($idLibro) {
        $this->idLibro = $idLibro;
    }

    
	private $titulo;

    public function getTitulo() {
        return $this->titulo;
    }
    
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    
	private $autor;

    public function getAutor() {
        return $this->autor;
    }
    
    public function setAutor($autor) {
        $this->autor = $autor;
    }

    
	private $editorial;

    public function getEditorial() {
        return $this->editorial;
    }
    
    public function setEditorial($editorial) {
        $this->editorial = $editorial;
    }

    
	private $publicado;

    public function getPublicado() {
        return $this->publicado;
    }
    
    public function setPublicado($publicado) {
        $this->publicado = $publicado;
    }

    
	private $paginas;

    public function getPaginas() {
        return $this->paginas;
    }
    
    public function setPaginas($paginas) {
        $this->paginas = $paginas;
    }

    
	private $isbn;

    public function getIsbn() {
        return $this->isbn;
    }
    
    public function setIsbn($isbn) {
        $this->isbn = $isbn;
    }

    
	private $codigoBarras;

    public function getCodigoBarras() {
        return $this->codigoBarras;
    }
    
    public function setCodigoBarras($codigoBarras) {
        $this->codigoBarras = $codigoBarras;
    }
	
	public function __construct($datos) {
		if(array_key_exists("idLibro", $datos)) $this->idLibro = $datos["idLibro"];
		$this->titulo = $datos["titulo"];
		$this->autor = $datos["autor"];
		$this->editorial = $datos["editorial"];
		$this->publicado = $datos["publicado"];
		$this->paginas = $datos["paginas"];
		$this->isbn = $datos["isbn"];
		$this->codigoBarras = $datos["codigoBarras"];
		
	}
    
	public function toArray() {
		$datos = array();
		
		$datos["idLibro"] = $this->idLibro;
		$datos["titulo"] = $this->titulo;
		$datos["autor"] = $this->autor;
		$datos["editorial"] = $this->editorial;
		$datos["publicado"] = $this->publicado;
		$datos["paginas"] = $this->paginas;
		$datos["isbn"] = $this->isbn;
		$datos["codigoBarras"] = $this->codigoBarras;
		
		
		return $datos;
	}

}

