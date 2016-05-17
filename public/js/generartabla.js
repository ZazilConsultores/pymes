
var numero = 0;
var cantidad = 0, precUnitario = 0, precioImporte = 0;

function AddItem() {
	var tbody = null;
	// obtenemos acceso a la tabla por su ID
	var tabla = document.getElementById("tabla");
	// obtenemos acceso a la fila maestra por su ID
  	var TROW = document.getElementById("celda");
 	// tomamos la celda
  	var content = TROW.getElementsByTagName("td");
	
	if (tbody = null) {
	var nodes = tabla.childNodes;
	for (var x = 0; x<nodes.length;x++) {
		if (nodes[x].nodeName == 'TBODY') {
			tbody = nodes[x];
			break;
		}
	}
}

 		
 		var newRow = tabla.insertRow(-1);
 		newRow.className = TROW.attributes['class'].value;
   		
   		var newcell1 = newRow.insertCell(-1);
   		var newcell2 = newRow.insertCell(-1);
   		var newcell3 = newRow.insertCell(-1);
     	var newcell4 = newRow.insertCell(-1);
   		var newcell5 = newRow.insertCell(-1);
   		var newcell6 = newRow.insertCell(-1);
   		var newcell7 = newRow.insertCell(-1);
   		var newcell8 = newRow.insertCell(-1);
 
  // creamos una nueva ID para el examinador
  newID1 = 'cantidad' + (++numero),newID2 = 'idProducto' + (++numero),newID3 = 'idUnidad' + (++numero);
  newID4 = 'codigoBarras' + (++numero);
  newID5 = 'producto' + (++numero);
  newID6 = 'costoUnitario' + (++numero);
  newID7 = 'totalImporte' + (++numero);
  newID8 = 'eliminar' + (++numero);
  
 
  // creamos un nuevo control
 //tr.innerHTML =';
  //<input id="totalImporte" type="text" name="totalImporte" readonly  />
 
  cantidad = '<input type="text" id="' + newID1  + '"  name="cantidad" onChange="Calcular(this);" value="1"  /> ';
  //idProducto = '<input id="' + newID2 + '" type="text" name="idProducto"/> <?php $conexion=mysql_connect("localhost","zazil","admin"); mysql_select_db("General",$conexion);$sql= ("select * from producto");$query = mysql_query($sql);while($row=mysql_fetch_array($query)){ ?><option value=" <?php echo $row['idProducto'] ?> " ><?php echo $row['claveProducto']; ?></option<?php}?></option>';
  idProducto = '<input id="' + newID2 + '" name = "idProducto" />';
  idUnidad = '<input id="' + newID3  + '" type="text" name="idUnidad"/>';
  codigoBarras = '<input id="' + newID4  + '" type="text" name="codigoBarras"/>';
  producto = '<input id="' + newID5  + '" type="text" name="producto"/></td>';
  costoUnitario ='<input id="' + newID6  + '" type="text" name="costoUnitario" onChange="Calcular(this);" value="1" />';
  totalImporte= '<input id="' + newID7  + '" type="text" name="totalImporte" readonly  />';
  eliminar='<input  class="eliminar" onClick="removeLastRow()" value =Eliminar  />';
  //eliminar='<td class="eliminar"onClick="removeLastRow()">Eliminar</td>';
 
  // y lo asignamos a la celda
  newcell1.innerHTML = cantidad;
  newcell2.innerHTML = idProducto;
  newcell3.innerHTML = idUnidad;     
  newcell4.innerHTML = codigoBarras;
  newcell5.innerHTML = producto;
  newcell6.innerHTML = costoUnitario; 
  newcell7.innerHTML = totalImporte;
  newcell8.innerHTML = eliminar;

  // aviso ;)
 
}

function removeLastRow()
{
  // obtenemos la tabla
  var tabla = document.getElementById("tabla");
 
  // si tenemos mas de una fila, borramos3
  
  if(tabla.rows.length > 2)
  {
  tabla.deleteRow(tabla.rows.length-1);
  --numero;
  }
}

// funcion buscar
function buscar(){
	  var claveProducto = $("#idProducto").val();
	 //var claveProducto = document.getElementById("producto").value;
	 if(claveProducto !=""){
	 	$.post("nueva", {valorBusqueda: claveProducto}, function(mensaje) {
	 		$("#producto").html(mensaje);

	 	});
	 }else{
	 	("#producto").html('<p>Descripcion vacia</p>');
	 	
	 }	
	 //alert($('claveProducto').val());
			
}

/*function calcularPrecioImporte(){
 		var importeTotal = 0;
 		$("table#productosNota > tbody > tr").each(function(){
 			
 			var iPrecioImporte = $(this).find("input#precioImporte_");
 			importeTotal += $iPrecioImporte;
 			
 		});	
 		console.log('ImporteTotal:'+importeTotal);
 	}*/
	
	

