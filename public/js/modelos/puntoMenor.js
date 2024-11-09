jQuery.noConflict();
jQuery(document).ready(function(){

    $("#puntoMenor").on('change', function(e){

        e.preventDefault();

        if( $(this).is(':checked') ){

            var valor = 'Activado';

        }else{

            var valor = 'Desactivado';

        }

        $.ajax({

            type: 'POST',
            url: '/modelo/punto',
            data:{

                'id' : $("#idModelo").val(),
                'punto' : valor,

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#actualizar").attr('disabled', true);

                Swal.fire({

                    icon: 'success',
                    title: 'Punto Menor ' + valor,
                    allowOutsideClick: false,
                    showConfirmButton: true

                });

            }else{

                $("#actualizar").attr('disabled', true);

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/modelos';

                    }

                });

            }

        });

    });

});