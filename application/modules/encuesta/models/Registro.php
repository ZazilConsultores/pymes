<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Encuesta_Model_Registro
{
	private $idRegistro;

    public function getIdRegistro() {
        return $this->idRegistro;
    }
    
    public function setIdRegistro($idRegistro) {
        $this->idRegistro = $idRegistro;
    }

    private $referencia;

    public function getReferencia() {
        return $this->referencia;
    }
    
    public function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

    private $tipo;

    public function getTipo() {
        return $this->tipo;
    }
    
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    private $nombres;

    public function getNombres() {
        return $this->nombres;
    }
    
    public function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    private $apellidos;

    public function getApellidos() {
        return $this->apellidos;
    }
    
    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }
	
	private $hash;

    public function getHash() {
    	if(is_null($this->hash)) $this->setHash(Util_Secure::generateKey($this->toArray()));
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function __construct(array $datos)
    {
    	if(array_key_exists("idRegistro", $datos)) $this->idRegistro = $datos["idRegistro"];
		$this->referencia = $datos["referencia"];
		$this->tipo = $datos["tipo"];
		$this->fecha = $datos["fecha"];
		$this->nombres = $datos["nombres"];
		$this->apellidos = $datos["apellidos"];
		if(array_key_exists("hash", $datos)) $this->hash = $datos["hash"];
    }
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idRegistro"] = $this->idRegistro;
		$datos["referencia"] = $this->referencia;
		$datos["tipo"] = $this->tipo;
		$datos["fecha"] = $this->fecha;
		$datos["nombres"] = $this->nombres;
		$datos["apellidos"] = $this->apellidos;
		$datos["hash"] = $this->hash;
		
		return $datos;
	}
}

