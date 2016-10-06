/**
 * @author IngenieroRodriguez
 */
$().ready(function(){
	var url = window.location.origin + "/General/public/";
	$("select#idNivel").on('change',function(){
		console.log("Select Nivel Educativo");
		var idNivel = $(this).val();
		//console.log("Valor del Combo: " + idNivel);
		// Si contiene un idNivel real, buscamos 
		if(idNivel != 0){
			//console.log("Valor diferente de 0:" + idNivel);
			var urlConsultaEncuesta = url + "encuesta/json/grados/idNivel/" + idNivel;
			//console.log(urlConsultaEncuesta);
			// hacemos la consulta y llenamos el combo de idGrado
			$.ajax({
				url: urlConsultaEncuesta,
				dataType: "json",
				success: function(data){
					//console.log("datos obtenidos!!!");
					var selectGradoEducativo = $("select#idGradoEducativo");
					selectGradoEducativo.empty();
					$.each(data,function(i,item){
						//console.log("Valor: " + item.idGradoEducativo);
						var opt = new Option(item.gradoEducativo, item.idGradoEducativo);
						selectGradoEducativo.append(opt);
					});
				}
			});
		}else{
			var selectGradoEducativo = $("select#idGradoEducativo");
			var selectGrupoEscolar = $("select#idGrupoEscolar");
			selectGradoEducativo.empty();
			selectGrupoEscolar.empty();
			var opt = new Option("Seleccione opción...", "0");
			selectGradoEducativo.append(opt);
			selectGrupoEscolar.append(opt);
		}
	});
	
	$("select#idGradoEducativo").on('change', function(){
		console.log("Select Grado Educativo");
		var idGrado = $(this).val();
		//console.log("Valor del Combo: " + idGrado);
		var urlQueryGrupos = url + "encuesta/json/grupos/idGrado/" + idGrado;
		//console.log(urlQueryGrupos);
		$.ajax({
			url: urlQueryGrupos,
			dataType: "json",
			success: function(data){
				//console.log("datos obtenidos!!!");
				//console.log(data);
				
				var selectGrupoEscolar = $("select#idGrupoEscolar");
				selectGrupoEscolar.empty();
				$.each(data,function(i,item){
					var opt = new Option(item.grupo, item.idGrupo);
					selectGrupoEscolar.append(opt);
				});
				
				$("button#btnQueryEncuesta").removeClass("disabled");
			}
		});
	});
	
	$("select#idGrupoEscolar").on('change',function(){
		$("button#btnQueryEncuesta").removeClass("disabled");
	});
	
	$("button#btnQueryEncuesta").on('click',function(){
		console.log("Button pressed");
		var idGrupo = $("select#idGrupoEscolar").val();
		var urlQueryEncuestasRealizadas = url + "encuesta/json/encrealizadas/idGrupo/" + idGrupo;
		//console.log(urlQueryEncuestasRealizadas);
		$.ajax({
			url: urlQueryEncuestasRealizadas,
			dataType: "json",
			success: function(data) {
				//console.log("datos obtenidos!!!");
				//console.dir(data);
				
				var tbody = $("table#tableDetails").find("tbody");
				tbody.empty();
				
				$.each(data,function(i,item){
					//var opt = new Option(item.grupo, item.idGrupo);
					//selectGrupoEscolar.append(opt);
					var anchorDetails = $('<a>').
						attr({'class':'btn btn-link'}).
						attr({'target':'_blank'}).
						attr({'href': url + "encuesta/index/resultado/idEncuesta/"+item.encuesta.idEncuesta+"/idAsignacion/"+item.asignacion.idAsignacionGrupo}).
						text("Detalle");
					
					//console.log(item.materia);
					tbody.append($('<tr>').
						append($('<td>').append(item.materia.materia)).
						append($('<td>').append(item.docente.apellidos + ", " +item.docente.nombres)).
						append($('<td>').append(item.encuesta.nombre)).
						append($('<td>').append(anchorDetails))
					);
				});
				
			}
		});
		$(this).addClass("disabled");
	});
	
});
