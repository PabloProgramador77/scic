jQuery.noConflict();
jQuery(document).ready(function(){

    $("input[name=numeracion]").change(function(){

        var cotizacion = $(this).attr('data-id');

        var pares = 0;
        var total = 0;
        var precio = parseFloat( $('.precio'+cotizacion).text() );
        var subtotal = 0;

        $('input[name=numeracion][data-id='+cotizacion+']').each(function(){

            pares += parseInt( $(this).val() ) || 0;

        });

        total = parseFloat( pares * precio );
        subtotal += total;

        $(".pares"+cotizacion).text( pares );
        $('.total'+cotizacion).text( total.toFixed(2) );

    });

});