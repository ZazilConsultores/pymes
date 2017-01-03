/**
 * @author Héctor Rodríguez
 */
$().ready(function(){
    var form = $("#altaEncuesta");
    
    form.validate({
        rules: {
            nombre: "required",
            nombreClave: {
                required: true,
                rangelength: [15,20],
            },
            descripcion: "required",
        },
        messages: {
            nombre: "Nombre de la encuesta requerido",
            nombreClave: {
                required: "Nombre Clave de encuesta requerido",
                rangelength: "Este campo debe tener entre 15 y 20 caracteres"
            },
            descripcion: "Agregue una descripcion acerca de esta encuesta"
        }
    });
    
    $("#submit").click(function(){
        console.log("" + form.valid());
    });
    
});