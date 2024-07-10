jQuery.noConflict();
jQuery(document).ready(function(){

    $(".consumos").on('click', function(){

        var nota = $(this).attr('data-id');
        
        $.ajax({

            type: 'POST',
            url: '/nota/consumos',
            data:{

                'id' : nota,

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                Swal.fire({

                    icon: 'success',
                    title: 'Documento Listo',
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/nota/consumos/'+nota;

                    }

                });

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