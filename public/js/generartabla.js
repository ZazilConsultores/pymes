

var numero = 0;

function addNewRow()
{
  // obtenemos acceso a la tabla por su ID
  var TABLE = document.getElementById("tabla");
  // obtenemos acceso a la fila maestra por su ID
  var TROW = document.getElementById("celda");
 
  // tomamos la celda
  var content = TROW.getElementsByTagName("td");
 
 
  // creamos una nueva fila
  var newRow = TABLE.insertRow(-1);
  newRow.className = TROW.attributes['class'].value;
 
  // creamos una nueva celda
  var newCell = newRow.insertCell(newRow.cells.length);
  var newCell1 = newRow.insertCell(newRow.cells.length);
  var newCell2 = newRow.insertCell(newRow.cells.length);
  var newCell3 = newRow.insertCell(newRow.cells.length);
  var newCell4 = newRow.insertCell(newRow.cells.length);
  var newCell5 = newRow.insertCell(newRow.cells.length);
  var newCell6 = newRow.insertCell(newRow.cells.length);
 	
  // creamos una nueva ID para el examinador
  // newID = 'file_' + (++numero);
  newID = 'cantidad_' + (++numero) ;
  newID1 = 'clave_' + (++numero);
  newID2 = 'codigoBarra_' + (++numero) ;
  newID3 = 'descripcion_' + (++numero);
  newID4 = 'unidad_' + (++numero) ;
  newID5 = 'precioUnitario_' + (++numero);
  newID6 = 'precioImporte_' + (++numero);
 
  // creamos un nuevo control
 // txt = '<input type="file" id="' + newID  + '" size="50" />';
  txt ='<input type="text" id="' + newID + '"  />';
  txt1 ='<input  type="select" id="' + newID1 + '" />';
  txt2 ='<input type="text" id="' + newID2 + '"  />';
  txt3 ='<input type="text" id="' + newID3 + '" />';
  txt4 ='<input type="text" id="' + newID4 + '"  />';
  txt5 ='<input type="text" id="' + newID5 + '" />';
  txt6 ='<input type="text" id="' + newID6 + '" />';
  
  // y lo asignamos a la celda
  newCell.innerHTML =  txt ; 
  newCell1.innerHTML = txt1;
  newCell2.innerHTML = txt2 ; 
  newCell3.innerHTML = txt3;
  newCell4.innerHTML = txt4 ; 
  newCell5.innerHTML = txt5;
  newCell6.innerHTML = txt6;
  
 
  // aviso ;)
  alert(txt);
}

function removeLastRow()
{
  // obtenemos la tabla
  var TABLE = document.getElementById("tabla");
 
  // si tenemos mas de una fila, borramos
  if(TABLE.rows.length > 2)
  {
  TABLE.deleteRow(TABLE.rows.length-1);
  --numero;
  }
}

 
/*
var numero = 0;
 
function addNewRow()
{
  // obtenemos acceso a la tabla por su ID
  var TABLE = document.getElementById("tabla");
  // obtenemos acceso a la fila maestra por su ID
  var TROW = document.getElementById("celda");
 
  // tomamos la celda
  var content = TROW.getElementsByTagName("td");
 
  // creamos una nueva fila
  var newRow = TABLE.insertRow(-1);
  newRow.className = TROW.attributes['class'].value;
 
  // creamos una nueva celda
  var newCell = newRow.insertCell(newRow.cells.length);
 
  // creamos una nueva ID para el examinador
  newID = 'file_' + (++numero);
  newID = 'text_' + (++numero);

 
  // creamos un nuevo control
  txt = '<input type="file" id="' + newID  + '" size="50" />';
  txt1= '<input type="text" id="' + newID + '" size="20" />';

  // y lo asignamos a la celda
  newCell.innerHTML = txt + txt1; 

 
  // aviso ;)
  alert(txt);
}
 
function removeLastRow()
{
  // obtenemos la tabla
  var TABLE = document.getElementById("tabla");
 
  // si tenemos mas de una fila, borramos
  if(TABLE.rows.length > 2)
  {
  TABLE.deleteRow(TABLE.rows.length-1);
  --numero;
  }
}
 
function verElementos(evento)
{
  for (i=0; i<=numero; i++)
  {
    var my_id = "file_" + i;
    var my_file = document.getElementById(my_id);
    alert ("id: " + my_id + " value: " + my_file.value);
  }
}
*/





/*
		// Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
		$("#tabla tbody tr:eq(0)").clone().removeClass('celda').appendTo("#tabla tbody");
		//
		newRow.className = TROW.attributes['class'].value;
		
		//
		// creamos una nueva ID para el examinador
  		//newID = 'file_' + (++numero);
  		newID = 'cantidad_0' + (++numero);

		// creamos un nuevo control
  		txt = '<input type="text" id="' + newID  + '"  />';
  		
  		// y lo asignamos a la celda
  		newRow.innerHTML = txt;
  		//newCell.innerHTML = txt; 

 
  		// aviso ;)
  		alert(txt);
		
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
	
	
	

	});*/
