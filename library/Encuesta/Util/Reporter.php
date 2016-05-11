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
		
		$nombreArchivo = $rowGrupoE->grupo."-".str_replace(' ', '', $rowMateriaE->materia)."-".mb_strlen(str_replace(' ', '', $rowEncuesta->nombre)).".pdf";
		
		print_r("Cargando plantilla");
		print_r("<br />");
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
		
		print_r("Generando contenido :: Header");
		print_r("<br />");
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
		
		print_r("Generando contenido :: Cuerpo");
		print_r("<br />");
		// ========================================================== >>> Generamos el cuerpo del reporte
		$tableContent = new My_Pdf_Table(2);
		
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
			$rowTH = new My_Pdf_Table_Row;
			$colth = new My_Pdf_Table_Column;
			$colth->setText($rowSeccion->nombre);
			$rowTH->setColumns(array($colth));
			
			$select = $tablaGrupo->select()->from($tablaGrupo)->where("idSeccion=?", $rowSeccion->idSeccion);
			$rowsGrupos = $tablaGrupo->fetchAll($select);
			// Iteramos sobre 
			foreach ($rowsGrupos as $rowGrupo) {
				$colc11 = new My_Pdf_Table_Cell;
				$colc12 = new My_Pdf_Table_Cell;
				
				$colc11->setText("Categoría: " . $rowGrupo->nombre);
				$colc12->setText();
				//Puntajes maximos obtenidos
				$puntajeMaximo = 0;
				$puntajeObtenido = 0;
				$calificacionCategoria = 0;
				$arrayIdsOpciones = array();
				// Procesamos la encuesta solo si es de tipo SS
				if($rowGrupo->tipo == "SS") {
					
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
						print_r($select->__toString());
						$rowsRespuesta = $tablaRespuesta->fetchAll($select);
						
						foreach ($rowsRespuesta as $rowRespuesta) {
							foreach ($rowsOpciones as $rowOpcion) {
								if($rowOpcion->idOpcion = $rowRespuesta->respuesta){
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
					
					print_r("<strong>Puntaje Obtenido: ".$puntajeObtenido."</strong><br />");
					print_r("<strong>Puntaje Maximo: ".$puntajeMaximo."</strong><br />");
				}
				
			}
			
		}
		
		print_r("Contenido creado, guardando archivo");
		print_r("<br />");
		/*
		foreach ($rowsSecciones as $row) {
			
			array_merge($grupos,$rowGrupos);
		}
		
		$preguntas = array();
		
		foreach ($grupos as $grupo) {
			
		}
		*/
		// ========================================================== >>> Guardamos el reporte
		//$pdfReport->addPage($page);
		//$pdfReport->save();
		//$pdfReport->save($nombreArchivo,false);
	}
	
	public function generarReporteGeneralEvaluacionDocente($value='')
	{
		
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
