jQuery.noConflict();
jQuery(document).ready(function(){

    $("#nuevoNumeracion").on('click', function(){

        $("#modalNumeracion").css('display', 'none');

    });

    $("#cancelarNumeracion").on('click', function(){

        $("#modalNuevoNumeracion").css('display', 'none');

        $("#modalNumeracion").css('display', 'block');

    });

    $("#registrarNumeracion").on('click', function(e){

        e.preventDefault();

        let procesamiento;

        Swal.fire({

            title: 'Registrando Numeración',
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
                    url: '/numeracion/agregar',
                    data:{

                        'numero' : $("#numeroNumeracion").val()

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({

                            icon: 'success',
                            title: 'Numeración Registrada',
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/modelo/piezas/'+$("#idModelo").val();

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

                                window.location.href = '/modelo/piezas/'+$("#idModelo").val();

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

                        window.location.href = '/modelos';

                    }

                });

            }

        });

    });
    
});