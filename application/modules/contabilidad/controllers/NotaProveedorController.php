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
				$notaEntradaDAO = new Contabilidad_DAO_NotaEntrada;
				$datos = $formulario->getValues();
				$encabezado = $datos[0];
				$productos = json_decode($encabezado['productos'],TRUE);
				/*print_r($encabezado);
				print_r('<br />');
				print_r('<br />');
				print_r($productos);*/
				$contador=0;
				foreach ($productos as $producto){
					//$producto->encabezado();
					//sprint_r($producto);
					$notaEntradaDAO->agregarProducto($encabezado, $producto);
					//print_r($contador);
					//print_r('<br />');
					$contador++;
					
				}
				//	
				//print_r($datos);
				//
				//print_r('<br />');
				//print_r($productos);
				//print_r(json_decode($datos[0]['productos']));
				//$notaentrada = new Contabilidad_Model_Movimientos($datos);
				//$this->notaEntradaDAO->crearNotaEntrada($datos);
			}
					
			//$this->_helper->redirector->gotoSimple("nueva", "notaproveedor", "contabilidad");
		}
		
		
	}
	

}



