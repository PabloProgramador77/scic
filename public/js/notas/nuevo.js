jQuery.noConflict();
jQuery(document).ready(function(){

    $("#nota").on('click', function(e){

        var cotizaciones = new Array();

        e.preventDefault();

        $("input[name=cotizacion][type=checkbox]:checked").each(function(){

            cotizaciones.push( $(this).attr('data-id') );

        });

        if( cotizaciones.length > 0 ){

            $("#nombre").attr('disabled', false);
            $("#telefono").attr('disabled', false);
            $("#domicilio").attr('disabled', false);
            $("#email").attr('disabled', false);
            $("#registrar").attr('disabled', false);
            $(".cliente").attr('disabled', false);

        }else{

            Swal.fire({

                icon: 'info',
                title: 'Elige las cotizaciones para la nueva nota.',
                showConfirmButton: true,
                allowOutsideClick: false,

            });

            $("#nombre").attr('disabled', true);
            $("#telefono").attr('disabled', true);
            $("#domicilio").attr('disabled', true);
            $("#email").attr('disabled', true);
            $("#registrar").attr('disabled', true);
            $(".cliente").attr('disabled', true);

        }

    });

});