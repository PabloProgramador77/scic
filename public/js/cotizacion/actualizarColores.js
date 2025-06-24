jQuery.noConflict();
jQuery(document).ready(function(){

    $("#colorear").on('click', function(e){

        e.preventDefault();

        let procesamiento;

        Swal.fire({

            title: 'Actualizando colores',
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
                    url: '/cotizacion/colores',
                    data:{

                        'piso' : $("#colorPisoEditar").val(),
                        'cuna' : $("#colorCunaEditar").val(),
                        'id' : $("#idCotizacionColores").val()

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        $("#actualizar").attr('disabled', true);

                        Swal.fire({

                            icon: 'success',
                            title: 'Colores actualizados',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            timer: 999,
                            timerProgressBar: true,

                        }).then((resultado)=>{

                            if( resultado.dismiss == Swal.DismissReason.timer ){

                                window.location.href = '/cotizaciones/cliente/'+$("#idCliente").val();

                            }

                        });

                    }else{

                        $("#actualizar").attr('disabled', true);

                        Swal.fire({

                            icon: 'error',
                            title: respuesta.mensaje,
                            allowOutsideClick: false,
                            showConfirmButton: true

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/cotizaciones/cliente/'+$("#idCliente").val();

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

                        window.location.href = '/cotizaciones/cliente/'+$("#idCliente").val();

                    }

                });

            }

        });

    });

});