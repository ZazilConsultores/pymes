/**
 * @author HectorRodriguez
 */
$().ready(function(){
	$("button[tipo='encuesta']").click(function(){
		//console.log($(this).attr("hash"));
		$hash = $(this).attr("hash");
		$hashContainer = $("div#detalles").attr("hash");
		
		if($hash != $hashContainer){
			$.ajax({
				url: "/SEncuestas/public/partials/encuestadet/idEncuesta/" + $hash,
				dataType: "html",
				success: function(data){
					$("div#detalles").html(data);
					$("div#detalles").attr("hash", $hash);
				}
			});
			// =======================================   >>> Cargamos las secciones
			$.ajax({
				url: "/SEncuestas/public/partials/secciones/idEncuesta/" + $hash,
				dataType: "html",
				success: function(data){
					$("div#contenedorSecciones").html(data);
					$("div#contenedorGrupos").html("");
					$("div#contenedorPreguntas").html("");
				}
			});
		}
		
	});
	
	$("div#contenedorSecciones").on("click", "button[tipo='seccion']", function(event) {
		$hash = $(this).attr("hash");
		$hashContainer = $("div#detalles").attr("hash");
		if($hash != $hashContainer){
			//============================================================================================== Detalles Seccion
			$urlDetallesSeccion = "/SEncuestas/public/partials/secciondet/idSeccion/" + $hash;
			$.ajax({
				url: $urlDetallesSeccion,
				dataType: "html",
				success: function(data){
					$("div#detalles").html(data);
					$("div#detalles").attr("tipo", "seccion");
					$("div#detalles").attr("hash", $hash);
				}
			});
			//============================================================================================== Grupos
			//console.log("Lanzando peticion de grupos");
			$urlGrupos = "/SEncuestas/public/partials/grupos/idSeccion/" + $hash;
			console.log($urlGrupos);
			$.ajax({
				url: $urlGrupos,
				dataType: "html",
				success: function(data){
					$("div#contenedorGrupos").html(data);
				}
			});
			//============================================================================================== Preguntas
			//console.log("Lanzando peticion de preguntas");
			$urlPreguntas = "/SEncuestas/public/partials/preguntas/idSeccion/" + $hash;
			$.ajax({
				url: $urlPreguntas,
				dataType: "html",
				success: function(data){
					$("div#contenedorPreguntas").html(data);
				}
			});
		}
		
	});
	
	$("div#contenedorGrupos").on("click", "button[tipo='grupo']", function(event) {
		$hash = $(this).attr("hash");
		console.log($hash);
		$hashContainer = $("div#detalles").attr("hash");
		if($hash != $hashContainer){
			//============================================================================================== Detalles Grupo
			$urlDetallesGrupo = "/SEncuestas/public/partials/grupodet/idGrupo/" + $hash;
			$.ajax({
				url: $urlDetallesGrupo,
				dataType: "html",
				success: function(data){
					$("div#detalles").html(data);
					$("div#detalles").attr("tipo", "grupo");
					$("div#detalles").attr("hash", $hash);
				}
			});
			//============================================================================================== Preguntas
			console.log("Lanzando peticion de preguntas");
			$urlPreguntas = "/SEncuestas/public/partials/preguntas/idGrupo/" + $hash;
			$.ajax({
				url: $urlPreguntas,
				dataType: "html",
				success: function(data){
					$("div#contenedorPreguntas").html(data);
				}
			});
		}
	});
	
	$("div#contenedorPreguntas").on("click", "button[tipo='pregunta']", function(event) {
		$hash = $(this).attr("hash");
		$hashPadre = $(this).attr("padre");
		$tipo = $(this).attr("tipo");
		//console.log($hash);
		$hashContainer = $("div#detalles").attr("hash");
		if($hash != $hashContainer){
			$urlDetallesPregunta = "/SEncuestas/public/partials/preguntadet/idPadre/"+ $hashPadre+"/tipo/"+$tipo+"/idPregunta/"+$hash;
			console.log($urlDetallesPregunta);
			$.ajax({
				url: $urlDetallesPregunta,
				dataType: "html",
				success: function(data){
					$("div#detalles").html(data);
					$("div#detalles").attr("tipo", "pregunta");
					$("div#detalles").attr("hash", $hash);
				}
			});
			
			
		}
		
	});
	
});
