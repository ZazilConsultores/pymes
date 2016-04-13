function AddItem() {
	var tbody = null;
	var tabla = document.getElementById("tabla");
	var nodes = tabla.childNodes;
	for (var x = 0; x<nodes.length;x++) {
		if (nodes[x].nodeName == 'TBODY') {
			tbody = nodes[x];
			break;
		}
	}
	if (tbody != null) {
		var tr = document.createElement('tr');
		//tr.innerHTML = '<td><input type="text" name="item[]"/></td><td><input type="text" name="cantidad[]" onChange="Calcular(this);" value="1" /></td><td><input type="text" name="precunit[]" onChange="Calcular(this);" value="0"/></td><td><input type="text" name="totalitem[]" readonly /></td>';
		tr.innerHTML = '<td><input type="text" name="cantidad" onChange="Calcular(this);" value="1" /></<td><td><input type="text" name="producto"/></td><td><input type="text" name="unidad"/></td><td><input type="text" name="codigoBarras"/></td><td><input type="text" name="descripcion"/></td><td><input type="text" name="precioUnitario" onChange="Calcular(this);" value="1" /></td><td><input type="text" name="precioImporte" readonly  /></td>';
					    
		tbody.appendChild(tr);
	}
}

function Calcular(ele) {
	var cantidad = 0, precUnitario = 0, precioImporte = 0;
	var tr = ele.parentNode.parentNode;
	var nodes = tr.childNodes;
	for (var x = 0; x<nodes.length;x++) {
		if (nodes[x].firstChild.name == 'cantidad') {
			cantidad = parseFloat(nodes[x].firstChild.value,10);
		}
		if (nodes[x].firstChild.name == 'precioUnitario') {
			precioUnitario = parseFloat(nodes[x].firstChild.value,10);
		}
		if (nodes[x].firstChild.name == 'precioImporte') {
			precioImporte = parseFloat((precioUnitario*cantidad),10);
			nodes[x].firstChild.value = precioImporte;
		}
	}
	var total = document.getElementById("total");
	if (total.innerHTML == 'NaN') {
		total.innerHTML = 0;
	}
	total.innerHTML = parseFloat(total.innerHTML)+precioImporte;
}



