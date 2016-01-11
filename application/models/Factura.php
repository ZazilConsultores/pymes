<?php
/**
 * @author Hector Giovanni Rodriguez Ramos
 * @copyright 2016, Zazil Consultores S.A. de C.V.
 * @version 1.0.0
 */
class Application_Model_Factura
{
	private $idFactura;

    public function getIdFactura() {
        return $this->idFactura;
    }
    
    public function setIdFactura($idFactura) {
        $this->idFactura = $idFactura;
    }

    private $idEmpresas;

    public function getIdEmpresas() {
        return $this->idEmpresas;
    }
    
    public function setIdEmpresas($idEmpresas) {
        $this->idEmpresas = $idEmpresas;
    }

    private $tipo;

    public function getTipo() {
        return $this->tipo;
    }
    
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    private $idEmpresa;

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }
    
    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    private $factura;

    public function getFactura() {
        return $this->factura;
    }
    
    public function setFactura($factura) {
        $this->factura = $factura;
    }

    private $fecha;

    public function getFecha() {
        return $this->fecha;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    private $subtotal;

    public function getSubtotal() {
        return $this->subtotal;
    }
    
    public function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

    private $total;

    public function getTotal() {
        return $this->total;
    }
    
    public function setTotal($total) {
        $this->total = $total;
    }

    public function __construct(array $datos)
    {
        $this->idEmpresas = $datos["idEmpresas"];
		$this->tipo = $datos["tipo"];
		$this->idEmpresa = $datos["idEmpresa"];
		$this->factura = $datos["factura"];
		$this->fecha = $datos["fecha"];
		$this->subtotal = $datos["subtotal"];
		$this->total = $datos["total"];
    } 
	
	public function toArray()
	{
		$datos = array();
		
		$datos["idFactura"] = $this->idFactura;
		$datos["idEmpresas"] = $this->idEmpresas;
		$datos["tipo"] = $this->tipo;
		$datos["idEmpresa"] = $this->idEmpresa;
		$datos["factura"] = $this->factura;
		$datos["fecha"] = $this->fecha;
		$datos["subtotal"] = $this->subtotal;
		$datos["total"] = $this->total;
		
		return $datos;
	}

}

