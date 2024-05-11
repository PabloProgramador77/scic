jQuery.noConflict();
jQuery(document).ready(function(){

    //Obteniendo ID de cotizacion a agregar a nota
    $(".agregar").on('click', function(){

        $(".nota").hide();

        var cotizacion = $(this).attr('data-id');
        var cliente = $(this).attr('data-value');

        $("#idCotizacion").val( cotizacion );

        $.ajax({

            type: 'POST',
            url: '/notas/cliente',
            data:{

                'cliente' : cliente

            },
            dataType: 'json',
            encode: true,

        }).done(function(respuesta){

            if( respuesta.exito ){

                if( respuesta.notas.length > 0 ){

                    delete respuesta.exito;

                    respuesta.notas.forEach(function(nota){

                        $(".nota[data-id='" + nota.id + "']").show();
                    
                    });
                    
                    

                }else{

                    Swal.fire({
                        icon: 'info',
                        title: 'Sin notas para el cliente',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });

                }

            }else{
                
                Swal.fire({
                    icon: 'error',
                    title: respuesta.mensaje,
                    showConfirmButton: true,
                    allowOutsideClick: false
                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/cotizaciones';

                    }

                });
            }

        });

    });

});