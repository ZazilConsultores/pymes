<?php
/**
 * 
 */
class Encuesta_Util_Reporter {
	
	private $tablaRegistro;
	
	private $tablaEncuesta;
	private $tablaSeccion;
	private $tablaGrupo;
	private $tablaPregunta;
	
	private $tablaRespuesta;
	private $tablaPreferenciaS;
	private $tablaOpcion;
	
	private $tablaPlanE;
	private $tablaCicloE;
	private $tablaNivelE;
	private $tablaGradoE;
	
	private $tablaMateriaE;
	private $tablaGrupoE;
	private $tablaAsignacionG;
	
	private $tablaERealizadas;
	private $reporteDAO;
	
	public function __construct() {
		
		$this->tablaRegistro = new Encuesta_Model_DbTable_Registro;
		
		$this->tablaEncuesta = new Encuesta_Model_DbTable_Encuesta;
		$this->tablaSeccion = new Encuesta_Model_DbTable_Seccion;
		$this->tablaGrupo = new Encuesta_Model_DbTable_Grupo;
		$this->tablaPregunta = new Encuesta_Model_DbTable_Pregunta;
		
		$this->tablaRespuesta = new Encuesta_Model_DbTable_Respuesta;
		$this->tablaPreferenciaS = new Encuesta_Model_DbTable_PreferenciaSimple;
		$this->tablaOpcion = new Encuesta_Model_DbTable_Opcion;
		
		$this->tablaPlanE = new Encuesta_Model_DbTable_PlanE;
		$this->tablaCicloE = new Encuesta_Model_DbTable_CicloE;
		$this->tablaNivelE = new Encuesta_Model_DbTable_NivelE;
		$this->tablaGradoE = new Encuesta_Model_DbTable_GradoE;
		
		$this->tablaMateriaE = new Encuesta_Model_DbTable_MateriaE;
		$this->tablaGrupoE = new Encuesta_Model_DbTable_GrupoE;
		$this->tablaAsignacionG = new Encuesta_Model_DbTable_AsignacionGrupo;
		
		$this->tablaERealizadas = new Encuesta_Model_DbTable_ERealizadas;
		$this->reporteDAO = new Encuesta_DAO_Reporte;
	}
	/**
	 * Genera un reporte de evaluacion de las preguntas de simple seleccion
	 */
	public function generarReporteGrupalEvaluacionAsignacion($idEncuesta, $idAsignacion)
	{
		// ========================================================== >>> Obtenemos los objetos estaticos basicos
		$select = $this->tablaEncuesta->select()->from($this->tablaEncuesta)->where("idEncuesta=?",$idEncuesta);
		$rowEncuesta = $this->tablaEncuesta->fetchRow($select);
		
		$select = $this->tablaAsignacionG->select()->from($this->tablaAsignacionG)->where("idAsignacion=?",$idAsignacion);
		$rowAsignacion = $this->tablaAsignacionG->fetchRow($select);
		
		$select = $this->tablaGrupoE->select()->from($this->tablaGrupoE)->where("idGrupo=?",$rowAsignacion->idGrupo);
		$rowGrupoE = $this->tablaGrupoE->fetchRow($select);
		
		$select = $this->tablaMateriaE->select()->from($this->tablaMateriaE)->where("idMateria=?",$rowAsignacion->idMateria);
		$rowMateriaE = $this->tablaMateriaE->fetchRow($select);
		
		$select = $this->tablaRegistro->select()->from($this->tablaRegistro)->where("idRegistro=?",$rowAsignacion->idRegistro);
		$rowDocente = $this->tablaRegistro->fetchRow($select);
		
		//$nombreArchivo = $rowGrupoE->grupo."-".str_replace(' ', '', $rowMateriaE->materia)."-".mb_strlen(str_replace(' ', '', $rowEncuesta->nombre)).".pdf";
		$nombreArchivo = $rowGrupoE->grupo."-".$idAsignacion."-".$idEncuesta."-RGP.pdf";
		
		//print_r("Cargando plantilla");
		//print_r("<br />");
		// ========================================================== >>> Generamos el reporte a partir de plantilla
		$pdfTemplate = My_Pdf_Document::load(PDF_PATH . '/reports/bases/reporteBaseEncuestas.pdf');
		$pages = $pdfTemplate->pages;
		$pdfReport = new My_Pdf_Document($nombreArchivo, PDF_PATH . '/reports/encuesta/grupal/');
		$pdfReport->setYHeaderOffset(160);
		// Clonamos 
		$pageZ = clone $pages[0];
		$page = new My_Pdf_Page($pageZ);
		$font = Zend_Pdf_Font::fontWithPath(PDF_PATH . "/fonts/microsoft/GOTHIC.TTF");
		$page->setFont($font, 10);
		
		//print_r("Generando contenido :: Header");
		//print_r("<br />");
		// ========================================================== >>> Generamos header del reporte.
		$tableHeader = new My_Pdf_Table(2);
		$rowTable1 = new My_Pdf_Table_Row;
		$rowTable2 = new My_Pdf_Table_Row;
		$rowTable3 = new My_Pdf_Table_Row;
		$rowTable4 = new My_Pdf_Table_Row;
		//$rowTable1 = new My_Pdf_Table_Row;
		
		$colthA1 = new My_Pdf_Table_Column;
		$colthA2 = new My_Pdf_Table_Column;
		$colthB1 = new My_Pdf_Table_Column;
		$colthB2 = new My_Pdf_Table_Column;
		$colthC1 = new My_Pdf_Table_Column;
		$colthC2 = new My_Pdf_Table_Column;
		$colthD1 = new My_Pdf_Table_Column;
		$colthD2 = new My_Pdf_Table_Column;
		
		$colthA1->setText("Evaluacion: ");
		$colthA1->setWidth(60);
		$colthA2->setText($rowEncuesta->nombre);
		$colthB1->setText("Docente: ");
		$colthB1->setWidth(60);
		$colthB2->setText($rowDocente->apellidos.", ".$rowDocente->nombres);
		$colthC1->setText("Materia: ");
		$colthC1->setWidth(60);
		$colthC2->setText($rowMateriaE->materia);
		$colthD1->setText("Grupo: ");
		$colthD1->setWidth(60);
		$colthD2->setText($rowGrupoE->grupo);
		
		$rowTable1->setColumns(array($colthA1,$colthA2));
		$rowTable1->setCellPaddings(array(5,5,5,5));
		$rowTable1->setFont($font,10);
		$rowTable2->setColumns(array($colthB1,$colthB2));
		$rowTable2->setCellPaddings(array(5,5,5,5));
		$rowTable2->setFont($font,10);
		$rowTable3->setColumns(array($colthC1,$colthC2));
		$rowTable3->setCellPaddings(array(5,5,5,5));
		$rowTable3->setFont($font,10);
		$rowTable4->setColumns(array($colthD1,$colthD2));
		$rowTable4->setCellPaddings(array(5,5,5,5));
		$rowTable4->setFont($font,10);
		
		$tableHeader->addRow($rowTable1);
		$tableHeader->addRow($rowTable2);
		$tableHeader->addRow($rowTable3);
		$tableHeader->addRow($rowTable4);
		
		$page->addTable($tableHeader, 98, 120);
		
		//print_r("Generando contenido :: Cuerpo");
		//print_r("<br />");
		// ========================================================== >>> Generamos el cuerpo del reporte
		$tablaContenidoR = new My_Pdf_Table(2);
		$promedioFinal = 0;
		$sumaFinal = 0;
		$numCategorias = 0;
		$tablaSeccion = $this->tablaSeccion;
		$tablaGrupo = $this->tablaGrupo;
		$tablaPregunta = $this->tablaPregunta;
		$tablaRespuesta = $this->tablaRespuesta;
		$tablaOpcion = $this->tablaOpcion;
		$tablaPreferenciaS = $this->tablaPreferenciaS;
		
		//$select = $tablaSeccion->select()->from($tablaSeccion)->where("idEncuesta=?",$rowEncuesta->idEncuesta);
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idEncuesta=?",$idEncuesta);
		
		$rowsSecciones = $tablaSeccion->fetchAll($select);
		//$grupos = array();
		//$tablaGrupo = $this->tablaGrupo;
		//$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo=?",)
		
		foreach ($rowsSecciones as $rowSeccion) {
			
			//print_r("PASO1:HeaderSeccion Agregado");
			//print_r("<br />");
			$select = $tablaGrupo->select()->from($tablaGrupo)->where("idSeccion=?", $rowSeccion->idSeccion);
			$rowsGrupos = $tablaGrupo->fetchAll($select);
			// Iteramos sobre 
			foreach ($rowsGrupos as $rowGrupo) {
				
				// Procesamos la encuesta solo si es de tipo SS
				if($rowGrupo->tipo == "SS") {
					$numCategorias++;
					//Puntajes maximos obtenidos
					$puntajeMaximo = 0;
					$puntajeObtenido = 0;
					$calificacionCategoria = 0;
					$arrayIdsOpciones = array();
					
					$rowContent = new My_Pdf_Table_Row;
					$colrc1 = new My_Pdf_Table_Column;
					$colrc1->setText($rowGrupo->nombre);
					$colrc2 = new My_Pdf_Table_Column;
					$colrc2->setText("");
					$rowContent->setColumns(array($colrc1,$colrc2));
					$rowContent->setFont($font);
					$rowContent->setCellPaddings(array(5,5,5,5));
					$tablaContenidoR->addRow($rowContent);
					
					$arrayIdsOpciones = explode(",", $rowGrupo->opciones);
					
					//print_r($arrayIdsOpciones);
					//print_r("<br />");
					$select = $tablaOpcion->select()->from($tablaOpcion)->where("idOpcion IN (?)",$arrayIdsOpciones)->order(array("vreal"));
					//print_r($select->__toString());
					//print_r("<br />");
					// ----
					$rowsOpciones = $tablaOpcion->fetchAll($select);
					$arrOpciones = $rowsOpciones->toArray();
					$mayorOpcion = end($arrOpciones);
					//print_r($rowsOpciones->toArray());
					//print_r($mayorOpcion);
					//print_r("<br />");
					$select = $tablaPregunta->select()->from($tablaPregunta)->where("origen=?","G")->where("idOrigen=?",$rowGrupo->idGrupo);
					$rowsPreguntasG = $tablaPregunta->fetchAll($select);
					$idsPreguntas = array();
					
					foreach ($rowsPreguntasG as $rowPreguntaG) {
						// 
						$select = $tablaRespuesta->select()->from($tablaRespuesta)->where("idEncuesta=?",$idEncuesta)->where("idAsignacion=?",$idAsignacion)->where("idPregunta=?",$rowPreguntaG->idPregunta);
						//print_r($select->__toString());
						$rowsRespuesta = $tablaRespuesta->fetchAll($select);
						
						foreach ($rowsRespuesta as $rowRespuesta) {
							foreach ($rowsOpciones as $rowOpcion) {
								if($rowOpcion->idOpcion == $rowRespuesta->respuesta){
									$puntajeObtenido += $rowOpcion->vreal;
									$puntajeMaximo += $mayorOpcion["vreal"];
								}
							}
						}
						
						$idsPreguntas[] = $rowPreguntaG->idPregunta;
						$select = $tablaPreferenciaS->select()->from($tablaPreferenciaS)->where("idPregunta IN (?)",$idsPreguntas);
						$preferenciasPregunta = $tablaPreferenciaS->fetchAll($select);
						$totalPregunta = 0;
						foreach ($preferenciasPregunta as $preferencia) {
							$totalPregunta += $preferencia->total;
						}
					}
					$calificacionCategoria = (10 * $puntajeObtenido) / $puntajeMaximo;
					//print_r("<strong>Puntaje Obtenido: ".sprintf('%.2f', $puntajeObtenido)."</strong><br />");
					//print_r("<strong>Puntaje Maximo: ".sprintf('%.2f', $puntajeMaximo)."</strong><br />");
					//print_r("<strong>Calificación: ".sprintf('%.2f', $calificacionCategoria)."</strong><br />");
					
					$rowContent2 = new My_Pdf_Table_Row;
					$colrc21 = new My_Pdf_Table_Column;
					$colrc21->setText("Puntaje Máximo: " .sprintf('%.2f', $puntajeMaximo));
					$colrc22 = new My_Pdf_Table_Column;
					$colrc22->setText("Puntaje Obtenido: " .sprintf('%.2f', $puntajeObtenido));
					$rowContent2->setColumns(array($colrc21,$colrc22));
					
					$rowContent3 = new My_Pdf_Table_Row;
					$colrc31 = new My_Pdf_Table_Column;
					$colrc31->setText("");
					$colrc32 = new My_Pdf_Table_Column;
					$colrc32->setText("Calificación: " .sprintf('%.2f', $calificacionCategoria));
					$rowContent3->setColumns(array($colrc31,$colrc32));
					
					$rowContent2->setFont($font);
					$rowContent2->setCellPaddings(array(5,5,5,5));
					$rowContent3->setFont($font);
					$rowContent3->setCellPaddings(array(5,5,5,5));
					
					$tablaContenidoR->addRow($rowContent2);
					$tablaContenidoR->addRow($rowContent3);
					//$tableContent->addRow($rowContent2);
					//$tableContent->addRow($rowContent3);
					$sumaFinal += $calificacionCategoria;
				}// fin de if($rowGrupo == "SS")
				
			}// fin de foreach $rowsGrupos
			
		}// fin de foreach $rowsSecciones
		$promedioFinal = $sumaFinal / $numCategorias;
		//print_r("Contenido creado, agregando...");
		//print_r("<br />");
		$resultado = "";
		if($promedioFinal >= 8.5){
			$resultado = "EXCELENTE";
		}elseif($promedioFinal > 7.0){
			$resultado = "ADECUADO";
		}elseif($promedioFinal > 5.0){
			$resultado = "INSUFICIENTE";
		}elseif($promedioFinal > 4.0){

			$resultado = "DEFICIENTE";
		}
		$page->drawText("PROMEDIO: ".sprintf('%.2f', $promedioFinal) . " - " . $resultado, 215, 215);
		$page->addTable($tablaContenidoR, 55, 215);
		//$page->addTable($tableContent, 30, 150);
		//print_r("Contenido Agregado, guardando...");
		//print_r("<br />");
		
		// ========================================================== >>> Guardamos el reporte
		$pdfReport->addPage($page);
		//$pdfReport->save();
		$pdfReport->saveDocument();
		//$pdfReport->save($nombreArchivo,false);
		//print_r("Archivo guardado");
		//print_r("<br />");
		$idReporte = $this->reporteDAO->agregarReporteGrupal($nombreArchivo, $idEncuesta, $idAsignacion);
		return $idReporte;
	}
	/**
	 * Genera Reporte General del Docente para una Encuesta Identificada.
	 * Este Reporte no hace diferencia entre materias. 
	 * Se centra en el contenido de la encuesta.
	 */
	public function generarReporteGeneralEvaluacionDocente($idDocente, $idEncuesta)
	{
		$tablaEncuesta = $this->tablaEncuesta;
		$select = $tablaEncuesta->select()->from($tablaEncuesta)->where("idEncuesta=?",$idEncuesta);
		$rowEncuesta = $tablaEncuesta->fetchRow($select);
		// ----------------------------------------------------------------------------
		$tablaSeccion = $this->tablaSeccion;
		$select = $tablaSeccion->select()->from($tablaSeccion)->where("idEncuesta=?",$idEncuesta);
		$rowsSecciones = $tablaSeccion->fetchAll($select);
		// ----------------------------------------------------------------------------
		$tablaRegistro = $this->tablaRegistro;
		$select = $tablaRegistro->select()->from($tablaRegistro)->where("idRegistro=?",$idDocente);
		$rowDocente = $tablaRegistro->fetchRow($select);
		// ---------------------------------------------------------------------------- Asignaciones
		$tablaAsignacion = $this->tablaAsignacionG;
		$select = $tablaAsignacion->select()->from($tablaAsignacion)->where("idRegistro=?",$idDocente);
		print_r("Query: " . $select->__toString());
		print_r("<br />");
		$rowsAsignaciones = $tablaAsignacion->fetchAll($select);
		// ---------------------------------------------------------------------------- Reporte
		$nombreArchivo = str_replace(' ', '_', $rowDocente->apellidos).str_replace(' ', '', $rowDocente->nombres)."-".$idEncuesta."-".$idDocente."-"."RGRAL.pdf";
		
		print_r("Nombre: " . $nombreArchivo);
		print_r("<br />");
		print_r("<br />");
		// ========================================================== >>> Generamos el reporte a partir de plantilla
		$pdfTemplate = My_Pdf_Document::load(PDF_PATH . '/reports/bases/reporteHBE.pdf');
		$pages = $pdfTemplate->pages;
		$pdfReport = new My_Pdf_Document($nombreArchivo, PDF_PATH . '/reports/encuesta/general/');
		$pdfReport->setYHeaderOffset(160);
		// Clonamos 
		$pageZ = clone $pages[0];
		$page = new My_Pdf_Page($pageZ);
		//$page = new My_Pdf_Page(Zend_Pdf_Page::SIZE_LETTER_LANDSCAPE);
		$font = Zend_Pdf_Font::fontWithPath(PDF_PATH . "/fonts/microsoft/GOTHIC.TTF");
		$page->setFont($font, 10);
		
		//print_r("Generando contenido :: Header");
		//print_r("<br />");
		// ========================================================== >>> Generamos header del reporte.
		$tableHeader = new My_Pdf_Table(2);
		$rowTable1 = new My_Pdf_Table_Row;
		$rowTable2 = new My_Pdf_Table_Row;
		$rowTable3 = new My_Pdf_Table_Row;
		$rowTable4 = new My_Pdf_Table_Row;
		
		$colthA1 = new My_Pdf_Table_Column;
		$colthA2 = new My_Pdf_Table_Column;
		$colthB1 = new My_Pdf_Table_Column;
		$colthB2 = new My_Pdf_Table_Column;
		$colthC1 = new My_Pdf_Table_Column;
		$colthC2 = new My_Pdf_Table_Column;
		$colthD1 = new My_Pdf_Table_Column;
		$colthD2 = new My_Pdf_Table_Column;
		
		$colthA1->setText("Evaluacion: ");
		$colthA1->setWidth(60);
		$colthA2->setText($rowEncuesta->nombre);
		$colthB1->setText("Docente: ");
		$colthB1->setWidth(60);
		$colthB2->setText($rowDocente->apellidos.", ".$rowDocente->nombres);
		
		$rowTable1->setColumns(array($colthA1,$colthA2));
		$rowTable1->setCellPaddings(array(5,5,5,5));
		$rowTable1->setFont($font,10);
		$rowTable2->setColumns(array($colthB1,$colthB2));
		$rowTable2->setCellPaddings(array(5,5,5,5));
		$rowTable2->setFont($font,10);
		
		$tableHeader->addRow($rowTable1);
		$tableHeader->addRow($rowTable2);
		//$tableHeader->addRow($rowTable3);
		//$tableHeader->addRow($rowTable4);
		
		$page->addTable($tableHeader, 150, 135);
		// ========================================================== >>> Generamos content del reporte.
		$numeroColumnas = 0;
		$categorias = array();
		$headersCategorias = array();
		$widthGeneral = 65;
		$hc1 = new My_Pdf_Table_Column;
		$hc1->setText("Grupo");
		$hc1->setWidth($widthGeneral);
		$hc2 = new My_Pdf_Table_Column;
		$hc2->setText("Alumnas");
		$hc2->setWidth($widthGeneral);
		$headersCategorias[] = $hc1;
		$headersCategorias[] = $hc2;
		
		$tablaGrupo = $this->tablaGrupo;
		
		foreach ($rowsSecciones as $rowSeccion) {
			$select = $tablaGrupo->select()->from($tablaGrupo)->where("idSeccion=?",$rowSeccion->idSeccion);
			$gruposSeccion = $tablaSeccion->fetchAll($select);
			$numeroColumnas += count($gruposSeccion);
			foreach ($gruposSeccion as $grupoSeccion) {
				$categorias[$grupoSeccion->idGrupo] = $grupoSeccion->nombre;
				$hc = new My_Pdf_Table_Column;
				$hc->setText($grupoSeccion->nombre);
				$hc->setWidth($widthGeneral);
				$headersCategorias[] = $hc;
			}
		}
		
		$tableContent = new My_Pdf_Table($numeroColumnas+2);
		//print_r($categorias);
		$rowHeaderTableContent = new My_Pdf_Table_HeaderRow;
		//$nombresCategorias = array_values($categorias);
		$rowHeaderTableContent->setColumns($headersCategorias);
		$rowHeaderTableContent->setFont($font,8);
		$rowHeaderTableContent->setCellPaddings(array(2,2,2,2));
		$tableContent->addRow($rowHeaderTableContent);
		// ========================================================== >>> Iteramos a traves de las asignaciones
		$tablaERealizadas = $this->tablaERealizadas;
		foreach ($rowsAsignaciones as $rowAsignacion) {
			// idAsignacion: 
			$select = $tablaERealizadas->select()->from($tablaERealizadas)->where("idAsignacion=?",$rowAsignacion->idAsignacion);
			$rowAsignacion = $tablaERealizadas->fetchRow($select);
			//
			$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo=?",$rowAsignacion->idGrupo);
			$rowGrupo = $tablaGrupo->fetchRow($select);
			//Obtenemos el numero de encuestas realizadas 
			$select = $tablaGrupo->select()->from($tablaGrupo)->where("idGrupo=?",$rowAsignacion->idGrupo);
			$rowGrupo = $tablaGrupo->fetchRow($select);
			//
			$cc1 = new My_Pdf_Table_Column;
			$cc1->setText($rowGrupo->nombre);
			$cc1->setWidth($widthGeneral);
			$cc2 = new My_Pdf_Table_Column;
			$cc2->setText($rowAsignacion->realizadas);
			$cc2->setWidth($widthGeneral);
			foreach ($categorias as $idGrupo => $nombreGrupo) {
				$valorMayor = $grupoDAO->obtenerValorMayorOpcion($categoria->getIdGrupo());
				$numeroPreguntas = count($grupoDAO->obtenerPreguntas($categoria->getIdGrupo()));
				$maximo = $erealizada["realizadas"] * $numeroPreguntas * $valorMayor["valor"];
			}
			
			
		}
		
		
		
		$page->addTable($tableContent, 40, 215);
		$pdfReport->addPage($page);
		$pdfReport->saveDocument();
	}
	
	public function generarReportePAGrupalEvaluacionDocente($value='')
	{
		
	}
	
	public function generaReporteVerticalBase($nombreArchivo = "template.pdf", $path = ".")
	{
		$properties = array();
		$properties["imgHeader"];
		$properties["imgFooter"];
		$pdfTemplate = new My_Pdf_Document($nombreArchivo,$path);
		
		$pdfTemplate->save();
	}
}
