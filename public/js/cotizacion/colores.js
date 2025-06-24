jQuery.noConflict();
jQuery(document).ready(function(){

    $(".colores").on('click', function(e){

        e.preventDefault();

        var id = $(this).attr('data-value').split(',')[0];
        var suela = $(this).attr('data-value').split(',')[1];
        var colorPiso = $(this).attr('data-value').split(',')[2];
        var colorCuna = $(this).attr('data-value').split(',')[3];

        if( id == null || id == 0 || id == '' ){

            Swal.fire({

                icon: 'error',
                title: 'Error de lectura de datos',
                allowOutsideClick: false,
                showConfirmButton: true

            }).then((resultado)=>{

                if( resultado.isConfirmed ){

                    window.location.href = '/cotizaciones/clientes/'+$("#idCliente").val();

                }

            });

            $("#colorear").attr('disabled', true);

        }else{

            $("#suelaEditar").val( suela );
            $("#colorPisoEditar").val( colorPiso );
            $("#colorCunaEditar").val( colorCuna );
            $("#idCotizacionColores").val( id );

            $("#colorear").attr('disabled', false);

        }

    });

});