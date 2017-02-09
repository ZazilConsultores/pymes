/**
 * @author WSZAZILSI01
 */
$().ready(function(){
		console.log("Javascript Activado!!");
		var jsonActual;
		
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
					jsonActual = data;
					var tbody = $("table#resultadoLibros").find('tbody');
					tbody.empty();
					$.each(data, function(i,item){
						var buttonDetalle = $('<button />').attr({'idLibro':data[i]["idLibro"]}).attr({'name':'detalle'}).attr({'tipo': 'detalle'}).attr({'class':'btn btn-info'}).attr({'data-toggle':'modal'}).attr({'data-target':'#msgDetalle'});
						buttonDetalle.html('<span class="glyphicon glyphicon-book"></span> Detalle Libro');
					
						tbody.append($('<tr>').
							append($('<td>').append(data[i]["titulo"])).
							append($('<td>').append(data[i]["autor"])).
							append($('<td>').append(data[i]["editorial"])).
							append($('<td>').append(buttonDetalle))
						);
						
						
					});
				}
			});
		});
		
		/**
		 * Listener de los botones dinamicos de detalle de la tabla de libros
		 */
		$('table#resultadoLibros').on('click', "button[tipo^='detalle']",function(){
				console.log("función dinamica ");
				console.log($(this).attr("idLibro"));
				console.dir(jsonActual);
				var idLibro =$(this).attr("idLibro");
				var url = window.location.origin + "/General/public/Biblioteca/Libro/admin/idLibro/"+idLibro;
				console.log(url);
				
				var libro = null;
				$.each(jsonActual,function(i,item){
					if(idLibro == item.idLibro) libro = item;
					//console.log(item);
				});
				
				$("span#titulo").html(libro.titulo);
				$("span#autor").text(libro.autor);
				$("span#editorial").text(libro.editorial);
				$("span#paginas").text(libro.paginas);
				$("span#publicacion").html(libro.publicado);
				$("a#aConfigLibro").attr("href", url);
				
				
				/*
				var url = window.location.origin + "/General/public/Biblioteca/json/consultabasica/idLibro/"+idLibro;

				console.log((url));
				
				$.ajax({
					url: url,
					dataType: "json",
					success: function(data){
						console.log("Peticion AJAX enviada");
						console.dir(data);
						$.each(jsonActual,function(i,item){
								var titulo=data[i]["titulo"];
								var autor=data[i]["autor"];
								var editorial=data[i]["editorial"];
								var paginas =data[i]["paginas"];
								var publicado =data[i]["publicado"];
								
								$("span#titulo")=value.titulo;
								
								console.log("Titulo:"+titulo);
								console.log("Autor:"+autor);
								console.log("Editorial:"+editorial);
								console.log("Paginas:"+paginas);
								console.log("Publicado:"+publicado);
								
								$("span#titulo")=titulo.val();
							
						});
					}
				});
				*/
		
		});
		
		
		function Libro(titulo, autor, editorial, publicado, paginas){
			
			this.titulo = titulo;
			this.autor = autor;
			this.editorial = editorial;
			this.publicado = publicado;
			this.paginas = paginas;
			//this.isbn = isbn;
			//this.codigoBarras = codigoBarras;
		}	
			
			
});	