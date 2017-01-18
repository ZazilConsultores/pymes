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
	
	private $idColeccion;
	
	public function getIdColeccion(){
		return $this->idColeccion;
	}
	
	public function setIdColeccion($idColeccion){
		$this->idColeccion = $idColeccion;
	}
	
	private $idMaterial;
	
	public function getIdMaterial(){
		return $this->idMaterial;
	}
	
	public function setIdMaterial($idMaterial){
		$this->idMaterial = $idMaterial;
	}
	
	private $issn;
	
	public function getIssn(){
		return $this->issn;
		
	}
	
	public function setIssn($issn)
	{
		$this->issn = $issn;
	}
	
	private $noClasif;
	
	public function getNoClasif()
	{
		return $this->noClasif;
	}
	
	public function setNoClasif($noClasif)
	{
		$this->noClasif = $noClasif;
	}
	
	
	private $noItem;
	
	public function getNoItem()
	{
		return $this->noItem;
	}
	
	public function getNoItem($noItem)
	{
		$this->noItem = $noItem;
	}
	
	private $noEdicion;
	
	public function getNoEdicion()
	{
		return $this->noEdicion;
	}
	
	public function setNoEdicion($noEdicion)
	{
		$this->noEdicion = $noEdicion;
	}
	
	
	private $idPaisPub;
	
	public function getIdPaisPub()
	{
		return $this->idPaisPub;
	}
	
	public function setIdPaisPub($idPaisPub)
	{
		$this->idPaisPub = $idPaisPub;
	}
	
	private $dimension;
	
	public function getDimension()
	{
		return $this->dimension;
	}
	
	public function setDimension($dimension)
	{
		$this->dimension = $dimension;
	}
	
	private $idClasificacion;
	
	public function getIdClasificacion()
	{
		return $this->idClasificacion;
	}
	
	public function setIdClasificacion($idClasificacion)
	{
		$this->idClasificacion = $idClasificacion;
	}
	
	private $serie;
	
	public function getSerie()
	{
		return $this->serie;
	}
	
	public function setSerie($serie)
	{
		$this->serie = $serie;
	}
	
	private $asienPrin;
	
	public function getAsienPrin()
	{
		return $this->asienPrin;
	}
	
	public function setAsienPrin($asienPrin)
	{
		$this->asienPrin = $asienPrin;
	}
	
	private $volumen;
	
	public function getVolumen()
	{
		return $this->volumen;
	}
	
	public function setVolumen($volumen)
	{
		$this->volumen = $volumen;
	}
	
	private $eti008;
	
	public function getEti008()
	{
		return $this->eti008;
	}
	
	public function setEti008($eti008)
	{
		$this->eti008 = $eti008;
	}
	
	private $etiLDR;
	
	public function getEtiLDR()
	{
		return $this->etiLDR;
	}
	
	public function setEtiLDR($etiLDR)
	{
		$this->etiLDR = $etiLDR;
	}
	
	
	private $etiqueta;
	
	public function getEtiqueta()
	{
		return $this->etiqueta;
	}
	
	public function setEtiqueta($etiqueta)
	{
		$this->etiqueta = $etiqueta;
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
		$this->idColeccion = $datos["idColeccion"];
		$this->idMaterial = $datos["idMaterial"];
		$this->issn = $datos["issn"];
		$this->noClasif = $datos["noClasif"];
		$this->noItem = $datos["noItem"];
		$this->noEdicion = $datos["noEdicion"];
		$this->idPaisPub = $datos["idPaisPub"];
		$this->dimension = $datos["dimension"];
		$this->idClasificacion = $datos["idClasificacion"];
		$this->serie = $datos["serie"];
		$this->asienPrin = $datos["asienPrin"];
		$this->volumen = $datos["volumen"];
		$this->eti008 = $datos["eti008"];
		$this->etiLDR = $datos["etiLDR"];
		$this->etiqueta = $datos["etiqueta"];
		
		
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
		$datos["idColeccion"]  = $this->idColeccion;
		$datos["idMaterial"] = $this->idMaterial;
		$datos["issn"] = $this->issn;
		$datos["noClasif"] = $this->noClasif;
		$datos["noItem"] = $this->noItem;
		$datos["noEdicion"] = $this->noEdicion;
		$datos["idPaisPub"] = $this->idPaisPub;
		$datos["dimension"] = $this->dimension;
		$datos["idClasificacion"]= $this->idClasificacion;
		$datos["serie"] = $this->serie;
		$datos["asienPrin"] = $this->asienPrin;
		$datos["volumen"] = $this->volumen;
		$datos["eti008"] = $this->eti008;
		$datos["etiLDR"] = $this->etiLDR;
		$datos["etiqueta"] = $this->etiqueta;
		
		
		return $datos;
	}

}

