/**
 * @author Hector Rodriguez
 */
//$host = "localhost/Encuesta/public/";
$().ready(function() {
	$("input[tipo='fecha']").click(function(){
		$(this).datepicker({
			minDate: 0,
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
	});
});
