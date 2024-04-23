jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/costo/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#nombreEditar").val( respuesta.nombre );
                $("#descripcionEditar").val( respuesta.descripcion );
                $("#totalEditar").val( respuesta.total );

                $("#tipoEditar").prepend('<option value="'+respuesta.tipo+'">'+respuesta.tipo+'</option>');
                $("#tipoEditar").val(respuesta.tipo);
                $("#tipoEditar option[value='"+respuesta.tipo+"']:not(:first)").remove();

                $("#id").val( respuesta.id );

                $("#actualizar").attr('disabled', false);

            }else{

                Swal.fire({

                    icon: 'error',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/costos';

                    }

                });

                $("#actualizar").attr('disabled', true);

            }

        });

    });

});