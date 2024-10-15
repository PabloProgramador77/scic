jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/cliente/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#numeroEditar").val( respuesta.numero );
                $("#nombreEditar").val( respuesta.nombre );
                $("#telefonoEditar").val( respuesta.telefono );
                $("#emailEditar").val( respuesta.email );
                $("#estadoEditar").val( respuesta.estado );
                $("#ciudadEditar").val( respuesta.ciudad );
                $("#empresaEditar").val( respuesta.empresa );
                $("#razonEditar").val( respuesta.razon );
                $("#rfcEditar").val( respuesta.rfc );

                $("#idCliente").val( respuesta.id );

                $("#actualizar").attr('disabled', false);

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/cotizaciones';

                    }

                });

                $("#actualizar").attr('disabled', true);

            }

        });

    });

});