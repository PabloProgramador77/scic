jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/material/buscar',
            data:{

                'id' : $(this).attr('data-id'),

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#nombreEditar").val( respuesta.nombre );
                $("#conceptoEditar").val( respuesta.concepto );
                $("#precioEditar").val( respuesta.precio );
                $("#unidadesEditar").val( respuesta.unidades );

                $("#proveedorEditar").prepend('<option value="'+respuesta.idProveedor+'">'+respuesta.proveedor+'</option>');
                $("#proveedorEditar").val(respuesta.idProveedor);
                $("#proveedorEditar option[value='"+respuesta.idProveedor+"']:not(:first)").remove();

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

                        window.location.href = '/materiales';

                    }

                });

                $("#actualizar").attr('disabled', true);

            }

        });

    });

});