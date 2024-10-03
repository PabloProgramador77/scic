jQuery.noConflict();
jQuery(document).ready(function(){

    $("#actualizar").attr('disabled', true);

    $(".editar").on('click', function(e){

        e.preventDefault();

        var id = $(this).attr('data-value').split(',')[0];
        var nombre = $(this).attr('data-value').split(',')[1];
        var numero = $(this).attr('data-value').split(',')[2];
        var descripcion = $(this).attr('data-value').split(',')[3];

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
            $("#numeroEditar").val( numero );
            $("#descripcionEditar").val( descripcion );
            $("#id").val( id );

            $("#actualizar").attr('disabled', false);

        }

    });

});