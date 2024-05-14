jQuery.noConflict();
jQuery(document).ready(function(){

    $("#agregarNum").on('click', function(e){

        e.preventDefault();

        let procesamiento;
        var cotizaciones = new Array();
        var numeraciones = new Array();

        $("input[name=cotizacion][type=hidden]").each(function(){

            cotizaciones.push( $(this).val() );

        });

        $("input[name=numeracion]").each(function(){

            var idNumeracion = $(this).attr('id');
            var cantidad = $(this).val();

            numeraciones.push({

                'id': idNumeracion,
                'cantidad' : cantidad

            });

        });

        console.log( cotizaciones );
        console.log( numeraciones );

        Swal.fire({

            title: 'Terminando Nota',
            html: 'Un momento por favor: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft();

                }, 100);

                $.ajax({

                    type: 'POST',
                    url: '/cotizacion/numeraciones',
                    data:{

                        
                        'cotizaciones' : cotizaciones,
                        'numeraciones' : numeraciones,

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Nota Creada',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/notas';

                            }

                        });

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

                    }

                });

            },
            willClose: ()=>{

                clearInterval(procesamiento);

            }

        }).then((resultado)=>{

            if( resultado.dismiss == Swal.DismissReason.timer ){

                Swal.fire({

                    icon: 'warning',
                    title: 'Hubo un inconveniente. Trata de nuevo.',
                    allowOutsideClick: false,
                    showConfirmButton: true

                }).then((resultado)=>{

                    if( resultado.isConfirmed ){

                        window.location.href = '/cotizaciones';

                    }

                });

            }

        });

    });
    
});