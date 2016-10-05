/**
 * @author IngenieroRodriguez
 */
$().ready(function(){
	$("select#nivel").on('change', function(){
		console.log(this.value);
		$url = "/General/public/encuesta/json/grados/idNivel/" + this.value;
		console.log($url);
		$.ajax({
			url: $url,
			dataType: "json",
			success: function(data){
				console.log($url);
				console.dir(data);
				$("select#1-grado").empty();
				$.each(data, function(i,item){//function(key,value)		
					$("select#1-grado").append($("<option></option>").attr("value",data[i].idGrado).text(data[i].grado)); 
				});
				
			}
		});
	});
	
});