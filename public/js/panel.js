/**
 * @author HectorRodriguez
 */
$().ready(function(){
	$urlEncuesta = "/General/public/encuesta/";
	$("button[tipo='encuesta']").click(function(){
		//console.log($(this).attr("hash"));
		$hash = $(this).attr("hash");
		$hashContainer = $("div#detalles").attr("hash");
		$tipo = "encuesta";
		$tipoContainer = $("div#detalles").attr("tipo");
		
		if(($tipo != $tipoContainer) && ($hash != $hashContainer)){
			$.ajax({
				url: $urlEncuesta + "html/encuestadet/idEncuesta/" + $hash,
				dataType: "html",
				success: function(data){
					$("div#detalles").html(data);
					$("div#detalles").attr("hash", $hash);
					$("div#detalles").attr("tipo", $tipo);
				}
			});
			// =======================================   >>> Cargamos las secciones
			$.ajax({
				url: $urlEncuesta + "html/secciones/idEncuesta/" + $hash,
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
		console.log("En secciones");
		
		$hash = $(this).attr("hash");
		$hashContainer = $("div#detalles").attr("hash");
		
		$tipo = "seccion";
		$tipoContainer = $("div#detalles").attr("tipo");
		console.log($tipo);
		console.log($tipoContainer);
		
		if(($tipo != $tipoContainer) || ($hash != $hashContainer)){
			//============================================================================================== Detalles Seccion
			$urlDetallesSeccion = $urlEncuesta + "html/secciondet/idSeccion/" + $hash;
			$.ajax({
				url: $urlDetallesSeccion,
				dataType: "html",
				success: function(data){
					$("div#detalles").html(data);
					$("div#detalles").attr("tipo", "seccion");
					$("div#detalles").attr("hash", $hash);
					$("div#detalles").attr("tipo", $tipo);
				}
			});
			//============================================================================================== Grupos
			//console.log("Lanzando peticion de grupos");
			$urlGrupos = $urlEncuesta + "html/grupos/idSeccion/" + $hash;
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
			$urlPreguntas = $urlEncuesta + "html/preguntas/idSeccion/" + $hash;
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
		console.log("En grupos");
		$hash = $(this).attr("hash");
		$hashContainer = $("div#detalles").attr("hash");
		
		$tipo = "grupo";
		$tipoContainer = $("div#detalles").attr("tipo");
		
		if(($tipo != $tipoContainer) && ($hash != $hashContainer)){
			//============================================================================================== Detalles Grupo
			$urlDetallesGrupo = $urlEncuesta + "html/grupodet/idGrupo/" + $hash;
			$.ajax({
				url: $urlDetallesGrupo,
				dataType: "html",
				success: function(data){
					$("div#detalles").html(data);
					$("div#detalles").attr("tipo", "grupo");
					$("div#detalles").attr("hash", $hash);
					$("div#detalles").attr("tipo", $tipo);
				}
			});
			//============================================================================================== Preguntas
			console.log("Lanzando peticion de preguntas");
			$urlPreguntas = $urlEncuesta + "html/preguntas/idGrupo/" + $hash;
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
		console.log("En preguntas");
		$hash = $(this).attr("hash");
		$hashPadre = $(this).attr("padre");
		//$tipo = $(this).attr("tipo");
		//console.log($hash);
		
		$hashContainer = $("div#detalles").attr("hash");
		$tipo = "grupo";
		$tipoContainer = $("div#detalles").attr("tipo");
		
		if(($tipo != $tipoContainer) && ($hash != $hashContainer)){
			$urlDetallesPregunta = $urlEncuesta + "html/preguntadet/idPadre/"+ $hashPadre+"/tipo/"+$tipo+"/idPregunta/"+$hash;
			console.log($urlDetallesPregunta);
			$.ajax({
				url: $urlDetallesPregunta,
				dataType: "html",
				success: function(data){
					$("div#detalles").html(data);
					$("div#detalles").attr("tipo", "pregunta");
					$("div#detalles").attr("hash", $hash);
					$("div#detalles").attr("tipo", $tipo);
				}
			});
			
			
		}
		
	});
	
});
