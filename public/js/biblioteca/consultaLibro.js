/**
 * @author WSZAZILSI01
 */
$().ready(function(){
		console.log("Javascript Activado!!");
		
		$("button#btnBusqueda").on('click', function(){
			console.log("Boton presionado!!");
			var titulo = $("input#titulo");
			var autor = $("input#autor");
			var editorial = $("input#editorial");
			
			var url = window.location.origin + "/General/public/Biblioteca/Json/consultabasica";
			
			if(autor.val() != "") url += "/autor/" + autor.val();
			if(titulo.val() != "") url += "/titulo/" + titulo.val();
			if(editorial.val() != "") url += "/editorial/" + editorial.val();
			
			//url += "autor/" + autor.val() + "/titulo/" + titulo.val() + "/editorial/" + editorial.val();
			
			console.log(encodeURI(url));
			
			$.ajax({
				url: encodeURI(url),
				dataType: "json",
				success: function(data){
					console.log("Peticion AJAX enviada");
					console.dir(data);
					var tbody = $("table#resultadoLibros").find('tbody');
					tbody.empty();
					$.each(data, function(i,item){
					
						tbody.append($('<tr>').
							append($('<td>').append(data[i]["titulo"])).
							append($('<td>').append(data[i]["autor"])).
							append($('<td>').append(data[i]["editorial"])).
							append($('<td>').append("-"))
						);
						
						
					});
				}
			});
			
			
			$("button#VerLibro").on('click',function(){
				var url = windows.location.origin + "General/public/"+"Biblioteca"
			});
		
		
		
		});
});	