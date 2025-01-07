jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        var id = $(this).attr('data-value').split(',')[0];
        var nombre = $(this).attr('data-value').split(',')[1];
        var orden = $(this).attr('data-value').split(',')[3];
        var descripcion = $(this).attr('data-value').split(',')[2];
        var duracion = $(this).attr('data-value').split(',')[4];
        var idProceso = $(this).attr('data-value').split(',')[5];
        var idUsuario = $(this).attr('data-value').split(',')[6];
        var usuario = $(this).attr('data-value').split(',')[7];
        var tipo = $(this).attr('data-value').split(',')[8];

        if( id === null || id === 0 || id === '' ){

            Swal.fire({

                icon: 'warning',
                title: 'Error de lectura',
                allowOutsideClick: false,
                showConfirmButton: true,

            });

            $("#actualizar").attr('disabled', true);

        }else{

            $("#nombreActividadEditar").val( nombre );
            $("#ordenActividadEditar").val( orden );
            $("#descripcionActividadEditar").val( descripcion );
            $("#duracionEditar").val( duracion );

            $("#usuarioEditar").prepend('<option value="'+idUsuario+'">'+usuario+'</option>');
            $("#usuarioEditar").val( idUsuario );
            $("#usuarioEditar option[value='"+idUsuario+"']:not(:first)").remove();

            $("#tipoEditar").prepend('<option value="'+tipo+'">'+tipo+'</option>');
            $("#tipoEditar").val( tipo );
            $("#tipoEditar option[value='"+tipo+"']:not(:first)").remove();

            $("#id").val( id );

            $("#actualizar").attr('disabled', false);

        }

    });

});