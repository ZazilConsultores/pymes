
 
$(function(){
	// Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
	$("#agregar").on('click', function(){
		$("#tabla tbody tr:eq(0)").clone().removeClass('filabase').appendTo("#tabla tbody");
	});
 
	// Evento que selecciona la fila y la elimina 
	$(document).on("click",".eliminar",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		
	});
	
	//calcular PrecioImporte
	$(document).on("click","precioImporte",function calcular(){
		
		var cantidad = document.getElementById("cantidad").value;
		var precioUnitario = document.getElementById("precioUnitario").value;
		
		var precioImporte = document.getElementById("precioImporte").value;	
		
		var total = (parseInt(cantidad) * parseInt(precioUnitario));
	
	precioImporte.value = total;
	

	});
	
});
 

