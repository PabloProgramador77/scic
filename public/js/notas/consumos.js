jQuery.noConflict();
jQuery(document).ready(function(){

    $("#consumos").on('click', function(){

        var id = $(this).attr('data-id');

        $.ajax({

            type: 'POST',
            url: '/notas/tabla',
            data:{

                'id' : id,

            },
            dataType: 'json',
            encode: true,

        }).done( function( respuesta){

            if( respuesta.exito ){

                Swal.fire({

                    icon: 'success',
                    title: 'Documento encontrado',
                    allowOutsideClick: false,
                    showConfirmButton: true,

                }).then( (resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/notas/tabla/' + id;

                    }

                });

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true,

                });

            }

        });
    
    });

});