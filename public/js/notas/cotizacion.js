jQuery.noConflict();
jQuery(document).ready(function(){

    //Obteniendo ID de cotizacion a agregar a nota
    $(".agregar").on('click', function(){

        var cotizacion = $(this).attr('data-id');

        $("#idCotizacion").val( cotizacion );

    });

});