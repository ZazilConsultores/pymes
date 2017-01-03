/**
 * @author EnginnerRodriguez
 */
$(document).ready(function() {
    $('#table').dataTable( {
        "pagingType": "full_numbers"
    } );
    
    // acomodando formularios creados con Zend.
    
    //$("fieldset > dl > dt").css("display","inline");
    $("fieldset > dl > div > dt").css("display","inline-block");
    $("fieldset > dl > div > dd").css("display","inline-block");
    //$("fieldset > dl > dd").css("clear","left");
    
} );