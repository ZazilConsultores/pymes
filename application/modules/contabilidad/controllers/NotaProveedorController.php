<?php
mysql_connect("localhost","zazil","admin");
mysql_select_db("General");

class Contabilidad_NotaproveedorController extends Zend_Controller_Action
{
	
	private $db;

    public function init()
    {
        /* Initialize action controller here */
        $this->notaEntradaDAO = new Contabilidad_DAO_NotaEntrada;
		$this->db = Zend_Db_Table::getDefaultAdapter();
    }

    public function indexAction()
    {
        // action body
        //$formulario = new Contabilidad_Form_NuevaNotaProveedor;
		//$this->view->formulario = $formulario;
		$request = $this->getRequest();
        $formulario = new Contabilidad_Form_NuevaNotaProveedor;
		if($request->isGet()){
			$this->view->formulario = $formulario;
		}elseif($request->isPost()){
			if($formulario->isValid($request->getPost())){
				$datos = $formulario->getValues();
				
				$notaentrada = new Contabilidad_Model_Movimientos($datos);
				$this->notaEntradaDAO->crearNotaEntrada($datos);
				print_r($datos);
				
			}
		}
    }

    public function nuevaAction()
    {
    	$request = $this->getRequest();
		/*
		
		if($request->isGet()){
			
		}elseif($request->isPost()){
			$consultaBusqueda = $_POST['valorBusqueda'];
			//$consultaBusqueda = ($request->isPost('valorBusqueda'));	
			//Variable vacía
			$mensaje = "";

			$consulta = "Select producto from producto WHERE claveProducto LIKE '%$consultaBusqueda%'";
			print_r($consulta);
			while($row=mysql_fetch_array($consulta)){
			$producto=$row['producto'];
			print_r($producto);
			}
		}
		*/
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

}



