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
                $("#colorEditar").val( respuesta.hex );
                $("#nombreColorEditar").val( respuesta.color );

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

    $(".color").on('click', function(e){

        e.preventDefault();

        var nombre = $(this).attr('data-value').split(',')[0];
        var concepto = $(this).attr('data-value').split(',')[1];
        var precio = $(this).attr('data-value').split(',')[2];
        var unidades = $(this).attr('data-value').split(',')[3];
        var color = $(this).attr('data-value').split(',')[4];
        var hex = $(this).attr('data-value').split(',')[5];
        var idProveedor = $(this).attr('data-value').split(',')[6];
        var proveedor = $(this).attr('data-value').split(',')[7];

        if( nombre == null || concepto == null || precio == null || unidades == null || idProveedor == null || proveedor == null ){

            $("#nombreMaterial").val('');
            $("#conceptoMaterial").val('');
            $("#precioMaterial").val('');
            $("#unidadesMaterial").val('');
            $("#nombreColorMaterial").val('');
            $("#colorMaterial").val('');
            $("#proveedorMaterial").attr('disabled', true);

            $("#registrarColor").attr('disabled', true);

        }else{

            $("#nombreMaterial").val(nombre);
            $("#conceptoMaterial").val(concepto);
            $("#precioMaterial").val(precio);
            $("#unidadesMaterial").val(unidades);

            $("#proveedorMaterial").attr('disabled', false);

            $("#proveedorEditar").prepend('<option value="'+idProveedor+'">'+proveedor+'</option>');
            $("#proveedorEditar").val( idProveedor );
            $("#proveedorEditar option[value='"+idProveedor+"']:not(:first)").remove();

            $("#registrarColor").attr('disabled', false);

        }

    });

});