jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        var id = $(this).attr('data-value').split(',')[0];
        var nombre = $(this).attr('data-value').split(',')[1];
        var orden = $(this).attr('data-value').split(',')[3];
        var descripcion = $(this).attr('data-value').split(',')[2];

        if( id === null || id === 0 || id === '' ){

            Swal.fire({

                icon: 'warning',
                title: 'Error de lectura',
                allowOutsideClick: false,
                showConfirmButton: true,

            });

            $("#actualizar").attr('disabled', true);

        }else{

            $("#nombreEditar").val( nombre );
            $("#ordenEditar").val( orden );
            $("#descripcionEditar").val( descripcion );
            $("#id").val( id );

            $("#actualizar").attr('disabled', false);

        }

    });

    $(".actividades").on('click', function(e){

        e.preventDefault();

        var id = $(this).attr('data-id');

        if( id === null || id === 0 || id === '' ){

            Swal.fire({

                icon: 'warning',
                title: 'Error de lectura',
                allowOutsideClick: false,
                showConfirmButton: true,

            });

            $("#agregar").attr('disabled', true);

        }else{

            console.log(id);

            $("#idProceso").val( id );

            $("#agregar").attr('disabled', false);

        }

    });

});