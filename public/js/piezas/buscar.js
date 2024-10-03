jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/pieza/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#nombreEditar").val( respuesta.nombre );
                $("#altoEditar").val( respuesta.alto );
                $("#largoEditar").val( respuesta.largo );
                $("#cantidadEditar").val( respuesta.cantidad );
                $("#descripcionEditar").val( respuesta.descripcion );
                $("#idPieza").val( respuesta.id );

                $("#suajeEditar").prepend('<option value="'+respuesta.idSuaje+'">'+respuesta.suaje+'</option>');
                $("#suajeEditar").val(respuesta.idSuaje);
                $("#suajeEditar option[value='"+respuesta.idSuaje+"']:not(:first)").remove();

                $("#actualizar").attr('disabled', false);

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/modelo/piezas/' + $("#idModelo").val();

                    }

                });

                $("#actualizar").attr('disabled', true);

            }

        });

    });

});