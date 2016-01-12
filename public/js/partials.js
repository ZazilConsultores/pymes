/**
 * @author Hector Rodriguez
 */
$().ready(function(){
	console.log("En partials.js");
	
	$colorEncuesta = "#FF1493";
	$colorSeccion = "#FF69B4";
	$colorGrupos = "#FCB6C1";
	$colorPreguntas = "#FCC0CB";
	
	$colorEncuesta = "#DC143C";
	$colorSeccion = "#FFA500";
	$colorGrupos = "#228B22";
	$colorPreguntas = "#0000FF";
	
	
	/*         ========================================   *   ========================================         */
	$("section#encuestaOpts").css("background-color", $colorEncuesta);
	$("section#seccionOpts").css("background-color", $colorSeccion);
	$("section#grupoOpts").css("background-color", $colorGrupos);
	$("section#preguntaOpts").css("background-color", $colorPreguntas);
	
	$("a[tipo='encuesta']").click(function() {
		$idEncuesta = $(this).attr("hash");
		//console.log("Hash boton: ");
		//console.log($idEncuesta);
		//console.log("ContentDet: ");
		//console.log($("#contentDet").attr("hash"));
		
		//$("#contentDet").css("background-color", $colorEncuesta);
		$("#principal").css("background-color", $colorEncuesta);
		$("section#preguntaOpts").css("background-color", $colorPreguntas);
		$("#contentDet").removeClass("oculto");
		$("#contentDet").addClass("visible");
		$("#contentDet").addClass("encuBack");
		$lanzaPeticion = false;
		
		if($("#contentDet").attr("tipo") != "encuesta"){
			$lanzaPeticion = true;
		}else{
			if(!($("#contentDet").attr("hash") == $(this).attr("hash"))){
				$lanzaPeticion = true;
			};
		}
		
		if($lanzaPeticion){
			// =======================================   >>> Cargamos los detalles  
			$.ajax({
				url: "/SEncuestas/public/partials/encuestadet/encuesta/" + $idEncuesta,
				dataType: "html",
				success: function(data){
					//console.dir(data);
					//console.dir("Cargando detalles");
					$("div#contentDet").html(data);
					$("div#contentDet").attr("tipo", "encuesta");
					$("div#contentDet").attr("hash", $idEncuesta);
				}
			});
			// =======================================   >>> Cargamos las secciones
			$.ajax({
				url: "/SEncuestas/public/partials/secciones/idEncuesta/" + $idEncuesta,
				dataType: "html",
				success: function(data){
					//console.dir("Cargando secciones");
					//console.dir(data);
					$("div#seccionAsync").html(data);
					$("div#gruposAsync").html("");
					$("div#preguntasAsync").html("");
				}
			});
		}else{
			//console.log("No se lanzo la peticion encuesta");
		}
	});
	
	$("#seccionAsync").on("click", "a[tipo='seccion']", function(event) {
		event.preventDefault();
		//console.log( $(this).text() );
		$idSeccion = $(this).attr("hash");
		console.log( $(this).attr("hash") );
		$lanzaPeticion = false;
		if($(this).attr("hash") != $("#contentDet").attr("hash")){
			//console.log("Los hashes son diferentes");
			$lanzaPeticion = true;
			
		}else{
			//console.log("Los hashes cambiaron"); 
		}
		
		if($lanzaPeticion) {
			$urlDetallesSeccion = "/SEncuestas/public/partials/secciondet/idSeccion/" + $idSeccion;
			console.log($urlDetallesSeccion);
			$.ajax({
				url: $urlDetallesSeccion,
				dataType: "html",
				success: function(data){
					//console.log(data);
					//console.dir($("#contentDet").html());
					$("#principal").css("background-color", $colorSeccion);
					$("section#preguntaOpts").css("background-color", $colorSeccion);
					//$("#contentDet").css("background-color", $colorSeccion);
					$("#contentDet").html(data);
					$("#contentDet").attr("tipo", "seccion");
					$("#contentDet").attr("hash", $idSeccion);
				}
			});
			//console.log("Lanzando peticion de grupos");
			$urlGrupos = "/SEncuestas/public/partials/grupos/idSeccion/" + $idSeccion;
			console.log($urlGrupos);
			$.ajax({
				url: $urlGrupos,
				dataType: "html",
				success: function(data){
					//console.log(data);
					//console.dir($("#contentDet").html());
					$("#principal").css("background-color", $colorSeccion);
					$("section#preguntaOpts").css("background-color", $colorSeccion);
					//$("#contentDet").css("background-color", $colorSeccion);
					$("#gruposAsync").html(data);
					//$("#contentDet").attr("tipo", "seccion");
					//$("#contentDet").attr("hash", $idSeccion);
				}
			});
			//console.log("Lanzando peticion de preguntas");
			$urlPreguntas = "/SEncuestas/public/partials/preguntas/idSeccion/" + $idSeccion;
			console.log($urlPreguntas);
			$.ajax({
				url: $urlPreguntas,
				dataType: "html",
				success: function(data){
					//console.log(data);
					//console.dir($("#contentDet").html());
					$("#principal").css("background-color", $colorSeccion);
					$("#preguntaOpts").css("background-color", $colorSeccion);
					//$("#contentDet").css("background-color", $colorSeccion);
					$("#preguntasAsync").html(data);
					//$("#contentDet").attr("tipo", "seccion");
					//$("#contentDet").attr("hash", $idSeccion);
				}
			});
			
		}else{
			
		}
		
	});
	
	$("#gruposAsync").on("click", "a[tipo='grupo']", function(event) {
		event.preventDefault();
		$idGrupo = $(this).attr("hash");
		//console.log("Hash boton: ");
		//console.log($idEncuesta);
		//console.log("ContentDet: ");
		//console.log($("#contentDet").attr("hash"));
		
		//$("#contentDet").css("background-color", $colorEncuesta);
		$("#principal").css("background-color", $colorGrupos);
		$("section#preguntaOpts").css("background-color", $colorGrupos);
		$("#contentDet").removeClass("oculto");
		$("#contentDet").addClass("visible");
		$("#contentDet").addClass("encuBack");
		$lanzaPeticion = false;
		if($(this).attr("hash") != $("#contentDet").attr("hash")){
			console.log("Los hashes son diferentes");
			$lanzaPeticion = true;
			
		}else{
			console.log("Los hashes cambiaron"); 
		}
		
		if($lanzaPeticion) {
			$urlDetallesGrupo = "/SEncuestas/public/partials/grupodet/idGrupo/" + $idGrupo;
			$.ajax({
				url: $urlDetallesGrupo,
				dataType: "html",
				success: function(data){
					//console.log(data);
					//console.dir($("#contentDet").html());
					$("#principal").css("background-color", $colorGrupos);
					$("section#preguntaOpts").css("background-color", $colorGrupos);
					//$("#contentDet").css("background-color", $colorSeccion);
					$("#contentDet").html(data);
					$("#contentDet").attr("tipo", "grupo");
					$("#contentDet").attr("hash", $idGrupo);
				}
			});
			console.log("Lanzando peticion de preguntas");
			$urlPreguntas = "/SEncuestas/public/partials/preguntas/idGrupo/" + $idGrupo;
			$.ajax({
				url: $urlPreguntas,
				dataType: "html",
				success: function(data){
					//console.log(data);
					//console.dir($("#contentDet").html());
					$("#principal").css("background-color", $colorGrupos);
					$("#preguntaOpts").css("background-color", $colorGrupos);
					//$("#contentDet").css("background-color", $colorSeccion);
					$("#preguntasAsync").html(data);
					//$("#contentDet").attr("tipo", "seccion");
					//$("#contentDet").attr("hash", $idSeccion);
				}
			});
		}
		
	});
	
	$("#preguntasAsync").on("click", "a[tipo='pregunta']", function(event) {
		event.preventDefault();
		$idPregunta = $(this).attr("hash");
		console.log( $(this).attr("hash") );
		//console.log($(this).attr("hash"));
		$idPadre = $("#contentDet").attr("hash");
		$tipo = $("#contentDet").attr("tipo");
		$lanzaPeticion = false;
		if($(this).attr("hash") != $("#contentDet").attr("hash")){
			//console.log("Los hashes son diferentes");
			$lanzaPeticion = true;
		}
		
		if($lanzaPeticion) {
			$urlDetallesPregunta = "/SEncuestas/public/partials/preguntadet/idPadre/"+ $idPadre+"/tipo/"+$tipo+"/idPregunta/"+$idPregunta;
			console.log($urlDetallesPregunta);
			$.ajax({
				url: $urlDetallesPregunta,
				dataType: "html",
				success: function(data){
					//console.log(data);
					//console.dir($("#contentDet").html());
					//$("#principal").css("background-color", $colorGrupos);
					//$("section#preguntaOpts").css("background-color", $colorGrupos);
					//$("#contentDet").css("background-color", $colorSeccion);
					$("#contentDet").html(data);
					$("#contentDet").attr("tipo", "pregunta");
					$("#contentDet").attr("hash", $idPregunta);
				}
			});
		}
	});
	
	console.log("Fin de partials.js");
	
});

