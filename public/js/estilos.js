/**
 * @author Hector Rodriguez
 */
$().ready(function(){
	//desplegar detalle encuestas
	$("a[tipo='encuesta']").click(function(){
		$("#generalDetails").removeClass("oculto");
		$("#generalDetails").addClass("visible");
		$(".encuTitle").removeClass("oculto");
		$(".encuTitle").addClass("visible");
		$("#contentDet").removeClass("oculto");
		$("#contentDet").addClass("visible");
		$("#contentDet").addClass("encuBack");
	});
	
	$("a[tipo='seccion']").click(function(){
		//$("#generalDetails").removeClass("oculto");
		//$("#generalDetails").addClass("visible");
		$(".encuTitle").addClass("oculto");
		$(".seccTitle").removeClass("oculto");
		$(".seccTitle").addClass("visible");
		//$("#contentDet").removeClass("oculto");
		//$("#contentDet").addClass("visible");
		$("#contentDet").addClass("seccBack");
	});
});
