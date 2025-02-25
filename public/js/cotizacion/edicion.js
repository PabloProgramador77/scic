jQuery.noConflict();
jQuery(document).ready(function(){

    //Calculo de costo
    function calcularCosto( precio, cantidad ){ 

        return parseFloat(precio * cantidad);

    }

    $('.material').on('change', function(){

        var pieza = $(this).attr('data-id');

        console.log("Pieza: " + pieza);

        var valoresMaterial = $(this).val().split(',');
        var precioMaterial = parseFloat( valoresMaterial[0] );
        var unidades = parseFloat( valoresMaterial[1] );
        var material = valoresMaterial[3];

        var valoresPieza = $("input[name=pieza][id=pieza"+pieza+"]").val().split(',');
        var largo = parseFloat( valoresPieza[1] );
        var alto = parseFloat( valoresPieza[2] );
        var cantidad = parseFloat( valoresPieza[3] );

        var MtsXPar = ((largo * alto)*(cantidad)/(unidades*100));
        var costo = calcularCosto( precioMaterial, MtsXPar );

        console.log(precioMaterial);
        console.log(unidades);
        console.log(largo);
        console.log(alto);
        console.log(cantidad);
        console.log(MtsXPar);
        console.log(costo);
        
        $(".medidas"+pieza).text( largo + " x " + alto );
        $('.cantidad' + pieza).text(cantidad); 
        $('.area' + pieza).text( (largo * alto).toFixed(1) );
        $('.cms' + pieza).text( (largo * alto * cantidad).toFixed(1) );
        $('.dm' + pieza).text( (largo * alto * cantidad / 100).toFixed(1) );
        $('.unidades' + pieza).text( unidades.toFixed(1) );
        $('.mts' + pieza).text( MtsXPar.toFixed(4) );
        $('.costo' + pieza).text( costo.toFixed(1) );

        var total = 0;

        $('td[class^="costo"]').each(function(){

            var valor = parseFloat( $(this).text() );

            total += valor;

        });

        console.log('Total:' +total );

        $("#total").val( total.toFixed(2) );

        $.ajax({

            type: 'POST',
            url: '/material/colores',
            data:{

                'material' : material,

            },
            dataType: 'json',
            encode: true,

        }).done(function(respuesta){

            if( respuesta.exito ){

                if( respuesta.colores.length > 0 ){

                    var opcionesColores = '';

                    respuesta.colores.forEach(function(color){

                        if( color.hexColor !== null ){

                            opcionesColores += '<option value="'+color.color+'" style="background-color: '+color.hexColor+';">'+color.color+'</option>'

                        }

                    });

                    $('.colorPieza'+pieza).empty();
                    $('.colorPieza'+pieza).append( opcionesColores );

                }else{

                    Swal.fire({

                        icon: 'info',
                        title: 'Sin colores registrados',
                        allowOutsideClick: false,
                        showConfirmButton: true

                    });
                    
                }

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                });

            }

        });

    });

    //Evento de selección de pieza para el costo total
    $('.pieza').on('click', function(){

        var pieza = $(this).attr('data-id');

        if( $(this).is(':checked') ){

            var costo = parseFloat( $('.costo'+pieza).text() );
            var total = parseFloat( $("#total").val() );

            total += costo;

            $("#total").val( total.toFixed(4) );

        }else{

            var costo = parseFloat( $('.costo'+pieza).text() );
            var total = parseFloat( $("#total").val() );

            total -= costo;

            $("#total").val( total.toFixed(4) );

        }

    });

    $('.material').change(function(){

        var pieza = $(this).attr('data-id');

        var color = $(this).find('option:selected').data('value');

        $('.colorPieza'+pieza).val( color );

    });

    $("input[type=checkbox]").prop('checked', true);

    $("#costos").attr('disabled', false);

});