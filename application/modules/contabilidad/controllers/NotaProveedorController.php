<?php


class Contabilidad_NotaproveedorController extends Zend_Controller_Action
{
	
	private $db;
	private $movimientosDAO;
	private $capasDAO;
	private $inventarioDAO;
	

    public function init()
    {
    	$this->notaEntradaDAO = new Contabilidad_DAO_NotaEntrada;
		 
        /* Initialize action controller here */
		$this->db = Zend_Db_Table::getDefaultAdapter();
			// =================================================== >>> Obtenemos todos los productos de la tabla producto
		$select = $this->db->select()->from("Producto");
		$statement = $select->query();
		$rowsProducto =  $statement->fetchAll();
		
		$select = $this->db->select()->from("Unidad");
		$statement = $select->query();
		$rowsUnidad =  $statement->fetchAll();
		// =================================== Codificamos los valores a formato JSON
		$jsonProductos = Zend_Json::encode($rowsProducto);
		$this->view->jsonProductos = $jsonProductos;
		$jsonUnidad = Zend_Json::encode($rowsUnidad);
		$this->view->jsonUnidad = $jsonUnidad;
    }

    public function indexAction()
    {
    	
    }

    public function nuevaAction()
    {
		$request = $this->getRequest();
        $formulario = new Contabilidad_Form_NuevaNotaProveedor;
		if($request->isGet()){
			$this->view->formulario = $formulario;
			
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				print_r($datos);
				$notaentrada = new Contabilidad_Model_Movimientos($datos);
				$this->notaEntradaDAO->crearNotaEntrada($datos);
			}
					
			
		}
		
		
	}
	

}



