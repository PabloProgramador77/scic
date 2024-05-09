jQuery.noConflict();
jQuery(document).ready(function(){

    $(".ver").on('click', function(){

        var valoresNota = $(this).attr('data-value').split(',');
        $("#nota").val( $(this).attr('data-id') );
        $("#cliente").val( valoresNota[0] );
        $("#total").val( valoresNota[1] );

        $.ajax({

            type: 'POST',
            url: '/nota/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                var filas = '<thead>' +
                            '<tr class="bg-info">' +
                                '<td><b>Folio</b></td>'+
                                '<td><b>Modelo</b></td>'+
                                '<td><b>Precio Unitario</b></td>'+
                            '</tr>'+
                        '</thead>';

                respuesta.cotizaciones.forEach(function(cotizacion){

                    filas += '<tr>' +
                                '<td>'+ cotizacion.idCotizacion +'</td>'+
                                '<td>'+ cotizacion.nombre+'</td>'+
                                '<td>$ '+cotizacion.precio+'</td>'+
                            '</tr>';

                });

                $("#contenedorCotizaciones").empty().append( filas );

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/notas';

                    }

                });

            }

        });

    });

});