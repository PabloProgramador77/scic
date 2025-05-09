jQuery.noConflict();
jQuery(document).ready(function(){

    $(".observaciones").on('click', function(e){

        e.preventDefault();

        var id = $(this).attr('data-value').split(',')[0];
        var observaciones = $(this).attr('data-value').split(',')[1];

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

            $("#observar").attr('disabled', true);

        }else{

            $("#observacionesEditar").val( observaciones );
            $("#idCotizacionObservaciones").val( id );

            $("#observar").attr('disabled', false);

        }

    });

});