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

        $("input[type=text][name=pares][data-id="+cotizacion+"]").val('');
        $("input[type=text][name=subtotal][data-id="+cotizacion+"]").val('');

        $("input[type=text][name=pares][data-id="+cotizacion+"]").val( pares );
        $("input[type=text][name=subtotal][data-id="+cotizacion+"]").val( total.toFixed(2) );

        $("input[name=subtotal]").each(function(){

            subtotal += parseFloat( $(this).val() );

        });

        $("#total").val('');
        $("#total").val( subtotal.toFixed(2) );

        console.log( subtotal );

    });

    $("input[name=descuento]").change(function(){

        var cotizacion = $(this).attr('data-id');
        var descuento = $(this).val();

        var precio = parseFloat( $(this).attr('data-value') );

        var price = parseFloat( precio - descuento );

        $('.precio'+cotizacion).text('');
        $('.precio'+cotizacion).text( price.toFixed(2) );

        var pares = 0;
        var total = 0;
        var subtotal = 0;

        $('input[name=numeracion][data-id='+cotizacion+']').each(function(){

            pares += parseInt( $(this).val() ) || 0;

        });

        total = parseFloat( pares * price );

        $("input[type=text][name=pares][data-id="+cotizacion+"]").val('');
        $("input[type=text][name=subtotal][data-id="+cotizacion+"]").val('');

        $("input[type=text][name=pares][data-id="+cotizacion+"]").val( pares );
        $("input[type=text][name=subtotal][data-id="+cotizacion+"]").val( total.toFixed(2) );

        $("input[name=subtotal]").each(function(){

            subtotal += parseFloat( $(this).val() );

        });

        $("#total").val('');
        $("#total").val( subtotal.toFixed(2) );

        console.log( subtotal );

    });

});